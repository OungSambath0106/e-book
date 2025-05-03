@extends('backends.layouts.admin')
@section('page_title', __('Banner Slider'))
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
    </style>
@endpush
@section('contents')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between pb-0">
                            <h5 class="pb-1">{{ __('Banner Slider Table') }}</h5>
                            @if (auth()->user()->can('banner.create'))
                                <a class="btn bg-gradient-primary btn-modal add-new-button-right-side btn-xs" href="#" data-href="{{ route('admin.banner-slider.create') }}"
                                    data-toggle="modal" data-container=".modal_form">
                                    <i class="fas fa-plus-circle"></i>
                                    {{ __('Add New') }}
                                </a>
                            @endif
                        </div>
                        <div class="card-body px-3 pt-0 pb-2">
                            <div class="dataTableButtons-container d-flex mx-0 align-items-center pb-2">
                                <div id="dataTableButtons" class="dataTableButtons-left-side col-md-12" style="justify-content: space-between"></div>
                            </div>
                            @include('backends.banner-slider._table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body text-center position-relative">
                    <img id="modalImage" src="" alt="User Image" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal_form" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>
    @include('backends.banner-slider.partial.delete_banner_modal')
@endsection
@push('js')
    <script>
        function showImageModal(img) {
            document.getElementById('modalImage').src = img.src;
        }
    </script>
    <script>
        $('.btn_add').click(function (e) {
            var tbody = $('.tbody');
            var numRows = tbody.find("tr").length;
            $.ajax({
                type: "get",
                url: window.location.href,
                data: {
                    "key": numRows
                },
                dataType: "json",
                success: function (response) {
                    $(tbody).append(response.tr);
                }
            });
        });

        $(document).on('click', '.btn-edit', function () {
            $("div.modal_form").load($(this).data('href'), function () {

                $(this).modal('show');

            });
        });

        $(document).on('click', '.btn-delete', function (e) {
            e.preventDefault();

            let bannerId = $(this).data('id');
            let deleteUrl = $(this).data('href');

            $('#deleteBannerModal').data('banner-id', bannerId).data('delete-url', deleteUrl).modal('show');
        });

        $(document).on('click', '.btn-confirm-modal', function () {
            let modal = $('#deleteBannerModal');
            let bannerId = modal.data('banner-id');
            let deleteUrl = modal.data('delete-url');

            let row = $(`.btn-delete[data-id="${bannerId}"]`).closest('tr');
            let dataTable = $('#bookingTable').DataTable();

            var data = $(`.form-delete-${bannerId}`).serialize();

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
        initializeStatusInput("{{ route('admin.banner-slider.update_status') }}");
    </script>
@endpush
