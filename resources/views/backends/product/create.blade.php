@extends('backends.layouts.admin')
@section('page_title', __('Add New Product'))
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
                    <form method="POST" action="{{ route('admin.product.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="name" class="required_label">{{ __('Name') }}</label>
                                                <input type="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                                    name="name" placeholder="{{ __('Enter Name') }}" value="">
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="description" class="required_label">{{ __('Description') }}</label>
                                                <textarea type="text" id="description" class="form-control @error('description') is-invalid @enderror"
                                                    name="description" placeholder="{{ __('Enter Description') }}" value=""></textarea>
                                                @error('description')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group d-flex col-md-12 mb-0">
                                                <div class="form-group col-md-2">
                                                    <label class="switch" for="new-arrival">
                                                        {{ __('New Arrival') }}
                                                        <input type="checkbox" class="status" id="new-arrival" value="0" name="new-arrival">
                                                        <div class="slider mt-2">
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
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label class="required_lable switch" for="recommended">
                                                        {{ __('Recommended') }}
                                                        <input type="checkbox" class="status" id="recommended" value="0" name="recommended">
                                                        <div class="slider mt-2">
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
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label class="required_lable switch" for="popular">
                                                        {{ __('Most Popular') }}
                                                        <input type="checkbox" class="status" id="popular" value="0" name="popular">
                                                        <div class="slider mt-2">
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
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6 ">
                                                <label class="required_label" for="brand">{{ __('Brand') }}</label>
                                                <select name="brand_id" id="brand"
                                                    class="form-control select2 @error('brand_id') is-invalid @enderror">
                                                    <option value="">{{ __('Select Brand') }}</option>
                                                    @foreach ($brands as $item)
                                                        <option value="{{ $item -> id }}">{{ $item -> name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('brand')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>

                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="required_label" for="rating">{{ __('Star Rating') }}</label>
                                                <select name="rating" id="rating" class="form-control select2 @error('rating') is-invalid @enderror">
                                                    <option value="">{{ __('Select Rating') }}</option>
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <option value="{{ $i }}">{{ $i }} @if($i < 2){{ __('Star') }}@else{{ __('Stars') }}@endif</option>
                                                    @endfor
                                                </select>
                                                @error('rating')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="form-group mb-0">
                                                    <label for="exampleInputFile">{{ __('Product Info') }}</label>
                                                    <table class="table table-bordered table-striped table-hover rowfy mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th class="col-4">{{ __('Size') }}</th>
                                                                <th class="col-4">{{ __('Price') }}</th>
                                                                <th class="col-4">{{ __('Quantity') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <input type="text" class="form-control" min="0" oninput="validatePriceInput(this)" onkeydown="preventMinus(event)"
                                                                        name="products_info[product_size][]">
                                                                </td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" style="border-top-right-radius: 0; border-bottom-right-radius: 0;">$</span>
                                                                        </div>
                                                                        <input type="text" class="form-control" min="0" oninput="validatePriceInput(this)" onkeydown="preventMinus(event)"
                                                                            name="products_info[product_price][]">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <input type="number" class="form-control" min="0" oninput="validatePriceInput(this)" onkeydown="preventMinus(event)"
                                                                        name="products_info[product_qty][]">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleInputFile" class="required_label">{{ __('Image') }} <span class="text-info text-xs"> {{ __('Recommended upload a maximum of 5 images.') }} </span> </label>
                                                    @include('backends.product.partial.product_galleries')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-end pt-2">
                                        <button type="submit" class="btn bg-gradient-primary btn-sm submit float-right mb-0">
                                            <i class="fa fa-save pe-1"></i>
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
        class ImageUploader {
            constructor(maxWidthOrHeight, csrfToken, uploadUrl) {
                this.maxWidthOrHeight = maxWidthOrHeight;
                this.csrfToken = csrfToken;
                this.uploadUrl = uploadUrl;
                this.isUploading = false;
            }

            async handleFileUpload(inputElement) {
                if (this.isUploading) return;

                this.isUploading = true;
                const fileInput = $(inputElement);
                const imageNamesHidden = fileInput.closest('.form-group').find('.image_names_hidden');
                const container = fileInput.closest('.form-group').find('.preview');

                const files = Array.from(fileInput[0].files);
                if (files.length === 0) return;

                const formData = new FormData();
                formData.append('_token', this.csrfToken);

                let uploadedFileNames = imageNamesHidden.val() ? imageNamesHidden.val().split(' ') : [];

                try {
                    const compressedFiles = await Promise.all(files.map((file) => {
                        const progressBar = this.createProgressBar(container);
                        return this.compressAndConvertToWebP(file, progressBar);
                    }));

                    compressedFiles.forEach(({ file, progressBar }) => {
                        formData.append('images[]', file);
                        progressBar.setProgress(100);
                    });

                    this.uploadImages(formData, uploadedFileNames, container, imageNamesHidden);
                } catch (error) {
                    toastr.error("Image processing failed");
                    console.error("Processing error:", error);
                } finally {
                    this.isUploading = false;
                }
            }

            async compressAndConvertToWebP(file, progressBar) {
                progressBar.setProgress(10);

                try {
                    const compressedFile = await this.compressImage(file);
                    progressBar.setProgress(60);

                    const webpFile = await this.convertToWebP(compressedFile);
                    progressBar.setProgress(90);
                    return { file: webpFile, progressBar };
                } catch (error) {
                    progressBar.setError();
                    throw error;
                }
            }

            async compressImage(file) {
                return new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.onload = async (event) => {
                        try {
                            const img = new Image();
                            img.src = event.target.result;
                            img.onload = () => {
                                const { width, height } = this.getScaledDimensions(img);
                                const canvas = document.createElement('canvas');
                                const ctx = canvas.getContext('2d');
                                canvas.width = width;
                                canvas.height = height;
                                ctx.drawImage(img, 0, 0, width, height);

                                canvas.toBlob((blob) => {
                                    if (blob) {
                                        resolve(new File([blob], file.name, { type: file.type }));
                                    } else {
                                        reject(new Error('Compression failed'));
                                    }
                                }, file.type, 0.8);
                            };
                            img.onerror = reject;
                        } catch (error) {
                            reject(error);
                        }
                    };
                    reader.readAsDataURL(file);
                });
            }

            async convertToWebP(file) {
                return new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        const img = new Image();
                        img.onload = () => {
                            const canvas = document.createElement('canvas');
                            const ctx = canvas.getContext('2d');
                            canvas.width = img.width;
                            canvas.height = img.height;
                            ctx.drawImage(img, 0, 0, img.width, img.height);

                            canvas.toBlob((blob) => {
                                if (blob) {
                                    resolve(new File([blob], file.name.replace(/\.(jpg|jpeg|png)$/i, '.webp'), { type: 'image/webp' }));
                                } else {
                                    reject(new Error('WebP conversion failed'));
                                }
                            }, 'image/webp', 0.8);
                        };
                        img.onerror = reject;
                        img.src = event.target.result;
                    };
                    reader.onerror = reject;
                    reader.readAsDataURL(file);
                });
            }

            createProgressBar(container) {
                const imageBox = $('<div class="image-box"></div>');
                const progressContainer = $('<div class="progress"></div>');
                const progressBar = $('<div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>');

                progressContainer.append(progressBar);
                imageBox.append(progressContainer);
                container.append(imageBox);

                return {
                    setProgress: function (percentage) {
                        progressBar.css('width', percentage + '%').text(percentage + '%').attr('aria-valuenow', percentage);
                        if (percentage === 100) {
                            progressContainer.fadeOut();
                        }
                    },
                    setError: function () {
                        progressBar.addClass('bg-danger').text('Failed');
                    }
                };
            }

            getScaledDimensions(img) {
                let width = img.width;
                let height = img.height;

                if (width > this.maxWidthOrHeight || height > this.maxWidthOrHeight) {
                    if (width > height) {
                        height *= this.maxWidthOrHeight / width;
                        width = this.maxWidthOrHeight;
                    } else {
                        width *= this.maxWidthOrHeight / height;
                        height = this.maxWidthOrHeight;
                    }
                }
                return { width, height };
            }

            uploadImages(formData, uploadedFileNames, container, imageNamesHidden) {
                $.ajax({
                    url: this.uploadUrl,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: (response) => {
                        if (response.status === 1) {
                            const tempFiles = response.temp_files;

                            if (tempFiles.length > 0) {
                                tempFiles.forEach((tempFile) => {
                                    uploadedFileNames.push(tempFile);

                                    const imgContainer = $('<div></div>').addClass('img_container');
                                    const img = $('<img>').attr('src', "{{ asset('uploads/temp') }}/" + tempFile);
                                    imgContainer.append(img);
                                    container.append(imgContainer);
                                });

                                imageNamesHidden.val(uploadedFileNames.join(' '));
                            }
                        } else {
                            toastr.error(response.msg);
                        }
                    },
                    error: (jqXHR, textStatus, errorThrown) => {
                        toastr.error(`Upload failed: ${jqXHR.status} ${errorThrown}`);
                        console.log(jqXHR.responseText);
                    }
                });
            }
        }

        $(document).ready(function () {
            const uploader = new ImageUploader(1200, '{{ csrf_token() }}', "{{ route('save_temp_file') }}");

            $('.custom-file-input').change(function () {
                uploader.handleFileUpload(this);
            });
        });
    </script>
    <script>
        document.querySelector('.upload-box').addEventListener('click', function() {
            document.getElementById('fileUpload').click();
        });

        $(document).ready(function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            $('#fileUpload').on('change', function(event) {
                const files = event.target.files;
                const uploadBox = $('#upload-box');

                $.each(files, function(index, file) {
                    if (!file.type.startsWith('image/')) {
                        Toast.fire({
                            icon: 'error',
                            title: 'Please upload a valid image file.'
                        });
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imageBox = $(`
                            <div class="image-box">
                                <img src="${e.target.result}" alt="Uploaded Image">
                                <button type="button" class="remove-image">&times;</button>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0"
                                        aria-valuemin="0" aria-valuemax="100">0%</div>
                                </div>
                            </div>
                        `);
                        uploadBox.before(imageBox);
                        simulateProgress(imageBox.find('.progress-bar'));

                        imageBox.find('.close-btn').on('click', function() {
                            imageBox.remove();
                        });
                    };
                    reader.readAsDataURL(file);
                });
            });

            function simulateProgress(progressBar) {
                let progress = 0;
                progressBar.closest('.progress').show();

                const interval = setInterval(function() {
                    progress += 10;
                    progressBar.css('width', progress + '%');
                    progressBar.text(progress + '%');
                    progressBar.attr('aria-valuenow', progress);

                    if (progress >= 100) {
                        clearInterval(interval);
                        progressBar.closest('.progress').hide();
                    }
                }, 300);
            }

            $('form').on('submit', function(event) {
                const imageDetails = [];
                const imageNames = $('.image_names_hidden').val().trim();

                if (imageNames) {
                    const imageArray = imageNames.split(' ');
                    imageArray.forEach((imgName) => {
                        if (imgName) imageDetails.push(imgName);
                    });
                }

                $('.image_names_hidden').val(imageDetails.length > 0 ? JSON.stringify(imageDetails) : '');

                $('#galleryError').removeClass('d-block').addClass('d-none');
                $("#card-validation-room").removeClass('is-invalid-card');
            });
        });
    </script>
    <script>
        // Function to prevent negative values
        function validatePriceInput(input) {
            if (input.value < 0) {
                input.value = '';
            }
        }

        // Function to prevent typing the minus (-) key
        function preventMinus(event) {
            if (event.key === '-' || event.key === '+') {
                event.preventDefault();
            }
        }
    </script>
@endpush
