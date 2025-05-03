@extends('backends.layouts.admin')
@section('page_title', __('Add New Customer'))
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
        .close-btn {
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
        .image-box:hover .close-btn {
            display: block;
        }
    </style>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{ route('admin.customer.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="form-group col-md-6 ">
                                                <label class="required_label">{{__('Name')}}</label>
                                                <input type="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                                    name="name" placeholder="{{__('John')}}">
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>{{__('Gender')}}</label>
                                                <select class="form-control select2" name="gender" >
                                                    <option value="male">{{__('Male')}}</option>
                                                    <option value="female">{{__('Female')}}</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="required_label">{{__('Phone Number')}}</label>
                                                <input type="text" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}"
                                                    name="phone" placeholder="{{__('+855 12 345 678')}}" >
                                                @error('phone')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="required_label">{{__('Email')}}</label>
                                                <input type="text" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                                name="email" placeholder="{{__('john.doe@example.com')}}" >
                                                    @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="required_label">{{__('Password')}}</label>
                                                <input type="password" class="form-control @error('password') is-invalid @enderror" value=""
                                                    name="password" placeholder="{{__('Must have at least 8 characters')}}" >
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            {{-- <div class="form-group col-md-6">
                                                <label>{{__('Address')}}</label>
                                                <input type="text" class="form-control" value="{{ old('address') }}"
                                                    name="address" placeholder="{{__('Enter Address')}}" >
                                            </div> --}}
                                            <div class="form-group col-md-6">
                                                <div class="form-group">
                                                    <label for="dropifyInput">{{__('Image')}} <span class="text-info text-xs"> {{ __('Recommend size 512 x 512 px') }} </span> </label>
                                                    <input type="hidden" name="image_names" class="image_names_hidden">
                                                    <input type="file" id="dropifyInput" class="dropify custom-file-input" name="image" accept="image/png, image/jpeg, image/gif, image/webp">
                                                    <div class="progress mt-2" style="height: 10px; display: none;">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">0%</div>
                                                    </div>
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
                                            {{__('Save')}}
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
@endsection

@push('js')
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
@endpush
