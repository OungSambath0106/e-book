@extends('website.master')
@section('page_title', __('Shop Page'))
@section('content')
    <style>
        .no-results {
            position: absolute;
            justify-self: center;
            bottom: -25vh;
        }

        @keyframes fadeUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            opacity: 0;
            animation: fadeUp 0.6s forwards 0.4s;
        }

        .book-card {
            opacity: 0;
            animation: fadeUp 0.6s forwards 0.4s;
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
            <h1>Shop</h1>
            <a href="{{ route('home') }}" class="back-link">Back To Home</a>

            <div class="search-container">
                <input type="text" class="search-input" placeholder="Search for a book, author...">
                <button class="search-btn-hero" type="button" aria-label="Search">
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
                            <li><a type="button" class="filter-btn active" data-id="all">All</a></li>
                            @foreach ($categories as $category)
                                <li><a type="button" class="filter-btn" data-id="{{ $category->id }}">{{ $category->name }}</a></li>
                            @endforeach
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
                    </div>

                    <section class="books-grid" id="best-seller-books">
                        @foreach ($bestSellersProducts as $book)
                            @include('website.shop.partials.card_book', ['book' => $book])
                        @endforeach
                    </section>

                    <div class="products-header all-products">
                        <div class="shop-info" id="shop-info">
                            Showing Products {{ $products->firstItem() }} - {{ $products->lastItem() }} of {{ $products->total() }} Results
                        </div>

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

                    <section class="books-grid" id="books-container">
                        @foreach ($products as $book)
                            @include('website.shop.partials.card_book', ['book' => $book])
                        @endforeach
                    </section>

                    <div id="pagination-links">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('.filter-btn').on('click', function () {
            let categoryId = $(this).data('id');

            $('.filter-btn').removeClass('active');
            $(this).addClass('active');

            $.ajax({
                url: '{{ route('filter-products', ['categoryId' => ':categoryId']) }}'.replace(':categoryId', categoryId),
                method: 'GET',
                beforeSend: function () {
                    $('#shop-info').html('');
                    $('#books-container').html('');
                    $('#pagination-links').html('');
                },
                success: function (response) {
                    if (response.html) {
                        $('#shop-info').html(`Showing Products ${response.firstItem} - ${response.lastItem} of ${response.count} Results`);
                        $('#books-container').html(response.html);
                        $('#pagination-links').html(response.pagination);
                    } else {
                        $('#books-container').html('<p class="no-results fade-in"> {{ __('No books found') }} </p>');
                        $('#shop-info').html(`Showing Products ${response.firstItem} - ${response.lastItem} of ${response.count} Results`);
                    }
                },
                error: function () {
                    $('#books-container').html('<p> {{ __('Error loading books') }} </p>');
                }
            });
        });
    </script>
@endpush