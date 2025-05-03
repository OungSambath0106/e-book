@extends('website.master')
@section('page_title', __('Home Page'))
@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <p class="shop-subtitle">All Your Favorite Books In One Place ✨</p>
            <h1>Largest Digital Library Of<br>Bestselling eBooks</h1>

            <div class="search-container">
                <input type="text" class="search-input" placeholder="Search for a book, author...">
                <button class="search-btn-hero">
                    <i class="fas fa-search"></i>
                </button>
            </div>

            <div class="book-showcase">
                <div class="book-image">
                    <img src="/api/placeholder/220/280" alt="Library Interior">
                </div>
                <div class="book-image">
                    <img src="/api/placeholder/220/280" alt="Stack of Books">
                </div>
                <div class="book-image">
                    <img src="/api/placeholder/220/280" alt="Person Reading">
                </div>
                <div class="book-image">
                    <img src="/api/placeholder/220/280" alt="Books on Shelf">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container features-container">
            <div class="feature">
                <div class="feature-icon">
                    <i class="fas fa-truck"></i>
                </div>
                <h3>Free Shipping</h3>
                <p>For Orders Over $100</p>
            </div>

            <div class="feature">
                <div class="feature-icon">
                    <i class="fas fa-exchange-alt"></i>
                </div>
                <h3>Exchange Offers</h3>
                <p>Book Exchange Policies</p>
            </div>

            <div class="feature">
                <div class="feature-icon">
                    <i class="fas fa-book-reader"></i>
                </div>
                <h3>My Subscriptions</h3>
                <p>Access Exclusive Books</p>
            </div>

            <div class="feature">
                <div class="feature-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h3>Help & Support</h3>
                <p>Contact Our Team 24/7</p>
            </div>
        </div>
    </section>

    @php
        $books = [
            [
                'title' => 'ផ្ទះត្រើយស្ទឹងម្ខាង',
                'author' => 'តាំង​ ហ៊ុយសេង',
                'price' => '$11.99',
                'rating' => 4.5,
                'thumbnail' => 'book1.webp'
            ],
            [
                'title' => '15ឆ្នាំក្រោយជួបគ្នា',
                'author' => 'ម៉ុង ម៉ានិត',
                'price' => '$11.99',
                'rating' => 4.5,
                'thumbnail' => 'book2.webp'
            ],
        ];
    @endphp

    <!-- Featured Books Section -->
    <section class="featured-books">
        <div class="container">
            <div class="section-header">
                <h2>Featured Books</h2>
            </div>

            <div class="books-grid">
                @foreach ($books as $book)
                    <div class="book-card">
                        <div class="book-card-img">
                            <img src="{{ asset('uploads/books/' . $book['thumbnail']) }}" alt="{{ $book['title'] }}">
                        </div>
                        <div class="book-card-content">
                            <h3>{{ $book['title'] }}</h3>
                            <p class="book-author">by {{ $book['author'] }}</p>
                            <div class="star-rating">
                                @for ($i = 0; $i < 5; $i++)
                                    @if ($i < $book['rating'])
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="fas fa-star-half-alt"></i>
                                    @endif
                                @endfor
                            </div>
                            <p class="book-price">{{ $book['price'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter">
        <div class="container newsletter-container">
            <h2>Subscribe to Our Newsletter</h2>
            <p>Get the latest updates on new books, exclusive offers, and more.</p>
            <form class="newsletter-form">
                <input type="email" class="newsletter-input" placeholder="Enter your email">
                <button type="submit" class="newsletter-btn">Subscribe</button>
            </form>
        </div>
    </section>
@endsection