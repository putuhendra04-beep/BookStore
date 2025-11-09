<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        // ✅ Tambahkan paginate agar bisa pakai ->links() di view
        $categories = Category::withCount('books')
            ->orderBy('nama', 'asc')
            ->paginate(20); // tampilkan 10 data per halaman

        return view('categories.index', compact('categories'));
    }
}
