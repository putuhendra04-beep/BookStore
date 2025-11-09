<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class topbookController extends Controller
{
    /**
     * Menampilkan top 10 buku berdasarkan avg_rating
     */
    public function index()
    {
        // Ambil top 10 buku langsung dari DB, dengan eager loading relasi
        $books = Book::with(['author', 'categories'])
            ->orderByDesc('avg_rating')
            ->take(10)
            ->get();

        return view('topbook.index', compact('books'));
    }
}
