<footer>
    @php
        $setting = App\Models\BusinessSetting::all();
        $company_description = $setting->where('type', 'company_description')->first()->value ?? '';
        $social_media = $setting->where('type', 'social_media')->first()->value ?? '';
        $company_name = $setting->where('type', 'company_name')->first()->value ?? '';
        $copy_right_text = $setting->where('type', 'copy_right_text')->first()->value ?? '';

        $categories = App\Models\Category::all();
    @endphp
    <div class="container footer-container">
        <div class="footer-about">
            <div class="footer-logo">
                <div class="footer-logo-icon">
                    <i class="fas fa-book"></i>
                </div>
                {{ $company_name }}
            </div>
            <p>{!! $company_description !!}</p>
            <div class="social-links">
                @foreach (json_decode($social_media, true) as $social)
                    <a href="{{ $social['link'] }}" class="social-link" target="_blank">
                        @if ($social['title'] == 'Facebook')
                            <i class="fab fa-facebook-f"></i>
                        @elseif ($social['title'] == 'Instagram')
                            <i class="fab fa-instagram"></i>
                        @elseif ($social['title'] == 'Telegram')
                            <i class="fab fa-telegram"></i>
                        @elseif ($social['title'] == 'Youtube')
                            <i class="fab fa-youtube"></i>
                        @elseif ($social['title'] == 'X')
                            <i class="fab fa-x-twitter"></i>
                        @elseif ($social['title'] == 'Pinterest')
                            <i class="fab fa-pinterest"></i>
                        @elseif ($social['title'] == 'Tiktok')
                            <i class="fab fa-tiktok"></i>
                        @elseif ($social['title'] == 'Whatsapp')
                            <i class="fab fa-whatsapp"></i
                        @elseif ($social['title'] == 'Linkedin')
                            <i class="fab fa-linkedin"></i>
                        @elseif ($social['title'] == 'Github')
                            <i class="fab fa-github"></i>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>

        <div class="footer-links">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('categories') }}">Categories</a></li>
                <li><a href="{{ route('shop') }}">Shop</a></li>
                <li><a href="{{ route('authors') }}">Authors</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Blog</a></li>
            </ul>
        </div>

        <div class="footer-links">
            <h3>Categories</h3>
            <ul>
                @foreach ($categories as $category)
                    <li><a href="{{ route('categories') }}">{{ $category->name }}</a></li>
                @endforeach
            </ul>
        </div>

        <div class="footer-links">
            <h3>Customer Service</h3>
            <ul>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">FAQ</a></li>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Terms & Conditions</a></li>
                <li><a href="#">Return Policy</a></li>
            </ul>
        </div>
    </div>

    <div class="container">
        <div class="copyright">
            {{ $copy_right_text }}
        </div>
    </div>
</footer>