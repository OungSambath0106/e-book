<div class="table-wrapper p-0">
    <table id="bookingTable" class="table align-items-center table-responsive mb-0">
        <thead>
            <tr>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">{{ __('SL') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">{{ __('Image') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 px-2">{{ __('Username') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 px-2">{{ __('Gender') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 px-2">{{ __('Phone') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 px-2">{{ __('Email') }}</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center">{{ __('Created date') }}</th>
                @if (auth()->user()->can('user.edit'))
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center">{{ __('Action') }}</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>
                        <p class="text-sm font-weight-bold mb-0"> {{ $loop->iteration }} </p>
                    </td>
                    <td data-order="{{ strtolower(@$user->first_name) . ' ' . strtolower(@$user->last_name) }}">
                        <img src="
                            @if ($user->image && file_exists(public_path('uploads/users/' . $user->image)))
                                {{ asset('uploads/users/'. $user->image) }}
                            @else
                                {{ asset('uploads/man.png') }}
                            @endif
                            " alt="" class="avatar avatar-md rounded-circle" style="object-fit: cover; cursor: pointer;"
                            data-toggle="modal" data-target="#imageModal" onclick="showImageModal(this)">
                    </td>
                    <td data-order="{{ strtolower(@$user->first_name) . ' ' . strtolower(@$user->last_name) }}">
                        <p class="text-sm font-weight-bold mb-0 "> {{ @$user->first_name }} {{ @$user->last_name ?? 'N/A' }} </p>
                    </td>
                    <td data-order="{{ strtolower(@$user->gender) }}">
                        <p class="text-sm font-weight-bold mb-0 "> {{ ucfirst(@$user->gender ?? 'N/A') }} </p>
                    </td>
                    <td data-order="{{ strtolower(@$user->phone) }}">
                        <p class="text-sm font-weight-bold mb-0 "> {{ @$user->phone ?? 'N/A' }} </p>
                    </td>
                    <td data-order="{{ strtolower(@$user->email) }}">
                        <p class="text-sm font-weight-bold mb-0 "> {{ @$user->email ?? 'N/A' }} </p>
                    </td>
                    <td data-order="{{ $user->created_at->timestamp }}">
                        <p class="text-sm font-weight-bold mb-0 text-center"> {{ $user->created_at->format('d M Y h:i A') }} </p>
                    </td>
                    <td class="align-middle text-center">
                        @if (auth()->user()->can('user.edit'))
                            <a href="{{ route('admin.user.edit', $user->id) }}" class="btn-edit" title="Edit" data-bs-toggle="tooltip" data-bs-placement="top">
                                <span class="badge bg-gradient-primary p-2">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </span>
                            </a>
                        @endif
                        @if (auth()->user()->can('user.delete'))
                            <form action="{{ route('admin.user.destroy', $user->id) }}" class="d-inline-block form-delete-{{ $user->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" data-id="{{ $user->id }}" data-username="{{ @$user->first_name }} {{ @$user->last_name ?? 'N/A' }}"
                                    data-href="{{ route('admin.user.destroy', $user->id) }}" class="btn-delete ps-0" title="Delete" style="background: none; border: none;" data-bs-toggle="tooltip" data-bs-placement="top">
                                    <span class="badge bg-gradient-danger p-2">
                                        <i class="fa fa-trash-alt"></i>
                                    </span>
                                </button>
                            </form>
                        @endif

                        @if (!auth()->user()->can('user.edit') && !auth()->user()->can('user.delete'))
                            <span class="text-muted">No Actions</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ auth()->user()->can('user.edit') || auth()->user()->can('user.delete') ? 7 : 6 }}" class="text-center data-not-available" style="background-color: ghostwhite">
                        {{ __('Users are not available.') }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
