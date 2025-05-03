<div class="col-md-12 px-0 pt-2">
    <div class="card p-2 mb-0" style="box-shadow:none !important;border:1px solid #E1E1E1 !important">
        <div class="image-grid">
            <input type="hidden" name="promotion_id" class="promotion_id" value="{{ $promotion->id }}">

            @if (@$promotion->promotiongallery)
                @php
                    $images = $promotion->promotiongallery->images;
                @endphp
                @foreach ($images as $index => $image)
                    @if (isset($image))
                        <div class="image-box" data-image-id="{{ $index }}">
                            <input type="hidden" name="name_images[]" value="{{ $image }}">
                            <img src="{{ asset('uploads/promotions/' . $image) }}"
                                alt="promotion_image" height="150px">
                            <button type="button" class="remove-image">&times;</button>
                        </div>
                    @endif
                @endforeach
            @endif
            <div class="upload-box custom-file m-0" id="upload-box" style="cursor: pointer; text-align: center;">
                <div class="mt-3"><i class="fa-solid fa-plus fa-lg" style="color:#666666;font-size: 7rem !important;"></i></div>
                <div>{{ __('Drop files or click to upload') }}</div>
                <input type="hidden" name="image_names" class="image_names_hidden">
                <input value="" type="file" class="custom-file-input" name="gallery[]" id="fileUpload"
                    accept="image/png, image/jpeg, image/gif, image/webp" style="display: none;" multiple>
            </div>
        </div>
    </div>
</div>
@include('backends.promotion.partial.delete-gallery-modal')

@push('js')
    <script>
        let imageBoxToDelete;
        $(document).on('click', '.remove-image', function() {
            const imageBox = $(this).closest('.image-box');
            const imageSrc = imageBox.find('img').attr('src');
            const imageName = imageSrc.split('/').pop();
            const promotionId = {{ $promotion->id }};

            $('#image-to-delete').attr('src', imageSrc);
            imageBoxToDelete = imageBox;
            $('#delete-gallery-modal').modal('show');

            $('#confirm-delete').off('click').on('click', function() {
                $.ajax({
                    url: '{{ route('admin.promotion.delete_gallery') }}',
                    type: 'DELETE',
                    data: {
                        name: imageName,
                        promotion_id: promotionId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            imageBoxToDelete.remove();
                            $('#delete-gallery-modal').modal('hide');
                        } else {
                            console.log('Error deleting image: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Error deleting image. Please try again.');
                    }
                });

            });
        });
    </script>
@endpush
