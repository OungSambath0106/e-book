@extends('backends.layouts.admin')
@section('page_title', __('Edit Role'))
@push('css')

@endpush
@section('contents')
    <?php
        $slider = '
        <div class="slider">
            <div class="circle">
                <svg class="cross" xml:space="preserve" style="enable-background:new 0 0 512 512" viewBox="0 0 365.696 365.696" y="0" x="0" height="6" width="6" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <g>
                        <path data-original="#000000" fill="currentColor" d="M243.188 182.86 356.32 69.726c12.5-12.5 12.5-32.766 0-45.247L341.238 9.398c-12.504-12.503-32.77-12.503-45.25 0L182.86 122.528 69.727 9.374c-12.5-12.5-32.766-12.5-45.247 0L9.375 24.457c-12.5 12.504-12.5 32.77 0 45.25l113.152 113.152L9.398 295.99c-12.503 12.503-12.503 32.769 0 45.25L24.48 356.32c12.5 12.5 32.766 12.5 45.247 0l113.132-113.132L295.99 356.32c12.503 12.5 32.769 12.5 45.25 0l15.081-15.082c12.5-12.504 12.5-32.77 0-45.25zm0 0"></path>
                    </g>
                </svg>
                <svg class="checkmark" xml:space="preserve" style="enable-background:new 0 0 512 512" viewBox="0 0 24 24" y="0" x="0" height="10" width="10" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <g>
                        <path class="" data-original="#000000" fill="currentColor" d="M9.707 19.121a.997.997 0 0 1-1.414 0l-5.646-5.647a1.5 1.5 0 0 1 0-2.121l.707-.707a1.5 1.5 0 0 1 2.121 0L9 14.171l9.525-9.525a1.5 1.5 0 0 1 2.121 0l.707.707a1.5 1.5 0 0 1 0 2.121z"></path>
                    </g>
                </svg>
            </div>
        </div>';
    ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form class="form-material form-horizontal" action="{{ route('admin.roles.update', $role->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-12">
                                        @if($role->name == 'customer' || $role->name == 'partner')
                                            <Label class="border p-2">{{ $role->name }}</Label>
                                        @endif
                                        @if($role->name != 'customer' && $role->name != 'partner')
                                            <div class="form-group">
                                                <label for="name">@lang('Name Position')</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" value="{{ $role->name }}" name="name"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        placeholder="@lang('Type name permission')">
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <label style="font-size: 16px;" for="">{{ __('Select Permission') }}</label>
                                <hr class="horizontal dark">

                                <div>
                                    <div class="d-flex">
                                        <label for="" class="mr-2 mb-3">{{ __('User Setup') }}</label>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group d-flex align-items-center mb-0 gap-2">
                                                <label for="view_user" class="switch pt-0">
                                                    <input type="checkbox" id="view_user" name="permissions[]"
                                                        @if (in_array('user.view', $role_permissions)) checked @endif
                                                                value="user.view">
                                                        {!! $slider !!}
                                                    </label>
                                                <label class="ml-2 m-0" for="view_user">{{ __('View User') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group d-flex align-items-center mb-0 gap-2">
                                                <label for="user_create" class="switch pt-0">
                                                    <input type="checkbox" id="user_create" name="permissions[]"
                                                        @if (in_array('user.create', $role_permissions)) checked @endif
                                                        value="user.create">
                                                    {!! $slider !!}
                                                </label>
                                                <label class="ml-2 m-0" for="user_create">{{ __('Create User') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group d-flex align-items-center mb-0 gap-2">
                                                <label for="user_edit" class="switch pt-0">
                                                    <input type="checkbox" id="user_edit" name="permissions[]"
                                                        @if (in_array('user.edit', $role_permissions)) checked @endif
                                                        value="user.edit">
                                                    {!! $slider !!}
                                                </label>
                                                <label class="ml-2 m-0" for="user_edit">{{ __('Edit User') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group d-flex align-items-center mb-0 gap-2">
                                                <label for="user_delete" class="switch pt-0">
                                                    <input type="checkbox" id="user_delete" name="permissions[]"
                                                        @if (in_array('user.delete', $role_permissions)) checked @endif
                                                        value="user.delete">
                                                    {!! $slider !!}
                                                </label>
                                                <label class="ml-2 m-0" for="user_delete">{{ __('Delete User') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="horizontal dark">
                                </div>

                                <div>
                                    <div class="d-flex">
                                        <label for="" class="mr-2 mb-3">{{ __('Customer Setup') }}</label>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group d-flex align-items-center mb-0 gap-2">
                                                <label for="view_customer" class="switch pt-0">
                                                    <input type="checkbox" id="view_customer" name="permissions[]"
                                                        @if (in_array('customer.view', $role_permissions)) checked @endif
                                                                value="customer.view">
                                                        {!! $slider !!}
                                                    </label>
                                                <label class="ml-2 m-0" for="view_customer">{{ __('View Customer') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group d-flex align-items-center mb-0 gap-2">
                                                <label for="customer_create" class="switch pt-0">
                                                    <input type="checkbox" id="customer_create" name="permissions[]"
                                                        @if (in_array('customer.create', $role_permissions)) checked @endif
                                                        value="customer.create">
                                                    {!! $slider !!}
                                                </label>
                                                <label class="ml-2 m-0" for="customer_create">{{ __('Create Customer') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group d-flex align-items-center mb-0 gap-2">
                                                <label for="customer_edit" class="switch pt-0">
                                                    <input type="checkbox" id="customer_edit" name="permissions[]"
                                                        @if (in_array('customer.edit', $role_permissions)) checked @endif
                                                        value="customer.edit">
                                                    {!! $slider !!}
                                                </label>
                                                <label class="ml-2 m-0" for="customer_edit">{{ __('Edit Customer') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group d-flex align-items-center mb-0 gap-2">
                                                <label for="customer_delete" class="switch pt-0">
                                                    <input type="checkbox" id="customer_delete" name="permissions[]"
                                                        @if (in_array('customer.delete', $role_permissions)) checked @endif
                                                        value="customer.delete">
                                                    {!! $slider !!}
                                                </label>
                                                <label class="ml-2 m-0" for="customer_delete">{{ __('Delete Customer') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="horizontal dark">
                                </div>

                                <div>
                                    <div class="d-flex">
                                        <label for="" class="mr-2 mb-3">{{ __('Brand Setup') }}</label>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group d-flex align-items-center mb-0 gap-2">
                                                <label for="view_brand" class="switch pt-0">
                                                    <input type="checkbox" id="view_brand" name="permissions[]"
                                                        @if (in_array('brand.view', $role_permissions)) checked @endif
                                                                value="brand.view">
                                                        {!! $slider !!}
                                                    </label>
                                                <label class="ml-2 m-0" for="view_brand">{{ __('View Brand') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group d-flex align-items-center mb-0 gap-2">
                                                <label for="brand_create" class="switch pt-0">
                                                    <input type="checkbox" id="brand_create" name="permissions[]"
                                                        @if (in_array('brand.create', $role_permissions)) checked @endif
                                                        value="brand.create">
                                                    {!! $slider !!}
                                                </label>
                                                <label class="ml-2 m-0" for="brand_create">{{ __('Create Brand') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group d-flex align-items-center mb-0 gap-2">
                                                <label for="brand_edit" class="switch pt-0">
                                                    <input type="checkbox" id="brand_edit" name="permissions[]"
                                                        @if (in_array('brand.edit', $role_permissions)) checked @endif
                                                        value="brand.edit">
                                                    {!! $slider !!}
                                                </label>
                                                <label class="ml-2 m-0" for="brand_edit">{{ __('Edit Brand') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group d-flex align-items-center mb-0 gap-2">
                                                <label for="brand_delete" class="switch pt-0">
                                                    <input type="checkbox" id="brand_delete" name="permissions[]"
                                                        @if (in_array('brand.delete', $role_permissions)) checked @endif
                                                        value="brand.delete">
                                                    {!! $slider !!}
                                                </label>
                                                <label class="ml-2 m-0" for="brand_delete">{{ __('Delete Brand') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="horizontal dark">
                                </div>

                                <div>
                                    <div class="d-flex">
                                        <label for="" class="mr-2 mb-3">{{ __('Product Setup') }}</label>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group d-flex align-items-center mb-0 gap-2">
                                                <label for="view_product" class="switch pt-0">
                                                    <input type="checkbox" id="view_product" name="permissions[]"
                                                        @if (in_array('product.view', $role_permissions)) checked @endif
                                                                value="product.view">
                                                        {!! $slider !!}
                                                    </label>
                                                <label class="ml-2 m-0" for="view_product">{{ __('View Product') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group d-flex align-items-center mb-0 gap-2">
                                                <label for="product_create" class="switch pt-0">
                                                    <input type="checkbox" id="product_create" name="permissions[]"
                                                        @if (in_array('product.create', $role_permissions)) checked @endif
                                                        value="product.create">
                                                    {!! $slider !!}
                                                </label>
                                                <label class="ml-2 m-0" for="product_create">{{ __('Create Product') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group d-flex align-items-center mb-0 gap-2">
                                                <label for="product_edit" class="switch pt-0">
                                                    <input type="checkbox" id="product_edit" name="permissions[]"
                                                        @if (in_array('product.edit', $role_permissions)) checked @endif
                                                        value="product.edit">
                                                    {!! $slider !!}
                                                </label>
                                                <label class="ml-2 m-0" for="product_edit">{{ __('Edit Product') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group d-flex align-items-center mb-0 gap-2">
                                                <label for="product_delete" class="switch pt-0">
                                                    <input type="checkbox" id="product_delete" name="permissions[]"
                                                        @if (in_array('product.delete', $role_permissions)) checked @endif
                                                        value="product.delete">
                                                    {!! $slider !!}
                                                </label>
                                                <label class="ml-2 m-0" for="product_delete">{{ __('Delete Product') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="horizontal dark">
                                </div>

                                <div>
                                    <div class="d-flex">
                                        <label for="" class="mr-2 mb-3">{{ __('Banner Setup') }}</label>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group d-flex align-items-center mb-0 gap-2">
                                                <label for="view_banner" class="switch pt-0">
                                                    <input type="checkbox" id="view_banner" name="permissions[]"
                                                        @if (in_array('banner.view', $role_permissions)) checked @endif
                                                                value="banner.view">
                                                        {!! $slider !!}
                                                    </label>
                                                <label class="ml-2 m-0" for="view_banner">{{ __('View Banner') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group d-flex align-items-center mb-0 gap-2">
                                                <label for="banner_create" class="switch pt-0">
                                                    <input type="checkbox" id="banner_create" name="permissions[]"
                                                        @if (in_array('banner.create', $role_permissions)) checked @endif
                                                        value="banner.create">
                                                    {!! $slider !!}
                                                </label>
                                                <label class="ml-2 m-0" for="banner_create">{{ __('Create Banner') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group d-flex align-items-center mb-0 gap-2">
                                                <label for="banner_edit" class="switch pt-0">
                                                    <input type="checkbox" id="banner_edit" name="permissions[]"
                                                        @if (in_array('banner.edit', $role_permissions)) checked @endif
                                                        value="banner.edit">
                                                    {!! $slider !!}
                                                </label>
                                                <label class="ml-2 m-0" for="banner_edit">{{ __('Edit Banner') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group d-flex align-items-center mb-0 gap-2">
                                                <label for="banner_delete" class="switch pt-0">
                                                    <input type="checkbox" id="banner_delete" name="permissions[]"
                                                        @if (in_array('banner.delete', $role_permissions)) checked @endif
                                                        value="banner.delete">
                                                    {!! $slider !!}
                                                </label>
                                                <label class="ml-2 m-0" for="banner_delete">{{ __('Delete Banner') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="horizontal dark">
                                </div>

                                <div>
                                    <div class="d-flex">
                                        <label for="" class="mr-2 mb-3">{{ __('Shoese Slider Setup') }}</label>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group d-flex align-items-center mb-0 gap-2">
                                                <label for="view_shoes_slider" class="switch pt-0">
                                                    <input type="checkbox" id="view_shoes_slider" name="permissions[]"
                                                        @if (in_array('shoes_slider.view', $role_permissions)) checked @endif
                                                                value="shoes_slider.view">
                                                        {!! $slider !!}
                                                    </label>
                                                <label class="ml-2 m-0" for="view_shoes_slider">{{ __('View Shoes Slider') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group d-flex align-items-center mb-0 gap-2">
                                                <label for="shoes_slider_create" class="switch pt-0">
                                                    <input type="checkbox" id="shoes_slider_create" name="permissions[]"
                                                        @if (in_array('shoes_slider.create', $role_permissions)) checked @endif
                                                        value="shoes_slider.create">
                                                    {!! $slider !!}
                                                </label>
                                                <label class="ml-2 m-0" for="shoes_slider_create">{{ __('Create Shoes Slider') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group d-flex align-items-center mb-0 gap-2">
                                                <label for="shoes_slider_edit" class="switch pt-0">
                                                    <input type="checkbox" id="shoes_slider_edit" name="permissions[]"
                                                        @if (in_array('shoes_slider.edit', $role_permissions)) checked @endif
                                                        value="shoes_slider.edit">
                                                    {!! $slider !!}
                                                </label>
                                                <label class="ml-2 m-0" for="shoes_slider_edit">{{ __('Edit Shoes Slider') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group d-flex align-items-center mb-0 gap-2">
                                                <label for="shoes_slider_delete" class="switch pt-0">
                                                    <input type="checkbox" id="shoes_slider_delete" name="permissions[]"
                                                        @if (in_array('shoes_slider.delete', $role_permissions)) checked @endif
                                                        value="shoes_slider.delete">
                                                    {!! $slider !!}
                                                </label>
                                                <label class="ml-2 m-0" for="shoes_slider_delete">{{ __('Delete Shoes Slider') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="horizontal dark">
                                </div>

                                <div>
                                    <div class="d-flex">
                                        <label for="" class="mr-2 mb-3">{{ __('Promotion Setup') }}</label>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group d-flex align-items-center mb-0 gap-2">
                                                <label for="view_promotion" class="switch pt-0">
                                                    <input type="checkbox" id="view_promotion" name="permissions[]"
                                                        @if (in_array('promotion.view', $role_permissions)) checked @endif
                                                                value="promotion.view">
                                                        {!! $slider !!}
                                                    </label>
                                                <label class="ml-2 m-0" for="view_promotion">{{ __('View Promotion') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group d-flex align-items-center mb-0 gap-2">
                                                <label for="promotion_create" class="switch pt-0">
                                                    <input type="checkbox" id="promotion_create" name="permissions[]"
                                                        @if (in_array('promotion.create', $role_permissions)) checked @endif
                                                        value="promotion.create">
                                                    {!! $slider !!}
                                                </label>
                                                <label class="ml-2 m-0" for="promotion_create">{{ __('Create Promotion') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group d-flex align-items-center mb-0 gap-2">
                                                <label for="promotion_edit" class="switch pt-0">
                                                    <input type="checkbox" id="promotion_edit" name="permissions[]"
                                                        @if (in_array('promotion.edit', $role_permissions)) checked @endif
                                                        value="promotion.edit">
                                                    {!! $slider !!}
                                                </label>
                                                <label class="ml-2 m-0" for="promotion_edit">{{ __('Edit Promotion') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group d-flex align-items-center mb-0 gap-2">
                                                <label for="promotion_delete" class="switch pt-0">
                                                    <input type="checkbox" id="promotion_delete" name="permissions[]"
                                                        @if (in_array('promotion.delete', $role_permissions)) checked @endif
                                                        value="promotion.delete">
                                                    {!! $slider !!}
                                                </label>
                                                <label class="ml-2 m-0" for="promotion_delete">{{ __('Delete Promotion') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="horizontal dark">
                                </div>

                                <div>
                                    <div class="d-flex">
                                        <label for="" class="mr-2 mb-3">{{ __('Sale Report') }}</label>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group d-flex align-items-center mb-0 gap-2">
                                                <label for="view_sale_report" class="switch pt-0">
                                                    <input type="checkbox" id="view_sale_report" name="permissions[]"
                                                        @if (in_array('sale_report.view', $role_permissions)) checked @endif
                                                                value="sale_report.view">
                                                        {!! $slider !!}
                                                    </label>
                                                <label class="ml-2 m-0" for="view_sale_report">{{ __('View Sale Report') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="horizontal dark">
                                </div>

                                <div>
                                    <div class="d-flex">
                                        <label for="" class="mr-2 mb-3">{{ __('Setting Setup') }}</label>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group d-flex align-items-center mb-0 gap-2">
                                                <label for="view_setting" class="switch pt-0">
                                                    <input type="checkbox" id="view_setting" name="permissions[]"
                                                        @if (in_array('setting.view', $role_permissions)) checked @endif
                                                                value="setting.view">
                                                        {!! $slider !!}
                                                    </label>
                                                <label class="ml-2 m-0" for="view_setting">{{ __('View Setting') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group d-flex align-items-center mb-0 gap-2">
                                                <label for="setting_edit" class="switch pt-0">
                                                    <input type="checkbox" id="setting_edit" name="permissions[]"
                                                        @if (in_array('setting.edit', $role_permissions)) checked @endif
                                                        value="setting.edit">
                                                    {!! $slider !!}
                                                </label>
                                                <label class="ml-2 m-0" for="setting_edit">{{ __('Edit Setting') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="horizontal dark">
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-0">
                                            <div class="col-md-12 d-flex justify-content-end gap-2 pt-2">
                                                <a href="{{ route('admin.roles.index') }}"
                                                class="btn bg-gradient-danger btn-sm">{{ __('Cancel') }}</a>
                                                <input type="submit" value="{{ __('Submit') }}"
                                                    class="btn bg-gradient-primary btn-sm" />
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
@endsection
