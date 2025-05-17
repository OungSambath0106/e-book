@extends('website.master')
@section('page_title', __('Home Page'))
@section('content')
    <style>
        .books-grid {
            position: relative;
        }

        .no-results {
            position: absolute;
            justify-self: center;
            align-self: center;
        }
    </style>
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
                                @if ($banner->image && file_exists(public_path('uploads/banners/' . $banner->image))) {{ asset('uploads/banners/' . $banner->image) }}
                                @else
                                    {{ asset('uploads/default1.png') }} @endif
                                "
                            alt="{{ $banner->name }}">
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
    <section class="featured-books" data-aos="fade-up">
        <div class="container">
            <div class="section-header">
                <h2>Featured Books</h2>
                @if (count($featured_products) > 0)
                    <a href="{{ route('shop') }}" class="btn-view-all">
                        <span>View All</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                @endif
            </div>

            <div class="books-grid">
                @forelse ($featured_products as $product)
                    <div class="book-card">
                        <div class="book-card-img">
                            <img src="
                                @if ($product->image && file_exists(public_path('uploads/products/' . $product->image))) {{ asset('uploads/products/' . $product->image) }}
                                @else
                                    {{ asset('uploads/default1.png') }} @endif
                                "
                                alt="{{ @$product->name }}">
                        </div>
                        <div class="book-card-content">
                            <h3>{{ @$product->name }}</h3>
                            <p class="book-author"> By {{ @$product->author->name }}</p>
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
                @empty
                    <div class="no-results" data-aos="fade-up">
                        <p>Featured Books Not Available.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- New Arrivals Section -->
    <section class="new-arrivals-books" data-aos="fade-up">
        <div class="container">
            <div class="section-header">
                <h2>New Arrivals</h2>
                @if (count($new_arrivals) > 0)
                    <a href="{{ route('shop') }}" class="btn-view-all">
                        <span>View All</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                @endif
            </div>

            <div class="books-grid">
                @forelse ($new_arrivals as $product)
                    <div class="book-card">
                        <div class="book-card-img">
                            <img src="
                                @if ($product->image && file_exists(public_path('uploads/products/' . $product->image))) {{ asset('uploads/products/' . $product->image) }}
                                @else
                                    {{ asset('uploads/default1.png') }} @endif
                                "
                                alt="{{ @$product->name }}">
                        </div>
                        <div class="book-card-content">
                            <h3>{{ @$product->name }}</h3>
                            <p class="book-author"> By {{ @$product->author->name }}</p>
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
                @empty
                    <div class="no-results" data-aos="fade-up">
                        <p>New Arrivals Books Not Available.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Promotions Section -->
    <section class="promotions" data-aos="fade-up">
        <div id="carouselExampleControls" class="carousel slide container" data-ride="carousel">
            <div class="carousel-inner">
                @foreach ($promotions as $promotion)
                    <div class="carousel-item @if ($loop->first) active @endif">
                        @if ($promotion->promotiongallery && count($promotion->promotiongallery->images) > 0)
                            @php
                                $firstImage = $promotion->promotiongallery->images[0];
                                $allImages = $promotion->promotiongallery->images;
                            @endphp
                            <img src="{{ file_exists(public_path('uploads/promotions/' . $firstImage)) ? asset('uploads/promotions/' . $firstImage) : asset('uploads/default1.png') }}"
                                alt="promotion Image" style="width:100%; height:400px; object-fit: cover;">
                        @else
                            <img src="{{ !empty($promotion->image[0]) && file_exists(public_path('uploads/promotions/' . $promotion->image[0])) ? asset('uploads/promotions/' . $promotion->image[0]) : asset('uploads/default.png') }}"
                                alt="promotion Image" style="width:100%; height:400px; object-fit: cover;">
                        @endif
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </section>

    <!-- Recommended Books Section -->
    <section class="recommended-books" data-aos="fade-up">
        <div class="container">
            <div class="section-header">
                <h2>Recommended Books</h2>
                @if (count($recommended) > 0)
                    <a href="{{ route('shop') }}" class="btn-view-all">
                        <span>View All</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                @endif
            </div>

            <div class="books-grid">
                @forelse ($recommended as $product)
                    <div class="book-card">
                        <div class="book-card-img">
                            <img src="
                                @if ($product->image && file_exists(public_path('uploads/products/' . $product->image))) {{ asset('uploads/products/' . $product->image) }}
                                @else
                                    {{ asset('uploads/default1.png') }} @endif
                                "
                                alt="{{ @$product->name }}">
                        </div>
                        <div class="book-card-content">
                            <h3>{{ @$product->name }}</h3>
                            <p class="book-author"> By {{ @$product->author->name }}</p>
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
                @empty
                    <div class="no-results" data-aos="fade-up">
                        <p>Recommended Books Not Available.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Popular Books Section -->
    <section class="popular-books" data-aos="fade-up">
        <div class="container">
            <div class="section-header">
                <h2>Popular Books</h2>
                @if (count($popular) > 0)
                    <a href="{{ route('shop') }}" class="btn-view-all">
                        <span>View All</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                @endif
            </div>

            <div class="books-grid">
                @forelse ($popular as $product)
                    <div class="book-card">
                        <div class="book-card-img">
                            <img src="
                                @if ($product->image && file_exists(public_path('uploads/products/' . $product->image))) {{ asset('uploads/products/' . $product->image) }}
                                @else
                                    {{ asset('uploads/default1.png') }} @endif
                                "
                                alt="{{ @$product->name }}">
                        </div>
                        <div class="book-card-content">
                            <h3>{{ @$product->name }}</h3>
                            <p class="book-author"> By {{ @$product->author->name }}</p>
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
                @empty
                    <div class="no-results" data-aos="fade-up">
                        <p>Popular Books Not Available.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Best Seller Books Section -->
    <section class="best-seller-books" data-aos="fade-up">
        <div class="container">
            <div class="section-header">
                <h2>Best Seller Books</h2>
                @if (count($best_sellers) > 0)
                    <a href="{{ route('shop') }}" class="btn-view-all">
                        <span>View All</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                @endif
            </div>

            <div class="books-grid">
                @forelse ($best_sellers as $product)
                    <div class="book-card">
                        <div class="book-card-img">
                            <img src="
                                @if ($product->image && file_exists(public_path('uploads/products/' . $product->image))) {{ asset('uploads/products/' . $product->image) }}
                                @else
                                    {{ asset('uploads/default1.png') }} @endif
                                "
                                alt="{{ @$product->name }}">
                        </div>
                        <div class="book-card-content">
                            <h3>{{ @$product->name }}</h3>
                            <p class="book-author"> By {{ @$product->author->name }}</p>
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
                @empty
                    <div class="no-results" data-aos="fade-up">
                        <p>Best Seller Books Not Available.</p>
                    </div>
                @endforelse
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
