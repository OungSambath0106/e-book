@extends('backends.layouts.admin')
@section('page_title', __('Edit Author'))
@section('contents')
    <style>
        .dark-version .table tbody tr td {
            border-width: 1px !important;
        }

        .image-box {
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 1px;
            padding: 7px;
            background-color: #E1E1E1;
            text-align: center;
            position: relative;
        }

        .div-form {
            margin-top: 0.5rem;
        }

        .progress {
            margin-top: 0.5rem;
            border-radius: 6px;
            height: 10px !important;
        }

        .image-box img {
            width: 100%;
            height: 7rem;
            border-radius: 7px;
            object-fit: cover;
        }

        .image-box .description {
            margin-top: 10px;
            font-weight: bold;
            color: #555;
        }

        .upload-box {
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border-radius: 2px;
            height: 127px;
            font-size: 11px;
            color: black;
            cursor: pointer;
            margin-top: 10px;
            text-align: center;
            background-color: #E1E1E1;
        }

        .upload-box div .fa-lg {
            margin-bottom: 8px;
        }


        .remove-image {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #fff;
            border: none;
            color: red;
            font-size: 20px;
            cursor: pointer;
            display: none;
            width: 2rem;
        }

        .image-box:hover .remove-image {
            display: block;
        }
    </style>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{ route('admin.author.update', $author->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="form-group col-md-6 ">
                                                <label class="required_label">{{__('Name')}}</label>
                                                <input type="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $author->name) }}"
                                                    name="name" placeholder="{{__('John Doe')}}">
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="required_label">{{__('Role')}}</label>
                                                <input type="text" class="form-control @error('role') is-invalid @enderror" value="{{ old('role', $author->role) }}"
                                                    name="role" placeholder="{{__('Author, Editor, etc.')}}" >
                                                @error('role')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="required_label">{{__('Creativity')}}</label>
                                                <input type="text" class="form-control @error('creativity') is-invalid @enderror" value="{{ old('creativity', $author->creativity) }}"
                                                name="creativity" placeholder="{{__('1-100')}}" >
                                                    @error('creativity')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="required_label">{{__('Popularity')}}</label>
                                                <input type="text" class="form-control @error('popularity') is-invalid @enderror" value="{{ old('popularity', $author->popularity) }}"
                                                    name="popularity" placeholder="{{__('1-100')}}" >
                                                @error('popularity')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="form-group mb-0">
                                                    <label for="exampleInputFile">{{ __('Social Media') }}</label>
                                                    <table class="table table-bordered table-striped table-hover mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th class="col-3">{{ __('Title') }}</th>
                                                                <th class="col-8">{{ __('Link') }}</th>
                                                                <th class="col-1 text-center">
                                                                    <button type="button" class="btn btn-sm bg-gradient-success btn_add_social_media my-0" id="addRow">
                                                                        <i class="fa fa-plus-circle"></i>
                                                                    </button>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="socialMediaTable">
                                                            @foreach ($author->social_media ?? [] as $index => $media)
                                                                <tr>
                                                                    <td>
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control" name="social_media[{{ $index }}][title]" value="{{ old("social_media.$index.title", $media['title'] ?? '') }}">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control" name="social_media[{{ $index }}][link]" value="{{ old("social_media.$index.link", $media['link'] ?? '') }}">
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <a type="button" class="btn btn-sm bg-gradient-danger btn_remove_social_media my-0">
                                                                            <i class="fa fa-trash-alt"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach

                                                            @if(empty($author->social_media))
                                                                <tr>
                                                                    <td>
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control" name="social_media[0][title]" value="{{ old('social_media.0.title') }}">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control" name="social_media[0][link]" value="{{ old('social_media.0.link') }}">
                                                                        </div>
                                                                    </td>
                                                                    <td></td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label>{{__('Description')}}</label>
                                                <textarea class="form-control summernote @error('description') is-invalid @enderror" name="description" placeholder="{{__('Enter Description')}}">{{ old('description', $author->description) }}</textarea>
                                                @error('description')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            @php
                                                if ($author->image && filter_var($author->image, FILTER_VALIDATE_URL)) {
                                                    $imageName = time() . '-' . Str::random(5) . '.jpg';
                                                    file_put_contents(public_path("uploads/authors/{$imageName}"), file_get_contents($author->image));
                                                    $author->image = $imageName;
                                                }
                                            @endphp
                                            <div class="form-group col-md-6">
                                                <label for="dropifyInput">{{ __('Image') }} <span class="text-info text-xs">{{ __('Recommend size 512 x 512 px') }}</span> </label>
                                                <input type="hidden" name="image_names" class="image_names_hidden">
                                                <input type="file" id="dropifyInput" class="dropify custom-file-input" name="image"
                                                        data-default-file="{{ isset($author) && $author->image && file_exists(public_path('uploads/authors/' . $author->image))
                                                        ? asset('uploads/authors/' . $author->image)
                                                        : $author->image }}" accept="image/png, image/jpeg, image/gif, image/webp">
                                                <div class="progress mt-2" style="height: 10px; display: none;">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">0%</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <a href="javascript:history.back()" class="btn bg-gradient-danger btn-sm mb-0 text-decoration-none">
                                            <i class="fas fa-arrow-left pe-1"></i>
                                            {{__('Back')}}
                                        </a>
                                    </div>
                                    <div class="col text-end">
                                        <button type="submit" class="btn bg-gradient-primary btn-sm submit float-right mb-0">
                                            <i class="fas fa-save pe-1"></i>
                                            {{__('Update')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    @include('backends.author.partial.delete_author_image_modal')
@endsection

@push('js')
    <script>
        $(document).on('click', '.btn_remove_social_media', function () {
            $(this).closest('tr').remove();
        });

        let rowIndex = $('#socialMediaTable tr').length;

        $('#addRow').click(function () {
            const row = `
                <tr>
                    <td>
                        <div class="input-group">
                            <input type="text" class="form-control" name="social_media[${rowIndex}][title]" value="">
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="text" class="form-control" name="social_media[${rowIndex}][link]" value="">
                        </div>
                    </td>
                    <td class="text-center">
                        <a type="button" class="btn btn-sm bg-gradient-danger btn_remove_social_media my-0">
                            <i class="fa fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>`;
            $('#socialMediaTable').append(row);
            rowIndex++;
        });
    </script>
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
                const MAX_WIDTH = 720;

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
            var customerId = "{{ isset($customer) ? $customer->id : null }}";
            var deleteConfirmed = false;

            dropifyInstance.on('dropify.beforeClear', function (event, element) {
                if (!deleteConfirmed) {
                    $('#deleteImageModal').modal('show');
                    return false;
                }
                deleteConfirmed = false;
            });

            $('.btn-confirm-modal').click(function () {
                if (customerId) {
                    $.ajax({
                        url: "{{ route('admin.customer.delete_image') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            customer_id: customerId
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
@endpush
