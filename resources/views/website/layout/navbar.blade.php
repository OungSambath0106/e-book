<header>
    @php
        $setting = App\Models\BusinessSetting::all();
        $web_header_logo = $setting->where('type', 'web_header_logo')->first()->value ?? '';
        $company_name = $setting->where('type', 'company_name')->first()->value ?? '';

        if (auth()->guard('customers')->check()) {
            $cartCount = App\Models\CartItem::where('customer_id', auth()->guard('customers')->user()->id)->count();
        }
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
                <li><a href="#">About Us</a></li>
            </ul>
        </nav>

        <div class="nav-buttons">
            <button type="button" class="btn cart-btn position-relative px-2" style="background: none; border: none;"
                @if (auth()->guard('customers')->check() && $cartCount > 0)
                    onclick="window.location.href='{{ route('checkout') }}'"
                @elseif (auth()->guard('customers')->check() && $cartCount == 0)
                    onclick="window.location.href='{{ route('shop') }}'"
                @else
                    onclick="window.location.href='{{ route('customer.loginForm') }}'"
                @endif
            >
                <i class="fas fa-shopping-cart"></i>
                @if (auth()->guard('customers')->check() && $cartCount > 0)
                    <span id="cart-count" class="badge-count">
                        {{ $cartCount }}
                    </span>
                @endif
            </button>

            <button type="button" class="btn fav-btn position-relative px-2" style="background: none; border: none;">
                <i class="fas fa-heart"></i>
                <span id="fav-count" class="badge-count">
                    {{-- {{ $favCount }} --}}
                    0
                </span>
            </button>

            <button type="button" class="user-info d-flex align-items-center pl-3 pr-2 @if(auth()->guard('customers')->check()) dropdown-toggle @endif"
                id="user-info-dropdown" style="gap: 5px; background: none; border: none; cursor: pointer;"
                @if(auth()->guard('customers')->check())
                    data-toggle="dropdown"
                    aria-expanded="false"
                    aria-haspopup="true"
                @else
                    onclick="window.location.href='{{ route('customer.loginForm') }}'"
                @endif
            >
                <div class="user-info-profile">
                    @if (auth()->guard('customers')->check())
                        <img src="{{ auth()->guard('customers')->user()->image_url }}" alt="profile" width="35px" height="35px">
                    @else
                        <i class="fas fa-user"></i>
                    @endif
                </div>
                <div class="user-info-text d-flex flex-column align-items-start p-1">
                    @if (auth()->guard('customers')->check())
                        <span class="user-welcome"> Hi, Welcome! </span>
                        <span class="user-name">{{ auth()->guard('customers')->user()->name }}</span>
                    @else
                        <span class="user-name">Sign In</span>
                    @endif
                </div>
                @if (auth()->guard('customers')->check())
                    <i class="fas fa-sort-down px-1"></i>
                @endif
            </button>
            @if(auth()->guard('customers')->check())
                <div class="dropdown-menu user-info-dropdown" aria-labelledby="user-info-dropdown">
                    <div class="dropdown-item">
                        <a href="#">My Orders</a>
                    </div>
                    <div class="dropdown-item">
                        <a href="#">My Profile</a>
                    </div>
                    <div class="dropdown-divider"></div>
                    <div class="dropdown-item logout-item">
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</header>
