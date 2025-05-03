@include('backends.layouts.partial.logout_modal')
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 {{ config('app.dark-version') == 1 ? 'bg-default' : 'bg-white' }}">
    @php
        $setting = App\Models\BusinessSetting::all();
        $web_header_logo = $setting->where('type', 'web_header_logo')->first()->value ?? '';
        $company_name = $setting->where('type', 'company_name')->first()->value ?? '';
    @endphp

    <div class="sidenav-header">
        <a class="navbar-brand m-0" href="{{ route('admin.dashboard') }}">
            <img src="@if ($web_header_logo && file_exists('uploads/business_settings/' . $web_header_logo)) {{ asset('uploads/business_settings/' . $web_header_logo) }}
            @else
                {{ asset('uploads/image/default.png') }}
            @endif" width="26px" height="26px" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold company-name" style="font-size: 16px">{{ $company_name }}</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="input-group ition-relative p-2 pt-0">
        <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
        <input type="text" class="form-control sidebar-search-menu" id="sidebar-search" placeholder="{{ __('Search menu...') }}">
        <div id="search-suggestions" class="list-group position-absolute search-menu-suggestions" style="width: 94%;"></div>
    </div>
    <div class="collapse navbar-collapse pt-1  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link mx-0 @if (request()->routeIs('admin.dashboard')) active @endif" href="{{ route('admin.dashboard') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tv-2 icon-aside text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1"> {{ __('Dashboard') }} </span>
                </a>
            </li>
            @if (auth()->user()->can('brand.view') || auth()->user()->can('product.view'))
                <li class="nav-item @if (request()->routeIs('admin.brand.*') || request()->routeIs('admin.product.*')) menu-is-opening menu-open @endif">
                    <a class="nav-link mx-0 justify-content-between @if (request()->routeIs('admin.brand.*') || request()->routeIs('admin.product.*')) active @endif" href="">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-box-2 icon-aside text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1"> {{ __('Product Management') }} </span>
                        <i class="menu-arrow fa-solid fa-chevron-down ms-auto transition-icon"></i>
                    </a>
                    <ul class="nav nav-treeview pt-1">
                        @if (auth()->user()->can('brand.view'))
                            <li class="nav-item">
                                <a href="{{ route('admin.brand.index') }}" class="nav-link @if (request()->routeIs('admin.brand*')) active @endif">
                                    <div class="icon icon-shape icon-xxs border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-circle nav-icon icon-aside text-sm opacity-10" style="top: 0;"></i>
                                    </div>
                                    <span class="nav-link-text ms-1"> {{ __('Brand') }} </span>
                                </a>
                            </li>
                        @endif

                        @if (auth()->user()->can('product.view'))
                            <li class="nav-item">
                                <a href="{{ route('admin.product.index') }}" class="nav-link @if (request()->routeIs('admin.product*')) active @endif">
                                    <div class="icon icon-shape icon-xxs border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-circle nav-icon icon-aside text-sm opacity-10" style="top: 0;"></i>
                                    </div>
                                    <span class="nav-link-text ms-1"> {{ __('Product') }} </span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (auth()->user()->can('banner.view') || auth()->user()->can('shoes-slider.view'))
                <li class="nav-item @if (request()->routeIs('admin.banner-slider.*') || request()->routeIs('admin.shoes-slider.*')) menu-is-opening menu-open @endif">
                    <a class="nav-link mx-0 justify-content-between @if (request()->routeIs('admin.banner-slider.*') || request()->routeIs('admin.shoes-slider.*')) active @endif" href="">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-image icon-aside text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1"> {{ __('Banner Slider') }} </span>
                        <i class="menu-arrow fa-solid fa-chevron-down ms-auto transition-icon"></i>
                    </a>
                    <ul class="nav nav-treeview pt-1">
                        @if (auth()->user()->can('banner.view'))
                            <li class="nav-item">
                                <a href="{{ route('admin.banner-slider.index') }}" class="nav-link @if (request()->routeIs('admin.banner-slider*')) active @endif">
                                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-circle nav-icon icon-aside text-sm opacity-10" style="top: 0;"></i>
                                    </div>
                                    <span class="nav-link-text ms-1"> {{ __('Banner') }} </span>
                                </a>
                            </li>
                        @endif

                        @if (auth()->user()->can('shoes-slider.view'))
                            <li class="nav-item">
                                <a href="{{ route('admin.shoes-slider.index') }}" class="nav-link @if (request()->routeIs('admin.shoes-slider*')) active @endif">
                                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-circle nav-icon icon-aside text-sm opacity-10" style="top: 0;"></i>
                                    </div>
                                    <span class="nav-link-text ms-1"> {{ __('Shoes Slider') }} </span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (auth()->user()->can('promotion.view'))
                <li class="nav-item">
                    <a class="nav-link mx-0 @if (request()->routeIs('admin.promotion*')) active @endif" href="{{ route('admin.promotion.index') }}">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-tag icon-aside text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1"> {{ __('Promotion') }} </span>
                    </a>
                </li>
            @endif
            @if (auth()->user()->can('order.view'))
                <li class="nav-item">
                    <a class="nav-link mx-0 @if (request()->routeIs('admin.order*')) active @endif" href="{{ route('admin.order.index') }}">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-money-coins icon-aside text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1"> {{ __('Sales Report') }} </span>
                    </a>
                </li>
            @endif
            @if (auth()->user()->can('user.view') || auth()->user()->can('role.view') || auth()->user()->can('customer.view'))
                <li class="nav-item @if (request()->routeIs('admin.user*', 'admin.customer*', 'admin.roles*')) menu-is-opening menu-open @endif">
                    <a class="nav-link mx-0 justify-content-between @if (request()->routeIs('admin.user*', 'admin.customer*', 'admin.roles*')) active @endif" href="">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-badge icon-aside text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1"> {{ __('User Management') }} </span>
                        <i class="menu-arrow fa-solid fa-chevron-down ms-auto transition-icon"></i>
                    </a>
                    <ul class="nav nav-treeview pt-1">
                        @if (auth()->user()->can('user.view'))
                            <li class="nav-item">
                                <a href="{{ route('admin.user.index') }}" class="nav-link @if (request()->routeIs('admin.user*')) active @endif">
                                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-circle nav-icon icon-aside text-sm opacity-10" style="top: 0;"></i>
                                    </div>
                                    <span class="nav-link-text ms-1"> {{ __('Users') }} </span>
                                </a>
                            </li>
                        @endif

                        @if (auth()->user()->can('customer.view'))
                            <li class="nav-item">
                                <a href="{{ route('admin.customer.index') }}" class="nav-link @if (request()->routeIs('admin.customer*')) active @endif">
                                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-circle nav-icon icon-aside text-sm opacity-10" style="top: 0;"></i>
                                    </div>
                                    <span class="nav-link-text ms-1"> {{ __('Customers') }} </span>
                                </a>
                            </li>
                        @endif

                        @if (auth()->user()->can('role.view'))
                            <li class="nav-item">
                                <a href="{{ route('admin.roles.index') }}" class="nav-link @if (request()->routeIs('admin.roles*')) active @endif">
                                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-circle nav-icon icon-aside text-sm opacity-10" style="top: 0;"></i>
                                    </div>
                                    <span class="nav-link-text ms-1"> {{ __('Role') }} </span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (auth()->user()->can('setting.view'))
                <li class="nav-item">
                    <a class="nav-link mx-0 @if (request()->routeIs('admin.setting*')) active @endif" href="{{ route('admin.setting.index') }}">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-settings-gear-65 icon-aside text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1"> {{ __('Setting') }} </span>
                    </a>
                </li>
            @endif

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account pages</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link mx-0 @if (request()->routeIs('admin.show_info*')) active @endif" href="{{ route('admin.show_info', auth()->user()->id) }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-02 icon-aside text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('Profile') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link mx-0" href="" data-toggle="modal" data-target="#logoutModal">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-sign-out-alt icon-aside text-lg opacity-10 text-danger pt-2"></i>
                    </div>
                    <span class="nav-link-text ms-1 text-danger">{{ __('Log out') }}</span>
                </a>
            </li>
        </ul>
    </div>

</aside>
