@extends('backends.layouts.admin')
@section('page_title', __('Author Management'))
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

        .carousel-control-prev,
        .carousel-control-next {
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
                        <div class="card-header d-flex justify-content-between pb-0">
                            <h5 class="pb-1">{{ __('Authors Table') }}</h5>
                            @if (auth()->user()->can('author.create'))
                                <a class="btn bg-gradient-primary add-new-button-right-side btn-xs"
                                    href="{{ route('admin.author.create') }}">
                                    <i class="fas fa-plus-circle"></i>
                                    {{ __('Add New') }}
                                </a>
                            @endif
                        </div>
                        <div class="card-body px-3 pt-0 pb-2">
                            <div class="dataTableButtons-container d-flex mx-0 align-items-center pb-2">
                                <div id="dataTableButtons" class="dataTableButtons-left-side col-md-12"
                                    style="justify-content: space-between"></div>
                            </div>
                            @include('backends.author._table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center position-relative">
                    <img id="modalImage" src="" alt="Author Image" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal_form" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>
    @include('backends.author.partial.delete_author_modal')

@endsection
@push('js')
    <script>
        document.getElementById('resetButton').addEventListener('click', function () {
            let icon = document.getElementById('resetIcon');
            icon.classList.add('fa-spin');

            window.location.href = "{{ route('admin.author.index') }}";
        });
    </script>
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

        $(document).on('click', '.btn-delete', function (e) {
            e.preventDefault();

            let authorId = $(this).data('id');
            let deleteUrl = $(this).data('href');

            $('#deleteAuthorModal').data('author-id', authorId).data('delete-url', deleteUrl).modal('show');
        });

        $(document).on('click', '.btn-confirm-modal', function () {
            let modal = $('#deleteAuthorModal');
            let authorId = modal.data('author-id');
            let deleteUrl = modal.data('delete-url');

            let row = $(`.btn-delete[data-id="${authorId}"]`).closest('tr');
            let dataTable = $('#bookingTable').DataTable();

            var data = $(`.form-delete-${authorId}`).serialize();

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
    </script>
@endpush