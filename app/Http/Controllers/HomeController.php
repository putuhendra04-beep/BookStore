<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Book;
use App\Models\Rating;
use App\Models\Author;

class HomeController extends Controller
{
    public function index()
    {
        $totalKategori = Category::count();
        $totalBuku = Book::count();
        $totalRating= Rating::count(); // contoh: total rating dianggap "penjualan"
        $totalPenulis = Author::count(); // contoh agregat (bisa diganti)

        // Contoh dummy data grafik (karena tidak ada tabel transaksi)
        $labels = ['2025-11-01','2025-11-02','2025-11-03','2025-11-04','2025-11-05'];
        $data = [15000000, 24000000, 10000000, 28000000, 36000000];

        return view('home.index', compact(
            'totalKategori',
            'totalBuku',
            'totalRating',
            'totalPenulis',
            'labels',
            'data'
        ));
    }
}
