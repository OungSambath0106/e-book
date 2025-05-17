<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
<link rel="stylesheet" href="{{ asset('assets/css/light-mode.css') }}">

<style>
    img {
        opacity: 1 !important;
    }
</style>
@stack('css')