@extends('backends.layouts.admin')
@section('page_title', __('Product'))
@push('css')
    <style>
        .preview {
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

        .carousel-control-prev, .carousel-control-next {
            width: unset !important;
            height: 2rem !important;
            align-self: center !important;
        }
        .carousel-control-prev {
            left: -50px !important;
        }
        .carousel-control-next {
            right: -50px !important;
        }
    </style>
@endpush
@section('contents')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h5 class="pb-1">
                                <i class="fa fa-filter" aria-hidden="true"></i>
                                {{ __('Filter') }}
                            </h5>
                        </div>
                        <div class="card-body pt-1">
                            <div class="d-flex col-lg-12 col-md-12 col-sm-12">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 filter tab-content" id="custom-content-below-tabContent">
                                    <label for="brand_id">{{ __('Brand') }}</label>
                                    <select name="brand_id" id="brand_id" class="form-control select2">
                                        <option value="" class="form-control"
                                            {{ !request()->filled('brands') ? 'selected' : '' }}>
                                            {{ __('All Brand') }}
                                        </option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}" class="form-control"
                                                {{ $brand->id == request('brand_id') ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between pb-0">
                            <h5 class="pb-1">{{ __('Products Table') }}</h5>
                            @if (auth()->user()->can('product.create'))
                                <a class="btn bg-gradient-primary add-new-button-right-side btn-xs" href="{{ route('admin.product.create') }}">
                                    <i class="fas fa-plus-circle"></i>
                                    {{ __('Add New') }}
                                </a>
                            @endif
                        </div>
                        <div class="card-body px-3 pt-0 pb-2">
                            <div class="dataTableButtons-container d-flex mx-0 align-items-center pb-2">
                                <div id="dataTableButtons" class="dataTableButtons-left-side col-md-12" style="justify-content: space-between"></div>
                            </div>
                            @include('backends.product._table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade modal_form" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>
    @include('backends.product.partial.delete_product_modal')
@endsection
@push('js')
    <script>
        function openGalleryModal(productId) {
            let modal = new bootstrap.Modal(document.getElementById('imageGalleryModal-' + productId), {
                keyboard: true
            });
            modal.show();
        }
    </script>
    <script>
        $('.btn_add').click(function(e) {
            var tbody = $('.tbody');
            var numRows = tbody.find("tr").length;
            $.ajax({
                type: "get",
                url: window.location.href,
                data: {
                    "key": numRows
                },
                dataType: "json",
                success: function(response) {
                    $(tbody).append(response.tr);
                }
            });
        });

        $(document).on('click', '.btn-edit', function() {
            $("div.modal_form").load($(this).data('href'), function() {

                $(this).modal('show');

            });
        });

        $(document).on('click', '.btn-delete', function (e) {
            e.preventDefault();

            let productId = $(this).data('id');
            let deleteUrl = $(this).data('href');

            $('#deleteProductModal').data('product-id', productId).data('delete-url', deleteUrl).modal('show');
        });

        $(document).on('click', '.btn-confirm-modal', function () {
            let modal = $('#deleteProductModal');
            let productId = modal.data('product-id');
            let deleteUrl = modal.data('delete-url');

            let row = $(`.btn-delete[data-id="${productId}"]`).closest('tr');
            let dataTable = $('#bookingTable').DataTable();

            var data = $(`.form-delete-${productId}`).serialize();

            $.ajax({
                type: "POST",
                url: deleteUrl,
                data: data,
                success: function (response) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    if (response.success == 1) {
                        dataTable.row(row).remove().draw(false);
                        modal.modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: response.msg
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: response.msg
                        });
                    }
                }
            });
        });

        //for update status
        initializeStatusInput("{{ route('admin.product.update_status') }}");
    </script>
    <script>
        $(document).ready(function() {
            $('#brand_id').select2();
        });

        $(document).on('change', '#brand_id', function(e) {
            e.preventDefault();

            var brand_id = $('#brand_id').val();

            if ($.fn.DataTable.isDataTable('#bookingTable')) {
                $('#bookingTable').DataTable().destroy();
            }

            $.ajax({
                type: "GET",
                url: '{{ route('admin.product.index') }}',
                data: {
                    'brand_id': brand_id
                },
                dataType: "json",
                success: function(response) {
                    if (response.view) {
                        $('.table-wrapper').html(response.view);
                        initDataTable();
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    </script>
@endpush
