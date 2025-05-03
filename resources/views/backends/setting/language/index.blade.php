@extends('backends.layouts.admin')
@section('page_title', __('Language'))
@push('css')
    <style>
        .preview {
            margin-block: 12px;
            text-align: center;
        }
        .tab-pane {
            margin-top: 20px
        }

        .table > :not(caption) > * > * {
            padding: 0.5rem 0.5rem !important;
        }
    </style>
@endpush
@section('contents')
<section class="content">
    <div class="container-fluid">
        <div class="card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                @include('backends.setting.partials.tab')
            </div>
            <div class="">
                <div class="tab-content" id="custom-tabs-four-tabContent">
                    <div class="tab-pane fade active show" id="custom-tabs-for-webcontent" role="tabpanel" aria-labelledby="custom-tabs-for-webcontent-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header pb-0">
                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <h4 class="card-title">{{ __('Language') }}</h4>
                                            </div>
                                            <div class="col-md-6 text-end">
                                                <a class="btn bg-gradient-primary btn-sm btn-modal" href="#" data-href="{{ route('admin.setting.language.create') }}" data-toggle="modal" data-container=".modal_form">
                                                    <i class=" fa fa-plus-circle"></i>
                                                    {{ __('Add New') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @include('backends.setting.language.partials._table')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade modal_form" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>
@include('backends.setting.language.partials.delete_lang_modal')
@endsection
@push('js')
<script>
    $(document).on('click', '.btn-modal', function(){
        $("div.modal_form").load($(this).data('href'), function(){

            $(this).modal('show');

        });
    });

    $('.btn_add').click(function (e) {
        var tbody = $('.how_to_enter_tbody');
        var numRows = tbody.find("tr").length;
        $.ajax({
            type: "get",
            url: window.location.href,
            data: {
                "key" : numRows
            },
            dataType: "json",
            success: function (response) {
                $(tbody).append(response.tr);
            }
        });
    });

    $('.custom-file-input').change(function (e) {
        var reader = new FileReader();
        var preview = $(this).closest('.form-group').find('.preview img');
        console.log(preview);
        reader.onload = function(e) {
            preview.attr('src', e.target.result).show();
        }
        reader.readAsDataURL(this.files[0]);
    });

    class DeleteHandler {
        constructor() {
            this.itemId = null;
            this.itemHref = null;

            this.init();
        }

        init() {
            // Bind delete button
            $(document).on('click', '.btn-delete', (e) => {
                e.preventDefault();

                this.itemId = $(e.currentTarget).data('id');
                this.itemHref = $(e.currentTarget).data('href');

                $('#deleteLangModal').modal('show');
            });

            // Bind confirm button inside modal
            $(document).on('click', '.btn-confirm-modal', () => {
                this.handleDelete();
            });
        }

        handleDelete() {
            const formSelector = `.form-delete-${this.itemId}`;
            const formData = $(formSelector).serialize();

            $.ajax({
                type: 'POST',
                url: this.itemHref,
                data: formData,
                success: (response) => {
                    $('#deleteLangModal').modal('hide');

                    if (response.status === 1) {
                        $('.table-wrapper').replaceWith(response.view);
                        toastr.success(response.msg);
                    } else {
                        toastr.error(response.msg);
                    }
                },
                error: () => {
                    $('#deleteLangModal').modal('hide');
                    toastr.error('Something went wrong.');
                }
            });
        }
    }

    // Initialize the handler
    $(document).ready(function () {
        new DeleteHandler();
    });
</script>
@endpush
