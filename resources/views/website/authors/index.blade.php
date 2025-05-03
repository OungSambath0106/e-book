@extends('website.master')
@section('page_title', __('Authors Page'))
@section('content')
    <!-- Shop Hero Section -->
    <section class="hero">
        <div class="circle-decoration circle-1"></div>
        <div class="circle-decoration circle-2"></div>
        <div class="line-decoration line-1"></div>
        <div class="line-decoration line-2"></div>

        <div class="container">
            <p class="shop-subtitle">All Your Favorite Books In One Place 📚</p>
            <h1>Authors</h1>
            <a href="{{ route('home') }}" class="back-link">Back To Home</a>

            <div class="search-container">
                <input type="text" class="search-input" placeholder="Search for a book, author...">
                <button class="search-btn-hero">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Authors grid -->
    <div class="authors-grid">
        <!-- Author card 1 -->
        <div class="author-card">
            <div class="author-image">
                <img src="/api/placeholder/400/400" alt="Silvan Schuppisser">
            </div>
            <h3 class="author-name">Silvan Schuppisser</h3>
            <p class="author-role">Technical Writer</p>
            <div class="social-links">
                <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>

        <!-- Author card 2 -->
        <div class="author-card">
            <div class="author-image">
                <img src="/api/placeholder/400/400" alt="Olive Yew">
            </div>
            <h3 class="author-name">Olive Yew</h3>
            <p class="author-role">Technical Writer</p>
            <div class="social-links">
                <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    </div>

    <!-- Main Shop Content -->
@endsection
