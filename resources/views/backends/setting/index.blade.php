@extends('backends.layouts.admin')
@section('page_title', __('General Setting'))
@push('css')
    <style>
        .preview {
            margin-block: 12px;
            text-align: center;
        }

        .video-preview {
            margin-block: 12px;
            text-align: center;
        }

        .tab-pane {
            margin-top: 20px
        }

        .ckbx-style-9 input[type=checkbox]:checked+label:before {
            background: #3d95d0 !important;
            box-shadow: inset 0 1px 1px rgba(84, 116, 152, 0.5) !important;
        }
        .btn_add_contact, .btn_add_social_media, .btn_add_payment {
            width: 40px !important;
            height: 40px !important;
            border-radius: 50% !important;
            padding: 0 !important;
        }
    </style>
@endpush
@section('contents')
    <section class="content">
        <div class="container-fluid">
            <div class="card-outline card-outline-tabs">
                <div class="card-header pb-0 p-0 border-bottom-0">
                    @include('backends.setting.partials.tab')
                </div>
                <div class="">
                    <div class="tab-content" id="custom-tabs-four-tabContent">
                        <div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel"
                            aria-labelledby="custom-tabs-four-home-tab">
                            <form action="{{ route('admin.setting.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card mb-3">
                                            <div class="card-header pb-0">
                                                <h4 class="card-title">{{ __('Company Information') }}</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        {{-- @include('backends.setting.partials._lang_tab', [
                                                            'tab_id' => 'company',
                                                        ]) --}}
                                                        <div class="tab-content" id="custom-content-below-tabContent">
                                                            @foreach (json_decode($language, true) as $key => $lang)
                                                                @if ($lang['status'] == 1)
                                                                    <?php
                                                                    $translate = [];
                                                                    foreach ($settings as $setting) {
                                                                        if (count($setting['translations'])) {
                                                                            // dd($setting['translations']);

                                                                            foreach ($setting['translations'] as $t) {
                                                                                // dd($t);
                                                                                if ($t->locale == $lang['code'] && $t->key == 'company_name') {
                                                                                    $translate[$lang['code']]['company_name'] = $t->value;
                                                                                }
                                                                                if ($t->locale == $lang['code'] && $t->key == 'company_address') {
                                                                                    $translate[$lang['code']]['company_address'] = $t->value;
                                                                                }
                                                                                if ($t->locale == $lang['code'] && $t->key == 'copy_right_text') {
                                                                                    $translate[$lang['code']]['copy_right_text'] = $t->value;
                                                                                }
                                                                                if ($t->locale == $lang['code'] && $t->key == 'company_description') {
                                                                                    $translate[$lang['code']]['company_description'] = $t->value;
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                    ?>

                                                                    <div class="tab-pane fade {{ $lang['code'] == $default_lang ? 'show active' : '' }} mt-0"
                                                                        id="company_lang_{{ $lang['code'] }}"
                                                                        role="tabpanel"
                                                                        aria-labelledby="lang_{{ $lang['code'] }}-tab">
                                                                        <input type="hidden" name="lang[]"
                                                                            value="{{ $lang['code'] }}">
                                                                        <div class="row">
                                                                            <div class="col-12 col-sm-6 col-md-4">
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="company_name">{{ __('Company Name') }}</label>
                                                                                    <input type="text"
                                                                                        name="company_name[]"
                                                                                        id="company_name"
                                                                                        class="form-control"
                                                                                        value="{{ $translate[$lang['code']]['company_name'] ?? $company_name }}">
                                                                                </div>
                                                                            </div>
                                                                            @if ($lang['code'] == 'en')
                                                                                <div class="col-12 col-sm-6 col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label
                                                                                            for="">{{ __('Email') }}</label>
                                                                                        <input type="text" name="email"
                                                                                            id="email"
                                                                                            class="form-control"
                                                                                            value="{{ $email }}">
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                            <div class="col-12 col-sm-6 col-md-4">
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="copy_right_text">{{ __('Copyright Text') }}</label>
                                                                                    <input type="text"
                                                                                        name="copy_right_text[]"
                                                                                        id="copy_right_text"
                                                                                        class="form-control"
                                                                                        value="{{ $translate[$lang['code']]['copy_right_text'] ?? $copy_right_text }}">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="company_address">{{ __('Company Address') }}</label>
                                                                                    <input type="text"
                                                                                        name="company_address[]"
                                                                                        id="company_address"
                                                                                        class="form-control"
                                                                                        value="{{ $translate[$lang['code']]['company_address'] ?? $company_address }}">

                                                                                </div>
                                                                            </div>
                                                                            @if ($lang['code'] == 'en')
                                                                                <div
                                                                                    class="col-12 col-sm-12 col-md-6 col-lg-6">
                                                                                    <div class="form-group">
                                                                                        <label
                                                                                            for="copy_right_text">{{ __('Link Google Map') }}</label>
                                                                                        <input type="text"
                                                                                            name="link_google_map"
                                                                                            id="link_google_map"
                                                                                            class="form-control"
                                                                                            value="{{ $link_google_map }}">
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                            {{-- <div class="col-12 col-sm-12 col-md-12">
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="company_description_{{ $lang['code'] }}">{{ __('Company Description') }}({{ strtoupper($lang['code']) }})</label>
                                                                                    <textarea name="company_description[]" id="company_description_{{ $lang['code'] }}"
                                                                                        class="form-control value_summernote" rows="6">{{ $translate[$lang['code']]['company_description'] ?? $company_description }}</textarea>
                                                                                </div>
                                                                            </div> --}}
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card mb-3" hidden>
                                            <div class="card-header pb-0">
                                                <h4 class="card-title">{{ __('Home Slider') }}</h4>
                                            </div>
                                            <div class="card-body pt-1">
                                                <div class="row">
                                                    <div class="col-12">
                                                        @include('backends.setting.partials._lang_tab', [
                                                            'tab_id' => 'home_slider',
                                                        ])
                                                        <div class="tab-content" id="custom-content-below-tabContent">
                                                            @foreach (json_decode($language, true) as $key => $lang)
                                                                @if ($lang['status'] == 1)
                                                                    <?php
                                                                    $translate = [];
                                                                    foreach ($settings as $setting) {
                                                                        if (count($setting['translations'])) {
                                                                            // dd($setting['translations']);

                                                                            foreach ($setting['translations'] as $t) {
                                                                                // dd($t);
                                                                                if ($t->locale == $lang['code'] && $t->key == 'slider_title') {
                                                                                    $translate[$lang['code']]['slider_title'] = $t->value;
                                                                                }
                                                                                if ($t->locale == $lang['code'] && $t->key == 'slider_description') {
                                                                                    $translate[$lang['code']]['slider_description'] = $t->value;
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                    ?>

                                                                    <div class="tab-pane fade {{ $lang['code'] == $default_lang ? 'show active' : '' }} mt-3"
                                                                        id="home_slider_lang_{{ $lang['code'] }}"
                                                                        role="tabpanel"
                                                                        aria-labelledby="lang_{{ $lang['code'] }}-tab">
                                                                        <input type="hidden" name="lang[]"
                                                                            value="{{ $lang['code'] }}">
                                                                        <div class="row">
                                                                            <div class="col-12 col-sm-12 col-md-12">
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="slider_title_{{ $lang['code'] }}">{{ __('Title') }}({{ strtoupper($lang['code']) }})</label>
                                                                                    <input type="text"
                                                                                        name="slider_title[]"
                                                                                        id="slider_title{{ $lang['code'] }}"
                                                                                        class="form-control"
                                                                                        value="{{ $translate[$lang['code']]['slider_title'] ?? $slider_title }}">
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-12 col-sm-12 col-md-12">
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="slider_description_{{ $lang['code'] }}">{{ __('Slider Description') }}({{ strtoupper($lang['code']) }})</label>
                                                                                    <textarea name="slider_description[]" id="slider_description_{{ $lang['code'] }}"
                                                                                        class="form-control home_slider_summernote" rows="7">{{ $translate[$lang['code']]['slider_description'] ?? $slider_description }}</textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card mb-3">
                                            <div class="card-header pb-0">
                                                <h4 class="card-title">{{ __('Contact') }}</h4>
                                            </div>
                                            <div class="card-body pt-1">
                                                <div class="row">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>{{ __('Phone Number') }}</th>
                                                                <th>
                                                                    {{ __('Icon') }}
                                                                    <br>
                                                                    <span
                                                                        class="text-info text-xs">{{ __('Recommend svg icon') }}</span>
                                                                </th>
                                                                <th>{{ __('Link') }}</th>
                                                                <th>{{ __('Status') }}</th>
                                                                <th>
                                                                    <button type="button"
                                                                        class="btn bg-gradient-success btn_add_contact" title="Add Contact" data-bs-toggle="tooltip" data-bs-placement="top">
                                                                        <i class="fa fa-plus-circle"></i>
                                                                    </button>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        @include('backends.setting.partials._contact_tbody')
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card mb-3">
                                            <div class="card-header pb-0">
                                                <h4 class="card-title">{{ __('Social Media') }}</h4>
                                            </div>
                                            <div class="card-body pt-1">
                                                <div class="row">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>{{ __('Title') }}</th>
                                                                <th>
                                                                    {{ __('Icon') }}
                                                                    <br>
                                                                    <span
                                                                        class="text-info text-xs">{{ __('Recommend svg icon') }}</span>
                                                                </th>
                                                                <th>{{ __('Link') }}</th>
                                                                <th>{{ __('Status') }}</th>
                                                                <th>
                                                                    <button type="button"
                                                                        class="btn bg-gradient-success btn-sm btn_add_social_media" title="Add Social Media" data-bs-toggle="tooltip" data-bs-placement="top">
                                                                        <i class="fa fa-plus-circle"></i>
                                                                    </button>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        @include('backends.setting.partials._social_media_tbody')
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card mb-3">
                                            <div class="card-header pb-0">
                                                <h4 class="card-title">{{ __('Payment') }}</h4>
                                            </div>
                                            <div class="card-body pt-1">
                                                <div class="row">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>{{ __('Title') }}</th>
                                                                <th>
                                                                    {{ __('Icon') }}
                                                                    <br>
                                                                    <span
                                                                        class="text-info text-xs">{{ __('Recommend svg icon') }}</span>
                                                                </th>
                                                                <th>{{ __('Status') }}</th>
                                                                <th>
                                                                    <button type="button"
                                                                        class="btn bg-gradient-success btn-sm btn_add_payment" title="Add Payment" data-bs-toggle="tooltip" data-bs-placement="top">
                                                                        <i class="fa fa-plus-circle"></i>
                                                                    </button>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        @include('backends.setting.partials._payment_tbody')
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card mb-3">
                                            <div class="card-header pb-0">
                                                <h4 class="card-title">{{ __('Website Logo setup') }}</h4>
                                            </div>
                                            <div class="card-body">
                                                {{-- <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label for="timezone">{{ __('Timezone') }}</label>
                                                            <select name="timezone" id="timezone" class="form-control select2">
                                                                <option value="">{{ __('Please Select') }}</option>
                                                                @foreach (config('list.all_timezone') as $value => $name)
                                                                    <option value="{{ $value }}" {{ $timezone == $value ? 'selected' : '' }}>{{ $name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label for="currency">{{ __('Currency') }}</label>
                                                            <select name="currency" id="currency" class="form-control select2">
                                                                <option value="">{{ __('Please Select') }}</option>
                                                                @foreach (config('list.currency_list') as $item)
                                                                    <option value="{{ $item['code'] }}" {{ $item['code'] == $currency ? 'selected' : '' }}>{{ $item['symbol'] . ' - ' . $item['name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div> --}}
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group col-md-12 px-0">
                                                            <label for="web_header_logo">
                                                                {{ __('Website logo') }}
                                                                <span class="text-info text-xs">{{ __('Recommend size 512 x 512 px') }}</span>
                                                            </label>
                                                            <input type="hidden" name="web_header_logo" value="{{ @$web_header_logo }}" id="photo-trigger">
                                                            <input type="file" id="web_header_logo" class="dropify custom-file-input" name="web_header_logo"
                                                                @if($web_header_logo)data-default-file="{{ asset('uploads/business_settings/' . @$web_header_logo) }}"@endif
                                                                accept="image/png, image/jpeg, image/gif, image/webp">
                                                            <div class="progress mt-2" style="height: 10px; display: none;">
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">0%</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group col-md-12 px-0">
                                                            <label for="fav_icon">
                                                                {{ __('Fav icon') }}
                                                                <span class="text-info text-xs">{{ __('Recommend size 512 x 512 px') }}</span>
                                                            </label>
                                                            <input type="hidden" name="fav_icon" value="{{ @$fav_icon }}" id="photo-trigger">
                                                            <input type="file" id="fav_icon" class="dropify custom-file-input" name="fav_icon"
                                                                @if($fav_icon)data-default-file="{{ asset('uploads/business_settings/' . @$fav_icon) }}"@endif
                                                                accept="image/png, image/jpeg, image/gif, image/webp">
                                                            <div class="progress mt-2" style="height: 10px; display: none;">
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">0%</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 text-end">
                                                <button type="submit"
                                                    class="btn bg-gradient-primary btn-sm submit float-right mb-0">
                                                    <i class="fa fa-save pe-1"></i>
                                                    {{ __('Save') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade modal_form" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>
@endsection
@push('js')
    <script>
        $('.home_slider_summernote').summernote({
            placeholder: '{{ 'Type something' }}',
            tabsize: 2,
            height: 150,
        });
        $('.value_summernote').summernote({
            placeholder: '{{ 'Type something' }}',
            tabsize: 2,
            height: 250,

        });
        $('.btn_add_contact').click(function(e) {
            var tbody = $('.contact_tbody');
            var numRows = tbody.find("tr").length;
            $.ajax({
                type: "get",
                url: window.location.href,
                data: {
                    "type": "key_contact",
                    "key": numRows
                },
                dataType: "json",
                success: function(response) {
                    $(tbody).append(response.tr);
                }
            });
        });
        $('.btn_add_social_media').click(function(e) {
            var tbody = $('.tbody');
            var numRows = tbody.find("tr").length;
            $.ajax({
                type: "get",
                url: window.location.href,
                data: {
                    "type": "key_social",
                    "key": numRows
                },
                dataType: "json",
                success: function(response) {
                    $(tbody).append(response.tr);
                }
            });
        });
        $('.btn_add_payment').click(function(e) {
            var tbody = $('.payment_tbody');
            var numRows = tbody.find("tr").length;
            $.ajax({
                type: "get",
                url: window.location.href,
                data: {
                    "type": "key_payment",
                    "key": numRows
                },
                dataType: "json",
                success: function(response) {
                    $(tbody).append(response.tr);
                }
            });
        });

        const compressor = new window.Compress();

        $(document).on('click', 'button[type=submit]', function(e) {
            e.preventDefault();
            // alert('okk');
            $('.home_images_wrapper input[type=file]').attr('disabled', true);
            $(this).closest('form').submit();
        });
    </script>
@endpush
