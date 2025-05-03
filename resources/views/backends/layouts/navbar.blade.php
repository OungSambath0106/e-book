<style>
    .nav-item .nav-link {
        margin-bottom: 0 !important;
    }
</style>
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur"
    data-scroll="false">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6">
                <li class="breadcrumb-item text-sm">
                    <a class="opacity-5 text-white" style="color: #fff !important;" href="{{ route('admin.dashboard') }}">
                        {{ __('Pages') }}
                    </a>
                </li>

                {{-- Parent Menu Detection --}}
                @if (request()->routeIs('admin.brand*') || request()->routeIs('admin.product*'))
                    <li class="breadcrumb-item text-sm text-white">
                        <a href="#" class="opacity-5 text-white" style="color: #fff !important;">{{ __('Product Management') }}</a>
                    </li>
                @elseif (request()->routeIs('admin.baner-slider*') || request()->routeIs('admin.shoes-slider*'))
                    <li class="breadcrumb-item text-sm text-white">
                        <a href="#" class="opacity-5 text-white" style="color: #fff !important;">{{ __('Banner Slider') }}</a>
                    </li>
                @elseif (request()->routeIs('admin.user*') || request()->routeIs('admin.customer*') || request()->routeIs('admin.roles*'))
                    <li class="breadcrumb-item text-sm text-white">
                        <a href="#" class="opacity-5 text-white" style="color: #fff !important;">{{ __('User Management') }}</a>
                    </li>
                @endif

                {{-- Submenu Detection --}}
                @if (request()->routeIs('admin.brand*'))
                    <li class="breadcrumb-item text-sm text-white active" aria-current="page">{{ __('Brand') }}</li>
                @elseif (request()->routeIs('admin.product*'))
                    <li class="breadcrumb-item text-sm text-white active" aria-current="page">{{ __('Product') }}</li>
                @elseif (request()->routeIs('admin.baner-slider*'))
                    <li class="breadcrumb-item text-sm text-white active" aria-current="page">{{ __('Banner') }}</li>
                @elseif (request()->routeIs('admin.shoes-slider*'))
                    <li class="breadcrumb-item text-sm text-white active" aria-current="page">{{ __('Shoes Slider') }}</li>
                @elseif (request()->routeIs('admin.user*'))
                    <li class="breadcrumb-item text-sm text-white active" aria-current="page">{{ __('Users') }}</li>
                @elseif (request()->routeIs('admin.customer*'))
                    <li class="breadcrumb-item text-sm text-white active" aria-current="page">{{ __('Customers') }}</li>
                @elseif (request()->routeIs('admin.roles*'))
                    <li class="breadcrumb-item text-sm text-white active" aria-current="page">{{ __('Roles') }}</li>
                @elseif (request()->routeIs('admin.promotion*'))
                    <li class="breadcrumb-item text-sm text-white active" aria-current="page">{{ __('Promotion') }}</li>
                @elseif (request()->routeIs('admin.order*'))
                    <li class="breadcrumb-item text-sm text-white active" aria-current="page">{{ __('Sales Report') }}</li>
                @elseif (request()->routeIs('admin.setting*'))
                    <li class="breadcrumb-item text-sm text-white active" aria-current="page">{{ __('Settings') }}</li>
                @elseif (request()->routeIs('admin.show_info'))
                    <li class="breadcrumb-item text-sm text-white active" aria-current="page">{{ __('Profile') }}</li>
                @else
                    <li class="breadcrumb-item text-sm text-white active" aria-current="page">{{ __('Dashboard') }}</li>
                @endif
            </ol>

            <h6 class="font-weight-bolder text-white mb-0">
                @yield('page_title', __('Dashboard'))
            </h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <li class="d-flex align-items-center pe-md-4 pe-sm-2">
                    <button class="icon icon-shape text-center rounded-circle m-0 button-control-theme position-relative" style="width: 35px; height: 35px;" onclick="toggleTheme()" aria-label="Toggle color mode">
                        <span id="light-icon" class="d-none position-absolute top-0 end-0">
                            <svg class="light-mode-icon" width="32" height="32" viewBox="0 0 26 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 7.5C9.51637 7.5 7.5 9.51637 7.5 12C7.5 14.4836 9.51637 16.5 12 16.5C14.4836 16.5 16.5 14.4836 16.5 12C16.5 9.51637 14.4836 7.5 12 7.5ZM12 9C13.6556 9 15 10.3444 15 12C15 13.6556 13.6556 15 12 15C10.3444 15 9 13.6556 9 12C9 10.3444 10.3444 9 12 9Z" fill=""/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.75 5.57138V4.5C12.75 4.086 12.414 3.75 12 3.75C11.586 3.75 11.25 4.086 11.25 4.5V5.57138C11.25 5.98538 11.586 6.32138 12 6.32138C12.414 6.32138 12.75 5.98538 12.75 5.57138Z" fill=""/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.75 19.5001V18.4287C12.75 18.0147 12.414 17.6787 12 17.6787C11.586 17.6787 11.25 18.0147 11.25 18.4287V19.5001C11.25 19.9141 11.586 20.2501 12 20.2501C12.414 20.2501 12.75 19.9141 12.75 19.5001Z" fill=""/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M18.4287 12.75H19.5001C19.9141 12.75 20.2501 12.414 20.2501 12C20.2501 11.586 19.9141 11.25 19.5001 11.25H18.4287C18.0147 11.25 17.6787 11.586 17.6787 12C17.6787 12.414 18.0147 12.75 18.4287 12.75Z" fill=""/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.5 12.75H5.57138C5.98538 12.75 6.32138 12.414 6.32138 12C6.32138 11.586 5.98538 11.25 5.57138 11.25H4.5C4.086 11.25 3.75 11.586 3.75 12C3.75 12.414 4.086 12.75 4.5 12.75Z" fill=""/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.98443 6.92442L7.22693 6.16692C6.93443 5.87405 6.45893 5.87405 6.16643 6.16692C5.87356 6.45942 5.87356 6.93492 6.16643 7.22742L6.92393 7.98492C7.21643 8.2778 7.69193 8.2778 7.98443 7.98492C8.27731 7.69242 8.27731 7.21692 7.98443 6.92442Z" fill=""/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M17.8336 16.7731L17.0761 16.0156C16.7836 15.7227 16.3081 15.7227 16.0156 16.0156C15.7227 16.3081 15.7227 16.7836 16.0156 17.0761L16.7731 17.8336C17.0656 18.1264 17.5411 18.1264 17.8336 17.8336C18.1264 17.5411 18.1264 17.0656 17.8336 16.7731Z" fill=""/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M17.0761 7.98492L17.8336 7.22742C18.1264 6.93492 18.1264 6.45942 17.8336 6.16692C17.5411 5.87405 17.0656 5.87405 16.7731 6.16692L16.0156 6.92442C15.7227 7.21692 15.7227 7.69242 16.0156 7.98492C16.3081 8.2778 16.7836 8.2778 17.0761 7.98492Z" fill=""/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.22693 17.8336L7.98443 17.0761C8.27731 16.7836 8.27731 16.3081 7.98443 16.0156C7.69193 15.7227 7.21643 15.7227 6.92393 16.0156L6.16643 16.7731C5.87356 17.0656 5.87356 17.5411 6.16643 17.8336C6.45893 18.1264 6.93443 18.1264 7.22693 17.8336Z" fill=""/>
                            </svg>
                        </span>
                        <span id="dark-icon" class="position-absolute top-0 end-0">
                            <svg class="dark-mode-icon" width="32" height="32" viewBox="0 0 26 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.1853 7.65104C11.2511 7.51469 11.2255 7.35183 11.121 7.24229C11.0165 7.13274 10.855 7.09947 10.7157 7.15877C8.77708 7.98413 7.66864 10.1496 8.07792 12.2785C8.55187 14.7436 10.9345 16.3578 13.3997 15.8839C15.2564 15.5269 16.5865 14.1238 16.9501 12.3848C16.9811 12.2365 16.9168 12.0846 16.7888 12.0035C16.6609 11.9224 16.496 11.9293 16.3752 12.0207C15.9727 12.325 15.533 12.5143 14.9885 12.619C13.1163 12.9789 11.3068 11.753 10.9469 9.88088C10.7982 9.10719 10.8805 8.28248 11.1853 7.65104ZM8.79157 12.1413C8.50406 10.6458 9.1019 9.14398 10.2252 8.28109C10.1184 8.84785 10.1241 9.45021 10.2333 10.0181C10.669 12.2844 12.8594 13.7684 15.1257 13.3326C15.4203 13.276 15.6946 13.1968 15.9535 13.0912C15.4598 14.1417 14.5019 14.932 13.2625 15.1702C11.1914 15.5684 9.18975 14.2123 8.79157 12.1413Z" fill=""/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.75 5.57138V4.5C12.75 4.086 12.414 3.75 12 3.75C11.586 3.75 11.25 4.086 11.25 4.5V5.57138C11.25 5.98538 11.586 6.32138 12 6.32138C12.414 6.32138 12.75 5.98538 12.75 5.57138Z" fill=""/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.75 19.5001V18.4287C12.75 18.0147 12.414 17.6787 12 17.6787C11.586 17.6787 11.25 18.0147 11.25 18.4287V19.5001C11.25 19.9141 11.586 20.2501 12 20.2501C12.414 20.2501 12.75 19.9141 12.75 19.5001Z" fill=""/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M18.4287 12.75H19.5001C19.9141 12.75 20.2501 12.414 20.2501 12C20.2501 11.586 19.9141 11.25 19.5001 11.25H18.4287C18.0147 11.25 17.6787 11.586 17.6787 12C17.6787 12.414 18.0147 12.75 18.4287 12.75Z" fill=""/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.5 12.75H5.57138C5.98538 12.75 6.32138 12.414 6.32138 12C6.32138 11.586 5.98538 11.25 5.57138 11.25H4.5C4.086 11.25 3.75 11.586 3.75 12C3.75 12.414 4.086 12.75 4.5 12.75Z" fill=""/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.98443 6.92442L7.22693 6.16692C6.93443 5.87405 6.45893 5.87405 6.16643 6.16692C5.87356 6.45942 5.87356 6.93492 6.16643 7.22742L6.92393 7.98492C7.21643 8.2778 7.69193 8.2778 7.98443 7.98492C8.27731 7.69242 8.27731 7.21692 7.98443 6.92442Z" fill=""/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M17.8336 16.7731L17.0761 16.0156C16.7836 15.7227 16.3081 15.7227 16.0156 16.0156C15.7227 16.3081 15.7227 16.7836 16.0156 17.0761L16.7731 17.8336C17.0656 18.1264 17.5411 18.1264 17.8336 17.8336C18.1264 17.5411 18.1264 17.0656 17.8336 16.7731Z" fill=""/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M17.0761 7.98492L17.8336 7.22742C18.1264 6.93492 18.1264 6.45942 17.8336 6.16692C17.5411 5.87405 17.0656 5.87405 16.7731 6.16692L16.0156 6.92442C15.7227 7.21692 15.7227 7.69242 16.0156 7.98492C16.3081 8.2778 16.7836 8.2778 17.0761 7.98492Z" fill=""/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.22693 17.8336L7.98443 17.0761C8.27731 16.7836 8.27731 16.3081 7.98443 16.0156C7.69193 15.7227 7.21643 15.7227 6.92393 16.0156L6.16643 16.7731C5.87356 17.0656 5.87356 17.5411 6.16643 17.8336C6.45893 18.1264 6.93443 18.1264 7.22693 17.8336Z" fill=""/>
                            </svg>
                        </span>
                    </button>
                </li>
            </div>
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="flag-icon flag-icon-{{ ($current_locale == 'en') ? 'gb' : $current_locale }}"></i>
                </a>
                <div class="dropdown-menu " style="left: -10px">
                    @foreach($available_locales as $locale_name => $available_locale)
                        @if($available_locale === $current_locale)
                            <a href="{{ route('change_language', $available_locale) }}"
                                class="dropdown-item text-capitalize active">
                                <i
                                    class="flag-icon flag-icon-{{ ($available_locale == 'en') ? 'gb' : $available_locale }} mr-2"></i>
                                {{ $locale_name }}
                            </a>
                        @else
                            <a href="{{ route('change_language', $available_locale) }}" class="dropdown-item text-capitalize">
                                <i
                                    class="flag-icon flag-icon-{{ ($available_locale == 'en') ? 'gb' : $available_locale }} mr-2"></i>
                                {{ $locale_name }}
                            </a>
                        @endif
                    @endforeach
                </div>
            </li>
            <ul class="navbar-nav  justify-content-end">
                <li class="nav-item d-flex align-items-center gap-2">
                    <h6 class="text-white mb-0 welcome-text text-end">{{ __('Hello') }}, <span
                            class="font-weight-bolder text-white mb-0 text-capitalize pl-2"
                            style="color: #fff !important;"> {{ Auth::user()->name }} </span></h6>
                    <a href="{{ route('admin.show_info', auth()->user()->id) }}">
                        <img style="border:2.7px solid white;" src="
                            @if (auth()->user()->image && file_exists(public_path('uploads/users/' . auth()->user()->image))) {{ asset('uploads/users/' . auth()->user()->image) }}
                            @else {{ asset('uploads/default-profile.png') }} @endif" class="avatar avatar-sm rounded-circle" alt="User Image">
                    </a>
                </li>
            </ul>
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line bg-white"></i>
                        <i class="sidenav-toggler-line bg-white"></i>
                        <i class="sidenav-toggler-line bg-white"></i>
                    </div>
                </a>
            </li>
        </div>
    </div>
</nav>

