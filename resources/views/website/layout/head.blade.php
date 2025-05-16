<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('page_title', 'E-Books')</title>
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
<link rel="stylesheet" href="{{ asset('assets/css/light-mode.css') }}">
@stack('css')