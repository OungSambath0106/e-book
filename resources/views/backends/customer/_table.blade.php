<div class="table-wrapper p-0">
    <table id="bookingTable" class="table align-items-center table-responsive mb-0">
        <thead class="text-uppercase">
            <tr>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">{{ __('SL') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">{{ __('Image') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 px-2">{{ __('Customer Name') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 px-2">{{ __('Gender') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 px-2">{{ __('Provider') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 px-2">{{ __('Phone') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 px-2">{{ __('Email') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center">{{ __('Created date') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center">{{ __('Status') }}</th>
                @if (auth()->user()->can('customer.edit'))
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center">{{ __('Action') }}</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse ($customers as $customer)
                <tr>
                    <td>
                        <p class="text-sm font-weight-bold mb-0"> {{ $loop->iteration }} </p>
                    </td>
                    <td data-order="{{ strtolower(@$customer->name) }}">
                        <img src="
                        @if ($customer->image && file_exists(public_path('uploads/customers/' . $customer->image)))
                            {{ asset('uploads/customers/'. $customer->image) }}
                        @elseif ($customer->provider=='google')
                            {{ $customer->image }}
                        @elseif ($customer->gender=='male')
                            {{ asset('uploads/man.png') }}
                        @elseif ($customer->gender=='female')
                            {{ asset('uploads/woman.png') }}
                        @elseif ($customer->gender==null)
                            {{ asset('uploads/man.png') }}
                        @endif
                        " alt="" class="avatar avatar-md rounded-circle" style="object-fit: cover; cursor: pointer;"
                        data-toggle="modal" data-target="#imageModal" onclick="showImageModal(this)">
                    </td>
                    <td data-order="{{ strtolower(@$customer->name) }}">
                        <p class="text-sm font-weight-bold mb-0 "> {{ @$customer->name ?? 'N/A' }} </p>
                    </td>
                    <td data-order="{{ strtolower(@$customer->gender) }}">
                        <p class="text-sm font-weight-bold mb-0 "> {{ ucfirst(@$customer->gender ?? 'N/A') }} </p>
                    </td>
                    <td data-order="{{ strtolower(@$customer->provider) }}">
                        <p class="text-sm font-weight-bold mb-0 "> {{ ucfirst(@$customer->provider ?? 'N/A') }} </p>
                    </td>
                    <td data-order="{{ strtolower(@$customer->phone) }}">
                        <p class="text-sm font-weight-bold mb-0 "> {{ @$customer->phone ?? 'N/A' }} </p>
                    </td>
                    <td data-order="{{ strtolower(@$customer->email) }}">
                        <p class="text-sm font-weight-bold mb-0 "> {{ @$customer->email ?? 'N/A' }} </p>
                    </td>
                    <td data-order="{{ $customer->created_at->timestamp }}">
                        <p class="text-sm font-weight-bold mb-0 text-center"> {{ $customer->created_at->format('d M Y h:i A') }} </p>
                    </td>
                    <td data-order="{{ $customer->status }}" class="align-middle text-center text-sm" style="justify-items: center;">
                        <label for="status_{{ $customer->id }}" class="switch">
                            <input type="checkbox" class="status"
                            id="status_{{ $customer->id }}" data-id="{{ $customer->id }}"
                            {{ $customer->status == 1 ? 'checked' : '' }} name="status">
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
                            </div>
                        </label>
                    </td>
                    <td class="align-middle text-center">
                        @if (auth()->user()->can('customer.edit'))
                            <a href="{{ route('admin.customer.edit', $customer->id) }}" class="btn-edit" title="Edit" data-bs-toggle="tooltip" data-bs-placement="top">
                                <span class="badge bg-gradient-primary p-2">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </span>
                            </a>
                        @endif
                        @if (auth()->user()->can('customer.delete'))
                            <form action="{{ route('admin.customer.destroy', $customer->id) }}" class="d-inline-block form-delete-{{ $customer->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" data-id="{{ $customer->id }}" data-username="{{ @$customer->first_name }} {{ @$customer->last_name ?? 'N/A' }}"
                                    data-href="{{ route('admin.customer.destroy', $customer->id) }}" class="btn-delete ps-0" title="Delete" style="background: none; border: none;" data-bs-toggle="tooltip" data-bs-placement="top">
                                    <span class="badge bg-gradient-danger p-2">
                                        <i class="fa fa-trash-alt"></i>
                                    </span>
                                </button>
                            </form>
                        @endif

                        @if (!auth()->user()->can('customer.edit') && !auth()->user()->can('customer.delete'))
                            <span class="text-muted">No Actions</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ auth()->user()->can('customer.edit') || auth()->user()->can('customer.delete') ? 8 : 7 }}" class="text-center data-not-available" style="background-color: ghostwhite">
                        {{ __('Customers are not available.') }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
