<div class="table-wrapper p-0">
    <table id="bookingTable" class="table align-items-center table-responsive mb-0">
        <thead>
            <tr>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7"> {{ __('SL') }} </th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 px-3"> {{ __('Name') }} </th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2"> {{ __('Created By') }} </th>
                <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7"> {{ __('Status') }} </th>
                <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7"> {{ __('Action') }} </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>
                        <p class="text-sm font-weight-bold mb-0">{{ $loop->iteration }}</p>
                    </td>
                    <td data-order="{{ strtolower($category->name) }}">
                        <p class="mb-0 text-sm font-weight-bold">{{ $category->name }}</p>
                    </td>
                    <td>
                        <p class="text-sm font-weight-bold mb-0">{{ $category->createdBy->name }}</p>
                    </td>
                    <td class="align-middle text-center text-sm" style="justify-items: center;">
                        <label for="status_{{ $category->id }}" class="switch">
                            <input type="checkbox" class="status"
                            id="status_{{ $category->id }}" data-id="{{ $category->id }}"
                            {{ $category->status == 1 ? 'checked' : '' }} name="status">
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
                        @if (auth()->user()->can('category.edit'))
                            <a href="#" data-href="{{ route('admin.category.edit', $category->id) }}"
                                class="btn-edit" data-bs-toggle="tooltip" title="{{ __('Edit') }}" data-bs-placement="top">
                                <span class="badge bg-gradient-primary p-2">
                                    <i class="fa fa-pen-to-square"></i>
                                </span>
                            </a>
                        @endif

                        @if (auth()->user()->can('category.delete'))
                            <form action="{{ route('admin.category.destroy', $category->id) }}" class="d-inline-block form-delete-{{ $category->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" data-id="{{ $category->id }}" data-href="{{ route('admin.category.destroy', $category->id) }}"
                                    class="btn-delete ps-0" title="{{ __('Delete') }}" style="background: none; border: none;" data-bs-toggle="tooltip" data-bs-placement="top">
                                    <span class="badge bg-gradient-danger p-2">
                                        <i class="fa fa-trash-alt"></i>
                                    </span>
                                </button>
                            </form>
                        @endif

                        @if (!auth()->user()->can('category.edit') && !auth()->user()->can('category.delete'))
                            <span class="text-muted">{{ __('No Actions') }}</span>
                        @endif
                    </td>
                </tr>
            @empty
                <td colspan="{{ auth()->user()->can('category.edit') || auth()->user()->can('category.delete') ? 5 : 4 }}" class="text-center" style="background-color: ghostwhite">
                    {{ __('Categories are not available.') }}
                </td>
            @endforelse
        </tbody>
    </table>
</div>
