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
            border-radius: 0.5rem;
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
            <h1 class="author-name">KURIZERK</h1>
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
                    <img src="{{ asset('images/author.jpg') }}" alt="Silvan Schuppisser" class="author-image">
                </div>
            </div>

            <!-- Author Info -->
            <div class="author-info">
                <h2 class="author-title">Silvan Schuppisser</h2>
                <p class="author-role">Crime Fiction Writer</p>

                <!-- Creativity Progress Bar -->
                <div class="progress-container">
                    <div class="progress-header">
                        <span class="progress-label">Creativity</span>
                        <span class="progress-label">85%</span>
                    </div>
                    <div class="progress-bar-bg">
                        <div class="progress-bar progress-creativity" style="--width: 85%"></div>
                    </div>
                </div>

                <!-- Popularity Progress Bar -->
                <div class="progress-container">
                    <div class="progress-header">
                        <span class="progress-label">Popularity</span>
                        <span class="progress-label">100%</span>
                    </div>
                    <div class="progress-bar-bg">
                        <div class="progress-bar progress-popularity" style="--width: 100%"></div>
                    </div>
                </div>

                <!-- Social Links -->
                <div class="social-links">
                    <a href="#" class="social-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                        </svg>
                    </a>
                    <a href="#" class="social-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path
                                d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z">
                            </path>
                        </svg>
                    </a>
                    <a href="#" class="social-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path>
                            <rect x="2" y="9" width="4" height="12"></rect>
                            <circle cx="4" cy="4" r="2"></circle>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- About The Author Section -->
    <div class="about-section fade-in-up delay-600">
        <div class="container">
            <h3 class="section-title">About The Author</h3>
            <p class="about-text">
                Silvan Schuppisser is a British American Crime Fiction writer best known for his trilogy 'CRIME XYZ' which
                has sold more than 1.5 million copies worldwide in 2007.
            </p>
            <p class="about-text">
                With over fifteen years in the publishing industry, Silvan has crafted intricate narratives that blend
                psychological suspense with richly developed characters. His work has been translated into 22 languages and
                adapted for television and film. When not writing, Silvan teaches creative writing workshops and mentors
                emerging authors in the crime fiction genre.
            </p>
        </div>
    </div>
@endsection
