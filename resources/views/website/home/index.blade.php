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
                <button class="search-btn-hero" type="button" aria-label="Search">
                    <i class="fas fa-search"></i>
                </button>
            </div>

            <div class="book-showcase">
                @foreach ($banners as $banner)
                    <div class="book-image">
                        <img src="
                                @if ($banner->image && file_exists(public_path('uploads/banners/' . $banner->image)))
                                    {{ asset('uploads/banners/'. $banner->image) }}
                                @else
                                    {{ asset('uploads/default1.png') }}
                                @endif
                                " alt="{{ $banner->name }}">
                    </div>
                @endforeach
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

    <!-- Featured Books Section -->
    <section class="featured-books">
        <div class="container">
            <div class="section-header">
                <h2>Featured Books</h2>
            </div>

            <div class="books-grid">
                @foreach ($products as $product)
                    <div class="book-card">
                        <div class="book-card-img">
                            <img src="
                                @if ($product->image && file_exists(public_path('uploads/products/' . $product->image)))
                                    {{ asset('uploads/products/'. $product->image) }}
                                @else
                                    {{ asset('uploads/default1.png') }}
                                @endif
                                " alt="{{ @$product->name }}">
                        </div>
                        <div class="book-card-content">
                            <h3>{{ @$product->name }}</h3>
                            <p class="book-author">by {{ @$product->author->name }}</p>
                            <div class="star-rating">
                                @for ($i = 0; $i < 5; $i++)
                                    @if ($i < @$product->rating)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <p class="book-price"> $ {{ @$product->price }} </p>
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