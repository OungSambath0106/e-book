@extends('website.master')
@section('page_title', __('Book Detail Page'))
@section('content')
    <style>
        /* Product Section */
        .product-section {
            padding: 70px 0;
            background-color: var(--light);
        }

        .product-container {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 60px;
            align-items: start;
        }

        .product-image {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            opacity: 0;
            transform: translateX(-30px);
            animation: fadeInLeft 1s 0.2s forwards;
        }

        .product-image img {
            width: 100%;
            height: auto;
            display: block;
            transition: transform 0.5s ease;
        }

        .product-image:hover img {
            transform: scale(1.05);
        }

        .product-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: var(--accent);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .product-info {
            opacity: 0;
            transform: translateX(30px);
            animation: fadeInRight 1s 0.4s forwards;
        }

        .product-title {
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--text);
        }

        .product-author {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            font-size: 16px;
            color: var(--gray);
        }

        .product-author a {
            color: var(--primary);
            text-decoration: none;
            margin-left: 5px;
            font-weight: 500;
            transition: color 0.3s;
        }

        .product-author a:hover {
            text-decoration: underline;
        }

        .product-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            margin-bottom: 30px;
            font-size: 15px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .meta-label {
            color: var(--gray);
        }

        .meta-value {
            font-weight: 500;
        }

        .in-stock {
            color: #2ecc71;
        }

        .ratings {
            display: flex;
            gap: 5px;
            margin-bottom: 25px;
        }

        .star {
            color: #ffc107;
            font-size: 18px;
        }

        .price-container {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        .current-price {
            font-size: 32px;
            font-weight: 600;
            color: var(--primary);
        }

        .original-price {
            font-size: 20px;
            color: var(--gray);
            text-decoration: line-through;
        }

        .product-actions {
            display: flex;
            gap: 15px;
            margin-bottom: 40px;
        }

        .add-to-cart,
        .buy-now {
            padding: 14px 30px;
            border-radius: 30px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .add-to-cart {
            background-color: transparent;
            color: var(--primary);
            border: 1px solid var(--primary);
        }

        .add-to-cart:hover {
            background-color: rgba(123, 72, 227, 0.1);
            transform: translateY(-3px);
        }

        .buy-now {
            background-color: var(--primary);
            color: white;
            border: none;
        }

        .buy-now:hover {
            background-color: #6339c0;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(123, 72, 227, 0.3);
        }

        /* Description Section */
        .description-section {
            padding: 40px 0 80px;
            opacity: 0;
            animation: fadeInUp 1s 0.6s forwards;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #eee;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 80px;
            height: 2px;
            background-color: var(--primary);
        }

        .description-content {
            line-height: 1.8;
            color: #555;
        }

        .description-content p {
            margin-bottom: 20px;
        }

        /* Related Products */
        .related-section {
            padding: 60px 0;
            background-color: var(--secondary);
        }

        .related-title {
            text-align: center;
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 40px;
        }

        .related-products {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
        }

        .related-product {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
        }

        .related-product:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .related-product-img {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .related-product-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .related-product:hover .related-product-img img {
            transform: scale(1.1);
        }

        .related-product-info {
            padding: 15px;
            text-align: center;
        }

        .related-product-title {
            font-weight: 600;
            font-size: 16px;
        }

        .related-product-author {
            color: var(--gray);
            font-size: 14px;
        }

        .related-product-price {
            color: var(--primary);
            font-weight: 600;
            font-size: 18px;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes floatAnimation {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .product-container {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .related-products {
                grid-template-columns: repeat(2, 1fr);
            }

            .footer-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            nav ul {
                display: none;
            }

            .hero-title {
                font-size: 36px;
            }

            .product-title {
                font-size: 28px;
            }

            .product-meta {
                gap: 15px;
            }

            .product-actions {
                flex-direction: column;
            }

            .add-to-cart,
            .buy-now {
                width: 100%;
                text-align: center;
            }
        }

        @media (max-width: 576px) {
            .related-products {
                grid-template-columns: 1fr;
            }

            .footer-container {
                grid-template-columns: 1fr;
            }

            .current-price {
                font-size: 28px;
            }

            .original-price {
                font-size: 18px;
            }
        }
    </style>

    @php
        $books = [
            [
                'id' => 1,
                'title' => 'ផ្ទះត្រើយស្ទឹងម្ខាង',
                'author' => 'តាំង​ ហ៊ុយសេង',
                'price' => '$11.99',
                'rating' => 4.5,
                'discount_percentage' => 20,
                'reviews' => 100,
                'barcode' => '1234567890',
                'format' => 'Paperback',
                'discount_price' => '11.99',
                'price' => '15.99',
                'pages' => 300,
                'thumbnail' => 'book1.webp',
                'description' => '',
            ],
            [
                'id' => 2,
                'title' => '15ឆ្នាំក្រោយជួបគ្នា',
                'author' => 'ម៉ុង ម៉ានិត',
                'price' => '$12.99',
                'rating' => 4.0,
                'reviews' => 100,
                'discount_percentage' => 20,
                'barcode' => '1234567890',
                'format' => 'Paperback',
                'discount_price' => '12.99',
                'price' => '15.99',
                'pages' => 300,
                'thumbnail' => 'book2.webp',
                'description' => '',
            ]
        ];
    @endphp
    <!-- Shop Hero Section -->
    <section class="hero">
        <div class="container">
            <p class="shop-subtitle">All Your Favorite Books In One Place 📚</p>
            <h1 class="hero-title">{{ $book['title'] }}</h1>
            <a href="{{ route('shop') }}" class="back-link">Back To Shop</a>

            <div class="search-container">
                <input type="text" class="search-input" placeholder="Search for a book, author...">
                <button class="search-btn-hero">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <div class="hero-shape shape-1"></div>
        <div class="hero-shape shape-2"></div>
        <div class="hero-shape shape-3"></div>
        <div class="hero-shape shape-4"></div>
    </section>

    <section class="product-section">
        <div class="container">
            <div class="product-container">
                <div class="product-image">
                    <img src="{{ asset('uploads/books/' . $book['thumbnail']) }}" alt="{{ $book['title'] }}">
                    <div class="product-badge">Bestseller</div>
                </div>

                <div class="product-info">
                    <h2 class="product-title">{{ $book['title'] }}</h2>
                    <div class="product-author">By <a href="#">{{ $book['author'] }}</a></div>

                    <div class="product-meta">
                        <div class="meta-item">
                            <span class="meta-label">Availability:</span>
                            <span class="meta-value in-stock">In Stock</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Barcode:</span>
                            <span class="meta-value">{{ $book['barcode'] }}</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Format:</span>
                            <span class="meta-value">{{ $book['format'] }}</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Pages:</span>
                            <span class="meta-value">{{ $book['pages'] }}</span>
                        </div>
                    </div>

                    <div class="ratings">
                        @for ($i = 0; $i < 5; $i++)
                            @if ($i < $book['rating'])
                                <i class="fas fa-star star"></i>
                            @else
                                <i class="fas fa-star-half-alt star"></i>
                            @endif
                        @endfor
                        <span style="margin-left: 8px; color: #777;">({{ $book['reviews'] }} reviews)</span>
                    </div>

                    <div class="price-container">
                        <span class="current-price">$ {{ $book['discount_price'] }}</span>
                        <span class="original-price">$ {{ $book['price'] }}</span>
                        <span
                            style="background-color: #f8d7da; color: #721c24; padding: 3px 10px; border-radius: 20px; font-size: 14px;">Save
                            {{ $book['discount_percentage'] }}%</span>
                    </div>

                    <div class="product-actions">
                        <button class="add-to-cart">
                            <i class="fas fa-shopping-cart" style="margin-right: 8px;"></i> Add To Cart
                        </button>
                        <button class="buy-now">Buy Now</button>
                    </div>

                    <div class="product-features">
                        <div style="display: flex; align-items: center; gap: 30px; margin-bottom: 20px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-truck" style="color: var(--primary);"></i>
                                <span>Free Shipping</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-undo" style="color: var(--primary);"></i>
                                <span>30-Day Returns</span>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 30px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-shield-alt" style="color: var(--primary);"></i>
                                <span>Secure Payment</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-headset" style="color: var(--primary);"></i>
                                <span>24/7 Support</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="description-section">
        <div class="container">
            <h3 class="section-title">Description</h3>
            <div class="description-content">
                <p>{!! $book['description'] !!}</p>
            </div>
        </div>
    </section>

    @php
        $relatedBooks = [
            [
                'id' => 1,
                'title' => 'ផ្ទះត្រើយស្ទឹងម្ខាង',
                'author' => 'តាំង​ ហ៊ុយសេង',
                'price' => '$11.99',
                'rating' => 4.5,
                'thumbnail' => 'book1.jpeg'
            ],
            [
                'id' => 2,
                'title' => '15ឆ្នាំក្រោយជួបគ្នា',
                'author' => 'ម៉ុង ម៉ានិត',
                'price' => '$11.99',
                'rating' => 4.5,
                'thumbnail' => 'book2.jpeg'
            ],
        ];
    @endphp
    <section class="related-section">
        <div class="container">
            <h3 class="related-title">You May Also Like</h3>
            <div class="related-products">
                @foreach ($relatedBooks as $relatedBook)
                    <div class="related-product">
                        <div class="related-product-img">
                            <img src="{{ asset('uploads/books/' . $relatedBook['thumbnail']) }}" alt="{{ $relatedBook['title'] }}">
                        </div>
                        <div class="related-product-info">
                            <h4 class="related-product-title">{{ $relatedBook['title'] }}</h4>
                            <p class="related-product-author">By {{ $relatedBook['author'] }}</p>
                            <div class="star-rating">
                                @for ($i = 0; $i < 5; $i++)
                                    @if ($i < $book['rating'])
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="fas fa-star-half-alt"></i>
                                    @endif
                                @endfor
                            </div>
                            <p class="related-product-price">{{ $relatedBook['price'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
