@extends('website.master')
@section('page_title', __($title))
@section('content')
<!-- All Books Hero Section -->
<section class="hero">
    <div class="circle-decoration circle-1"></div>
    <div class="circle-decoration circle-2"></div>
    <div class="line-decoration line-1"></div>
    <div class="line-decoration line-2"></div>

    <div class="container">
        <p class="shop-subtitle">All Your Favorite Books In One Place 📚</p>
        <h1>{{ $title }}</h1>
        <a href="{{ route('home') }}" class="back-link">Back To Home</a>

        <div class="search-container">
            <input type="text" class="search-input" placeholder="Search your favorite books..." id="search-input">
            <button class="search-btn-hero" type="button" aria-label="Search">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
</section>

<!-- All Books Section -->
<section class="all-books">
    <div class="container">
        <div class="section-header">
            <h2>{{ $title }}</h2>
        </div>

        <div class="books-grid pt-2 pb-3" id="all-books-container">
            @include('website.home.partials.all_books_card', ['books' => $books])
        </div>
    </div>
</section>
@endsection