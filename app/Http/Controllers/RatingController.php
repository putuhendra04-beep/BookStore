<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class RatingController extends Controller
{
    protected const RATING_COOLDOWN_HOURS = 24;
    // Tampilkan form rating
    public function index(Request $request)
    {
        $search = trim($request->input('search'));

        $query = Rating::with(['book', 'user'])->orderBy('created_at', 'desc');
    
        // 🔍 Filter hanya jika ada kata kunci
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('book', function ($bookQuery) use ($search) {
                    $bookQuery->where('judul', 'like', "%{$search}%");
                })
                ->orWhere('comment', 'like', "%{$search}%");
            });
        }
    
        // 📄 Pagination
        $ratings = $query->paginate(10);
    
        return view('ratings.index', compact('ratings', 'search'));
    }
    public function create(Book $book)
    {
        $userId = auth()->check() ? auth()->id() : null;
        $guestIp = $userId ? null : request()->ip();

        // Cek cooldown per buku
        $hasRated = Rating::where('book_id', $book->id)
            ->when($userId, fn($q) => $q->where('user_id', $userId))
            ->when(!$userId, fn($q) => $q->where('guest_ip', $guestIp))
            ->where('created_at', '>', now()->subHours(self::RATING_COOLDOWN_HOURS))
            ->exists();

        if ($hasRated) {
            return redirect()->back()->with('error', 'Anda sudah memberi rating buku ini dalam 24 jam terakhir.');
        }

        return view('ratings.create', compact('book'));
    }

    // Simpan rating
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'score' => 'required|integer|min:1|max:10',
            'comment' => 'nullable|string|max:500',
            'redirect_to' => 'nullable|url'
        ]);

        $userId = auth()->check() ? auth()->id() : null;
        $guestIp = $userId ? null : request()->ip();

        try {
            $this->ensureRatingIsValid($validated['book_id'], $userId, $guestIp);

            DB::transaction(function () use ($validated, $userId, $guestIp) {
                Rating::create([
                    'book_id' => $validated['book_id'],
                    'score' => $validated['score'],
                    'comment' => $validated['comment'] ?? null,
                    'user_id' => $userId,
                    'guest_ip' => $guestIp,
                ]);

                $this->updateBookStats($validated['book_id']);
            });

            $redirectUrl = $validated['redirect_to'] ?? url()->previous();
            return redirect($redirectUrl)->with('success', 'Rating berhasil disimpan!');

        } catch (ValidationException $ve) {
            return back()->withErrors($ve->errors())->withInput();
        } catch (\Throwable $e) {
            return back()->withErrors(['general' => 'Gagal menyimpan rating. Silakan coba lagi.'])->withInput();
        }
    }

    // Validasi per buku
    protected function ensureRatingIsValid(int $bookId, $userId = null, $guestIp = null): void
    {
        $query = Rating::where('book_id', $bookId);

        if ($userId) $query->where('user_id', $userId);
        else $query->where('guest_ip', $guestIp);

        $lastRating = $query->latest()->first();

        if ($lastRating && $lastRating->created_at->gt(now()->subHours(self::RATING_COOLDOWN_HOURS))) {
            throw ValidationException::withMessages([
                'score' => "Anda hanya dapat memberikan rating sekali setiap " . self::RATING_COOLDOWN_HOURS . " jam untuk buku ini."
            ]);
        }
    }

    // Update statistik buku
    protected function updateBookStats(int $bookId): void
    {
        $stats = Rating::where('book_id', $bookId)
                       ->selectRaw('AVG(score) as avg, COUNT(*) as cnt')
                       ->first();

        if ($stats) {
            $avgRating = round($stats->avg, 2);
            $votesCount = (int)$stats->cnt;
            $priorMean = 3.5;
            $priorCount = 10;
            $popularityScore = (($priorMean * $priorCount) + ($avgRating * $votesCount)) / ($priorCount + $votesCount);

            Book::where('id', $bookId)->update([
                'avg_rating' => $avgRating,
                'votes_count' => $votesCount,
                'recent_popularity_score' => round($popularityScore, 2),
                'updated_at' => now(),
            ]);
        }
    }
}
