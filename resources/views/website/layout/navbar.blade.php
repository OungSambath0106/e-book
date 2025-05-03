<header>
    <div class="container nav-container">
        <a href="#" class="logo">
            <div class="logo-icon">
                <i class="fas fa-book"></i>
            </div>
            E-Books.
        </a>

        <nav>
            <ul>
                <li><a class="@if (request()->is('/')) active @endif" href="{{ route('home') }}">Home</a></li>
                <li><a class="@if (request()->is('categories')) active @endif"
                        href="{{ route('categories') }}">Categories</a></li>
                <li><a class="@if (request()->is('shop') || request()->is('book/*')) active @endif" href="{{ route('shop') }}">Shop</a></li>
                <li><a class="@if (request()->is('authors') || request()->is('author-detail')) active @endif" href="{{ route('authors') }}">Authors</a>
                </li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Blog</a></li>
            </ul>
        </nav>

        <div class="nav-buttons">
            <button class="search-btn" type="button" aria-label="Search">
                <i class="fas fa-search"></i>
            </button>

            <button class="cart-btn" type="button" aria-label="View cart">
                <i class="fas fa-shopping-cart"></i>
            </button>

            <button class="contact-btn" type="button" aria-label="Contact now">
                Contact Now
            </button>
        </div>
    </div>
</header>
