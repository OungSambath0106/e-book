@extends('backends.layouts.admin')
@section('page_title', __('Sales Report'))
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
                            <form method="GET" action="{{ route('admin.order.index') }}" id="filterForm">
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-6 filter">
                                        <label for="customer_id">{{ __('Customer') }}</label>
                                        <select name="customer_id" id="customer_id" class="form-control select2">
                                            <option value="" class="form-control"
                                                {{ !request()->filled('customer_id') ? 'selected' : '' }}>
                                                {{ __('All Customers') }}
                                            </option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}" class="form-control"
                                                    {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                                    {{ $customer->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-6 filter">
                                        <label for="order_type">{{ __('Order Type') }}</label>
                                        <select name="order_type" id="order_type" class="form-control select2">
                                            <option value="" class="form-control"
                                                {{ !request()->filled('order_type') ? 'selected' : '' }}>
                                                {{ __('All Order Type') }}
                                            </option>
                                            <option value="delivery"
                                                {{ request('order_type') == 'delivery' ? 'selected' : '' }}>
                                                {{ __('Delivery') }}
                                            </option>
                                            <option value="pickup"
                                                {{ request('order_type') == 'pickup' ? 'selected' : '' }}>
                                                {{ __('Pickup') }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-6 filter">
                                        <label for="payment_status">{{ __('Payment Status') }}</label>
                                        <select name="payment_status" id="payment_status" class="form-control select2">
                                            <option value="" class="form-control"
                                                {{ !request()->filled('payment_status') ? 'selected' : '' }}>
                                                {{ __('All Payment') }}
                                            </option>
                                            <option value="unpaid"
                                                {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>
                                                {{ __('Unpaid') }}
                                            </option>
                                            <option value="paid"
                                                {{ request('payment_status') == 'paid' ? 'selected' : '' }}>
                                                {{ __('Paid') }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-6 filter pt-2">
                                        <label for="payment_method">{{ __('Payment Method') }}</label>
                                        <select name="payment_method" id="payment_method" class="form-control select2">
                                            <option value="" class="form-control"
                                                {{ !request()->filled('payment_method') ? 'selected' : '' }}>
                                                {{ __('All Payment Method') }}
                                            </option>
                                            <option value="pay_at_store"
                                                {{ request('payment_method') == 'pay_at_store' ? 'selected' : '' }}>
                                                {{ __('Pay at Store') }}
                                            </option>
                                            <option value="cash_on_delivery"
                                                {{ request('payment_method') == 'cash_on_delivery' ? 'selected' : '' }}>
                                                {{ __('Cash on Delivery') }}
                                            </option>
                                            <option value="aba"
                                                {{ request('payment_method') == 'aba' ? 'selected' : '' }}>
                                                {{ __('ABA') }}
                                            </option>
                                            <option value="wing"
                                                {{ request('payment_method') == 'wing' ? 'selected' : '' }}>
                                                {{ __('Wing') }}
                                            </option>
                                            <option value="acleda"
                                                {{ request('payment_method') == 'acleda' ? 'selected' : '' }}>
                                                {{ __('Acleda') }}
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-sm-6 filter pt-2">
                                        <label for="filter">{{ __('Filter Date') }}</label>
                                        <div id="reportrange"
                                            style="cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; border-radius: 0.5rem; width: 100%">
                                            <i class="fa fa-calendar"></i>&nbsp; &nbsp;
                                            <span></span>
                                        </div>
                                    </div>
                                    <input type="hidden" name="date_from" id="date_from">
                                    <input type="hidden" name="date_to" id="date_to">

                                    <div class="d-flex align-items-end justify-content-end col-md-4 pt-2">
                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm mb-1" id="resetButton">
                                            <i class="fas fa-sync-alt pe-1" id="resetIcon"></i>
                                            {{ __('Reset') }}
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between pb-0">
                            <h5 class="pb-1">{{ __('Sales Report') }}</h5>
                        </div>
                        <div class="card-body px-3 pt-0 pb-2">
                            <div class="dataTableButtons-container d-flex mx-0 align-items-center pb-2">
                                <div id="dataTableButtons" class="dataTableButtons-left-side col-md-12"
                                    style="justify-content: space-between"></div>
                            </div>
                            @include('backends.order._table')
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
        document.getElementById('resetButton').addEventListener('click', function() {
            let icon = document.getElementById('resetIcon');
            icon.classList.add('fa-spin');

            window.location.href = "{{ route('admin.order.index') }}";
        });
    </script>
    <script>
        $(function() {
            // Date-range callback
            function cb(start, end) {
                $('#reportrange span')
                .text(start.format('D MMM, YYYY') + ' - ' + end.format('D MMM, YYYY'));
                $('#date_from').val(start.format('YYYY-MM-DD'));
                $('#date_to').val(end.format('YYYY-MM-DD'));
                fetchFilteredData();
            }

            // Initialize the picker
            $('#reportrange').daterangepicker({
                startDate: moment().subtract(29, 'days'),
                endDate:   moment(),
                ranges: {
                    'Today':       [moment(), moment()],
                    'Yesterday':   [moment().subtract(1,'days'), moment().subtract(1,'days')],
                    'Last 7 Days': [moment().subtract(6,'days'), moment()],
                    'Last 30 Days':[moment().subtract(29,'days'), moment()],
                    'This Month':  [moment().startOf('month'), moment().endOf('month')],
                    'Last Month':  [moment().subtract(1,'month').startOf('month'), moment().subtract(1,'month').endOf('month')]
                }
            }, cb);

            // Re-fetch when any filter input/select changes
            $('#filterForm').on('change', 'select, input', fetchFilteredData);

            // Initial load
            cb(moment().subtract(29, 'days'), moment());


            // AJAX replace table HTML & re-init DataTable
            function fetchFilteredData() {
                const formData = $('#filterForm').serialize();
                $.ajax({
                    url: "{{ route('admin.order.index') }}",
                    method: 'GET',
                    data: formData,
                    success: function(html) {
                        // Inject new table
                        $('.table-wrapper').html(html);
                        // Destroy old table (if any) & re-initialize
                        if ($.fn.DataTable.isDataTable('#bookingTable')) {
                            $('#bookingTable').DataTable().clear().destroy();
                        }
                        initDataTable();
                    },
                    error: function() {
                        alert('Failed to fetch filtered data.');
                    }
                });
            }
        });
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

        $('.custom-file-input').change(function(e) {
            var reader = new FileReader();
            var preview = $(this).closest('.form-group').find('.preview img');
            console.log(preview);
            reader.onload = function(e) {
                preview.attr('src', e.target.result).show();
            }
            reader.readAsDataURL(this.files[0]);
        });

        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();

            const Confirmation = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            });

            Confirmation.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {

                    console.log(`.form-delete-${$(this).data('id')}`);
                    var data = $(`.form-delete-${$(this).data('id')}`).serialize();
                    // console.log(data);
                    $.ajax({
                        type: "post",
                        url: $(this).data('href'),
                        data: data,
                        // dataType: "json",
                        success: function(response) {
                            console.log(response);
                            if (response.status == 1) {
                                $('.table-wrapper').replaceWith(response.view);
                                toastr.success(response.msg);
                            } else {
                                toastr.error(response.msg)

                            }
                        }
                    });
                }
            });
        });

        //for update status
        // initializeStatusInput("{{ route('admin.shoes-slider.update_status') }}");
    </script>
@endpush
