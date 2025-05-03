@push('css')
@endpush
<div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">{{ __('Update Banner Slider') }}</h5>
            <button type="button" class="close btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <form action="{{ route('admin.banner-slider.update', $baner->id) }}" enctype="multipart/form-data"
            class="submit-form" method="post">
            <div class="modal-body">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="required_label" for="name">{{ __('Name') }}</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ $baner['name'] }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-12 px-0">
                    <label for="dropifyInput">{{ __('Image') }} <span class="text-info text-xs">{{ __('Recommend size 1200 px') }}</span> </label>
                    <input type="hidden" name="image_names" class="image_names_hidden">
                    <input type="file" id="dropifyInput" class="dropify custom-file-input" name="image"
                            data-default-file="{{ isset($baner) && $baner->image && file_exists(public_path('uploads/banner-slider/' . $baner->image))
                            ? asset('uploads/banner-slider/' . $baner->image)
                            : '' }}" accept="image/png, image/jpeg, image/gif, image/webp">
                    <div class="progress mt-2" style="height: 10px; display: none;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">0%</div>
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
@include('backends.banner-slider.partial.delete_banner_image_modal')
<script>
    $(document).ready(function () {
        var dropifyInput = $('.dropify').dropify();

        $('.custom-file-input').change(async function (e) {
            const fileInput = $(this);
            const imageNamesHidden = fileInput.closest('.form-group').find('.image_names_hidden');
            const progressBarContainer = fileInput.closest('.form-group').find('.progress');
            const progressBar = progressBarContainer.find('.progress-bar');

            const file = e.target.files[0];
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];

            if (!allowedTypes.includes(file.type)) {
                toastr.error('Only JPG, JPEG, PNG, GIF, WEBP files are allowed.');
                return;
            }

            const formData = new FormData();
            progressBarContainer.show();
            updateProgressBar(progressBar, 0);

            try {
                const webpFile = await processImageToWebP(file);

                formData.append('image', webpFile);
                formData.append('_token', '{{ csrf_token() }}');

                simulateProgress(progressBar, function () {
                    $.ajax({
                        url: "{{ route('save_temp_file') }}",
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            if (response.status === 1) {
                                imageNamesHidden.val(response.temp_files);
                            } else {
                                toastr.error(response.msg);
                            }
                            progressBarContainer.hide();
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            toastr.error(`Upload failed: ${jqXHR.status} ${errorThrown}`);
                            console.log(jqXHR.responseText);
                            progressBarContainer.hide();
                        }
                    });
                });

            } catch (error) {
                toastr.error("Image processing failed: " + error.message);
                console.error(error);
                progressBarContainer.hide();
            }
        });

        dropifyInput.on('dropify.afterClear', function () {
            $(this).closest('.form-group').find('.image_names_hidden').val('');
            const progressBarContainer = $(this).closest('.form-group').find('.progress');
            progressBarContainer.hide();
        });

        function simulateProgress(progressBar, callback) {
            let progress = 0;
            const interval = setInterval(function () {
                progress += 10;
                updateProgressBar(progressBar, progress);
                if (progress >= 100) {
                    clearInterval(interval);
                    if (typeof callback === "function") {
                        callback();
                    }
                }
            }, 300);
        }

        function updateProgressBar(progressBar, value) {
            progressBar.css('width', value + '%');
            progressBar.text(value + '%');
            progressBar.attr('aria-valuenow', value);
        }

        async function processImageToWebP(file) {
            const MAX_WIDTH = 1200;

            const { canvas } = await loadImageToCanvas(file, MAX_WIDTH);

            const webpFile = await convertCanvasToWebPFile(canvas, file.name, 0.85);
            return webpFile;
        }

        async function loadImageToCanvas(file, maxWidth) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.onload = function (event) {
                    const img = new Image();
                    img.onload = function () {
                        const canvas = document.createElement('canvas');
                        let width = img.width;
                        let height = img.height;

                        if (width > maxWidth) {
                            height = (maxWidth / width) * height;
                            width = maxWidth;
                        }

                        canvas.width = width;
                        canvas.height = height;
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0, width, height);

                        resolve({ canvas, width, height });
                    };
                    img.onerror = reject;
                    img.src = event.target.result;
                };
                reader.onerror = reject;
                reader.readAsDataURL(file);
            });
        }

        async function convertCanvasToWebPFile(canvas, fileName, quality = 0.85) {
            const blob = await canvasToBlob(canvas, quality);

            if (!blob) {
                throw new Error('Failed to convert canvas to WebP.');
            }

            return new File([blob], fileName.replace(/\.(jpg|jpeg|png)$/i, '.webp'), { type: 'image/webp' });
        }

        function canvasToBlob(canvas, quality) {
            return new Promise((resolve) => {
                canvas.toBlob(resolve, 'image/webp', quality);
            });
        }
    });
</script>
<script>
    $(document).ready(function () {
        var dropifyInstance = $('#dropifyInput').dropify();
        var banerId = "{{ isset($baner) ? $baner->id : null }}";
        var deleteConfirmed = false;

        dropifyInstance.on('dropify.beforeClear', function (event, element) {
            if (!deleteConfirmed) {
                $('#deleteImageModal').modal('show');
                return false;
            }
            deleteConfirmed = false;
        });

        $('.btn-confirm-modal').click(function () {
            if (banerId) {
                $.ajax({
                    url: "{{ route('admin.banner-slider.delete_image') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        baner_id: banerId
                    },
                    success: function (response) {
                        if (response.success) {
                            deleteConfirmed = true;

                            removeDropifyPreview();
                        } else {
                            console.log("Error deleting image.");
                        }
                    },
                    error: function () {
                        console.log("Request failed.");
                    }
                });
            }
            $('#deleteImageModal').modal('hide');
        });

        $('.btn-cancel-modal').click(function () {
            $('#deleteImageModal').modal('hide');
        });

        function removeDropifyPreview() {
            var dropifyInput = $('#dropifyInput');
            dropifyInput.closest('.dropify-wrapper').find('.dropify-render img').remove();
            dropifyInput.closest('.dropify-wrapper').find('.dropify-preview').css('display', 'none');
            dropifyInput.val('');
        }
    });
</script>
