@push('css')
@endpush
<div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">{{ __('Update Category') }}</h5>
            <button type="button" class="close btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <form action="{{ route('admin.category.update', $category->id) }}" enctype="multipart/form-data"
            class="submit-form" method="post">
            <div class="modal-body">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="required_label" for="name">{{ __('Name') }}</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ $category['name'] }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-end py-2">
                        <button type="submit" class="btn bg-gradient-primary btn-sm submit float-right mb-0">
                            <i class="fa fa-save pe-1"></i>
                            {{__('Save')}}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>