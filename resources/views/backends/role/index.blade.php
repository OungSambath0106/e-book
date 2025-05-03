@extends('backends.layouts.admin')
@section('page_title', __('Role Management'))
@push('css')

@endpush
@section('contents')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between pb-0">
                        <h5 class="pb-1">{{ __('User role list') }}</h5>
                        @if (auth()->user()->can('role.create'))
                            <a class="btn bg-gradient-primary add-new-button-right-side btn-xs" href="{{ route('admin.roles.create') }}">
                                <i class=" fa fa-plus-circle"></i>
                                {{ __('Add New') }}
                            </a>
                        @endif
                    </div>
                    <div class="card-body px-3 pt-0 pb-2">
                        <div class="dataTableButtons-container d-flex mx-0 align-items-center pb-2">
                            <div id="dataTableButtons" class="dataTableButtons-left-side col-md-12"
                                style="justify-content: space-between"></div>
                        </div>
                        @include('backends.role._table')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('backends.role.partial.delete_role_modal')

</section>

@endsection

@push('js')
    <script>
        $(document).on('click', '.btn-delete', function (e) {
            e.preventDefault();

            let roleId = $(this).data('id');
            let deleteUrl = $(this).data('href');

            $('#deleteRoleModal').data('role-id', roleId).data('delete-url', deleteUrl).modal('show');
        });

        $(document).on('click', '.btn-confirm-modal', function () {
            let modal = $('#deleteRoleModal');
            let roleId = modal.data('role-id');
            let deleteUrl = modal.data('delete-url');

            let row = $(`.btn-delete[data-id="${roleId}"]`).closest('tr');
            let dataTable = $('#bookingTable').DataTable();

            var data = $(`.form-delete-${roleId}`).serialize();

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
