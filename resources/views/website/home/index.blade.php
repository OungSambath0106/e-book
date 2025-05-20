@extends('website.master')
@section('page_title', __('Home Page'))
@section('content')
    <style>
        .books-grid {
            min-height: 200px;
        }
        .book-card {
            position: relative;
        }
        .firstLine {
            font-size: 14px;
            font-weight: 600;
        }.secondLine {
            font-size: 12px;
            font-weight: 500;
        }

        .badges {
            position: absolute;
            margin:25px auto;
            top: 0;
            right: 20px;
            width:50px;
            height:50px;
            background:#552F87;
            border-radius:100%;
            color: #FFF;
            line-height: 15px;
            text-align: center;
            align-content: center;
            text-transform: uppercase;
            font-family: "Open Sans",sans-serif;
            -webkit-animation: 3s ease-in-out 0s normal none infinite running swing;
            -moz-animation: 3s ease-in-out 0s normal none infinite running swing;
            -o-animation: 3s ease-in-out 0s normal none infinite running swing;
            animation: 3s ease-in-out 0s normal none infinite running swing;
            /* animation: swing 1s infinite ease-in-out; */
            transform-origin: center;

            -webkit-transform-origin: 100px -71px;
            -moz-transform-origin: 100px -71px;
            -o-transform-origin: 100px -71px;
            transform-origin: 100px -71px;
        }
        .badges:before {
            content: '';
            position: absolute;
            top: 22.5px;
            left: 22.5px;
            width: 5px;
            height: 5px;
            border-radius: 100%;

            -webkit-box-shadow: 0px -20.5px 0px -0.5px #fff, 0px -25px #552F87, 5px -24.5px #552F87, 9.75px -23.5px #552F87, 14px -21.25px #552F87, 17.75px -18px #552F87,
                20.75px -14.25px #552F87, 23.25px -10px #552F87, 24.5px -5px #552F87, 25px 0px #552F87,

                -5px -24.5px #552F87, -9.75px -23.5px #552F87, -17.75px -18px #552F87,
                -14px -21.25px #552F87, -20.75px -14.25px #552F87, -23.25px -10px #552F87, -24.5px -5px #552F87, -25px 0px #552F87,

                0px 25px #552F87, -5px 24.5px #552F87, -9.75px 23.5px #552F87, -14px 21.25px #552F87,
                -17.75px 18px #552F87, -20.75px 14.25px #552F87, -23.25px -10px #552F87, -24.5px 5px #552F87, -23.25px 10px #552F87,

                5px 24.5px #552F87, 9.75px 23.5px #552F87, 14px 21.25px #552F87,
                17.75px 18px #552F87, 20.75px 14.25px #552F87, 23.25px 10px #552F87, 24.5px 5px #552F87;

            -moz-box-shadow: 0px -20.5px 0px -0.5px #fff, 0px -25px #552F87, 5px -24.5px #552F87, 9.75px -23.5px #552F87, 14px -21.25px #552F87, 17.75px -18px #552F87,
                20.75px -14.25px #552F87, 23.25px -10px #552F87, 24.5px -5px #552F87, 25px 0px #552F87,

                -5px -24.5px #552F87, -9.75px -23.5px #552F87, -17.75px -18px #552F87,
                -14px -21.25px #552F87, -20.75px -14.25px #552F87, -23.25px -10px #552F87, -24.5px -5px #552F87, -25px 0px #552F87,

                0px 25px #552F87, -5px 24.5px #552F87, -9.75px 23.5px #552F87, -14px 21.25px #552F87,
                -17.75px 18px #552F87, -20.75px 14.25px #552F87, -23.25px -10px #552F87, -24.5px 5px #552F87, -23.25px 10px #552F87,

                5px 24.5px #552F87, 9.75px 23.5px #552F87, 14px 21.25px #552F87,
                17.75px 18px #552F87, 20.75px 14.25px #552F87, 23.25px 10px #552F87, 24.5px 5px #552F87;
            -o-box-shadow: 0px -20.5px 0px -0.5px #fff, 0px -25px #552F87, 5px -24.5px #552F87, 9.75px -23.5px #552F87, 14px -21.25px #552F87, 17.75px -18px #552F87,
                20.75px -14.25px #552F87, 23.25px -10px #552F87, 24.5px -5px #552F87, 25px 0px #552F87,

                -5px -24.5px #552F87, -9.75px -23.5px #552F87, -17.75px -18px #552F87,
                -14px -21.25px #552F87, -20.75px -14.25px #552F87, -23.25px -10px #552F87, -24.5px -5px #552F87, -25px 0px #552F87,

                0px 25px #552F87, -5px 24.5px #552F87, -9.75px 23.5px #552F87, -14px 21.25px #552F87,
                -17.75px 18px #552F87, -20.75px 14.25px #552F87, -23.25px -10px #552F87, -24.5px 5px #552F87, -23.25px 10px #552F87,

                5px 24.5px #552F87, 9.75px 23.5px #552F87, 14px 21.25px #552F87,
                17.75px 18px #552F87, 20.75px 14.25px #552F87, 23.25px 10px #552F87, 24.5px 5px #552F87;
            box-shadow: 0px -20.5px 0px -0.5px #fff, 0px -25px #552F87, 5px -24.5px #552F87, 9.75px -23.5px #552F87, 14px -21.25px #552F87, 17.75px -18px #552F87,
                20.75px -14.25px #552F87, 23.25px -10px #552F87, 24.5px -5px #552F87, 25px 0px #552F87,

                -5px -24.5px #552F87, -9.75px -23.5px #552F87, -17.75px -18px #552F87,
                -14px -21.25px #552F87, -20.75px -14.25px #552F87, -23.25px -10px #552F87, -24.5px -5px #552F87, -25px 0px #552F87,

                0px 25px #552F87, -5px 24.5px #552F87, -9.75px 23.5px #552F87, -14px 21.25px #552F87,
                -17.75px 18px #552F87, -20.75px 14.25px #552F87, -23.25px -10px #552F87, -24.5px 5px #552F87, -23.25px 10px #552F87,

                5px 24.5px #552F87, 9.75px 23.5px #552F87, 14px 21.25px #552F87,
                17.75px 18px #552F87, 20.75px 14.25px #552F87, 23.25px 10px #552F87, 24.5px 5px #552F87;
        }
        .badges:after{
            content:'';
            position:absolute;
            top:-25px;right:24px;
            width:1.5px;height:35px;
            border-radius:0%;
            background:#000;
        }

        @-webkit-keyframes swing {
            0%   { -webkit-transform: rotate(-3deg) translate(-2px, -2px); }
            50%  { -webkit-transform: rotate(3deg) translate(2px, 2px); }
            100% { -webkit-transform: rotate(-3deg) translate(-2px, -2px); }
        }
        @-moz-keyframes swing {
            0%   { -moz-transform: rotate(-3deg) translate(-2px, -2px); }
            50%  { -moz-transform: rotate(3deg) translate(2px, 2px); }
            100% { -moz-transform: rotate(-3deg) translate(-2px, -2px); }
        }
        @-o-keyframes swing {
            0%   { -o-transform: rotate(-3deg) translate(-2px, -2px); }
            50%  { -o-transform: rotate(3deg) translate(2px, 2px); }
            100% { -o-transform: rotate(-3deg) translate(-2px, -2px); }
        }
        @keyframes swing {
            0%   { transform: rotate(-3deg) translate(-2px, -2px); }
            50%  { transform: rotate(3deg) translate(2px, 2px); }
            100% { transform: rotate(-3deg) translate(-2px, -2px); }
        }
    </style>
    <!-- Hero Section -->
    <section class="hero" style="padding-bottom: 40px;">
        <div class="container">
            <p class="shop-subtitle">All Your Favorite Books In One Place ✨</p>
            <h1>Largest Digital Library Of<br>Bestselling eBooks</h1>

            <div class="search-container">
                <input type="text" class="search-input" placeholder="Search your favorite books..." id="search-input">
                <button class="search-btn-hero" type="button" aria-label="Search">
                    <i class="fas fa-search"></i>
                </button>
            </div>

            <div class="book-showcase">
                @foreach ($banners as $banner)
                    <div class="book-image parallelogram">
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
                    <a href="{{ route('all.books.show', ['type' => 'featured']) }}" class="btn-view-all">
                        <span>View All</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                @endif
            </div>

            <div class="books-grid " id="featured-books-container">
                @include('website.home.partials.feature_books', ['featured_products' => $featured_products])
            </div>
        </div>
    </section>

    <!-- Best Seller Books Section -->
    <section class="best-seller-books" data-aos="fade-up">
        <div class="container">
            <div class="section-header">
                <h2>Best Seller Books</h2>
                <a href="{{ route('all.books.show', ['type' => 'bestseller']) }}" class="btn-view-all">
                    <span>View All</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="books-grid " id="best-seller-container">
                @include('website.home.partials.best_seller_books', ['best_sellers' => $best_sellers])
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

    <!-- New Arrivals Section -->
    <section class="new-arrivals-books" data-aos="fade-up">
        <div class="container">
            <div class="section-header">
                <h2>New Arrivals</h2>
                @if (count($new_arrivals) > 0)
                    <a href="{{ route('all.books.show', ['type' => 'new_arrival']) }}" class="btn-view-all">
                        <span>View All</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                @endif
            </div>

            <div class="books-grid " id="new-arrivals-container">
                @include('website.home.partials.new_arrival_books', ['new_arrivals' => $new_arrivals])
            </div>
        </div>
    </section>

    <!-- Recommended Books Section -->
    <section class="recommended-books" data-aos="fade-up">
        <div class="container">
            <div class="section-header">
                <h2>Recommended Books</h2>
                @if (count($recommended) > 0)
                    <a href="{{ route('all.books.show', ['type' => 'recommended']) }}" class="btn-view-all">
                        <span>View All</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                @endif
            </div>

            <div class="books-grid " id="recommended-container">
                @include('website.home.partials.recommended_books', ['recommended' => $recommended])
            </div>
        </div>
    </section>

    <!-- Popular Books Section -->
    <section class="popular-books" data-aos="fade-up">
        <div class="container">
            <div class="section-header">
                <h2>Popular Books</h2>
                @if (count($popular) > 0)
                    <a href="{{ route('all.books.show', ['type' => 'popular']) }}" class="btn-view-all">
                        <span>View All</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                @endif
            </div>

            <div class="books-grid " id="popular-container">
                @include('website.home.partials.popular_books', ['popular' => $popular])
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
{{-- @push('js')
    <script>
        document.getElementById('search-input').addEventListener('click', function () {
            window.location.href = "{{ route('books.search') }}";
        });
    </script>
@endpush --}}