@extends('backends.layouts.admin')
@section('page_title', __('Sales Report Detail'))

@section('contents')
    <style>
        .form-switch .form-check-input:after {
            top: 0px;
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

    <div class="px-2 mx-1">
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="mb-1">Order ID #{{ @$order->invoice_ref }}</h5>
                                <p class="text-muted mb-2">{{ @$order->created_at->format('d M, Y, h:i A') }}</p>
                            </div>
                            <div>
                                {{-- <a href="" class="btn bg-gradient-primary me-2">
                                    <i class="fas fa-map-marker-alt me-2"></i> Show locations on map
                                </a> --}}
                                <a href="{{ route('admin.order.invoice.pdf', @$order->id) }}" class="btn bg-gradient-primary" target="_blank">
                                    <i class="fas fa-print me-2"></i> Print Invoice
                                </a>
                            </div>
                        </div>

                        @if ($order->order_type == 'delivery')
                            <div class="row mb-3">
                                <div class="col-md-12 text-md-end">
                                    <span class="text-muted pe-2">{{ __('Order Status') }}:</span>
                                    <span id="order-status-badge" class="badge
                                        {{ $order->order_status == 'pending' ? 'bg-gradient-warning' : '' }}
                                        {{ $order->order_status == 'confirmed' ? 'bg-gradient-success' : '' }}
                                        {{ $order->order_status == 'packaging' ? 'bg-gradient-info' : '' }}
                                        {{ $order->order_status == 'out_for_delivery' ? 'bg-gradient-primary' : '' }}
                                        {{ $order->order_status == 'delivered' ? 'bg-gradient-success' : '' }}
                                        {{ $order->order_status == 'failed_to_deliver' ? 'bg-gradient-danger' : '' }}
                                        {{ $order->order_status == 'cancelled' ? 'bg-gradient-danger' : '' }}">
                                        {{ str_replace('_', ' ', $order->order_status) }}
                                    </span>
                                </div>
                            </div>
                        @else
                            <div class="row mb-3">
                                <div class="col-md-12 text-md-end">
                                    <span class="text-muted pe-2">{{ __('Order Status') }}:</span>
                                    <span id="order-status-badge" class="badge
                                        {{ $order->order_status == 'pending' ? 'bg-gradient-warning' : '' }}
                                        {{ $order->order_status == 'confirmed' ? 'bg-gradient-success' : '' }}
                                        {{ $order->order_status == 'preparing' ? 'bg-gradient-info' : '' }}
                                        {{ $order->order_status == 'picked_up' ? 'bg-gradient-primary' : '' }}
                                        {{ $order->order_status == 'cancelled' ? 'bg-gradient-danger' : '' }}">
                                        {{ str_replace('_', ' ', $order->order_status) }}
                                    </span>
                                </div>
                            </div>
                        @endif

                        <div class="row mb-3">
                            <div class="col-md-12 text-md-end">
                                <span class="text-muted pe-2">Order Type:</span>
                                {{ ucwords(@$order->order_type) }}
                            </div>
                        </div>

                        @if ($order->order_type == 'delivery')
                            <div class="row mb-3">
                                <div class="col-md-12 text-md-end">
                                    <span class="text-muted pe-2">Payment Method:</span>
                                    {{ strtoupper(str_replace('_', ' ', @$order->payment_method)) }}
                                </div>
                            </div>
                        @endif

                        <div class="row mb-4">
                            <div class="col-md-12 text-md-end">
                                <span class="text-muted pe-2">Payment Status:</span>
                                <span id="payment-status-label" class="{{ $order->payment_status == 'paid' ? 'text-success' : 'text-danger' }}">
                                    {{ ucwords($order->payment_status) }}
                                </span>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">
                                            SL</th>
                                        <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 px-2">
                                            Item Details</th>
                                        <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 px-2">
                                            Item Price</th>
                                        <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 px-2">
                                            Item Discount</th>
                                        <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 px-2">
                                            Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($order->details ?? [] as $index => $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if ($item->product->productgallery && count($item->product->productgallery->images) > 0)
                                                        @php
                                                            $firstImage = $item->product->productgallery->images[0];
                                                            $allImages = $item->product->productgallery->images;
                                                        @endphp

                                                        <img src="{{ file_exists(public_path('uploads/products/' . $firstImage)) ? asset('uploads/products/' . $firstImage) : asset('uploads/default.png') }}"
                                                            alt="Product Image" class="avatar avatar-xl me-3"
                                                            style="object-fit: contain; cursor: pointer;"
                                                            onclick="openGalleryModal({{ $item->product->id }})">

                                                        @include('backends.order.partial.modal_popup_image')
                                                    @else
                                                        <img src="{{ !empty($item->product->image[0]) && file_exists(public_path('uploads/products/' . $item->product->image[0])) ? asset('uploads/products/' . $item->product->image[0]) : asset('uploads/default.png') }}"
                                                            alt="Product Image" class="avatar avatar-sm me-3">
                                                    @endif
                                                    <div>
                                                        <p class="mb-0 fw-bold"> {{ $item->product->name }} </p>
                                                        <p class="mb-0"> Qty: {{ $item->product_qty }} </p>
                                                        <p class="mb-0"> Size: {{ $item->product_size }}</p>
                                                        <p class="mb-0 text-muted">Unit price:
                                                            ${{ number_format($item->product_price, 2) }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td> $ {{ number_format($item->product_price * $item->product_qty, 2) }} </td>
                                            @php
                                                $discount_percent = (($item->product_price * $item->discount) / 100) * $item->product_qty;
                                                $discount_amount = $item->discount * $item->product_qty;
                                            @endphp
                                            <td>
                                                @if ($item->discount_type == 'percent')
                                                    $ {{ number_format($discount_percent, 2) }}
                                                @else
                                                    $ {{ number_format($discount_amount, 2) }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->discount_type == 'percent')
                                                    $ {{ number_format(($item->product_price * $item->product_qty) - $discount_percent, 2) }}
                                                @else
                                                    $ {{ number_format($item->product_price * $item->product_qty - $discount_amount, 2) }}
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No data found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-md-6">
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td>Item price</td>
                                            <td class="text-end"> $ {{ number_format($order->order_amount, 2) }} </td>
                                        </tr>
                                        <tr>
                                            <td>Item Discount</td>
                                            <td class="text-end"> - $ {{ number_format($order->discount_amount, 2) }} </td>
                                        </tr>
                                        <tr>
                                            <td>Sub Total</td>
                                            <td class="text-end"> $ {{ number_format($order->order_amount - $order->discount_amount, 2) }} </td>
                                        </tr>
                                        <tr>
                                            <td>Delivery Fee</td>
                                            <td class="text-end"> $ {{ number_format($order->delivery_fee, 2) }} </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><hr class="horizontal dark my-0"></td>
                                        </tr>
                                        <tr class="fw-bold">
                                            <td>Total</td>
                                            <td class="text-end"> $ {{ number_format($order->final_total, 2) }} </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h6 class="mb-3 text-center">Order & Shipping Info</h6>

                        @if ($order->order_type == 'delivery')
                            <div class="mb-3">
                                <label class="form-label">Change Order Status</label>
                                <select class="form-select" id="orderStatus" onchange="changeOrderStatus(this.value)">
                                    <option value="pending" {{ @$order->order_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ @$order->order_status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="packaging" {{ @$order->order_status == 'packaging' ? 'selected' : '' }}>Packaging</option>
                                    <option value="out_for_delivery" {{ @$order->order_status == 'out_for_delivery' ? 'selected' : '' }}>Out for delivery</option>
                                    <option value="delivered" {{ @$order->order_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="failed_to_deliver" {{ @$order->order_status == 'failed_to_deliver' ? 'selected' : '' }}>Failed to deliver</option>
                                    <option value="cancelled" {{ @$order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                        @else
                            <div class="mb-3">
                                <label class="form-label">Change Order Status</label>
                                <select class="form-select" id="orderStatus" onchange="changeOrderStatus(this.value)">
                                    <option value="pending" {{ @$order->order_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ @$order->order_status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="preparing" {{ @$order->order_status == 'preparing' ? 'selected' : '' }}>Preparing</option>
                                    <option value="picked_up" {{ @$order->order_status == 'picked_up' ? 'selected' : '' }}>Picked up</option>
                                    <option value="cancelled" {{ @$order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                        @endif

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center form-control">
                                <div class="left">
                                    <span>Payment Status</span>
                                </div>
                                <div class="right d-flex align-items-center">
                                    <span class="me-3">{{ ucwords(@$order->payment_status) }}</span>
                                    <label for="status_{{ $order->id }}" class="switch pt-0">
                                        <input type="checkbox" class="status" id="status_{{ $order->id }}"
                                            data-id="{{ $order->id }}" {{ $order->payment_status == 'paid' ? 'checked' : '' }}
                                            name="payment_status">
                                        <div class="slider">
                                            <div class="circle">
                                                <svg class="cross" xml:space="preserve" style="enable-background:new 0 0 512 512"
                                                    viewBox="0 0 365.696 365.696" y="0" x="0" height="6" width="6"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g>
                                                        <path data-original="#000000" fill="currentColor"
                                                            d="M243.188 182.86 356.32 69.726c12.5-12.5 12.5-32.766 0-45.247L341.238 9.398c-12.504-12.503-32.77-12.503-45.25 0L182.86 122.528 69.727 9.374c-12.5-12.5-32.766-12.5-45.247 0L9.375 24.457c-12.5 12.504-12.5 32.77 0 45.25l113.152 113.152L9.398 295.99c-12.503 12.503-12.503 32.769 0 45.25L24.48 356.32c12.5 12.5 32.766 12.5 45.247 0l113.132-113.132L295.99 356.32c12.503 12.5 32.769 12.5 45.25 0l15.081-15.082c12.5-12.504 12.5-32.77 0-45.25zm0 0">
                                                        </path>
                                                    </g>
                                                </svg>
                                                <svg class="checkmark" xml:space="preserve"
                                                    style="enable-background:new 0 0 512 512" viewBox="0 0 24 24" y="0" x="0"
                                                    height="10" width="10" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                    version="1.1" xmlns="http://www.w3.org/2000/svg">
                                                    <g>
                                                        <path class="" data-original="#000000" fill="currentColor"
                                                            d="M9.707 19.121a.997.997 0 0 1-1.414 0l-5.646-5.647a1.5 1.5 0 0 1 0-2.121l.707-.707a1.5 1.5 0 0 1 2.121 0L9 14.171l9.525-9.525a1.5 1.5 0 0 1 2.121 0l.707.707a1.5 1.5 0 0 1 0 2.121z">
                                                        </path>
                                                    </g>
                                                </svg>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        @if ($order->order_type == 'delivery')
                            <div class="mb-4">
                                <label class="form-label">Shipping Method ( No Shipping Method Selected )</label>
                                <div class="form-control">
                                    <span>{{ ucwords(str_replace('_', ' ', @$order->delivery_type)) }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-user me-2"></i>
                                <h6 class="mb-0">Customer information</h6>
                            </div>

                            <div class="d-flex mb-2">
                                <img src="{{ asset('uploads/customers/' . $order->customer->image) ?? asset('uploads/man.png') }}"
                                    alt="Customer" class="avatar avatar-lg rounded-circle me-3" style="object-fit: cover;">
                                <div>
                                    <h6 class="mb-1">{{ @$order->customer->name }}</h6>
                                    <p class="mb-1 text-muted">
                                        {{ App\Models\Order::where('customer_id', @$order->customer->id)->count() }} Orders
                                    </p>
                                    <p class="mb-1">{{ @$order->customer->phone }}</p>
                                    <p class="mb-0">{{ @$order->customer->email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($order->address)
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <div>
                                <div class="d-flex justify-content-between mb-1">
                                    <div class="d-flex">
                                        <i class="fas fa-map-marker-alt me-2 pt-1"></i>
                                        <h6>Shipping address</h6>
                                    </div>
                                    {{-- <a href="#" class="btn btn-sm btn-outline-primary btn-modal" data-toggle="modal"
                                        data-target="#editAddressModal">
                                        <i class="fas fa-edit"></i>
                                    </a> --}}
                                </div>
                                <div>
                                    <p class="mb-1"><strong>Name:</strong> {{ @$order->customer->name }} </p>
                                    <p class="mb-1"><strong>Label:</strong> {{ ucwords(@$order->address['label'] ) }} </p>
                                    <p class="mb-1"><strong>Contact:</strong> {{ @$order->address['phoneNumber'] }}
                                    </p>
                                    <p class="mb-1"><strong>Province:</strong>
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        {{ @$order->address['province'] ?? '' }}
                                    </p>
                                    <p class="mb-1"><strong>Street Line #1:</strong>
                                        {{ @$order->address['streetLine1'] ?? '' }}</p>
                                    <p class="mb-1"><strong>Street Line #2:</strong>
                                        {{ @$order->address['streetLine2'] ?? '' }}</p>
                                    <p class="mb-0"><strong>Note:</strong> {{ @$order->address['note'] ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($order->pay_slip)
                    <div class="card shadow-sm mb-2">
                        <div class="card-body">
                            <div class="">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-user me-2"></i>
                                    <h6 class="mb-0">Pay Slip</h6>
                                </div>
                                <div class="d-flex align-items-center">
                                    <img src="{{ !empty($order->pay_slip) ? asset('uploads/payments/' . $order->pay_slip) : asset('uploads/default1.png') }}"
                                        alt="payslip" class="w-100 rounded-3" style="object-fit: cover; height: 16rem; object-position: center;">
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @include('backends.order.partial.modal_edit_address')
@endsection
@push('js')
    {{-- Update Payment Status --}}
    <script>
        $(document).on('change', '.status', function () {
            var checkbox = $(this);
            var orderId = checkbox.data('id');
            var isChecked = checkbox.is(':checked');

            $.ajax({
                url: '{{ route('admin.order.update_payment_status', $order->id) }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    payment_status: isChecked
                },
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

                    if (response.success) {
                        const statusText = response.new_status.charAt(0).toUpperCase() + response.new_status.slice(1);
                        const statusLabel = $('#payment-status-label');

                        checkbox.closest('.right').find('span').text(statusText);
                        statusLabel.text(statusText);

                        if (response.new_status === 'paid') {
                            statusLabel.removeClass('text-danger').addClass('text-success');
                        } else {
                            statusLabel.removeClass('text-success').addClass('text-danger');
                        }

                        Toast.fire({
                            icon: 'success',
                            title: 'Updated to ' + response.new_status
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Failed to update payment status'
                        });
                    }
                },
                error: function () {
                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong while updating payment status.'
                    });
                }
            });
        });
    </script>
    {{-- Update Order Status --}}
    <script>
        function changeOrderStatus(newStatus) {
            $.ajax({
                url: '{{ route('admin.order.update_order_status', $order->id) }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    order_status: newStatus
                },
                success: function (response) {
                    if (response.success) {
                        const formattedStatus = response.new_status.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());

                        $('#order-status-badge')
                            .text(formattedStatus)
                            .removeClass('bg-gradient-warning bg-gradient-success bg-gradient-info bg-gradient-primary bg-gradient-danger')
                            .addClass(getGradientBadgeClass(response.new_status));

                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Failed to update order status.'
                        });
                    }
                },
                error: function () {
                    Toast.fire({
                        icon: 'error',
                        title: 'An error occurred while updating order status.'
                    });
                }
            });
        }

        function getBadgeClass(status) {
            switch (status) {
                case 'delivered': return 'bg-success';
                case 'failed_to_deliver': return 'bg-danger';
                case 'cancelled': return 'bg-danger';
                case 'out_for_delivery': return 'bg-info';
                case 'packaging': return 'bg-warning';
                case 'confirmed': return 'bg-primary';
                default: return 'bg-secondary';
            }
        }

        function getGradientBadgeClass(status) {
            switch (status) {
                case 'pending': return 'bg-gradient-warning';
                case 'confirmed': return 'bg-gradient-success';
                case 'packaging': return 'bg-gradient-info';
                case 'out_for_delivery': return 'bg-gradient-primary';
                case 'delivered': return 'bg-gradient-success';
                case 'failed_to_deliver': return 'bg-gradient-danger';
                case 'cancelled': return 'bg-gradient-danger';
                case 'preparing': return 'bg-gradient-info';
                case 'picked_up': return 'bg-gradient-primary';
                default: return 'bg-gradient-secondary';
            }
        }
    </script>
    <script>
        function openGalleryModal(productId) {
            let modal = new bootstrap.Modal(document.getElementById('imageGalleryModal-' + productId), {
                keyboard: true
            });
            modal.show();
        }
    </script>
@endpush
