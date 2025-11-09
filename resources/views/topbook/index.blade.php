@extends('layouts.app')

@section('title', '🏆 Top 10 Books by Rating')

@section('content')
<div class="container py-4">

    <h2 class="mb-4 fw-bold text-center text-primary">🏆 Top 10 Books by Rating</h2>

    {{-- 📘 Card Tabel Buku --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Kategori</th>
                            <th>Rata-Rata Rating</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($books as $book)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $book->judul }}</td>
                                <td>{{ $book->author->nama ?? '-' }}</td>
                                <td>
                                    @forelse($book->categories as $cat)
                                        <span class="badge bg-info text-dark">{{ $cat->nama }}</span>
                                    @empty
                                        <span class="text-muted">-</span>
                                    @endforelse
                                </td>

                                {{-- 🌟 Rating --}}
                                <td class="text-center">
                                    @php
                                        $rating = round($book->avg_rating, 1);
                                        $fullStars = floor($rating);
                                        $halfStar = $rating - $fullStars >= 0.5;
                                    @endphp

                                    {{-- Bintang penuh --}}
                                    @for ($i = 0; $i < $fullStars; $i++)
                                        <span class="text-warning">★</span>
                                    @endfor

                                    {{-- Setengah bintang --}}
                                    @if ($halfStar)
                                        <span class="text-warning">☆</span>
                                    @endif

                                    {{-- Sisa kosong --}}
                                    @for ($i = $fullStars + ($halfStar ? 1 : 0); $i < 5; $i++)
                                        <span class="text-muted">★</span>
                                    @endfor

                                    <small class="d-block text-secondary mt-1">
                                        {{ number_format($rating, 1) }}
                                    </small>
                                </td>

                                {{-- 🎯 Aksi --}}
                                <td class="text-center">
                                    @php
                                        // Cek apakah user sudah memberi rating dalam 24 jam
                                        $canRate = !\App\Models\Rating::where('book_id', $book->id)
                                            ->when(auth()->check(), fn($q) => $q->where('user_id', auth()->id()))
                                            ->when(!auth()->check(), fn($q) => $q->where('guest_ip', request()->ip()))
                                            ->where('created_at', '>', now()->subHours(24))
                                            ->exists();
                                    @endphp

                                    @if($canRate)
                                        <a href="{{ route('ratings.create', $book->id) }}" class="btn btn-sm btn-success">Rate</a>
                                    @else
                                        <button class="btn btn-sm btn-secondary" disabled>Sudah dirating</button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Tidak ada data buku ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
