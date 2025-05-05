@extends('website.master')
@section('page_title', __('Authors Page'))
@section('content')
    <style>
        .social-links {
            justify-content: start;
        }

        .author-profile {
            padding-top: 5rem;
        }

        .author-profile .container {
            display: flex;
            gap: 2rem;
        }

        @media (min-width: 768px) {
            .author-profile {
                flex-direction: row;
                align-items: flex-start;
            }
        }

        .author-image-container {
            display: flex;
            justify-content: center;
        }

        .author-image-wrapper {
            width: 280px;
            height: 280px;
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .author-image-wrapper:hover {
            transform: scale(1.03);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .author-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .author-info {
            flex: 2;
        }

        .author-title {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .author-role {
            margin-bottom: 1.5rem;
        }

        /* Progress Bars */
        .progress-container {
            margin-bottom: 1rem;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .progress-bar-bg {
            width: 100%;
            height: 8px;
            border-radius: 9999px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            border-radius: 9999px;
            width: 0;
        }

        .progress-creativity {
            animation: progressAnimation 1.5s forwards ease-out;
            animation-delay: 1s;
        }

        .progress-popularity {
            animation: progressAnimation 1.5s forwards ease-out;
            animation-delay: 1.2s;
        }

        @keyframes progressAnimation {
            from {
                width: 0;
            }

            to {
                width: var(--width);
            }
        }

        /* About Section */
        .about-section {
            padding-block: 2.5rem;
            background-color: var(--light-bg);
        }

        .section-title {
            font-size: 1.875rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .about-text {
            color: var(--gray-700);
            line-height: 1.7;
            margin-bottom: 1.5rem;
        }
    </style>
    <!-- Shop Hero Section -->
    <section class="hero">
        <div class="circle-decoration circle-1"></div>
        <div class="circle-decoration circle-2"></div>
        <div class="line-decoration line-1"></div>
        <div class="line-decoration line-2"></div>

        <div class="container">
            <p class="shop-subtitle">All Your Favorite Books In One Place 📚</p>
            <h1 class="author-name">{{ $author->name }}</h1>
            <a href="{{ route('authors') }}" class="back-link">Back To Authors</a>

            <div class="search-container">
                <input type="text" class="search-input" placeholder="Search for a book, author...">
                <button class="search-btn-hero">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Author Profile Section -->
    <div class="author-profile fade-in-up delay-400">
        <div class="container">
            <!-- Author Image -->
            <div class="author-image-container">
                <div class="author-image-wrapper">
                    <img src="{{ $author->image ? asset('uploads/authors/' . $author->image) : asset('uploads/man.png') }}"
                        alt="{{ $author->name }}" class="author-image">
                </div>
            </div>

            <!-- Author Info -->
            <div class="author-info">
                <h2 class="author-title">{{ $author->name }}</h2>
                <p class="author-role">{{ $author->role }}</p>

                <!-- Creativity Progress Bar -->
                <div class="progress-container">
                    <div class="progress-header">
                        <span class="progress-label">Creativity</span>
                        <span class="progress-label">{{ $author->creativity }}%</span>
                    </div>
                    <div class="progress-bar-bg">
                        <div class="progress-bar progress-creativity" style="--width: {{ $author->creativity }}%"></div>
                    </div>
                </div>

                <!-- Popularity Progress Bar -->
                <div class="progress-container">
                    <div class="progress-header">
                        <span class="progress-label">Popularity</span>
                        <span class="progress-label">{{ $author->popularity }}%</span>
                    </div>
                    <div class="progress-bar-bg">
                        <div class="progress-bar progress-popularity" style="--width: {{ $author->popularity }}%"></div>
                    </div>
                </div>

                <!-- Social Links -->
                <div class="social-links">
                    {{-- <a href="#" class="social-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                        </svg>
                    </a> --}}
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
        </div>
    </div>

    <!-- About The Author Section -->
    <div class="about-section fade-in-up delay-600">
        <div class="container">
            <h3 class="section-title">About The Author</h3>
            <p class="about-text">
                {!! $author->description !!}
            </p>
        </div>
    </div>
@endsection
