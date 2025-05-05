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
                <button class="search-btn-hero" type="button" aria-label="Search">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Authors grid -->
    <div class="authors-grid">
        @foreach ($authors as $author)
            <div class="author-card">
                <div class="author-image">
                    <img src="{{ asset('uploads/authors/' . $author->image) }}" alt="{{ $author->name }}">
                </div>
                <a href="{{ route('author.detail', $author->id) }}" class="back-link">
                    <h3 class="author-name">{{ $author->name }}</h3>
                </a>
                <p class="author-role">{{ $author->role }}</p>
                <div class="social-links">
                    @if($author->social_media && is_array($author->social_media))
                        @foreach ($author->social_media as $social)
                            @if(isset($social['link']) && isset($social['title']))
                                <a href="{{ $social['link'] }}" class="social-link" target="_blank">
                                    @if ($social['title'] == 'Facebook')
                                        <i class="fab fa-facebook-f"></i>
                                    @elseif ($social['title'] == 'Twitter')
                                        <i class="fab fa-twitter"></i>
                                    @elseif ($social['title'] == 'Instagram')
                                        <i class="fab fa-instagram"></i>
                                    @elseif ($social['title'] == 'LinkedIn')
                                        <i class="fab fa-linkedin-in"></i>
                                    @elseif ($social['title'] == 'TikTok')
                                        <i class="fab fa-tiktok"></i>
                                    @elseif ($social['title'] == 'YouTube')
                                        <i class="fab fa-youtube"></i>
                                    @elseif ($social['title'] == 'Snapchat')
                                        <i class="fab fa-snapchat"></i>
                                    @elseif ($social['title'] == 'Telegram')
                                        <i class="fab fa-telegram"></i>
                                    @elseif ($social['title'] == 'WhatsApp')
                                        <i class="fab fa-whatsapp"></i>
                                    @endif
                                </a>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Main Shop Content -->
@endsection
