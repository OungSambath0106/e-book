<div class="table-wrapper p-0">
    <table id="bookingTable" class="table align-items-center table-responsive mb-0">
        <thead class="text-uppercase">
            <tr>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">{{ __('SL') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">{{ __('Image') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 px-2">{{ __('Author Name') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 px-2">{{ __('Role') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 px-2">{{ __('Creativity') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 px-2">{{ __('Popularity') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center">{{ __('Created date') }}</th>
                @if (auth()->user()->can('author.edit'))
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center">{{ __('Action') }}</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse ($authors as $author)
                <tr>
                    <td>
                        <p class="text-sm font-weight-bold mb-0"> {{ $loop->iteration }} </p>
                    </td>
                    <td data-order="{{ strtolower(@$author->name) }}">
                        <img src="
                        @if ($author->image && file_exists(public_path('uploads/authors/' . $author->image)))
                            {{ asset('uploads/authors/'. $author->image) }}
                        @else
                            {{ asset('uploads/man.png') }}
                        @endif
                        " alt="" class="avatar avatar-md rounded-circle" style="object-fit: cover; cursor: pointer;"
                        data-toggle="modal" data-target="#imageModal" onclick="showImageModal(this)">
                    </td>
                    <td data-order="{{ strtolower(@$author->name) }}">
                        <p class="text-sm font-weight-bold mb-0 "> {{ @$author->name ?? 'N/A' }} </p>
                    </td>
                    <td data-order="{{ strtolower(@$author->role) }}">
                        <p class="text-sm font-weight-bold mb-0 "> {{ ucfirst(@$author->role ?? 'N/A') }} </p>
                    </td>
                    <td data-order="{{ strtolower(@$author->creativity) }}">
                        <p class="text-sm font-weight-bold mb-0 "> {{ ucfirst(@$author->creativity ?? 'N/A') }} </p>
                    </td>
                    <td data-order="{{ strtolower(@$author->popularity) }}">
                        <p class="text-sm font-weight-bold mb-0 "> {{ @$author->popularity ?? 'N/A' }} </p>
                    </td>
                    <td data-order="{{ $author->created_at->timestamp }}">
                        <p class="text-sm font-weight-bold mb-0 text-center"> {{ $author->created_at->format('d M Y h:i A') }} </p>
                    </td>
                    <td class="align-middle text-center">
                        @if (auth()->user()->can('author.edit'))
                            <a href="{{ route('admin.author.edit', $author->id) }}" class="btn-edit" title="Edit" data-bs-toggle="tooltip" data-bs-placement="top">
                                <span class="badge bg-gradient-primary p-2">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </span>
                            </a>
                        @endif
                        @if (auth()->user()->can('author.delete'))
                            <form action="{{ route('admin.author.destroy', $author->id) }}" class="d-inline-block form-delete-{{ $author->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" data-id="{{ $author->id }}" data-username="{{ @$author->name ?? 'N/A' }}"
                                    data-href="{{ route('admin.author.destroy', $author->id) }}" class="btn-delete ps-0" title="Delete" style="background: none; border: none;" data-bs-toggle="tooltip" data-bs-placement="top">
                                    <span class="badge bg-gradient-danger p-2">
                                        <i class="fa fa-trash-alt"></i>
                                    </span>
                                </button>
                            </form>
                        @endif

                        @if (!auth()->user()->can('author.edit') && !auth()->user()->can('author.delete'))
                            <span class="text-muted">No Actions</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ auth()->user()->can('author.edit') || auth()->user()->can('author.delete') ? 8 : 7 }}" class="text-center data-not-available" style="background-color: ghostwhite">
                        {{ __('Authors are not available.') }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
