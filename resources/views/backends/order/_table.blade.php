<div class="table-wrapper p-0">
    <table id="bookingTable" class="table align-items-center table-responsive mb-0">
        <thead>
            <tr>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder ps-2 opacity-7">{{ __('SL') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder px-2 opacity-7">{{ __('Order ID') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder px-2 opacity-7">{{ __('Customer Name') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder px-2 opacity-7">{{ __('Order Type') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder px-2 opacity-7">{{ __('Delivery Fee') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder px-2 opacity-7">{{ __('Total Qty') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder px-2 opacity-7">{{ __('Total Discount') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder px-2 opacity-7">{{ __('Total Amount') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder px-2 opacity-7">{{ __('Payment Method') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder px-2 opacity-7">{{ __('Payment Status') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder px-2 opacity-7">{{ __('Action') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $item)
                <tr>
                    <td>
                        <p class="text-sm font-weight-bold mb-0"> {{ $loop->iteration }} </p>
                    </td>
                    <td data-order="{{ strtolower(@$item->invoice_ref) }}">
                        <p class="text-sm font-weight-bold mb-0"> {{ $item->invoice_ref }} </p>
                    </td>
                    <td data-order="{{ strtolower(@$item->customer->name) }}">
                        <p class="text-sm font-weight-bold mb-0"> {{ @$item->customer->name }} </p>
                    </td>
                    <td>
                        <p class="text-sm font-weight-bold mb-0 text-uppercase"> {{ ucwords(str_replace('_', ' ', $item->order_type)) }} </p>
                    </td>
                    <td>
                        <p class="text-sm font-weight-bold mb-0"> $ {{ $item->delivery_fee ?? 0 }} </p>
                    </td>
                    <td>
                        <p class="text-sm font-weight-bold mb-0"> {{ $item->details->sum('product_qty') }} </p>
                    </td>
                    <td>
                        <p class="text-sm font-weight-bold mb-0"> $ {{ $item->discount_amount }} </p>
                    </td>
                    <td>
                        <p class="text-sm font-weight-bold mb-0"> $ {{ number_format($item->final_total, 2) }} </p>
                    </td>
                    <td>
                        <p class="text-sm font-weight-bold mb-0 text-uppercase"> {{ ucwords(str_replace('_', ' ', $item->payment_method)) }} </p>
                    </td>
                    <td>
                        <p class="text-sm font-weight-bold mb-0">
                            @if ($item->payment_status == 'unpaid')
                                <span class="badge bg-gradient-danger"> {{ ucwords($item->payment_status) }} </span>
                            @else
                                <span class="badge bg-gradient-success"> {{ ucwords($item->payment_status) }} </span>
                            @endif
                        </p>
                    </td>
                    <td class="align-middle">
                        <a href="{{ route('admin.order.show', $item->id) }}" class="btn-edit" title="View" data-bs-toggle="tooltip" data-bs-placement="top">
                            <span class="badge bg-gradient-primary p-2">
                                <i class="fa-solid fa-eye"></i>
                            </span>
                        </a>
                        <a href="{{ route('admin.order.invoice.pdf', $item->id) }}" class="btn-link" title="PDF" data-bs-toggle="tooltip" data-bs-placement="top" target="_blank">
                            <span class="badge bg-gradient-danger p-2">
                                <i class="fas fa-file-pdf"></i>
                            </span>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" class="text-center data-not-available" style="background-color: ghostwhite">
                        {{ __('Transactions are not available.') }}
                    </td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4"></td>
                <td>
                    <span class="text-sm font-weight-bolder mb-0">
                        Total: $ {{ number_format($orders->sum('delivery_fee'), 2) }}
                    </span>
                </td>
                <td colspan="1"></td>
                <td>
                    <span class="text-sm font-weight-bolder mb-0">
                        Total: $ {{ number_format($orders->sum('discount_amount'), 2) }}
                    </span>
                </td>
                <td>
                    <span class="text-sm font-weight-bolder mb-0">
                        Total: $ {{ number_format($orders->sum('final_total'), 2) }}
                    </span>
                </td>
                <td colspan="3"></td>
            </tr>
        </tfoot>
    </table>
</div>
