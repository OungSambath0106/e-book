@extends('website.master')
@section('page_title', __('Search Books'))
@section('content')
<style>
    .books-grid {
        min-height: 300px;
    }
</style>
<!-- All Books Hero Section -->
<section class="hero">
    <div class="circle-decoration circle-1"></div>
    <div class="circle-decoration circle-2"></div>
    <div class="line-decoration line-1"></div>
    <div class="line-decoration line-2"></div>

    <div class="container">
        <p class="shop-subtitle">All Your Favorite Books In One Place 📚</p>
        <h1>Search Books</h1>
        <a href="{{ route('home') }}" class="back-link">Back To Home</a>

        <div class="search-container">
            <input type="text" class="search-input" placeholder="Search for a book..." id="search-book">
            <button class="search-btn-hero" type="button" onclick="searchBooks()" aria-label="Search">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
</section>

<!-- All Books Section -->
<section class="all-books">
    <div class="container">
        <div class="section-header">
            <h2>All Books</h2>
        </div>

        <div class="books-grid pt-2 pb-3" id="all-books-search-container">
            @include('website.books.all_books_search', ['books' => $books])
        </div>
    </div>
</section>
@endsection
@push('js')
    <script>
        function searchBooks() {
            const query = document.getElementById('search-book').value;

            fetch(`{{ route('books.search') }}?search=${encodeURIComponent(query)}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network error');
                }
                return response.text();
            })
            .then(html => {
                document.getElementById('all-books-search-container').innerHTML = html;
            })
            .catch(error => {
                console.error('Search failed:', error);
            });
        }
    </script>
@endpush