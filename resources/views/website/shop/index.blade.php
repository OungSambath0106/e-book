@extends('website.master')
@section('page_title', __('Shop Page'))
@section('content')
    <style>

    </style>
    <!-- Shop Hero Section -->
    <section class="hero">
        <div class="circle-decoration circle-1"></div>
        <div class="circle-decoration circle-2"></div>
        <div class="line-decoration line-1"></div>
        <div class="line-decoration line-2"></div>

        <div class="container">
            <p class="shop-subtitle">All Your Favorite Books In One Place 📚</p>
            <h1>Shop</h1>
            <a href="{{ route('home') }}" class="back-link">Back To Home</a>

            <div class="search-container">
                <input type="text" class="search-input" placeholder="Search for a book, author...">
                <button class="search-btn-hero">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Main Shop Content -->
    <section class="shop-content">
        <div class="container">
            <div class="shop-layout">
                <!-- Sidebar -->
                <div class="sidebar">
                    <div class="sidebar-widget">
                        <h3 class="sidebar-title">Categories</h3>
                        <ul class="categories-list">
                            <li><a href="#" class="active">All</a></li>
                            <li><a href="#">Art & Photography</a></li>
                            <li><a href="#">Biographies</a></li>
                            <li><a href="#">Cookbooks</a></li>
                            <li><a href="#">Business & Money</a></li>
                            <li><a href="#">Accessories</a></li>
                            <li><a href="#">Comics</a></li>
                            <li><a href="#">Children's Book</a></li>
                        </ul>
                    </div>

                    <div class="sidebar-widget">
                        <h3 class="sidebar-title">Years</h3>
                        <div class="filter-options">
                            <div class="filter-option">
                                <input type="checkbox" id="year-2015" class="filter-checkbox">
                                <label for="year-2015" class="filter-text">2015<span class="filter-count">
                                        (20)</span></label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="year-2016" class="filter-checkbox">
                                <label for="year-2016" class="filter-text">2016<span class="filter-count">
                                        (34)</span></label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="year-2017" class="filter-checkbox">
                                <label for="year-2017" class="filter-text">2017<span class="filter-count">
                                        (15)</span></label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="year-2018" class="filter-checkbox">
                                <label for="year-2018" class="filter-text">2018<span class="filter-count">
                                        (24)</span></label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="year-2019" class="filter-checkbox">
                                <label for="year-2019" class="filter-text">2019<span class="filter-count">
                                        (45)</span></label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="year-2020" class="filter-checkbox">
                                <label for="year-2020" class="filter-text">2020<span class="filter-count">
                                        (18)</span></label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="year-2021" class="filter-checkbox">
                                <label for="year-2021" class="filter-text">2021<span class="filter-count">
                                        (25)</span></label>
                            </div>
                        </div>
                    </div>

                    <div class="sidebar-widget">
                        <h3 class="sidebar-title">Ratings</h3>
                        <div class="filter-options">
                            <div class="filter-option">
                                <input type="checkbox" id="rating-5" class="filter-checkbox">
                                <label for="rating-5" class="filter-text">
                                    <div class="star-rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                </label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="rating-4" class="filter-checkbox">
                                <label for="rating-4" class="filter-text">
                                    <div class="star-rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                </label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="rating-3" class="filter-checkbox">
                                <label for="rating-3" class="filter-text">
                                    <div class="star-rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                </label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="rating-2" class="filter-checkbox">
                                <label for="rating-2" class="filter-text">
                                    <div class="star-rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                </label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="rating-1" class="filter-checkbox">
                                <label for="rating-1" class="filter-text">
                                    <div class="star-rating">
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Section -->
                <div class="products-section">
                    <div class="products-header">
                        <h2 class="products-title">Best Seller Items</h2>
                        <div class="products-sort">
                            <span class="sort-label">Default sorting</span>
                            <select class="sort-select">
                                <option value="default">Default sorting</option>
                                <option value="popularity">Sort by popularity</option>
                                <option value="rating">Sort by rating</option>
                                <option value="latest">Sort by latest</option>
                                <option value="price-low">Sort by price: low to high</option>
                                <option value="price-high">Sort by price: high to low</option>
                            </select>
                        </div>
                    </div>

                    @php
                        $books = [
                            [
                                'id' => 1,
                                'title' => 'ផ្ទះត្រើយស្ទឹងម្ខាង',
                                'author' => 'តាំង​ ហ៊ុយសេង',
                                'price' => '$11.99',
                                'rating' => 4.5,
                                'thumbnail' => 'book1.webp'
                            ],
                            [
                                'id' => 2,
                                'title' => '15ឆ្នាំក្រោយជួបគ្នា',
                                'author' => 'ម៉ុង ម៉ានិត',
                                'price' => '$11.99',
                                'rating' => 4.5,
                                'thumbnail' => 'book2.webp'
                            ],
                        ];
                    @endphp

                    <section class="books-grid">
                        @foreach ($books as $book)
                            <div class="book-card">
                                <div class="book-card-img">
                                    <img src="{{ asset('uploads/books/' . $book['thumbnail']) }}" alt="{{ $book['title'] }}">
                                </div>
                                <div class="book-card-content">
                                    <a href="{{ route('book.detail', $book['id']) }}"><h3>{{ $book['title'] }}</h3></a>
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
                    </section>

                    <div class="shop-info">
                        Showing Products 1 - 2 of 90 Results
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
