@extends('website.master')
@section('title', 'Categories Page')
@section('content')
    <style>
        hero p {
            color: #666;
            margin-bottom: 20px;
        }

        .decorative-circle {
            position: absolute;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 2px solid #ffd700;
            z-index: -1;
        }

        .circle-1 {
            top: 50px;
            left: 15%;
            border-color: #e6a8a8;
        }

        .circle-2 {
            bottom: 30px;
            right: 20%;
            border-color: #7b68ee;
        }

        /* Category Filters */
        .category-filters {
            display: flex;
            gap: 10px;
            margin-bottom: 40px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .filter-btn {
            background-color: #fff;
            border: 1px solid #e0e0e0;
            padding: 8px 16px;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background-color: #7b68ee;
            color: white;
            border-color: #7b68ee;
        }

        /* Products Grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 30px;
            padding-top: 20px;
            margin-bottom: 60px;
        }

        .product-card {
            background-color: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            padding: 20px;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .product-image {
            height: 300px;
            width: 100%;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .product-title {
            font-weight: 600;
            font-size: 18px;
            margin-bottom: 5px;
        }

        .product-author {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .rating {
            color: #ffd700;
            margin-bottom: 10px;
        }

        .product-price {
            font-weight: 700;
            font-size: 18px;
            color: #333;
        }

        /* Decorative elements */
        .decorative-shape {
            position: absolute;
            z-index: -1;
            opacity: 0.6;
        }

        .shape-1 {
            top: 20%;
            left: 5%;
            width: 150px;
            height: 150px;
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            border: 2px solid #ffd700;
        }

        .shape-2 {
            bottom: 10%;
            right: 5%;
            width: 180px;
            height: 180px;
            border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
            border: 2px solid #e6a8a8;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .nav-container {
                flex-direction: column;
                gap: 15px;
            }

            nav ul {
                gap: 15px;
            }

            .hero h1 {
                font-size: 36px;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }
        }
    </style>
    <section class="hero">
        <div class="decorative-circle circle-1"></div>
        <div class="decorative-circle circle-2"></div>

        <p class="shop-subtitle">Explore your favorite books 📚</p>
        <h1>Categories</h1>
        <a href="{{ route('home') }}" class="back-link">Back To Home</a>

        <div class="search-container">
            <input type="text" class="search-input" placeholder="Search For Popular Books...">
            <button class="search-btn-hero">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z"
                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M21 21L16.65 16.65" stroke="white" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </button>
        </div>
    </section>
    <section class="categories-body">
        <div class="container">
            <section class="category-filters">
                <button class="filter-btn active">All</button>
                <button class="filter-btn">Art & Crafts</button>
                <button class="filter-btn">Biography</button>
                <button class="filter-btn">Business & Development</button>
                <button class="filter-btn">Children's Books</button>
                <button class="filter-btn">Cookbooks</button>
                <button class="filter-btn">Fiction & Fantasies</button>
                <button class="filter-btn">Comics</button>
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
            <section class="books-grid">
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
            </section>
        </div>
    </section>

    <div class="decorative-shape shape-1"></div>
@endsection
