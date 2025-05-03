<div class="table-wrapper p-0">
    <table id="bookingTable" class="table align-items-center table-responsive mb-0">
        <thead>
            <tr>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 px-3">#</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 px-3">{{ __('Name') }} </th>
                <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">{{ __('Action') }}</th>
            </tr>
        </thead>
        <tbody>
            @if($roles)
                @foreach ($roles as $row)
                    <tr>
                        <td>
                            <p class="text-sm font-weight-bold mb-0 px-2">{{$loop->iteration}}</p>
                        </td>
                        <td>
                            <p class="text-sm font-weight-bold mb-0 px-2">{{$row->name}}</p>
                        </td>
                        <td class="align-middle text-center">
                            @if ($row->name != 'admin')
                                @if (auth()->user()->can('role.edit'))
                                    <a href="{{route('admin.roles.edit',$row->id)}}" class="btn-edit" title="Edit" data-bs-toggle="tooltip" data-bs-placement="top">
                                        <span class="badge bg-gradient-primary p-2">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </span>
                                    </a>
                                @endif

                                @if (auth()->user()->can('role.delete') && !in_array($row->name, ['admin', 'partner', 'customer']))
                                    <form action="{{ route('admin.roles.destroy', $row->id) }}" class="d-inline-block form-delete-{{ $row->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" data-id="{{ $row->id }}" data-href="{{ route('admin.roles.destroy', $row->id) }}" class="btn-delete ps-0" title="Delete" style="background: none; border: none;" data-bs-toggle="tooltip" data-bs-placement="top">
                                            <span class="badge bg-gradient-danger p-2">
                                                <i class="fa fa-trash-alt"></i>
                                            </span>
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
