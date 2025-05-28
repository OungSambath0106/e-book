<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('page_title', session()->get('company_name'))</title>
@php
    $setting = \App\Models\BusinessSetting::all();
    $data['fav_icon'] = @$setting->where('type', 'fav_icon')->first()->value ?? '';
@endphp
<link rel="icon" type="image/x-icon" href="
    @if ($data['fav_icon'] && file_exists('uploads/business_settings/' . $data['fav_icon']))
        {{ asset('uploads/business_settings/' . $data['fav_icon']) }}
    @else
        {{ asset('uploads/image/default.png') }}
    @endif">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<link rel="stylesheet" href="{{ asset('assets/css/light-mode.css') }}">

<style>
    img {
        opacity: 1 !important;
    }

    .dropdown:hover .dropdown-menu {
        display: block;
        margin-top: 0; /* fix Bootstrap's margin */
    }

    .dropdown-toggle::after {
        display: none;
    }

    .user-info-dropdown .dropdown-item.active,
    .user-info-dropdown .dropdown-item:active {
        color: #16181b;
        text-decoration: none;
        background-color: #f8f9fa;
    }

    .user-info-dropdown .dropdown-item {
        padding: 0;
    }

    .user-info-dropdown .dropdown-item a {
        color: var(--gray-700);
        font-size: .8rem;
        font-weight: 500;
        padding: .25rem 1.5rem;
        text-decoration: none;
        display: block;
        width: 100%;
    }

    .user-info-dropdown .dropdown-item:hover a {
        color: var(--primary);
    }

    .user-info-dropdown .logout-item a {
        color: var(--red-500);
    }

    .user-info-dropdown .logout-item:hover a {
        color: var(--red-600);
    }
</style>
@stack('css')