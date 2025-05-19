@extends('website.master')
@section('page_title', __('Shop Page'))
@section('content')
    <style>
        .books-grid {
            min-height: 200px;
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
                <input type="text" class="search-input" placeholder="Search your favorite books..." id="search-input">
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
                            @foreach ($years as $year)
                                <div class="filter-option">
                                    <input type="checkbox" id="year-{{ $year }}" class="filter-checkbox filter-year" data-year="{{ $year }}">
                                    <label for="year-{{ $year }}" class="filter-text">
                                        {{ $year }} <span class="filter-count">({{ $yearCounts[$year] ?? 0 }})</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="sidebar-widget">
                        <h3 class="sidebar-title">Ratings</h3>
                        <div class="filter-options">
                            @for ($i = 5; $i >= 1; $i--)
                                <div class="filter-option">
                                    <input type="checkbox" id="rating-{{ $i }}" class="filter-checkbox filter-rating" data-rating="{{ $i }}">
                                    <label for="rating-{{ $i }}" class="filter-text">
                                        <div class="star-rating">
                                            @for ($j = 1; $j <= 5; $j++)
                                                <i class="{{ $j <= $i ? 'fas fa-star' : 'far fa-star' }}"></i>
                                            @endfor
                                        </div>
                                    </label>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>

                <!-- Products Section -->
                <div class="products-section">
                    <div class="products-header all-products">
                        <div class="shop-info" id="shop-info">
                            Showing Products {{ $products->firstItem() }} - {{ $products->lastItem() }} of {{ $products->total() }} Results
                        </div>

                        <div class="products-sort">
                            <span class="sort-label">Default sorting</span>
                            <select class="sort-select">
                                <option value="default">Default sorting</option>
                                <option value="popularity">Sort by popularity</option>
                                <option value="bestseller">Sort by bestseller</option>
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
        let filters = {
            categoryId: 'all',
            years: [],
            ratings: [],
            sort: 'default'
        };

        // Triggered on category click
        $('.filter-btn').on('click', function () {
            filters.categoryId = $(this).data('id');
            $('.filter-btn').removeClass('active');
            $(this).addClass('active');
            fetchBooks();
        });

        // Triggered on checkbox change (years & ratings)
        $('.filter-checkbox').on('change', function () {
            filters.years = $('.filter-checkbox[id^="year-"]:checked').map(function () {
                return $(this).attr('id').replace('year-', '');
            }).get();

            filters.ratings = $('.filter-checkbox[id^="rating-"]:checked').map(function () {
                return $(this).attr('id').replace('rating-', '');
            }).get();

            fetchBooks();
        });

        // Triggered on sort select
        $('.sort-select').on('change', function () {
            filters.sort = $(this).val();
            fetchBooks();
        });

        // Fetch function
        function fetchBooks() {
            $.ajax({
                url: "{{ url('/shop/filter-products') }}/" + filters.categoryId,
                method: 'GET',
                data: {
                    years: filters.years,
                    ratings: filters.ratings,
                    sort: filters.sort
                },
                beforeSend: function () {
                    $('#books-container').html('<div class="loading">Loading...</div>');
                    $('#pagination-links').html('');
                    $('#shop-info').html('');
                },
                success: function (response) {
                    if (response.html) {
                        $('#books-container').html(response.html);
                        $('#pagination-links').html(response.pagination);
                        $('#shop-info').html(`Showing Products ${response.firstItem} - ${response.lastItem} of ${response.count} Results`);
                    } else {
                        $('#books-container').html('<p class="no-results fade-in">{{ __('No books found') }}</p>');
                        $('#shop-info').html(`Showing Products 0 - 0 of 0 Results`);
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    $('#books-container').html('<p>{{ __('Error loading books') }}</p>');
                }
            });
        }

        $(document).ready(function () {
            // 1. Uncheck all filter checkboxes on page load
            $('.filter-checkbox').prop('checked', false);

            // 2. Reset sort select to "default"
            $('.sort-select').val('default');

            // 3. Update sort label text
            $('.sort-label').text($('.sort-select option:selected').text());

            // 4. Update sort label on change
            $('.sort-select').on('change', function () {
                $('.sort-label').text($(this).find('option:selected').text());
            });
        });
    </script>
@endpush