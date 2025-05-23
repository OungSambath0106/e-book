<header>
    @php
        $setting = App\Models\BusinessSetting::all();
        $web_header_logo = $setting->where('type', 'web_header_logo')->first()->value ?? '';
        $company_name = $setting->where('type', 'company_name')->first()->value ?? '';

        $cartCount = App\Models\CartItem::where('customer_id', auth()->guard('customers')->user()->id)->count();
    @endphp
    <div class="container nav-container">
        <a href="{{ route('home') }}" class="logo">
            <div class="logo-icon">
                <img src="{{ asset('uploads/business_settings/' . $web_header_logo) }}" alt="logo" width="26px" height="26px">
            </div>
            {{ $company_name }}
        </a>

        <nav>
            <ul>
                <li><a class="@if (request()->is('/') || request()->is('books/all')) active @endif" href="{{ route('home') }}">Home</a></li>
                <li><a class="@if (request()->is('categories')) active @endif"
                        href="{{ route('categories') }}">Categories</a></li>
                <li><a class="@if (request()->is('shop') || request()->is('book-detail/*')) active @endif" href="{{ route('shop') }}">Shop</a></li>
                <li><a class="@if (request()->is('authors') || request()->is('author-detail/*')) active @endif" href="{{ route('authors') }}">Authors</a>
                </li>
                <li><a href="{{ route('customer.loginForm') }}">About Us</a></li>
            </ul>
        </nav>

        <div class="nav-buttons">
            <button type="button" class="btn cart-btn position-relative" style="background: none; border: none; color: #000;" onclick="window.location.href='{{ route('checkout') }}'">
                <i class="fas fa-shopping-cart"></i>
                <span id="cart-count" class="badge-count">
                    {{ $cartCount }}
                </span>
            </button>

            <button class="contact-btn" type="button" aria-label="Contact now">
                Contact Now
            </button>
        </div>
    </div>
</header>
