@extends('layouts.app')

@section('title', '🏆 Top 20 Authors')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4 fw-bold text-center text-primary">🏆 Top 20 Authors</h2>

        {{-- 🔹 Tabs Navigasi --}}
        <ul class="nav nav-tabs justify-content-center mb-4">
            <li class="nav-item">
                <a class="nav-link @if($tab == 'popularity') active @endif"
                   href="{{ route('authors.index', ['tab' => 'popularity']) }}">
                    🔥 By Popularity
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if($tab == 'rating') active @endif"
                   href="{{ route('authors.index', ['tab' => 'rating']) }}">
                    ⭐ By Average Rating
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if($tab == 'trending') active @endif"
                   href="{{ route('authors.index', ['tab' => 'trending']) }}">
                    📈 Trending
                </a>
            </li>
        </ul>

        {{-- 🔹 Card Wrapper --}}
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama Penulis</th>
                                <th>Total Ratings</th>
                                <th>Buku Terbaik</th>
                                <th>Buku Terburuk</th>
                                @if($tab == 'trending')
                                    <th>Trending Score</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($authors as $index => $author)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="fw-semibold">{{ $author->nama }}</td>
                                    <td class="text-center">{{ number_format($author->total_ratings) }}</td>
                                    <td>{{ $author->best_book->judul ?? '-' }}</td>
                                    <td>{{ $author->worst_book->judul ?? '-' }}</td>

                                    @if($tab == 'trending')
                                        <td class="text-center">{{ number_format($author->trending_score, 2) }}</td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $tab == 'trending' ? 6 : 5 }}" class="text-center text-muted">
                                        Tidak ada data penulis ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
