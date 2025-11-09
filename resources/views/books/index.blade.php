@extends('layouts.app')

@section('title', '📚 Daftar Buku')

@section('content')
    <div class="container py-4">

        <h2 class="mb-4 fw-bold text-center text-primary">📚 Daftar Buku</h2>


        {{-- 🔍 Filter Form --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3 align-items-end">

                    {{-- Keyword Search --}}
                    <div class="col-md-3">
                        <label for="keyword" class="form-label">Cari Buku</label>
                        <input type="text" name="keyword" id="keyword" class="form-control"
                            placeholder="Judul / ISBN / Penulis / Penerbit" value="{{ request('keyword') }}">
                    </div>

                    {{-- Author --}}
                    <div class="col-md-3">
                        <label for="author_id" class="form-label">Penulis</label>
                        <select name="author_id" id="author_id" class="form-select">
                            <option value="">Semua Penulis</option>
                            @foreach ($authors as $author)
                                <option value="{{ $author->id }}" @selected(request('author_id') == $author->id)>
                                    {{ $author->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Kategori --}}
                    <div class="col-md-3">
                        <label for="categories" class="form-label">Kategori</label>
                        <select name="categories[]" id="categories" multiple class="form-select" size="1">
                            @foreach($categories as $c)
                                <option value="{{ $c->id }}" @selected(in_array($c->id, (array) request('categories', [])))>
                                    {{ $c->nama }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">
                            <label class="ms-2"><input type="radio" name="mode" value="or" @checked(request('mode', 'or') == 'or')>
                                OR</label>
                            <label><input type="radio" name="mode" value="and" @checked(request('mode') == 'and')> AND</label>
                        </small>
                    </div>
        

                    {{-- Sort --}}
                    <div class="col-md-3">
                        <label for="sort" class="form-label">Urutkan Berdasarkan</label>
                        <select name="sort" id="sort" class="form-select">
                            <option value="weighted" @selected(request('sort', 'weighted') == 'weighted')>Default</option>
                            <option value="rating" @selected(request('sort') == 'rating')>Rata-rata Rating</option>
                            <option value="votes" @selected(request('sort') == 'votes')>Total Votes</option>
                            <option value="popularity" @selected(request('sort') == 'popularity')>Popularitas</option>
                            <option value="alphabetical" @selected(request('sort') == 'alphabetical')>Judul A-Z</option>
                        </select>
                    </div>

                    {{-- Status & Lokasi --}}
                    <div class="col-md-2">
                        <label for="availability_status" class="form-label">Status</label>
                        <select name="availability_status" id="availability_status" class="form-select">
                            <option value="">Semua</option>
                            @foreach($availabilityStatuses as $status)
                                <option value="{{ $status }}" @selected(request('availability_status') == $status)>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="store_location" class="form-label">Lokasi Toko</label>
                        <select name="store_location" id="store_location" class="form-select">
                            <option value="">Semua</option>
                            @foreach($storeLocations as $location)
                                <option value="{{ $location }}" @selected(request('store_location') == $location)>
                                    {{ $location }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tahun --}}
                    <div class="col-md-3">
                        <label class="form-label">Tahun Terbit</label>
                        <div class="input-group">
                            <input type="number" name="year_from" placeholder="Dari" class="form-control"
                                value="{{ request('year_from') }}">
                            <input type="number" name="year_to" placeholder="Sampai" class="form-control"
                                value="{{ request('year_to') }}">
                        </div>
                    </div>

                    {{-- Rating --}}
                    <div class="col-md-3">
                        <label class="form-label">Rating</label>
                        <div class="input-group">
                            <input type="number" name="rating_min" placeholder="Min" class="form-control" min="1" max="10"
                                value="{{ request('rating_min') }}">
                            <input type="number" name="rating_max" placeholder="Max" class="form-control" min="1" max="10"
                                value="{{ request('rating_max') }}">
                        </div>
                    </div>

                    {{-- Tombol --}}
                    <div class="col-md-2 d-grid">
                        <button class="btn btn-primary">Filter</button>
                        <a href="{{ route('books.index') }}" class="btn btn-outline-secondary mt-2">Reset</a>
                    </div>
                </form>
            </div>
        </div>
        {{-- 📘 Table Buku --}}
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
                                <th>ISBN</th>
                                <th>Tahun</th>
                                <th>Rating</th>
                                <th>Votes</th>
                                <th>Popularitas</th>
                                <th>Status</th>
                                <th>Lokasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($books as $book)
                                <tr>
                                    <td class="text-center">{{ $books->firstItem() + $loop->index }}</td>
                                    <td>
                                        {{ $book->judul }}
                                        @if($book->trending_status)
                                            <span class="badge bg-warning text-dark ms-1">{{ $book->trending_status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $book->author->nama ?? '-' }}</td>
                                    <td>
                                        @forelse($book->categories as $cat)
                                            <span class="badge bg-info text-dark">{{ $cat->nama }}</span>
                                        @empty
                                            -
                                        @endforelse
                                    </td>
                                    <td>{{ $book->isbn ?? '-' }}</td>
                                    <td class="text-center">{{ $book->tahun_publis ?? '-' }}</td>

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

                                        <small class="d-block text-secondary">
                                            {{ number_format($rating, 1) }}
                                        </small>
                                    </td>

                                    <td class="text-center">{{ $book->votes_count }}</td>
                                    <td class="text-center">{{ number_format($book->recent_popularity_score, 2) }}</td>

                                    {{-- Status --}}
                                    <td class="text-center">
                                        <span class="badge 
                                                @if($book->availability_status == 'available') bg-success 
                                                @elseif($book->availability_status == 'rented') bg-danger 
                                                @else bg-warning text-dark @endif">
                                            {{ ucfirst($book->availability_status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">{{ $book->store_location ?? '-' }}</td>

                                    <td class="text-center">
                                        @if($book->canRate ?? false)
                                            <a href="{{ route('ratings.create', $book->id) }}"
                                                class="btn btn-sm btn-success">Rate</a>
                                        @else
                                            <button class="btn btn-sm btn-secondary" disabled>Sudah dirating</button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center text-muted">Tidak ada data buku ditemukan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center gap-3">
                    {{ $books->appends(request()->except('page'))->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection