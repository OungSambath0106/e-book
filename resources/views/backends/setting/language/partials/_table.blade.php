<div class="card-body table-wrapper">
    <table class="table">
        <thead>
            <tr>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Code') }}</th>
                <th>{{ __('Status') }}</th>
                {{-- <th>{{ __('Default') }}</th> --}}
                <th>{{ __('Action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach (json_decode($language) as $row)
                <tr>
                    <td class="text-capitalize align-content-center">{{ $row->name }}</td>
                    <td class="align-content-center">{{ $row->code }}</td>
                    <td>
                        @if($row->code != 'en')
                            <label for="status_{{ $row->id }}" class="switch">
                                <input type="checkbox" class="status" id="status_{{ $row->id }}"
                                    data-id="{{ $row->id }}" {{ $row->status == 1 ? 'checked' : '' }} name="status">
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
                                        <svg class="checkmark" xml:space="preserve" style="enable-background:new 0 0 512 512"
                                            viewBox="0 0 24 24" y="0" x="0" height="10" width="10"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g>
                                                <path class="" data-original="#000000" fill="currentColor"
                                                    d="M9.707 19.121a.997.997 0 0 1-1.414 0l-5.646-5.647a1.5 1.5 0 0 1 0-2.121l.707-.707a1.5 1.5 0 0 1 2.121 0L9 14.171l9.525-9.525a1.5 1.5 0 0 1 2.121 0l.707.707a1.5 1.5 0 0 1 0 2.121z">
                                                </path>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                            </label>
                        @endif
                    </td>
                    <td>
                        @if ($row->code != 'en')
                            <a class="btn bg-gradient-success btn-sm mb-0 btn-modal" href="#" data-href="{{ route('admin.setting.language.edit', ['id' => $row->id]) }}" data-toggle="modal" data-container=".modal_form">
                                <i class=" fa fa-pencil-alt"></i>
                                {{ __('Edit') }}
                            </a>
                            <a class="btn bg-gradient-info btn-sm mb-0" href="{{ route('admin.setting.language.translate', ['code' => $row->code]) }}" >
                                {{-- <i class=" fa fa-tr"></i> --}}
                                {{ __('Translate') }}
                            </a>
                            <form action="{{ route('admin.setting.language.delete', ['id' => $row->id, 'code' => $row->code]) }}" class="d-inline-block form-delete-{{ $row->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" data-id="{{ $row->id }}" data-href="{{ route('admin.setting.language.delete', ['id' => $row->id, 'code' => $row->code]) }}" class="btn bg-gradient-danger btn-sm mb-0 btn-delete">
                                    <i class="fas fa-trash-alt"></i>
                                    {{ __('Delete') }}
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@push('js')
<script>
    $('input.status').on('change', function () {
        $.ajax({
            type: "get",
            url: "{{ route('admin.setting.language.update-status') }}",
            data: { "id" : $(this).data('id') },
            dataType: "json",
            success: function (response) {
                if (response.status == 1) {
                    toastr.success(response.msg);
                } else {
                    toastr.error(response.msg);
                }
            }
        });
    });

    $('input.default_status').on('change', function () {
        $.ajax({
            type: "get",
            url: "{{ route('admin.setting.language.update-default-status') }}",
            data: { "id" : $(this).data('id') },
            dataType: "json",
            success: function (response) {
                if (response.status == 1) {
                    toastr.success(response.msg);
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                } else {
                    toastr.error(response.msg);
                }
            }
        });
    });
</script>
@endpush

