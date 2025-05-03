@extends('backends.layouts.admin')
@section('page_title', __('Add New Promotion'))
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
                    <form method="POST" action="{{ route('admin.promotion.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="title" class="required_label">{{ __('Name') }}</label>
                                                <input type="title" id="title" class="form-control @error('title') is-invalid @enderror"
                                                    name="title" placeholder="{{ __('Enter Name') }}" value="">
                                                @error('title')
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
                                            <div class="form-group col-md-6">
                                                <label class="required_label" for="promotion_type">{{ __('Promotion Type') }}</label>
                                                <select name="promotion_type" id="promotion_type" class="form-control select2 @error('Promotion_type') is-invalid @enderror" onchange="togglePromotionFields()">
                                                    <option value="brand" selected>{{ __('By Brand') }}</option>
                                                    <option value="product">{{ __('By Product') }}</option>
                                                </select>
                                                @error('promotion_type')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6" id="product_field">
                                                <label class="required_label" for="product">{{ __('Promotion by Product') }}</label>
                                                <select name="products[]" id="product" multiple class="form-control select2 @error('product') is-invalid @enderror">
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('product')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6" id="brand_field" style="display: none;">
                                                <label class="required_label" for="brand">{{ __('Promotion by Brand') }}</label>
                                                <select name="brands[]" id="brand" multiple class="form-control select2 @error('brand') is-invalid @enderror">
                                                    @foreach ($brands as $brand)
                                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('brand')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="required_label" for="discount_type">{{ __('Discount Type') }}</label>
                                                <select name="discount_type" id="discount_type" class="form-control select2 @error('discount_type') is-invalid @enderror" onchange="toggleDiscountFields()">
                                                    <option value="percent" selected>{{ __('Percent') }}</option>
                                                    <option value="amount">{{ __('Amount') }}</option>
                                                </select>
                                                @error('discount_type')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6" id="percent_field">
                                                <label class="required_label" for="percent_input">{{ __('Discount Percent') }}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" style="border-top-right-radius: 0; border-bottom-right-radius: 0;">%</span>
                                                    </div>
                                                    <input type="text" name="percent" id="percent_input" min="0" oninput="validateDiscountInput(this)" onkeydown="preventMinus(event)"
                                                        class="form-control @error('percent') is-invalid @enderror" step="any"
                                                        value="{{ old('percent') }}">
                                                </div>

                                                @error('percent')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6" id="amount_field" style="display: none;">
                                                <label class="required_label" for="amount_input">{{ __('Discount Amount') }}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" style="border-top-right-radius: 0; border-bottom-right-radius: 0;">$</span>
                                                    </div>
                                                    <input type="text" name="amount" id="amount_input" min="0" oninput="validateDiscountInput(this)" onkeydown="preventMinus(event)"
                                                        class="form-control @error('amount') is-invalid @enderror" step="any"
                                                        value="{{ old('amount') }}">
                                                </div>

                                                @error('amount')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label class="required_label">{{__('Start Date')}}</label>
                                                <div class="input-group input-group-alternative">
                                                    <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                                    <input type="date" class="form-control flatpickr @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}"
                                                        name="start_date" placeholder="Select Start Date" >
                                                </div>
                                                @error('start_date')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="required_label">{{__('End Date')}}</label>
                                                <div class="input-group input-group-alternative">
                                                    <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                                    <input type="date" class="form-control flatpickr @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}"
                                                        name="end_date" placeholder="Select End Date" >
                                                </div>
                                                @error('end_date')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleInputFile">{{ __('Banner') }} <span class="text-info text-xs"> {{ __('Recommended upload a maximum of 5 images.') }} </span> </label>
                                                    @include('backends.promotion.partial.promotion_galleries')
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
                                <button type="button" class="remove-image close-btn">&times;</button>
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
        function validateDiscountInput(input) {
            if (input.value < 0) {
                input.value = '';
            }
        }

        function preventMinus(event) {
            if (event.key === '-' || event.key === '+') {
                event.preventDefault();
            }
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.brand-checkbox').forEach(function (brandCheckbox) {
                brandCheckbox.addEventListener('change', function () {
                    const brandId = this.getAttribute('data-brand');
                    const checked = this.checked;

                    document.querySelectorAll(`.product-checkbox.brand-${brandId}`).forEach(function (productCheckbox) {
                        productCheckbox.checked = checked;
                    });
                });
            });
        });
    </script>
    <script>
        function toggleDiscountFields() {
            var discountType = document.getElementById('discount_type').value;
            var amountField = document.getElementById('amount_field');
            var percentField = document.getElementById('percent_field');

            if (discountType === 'percent') {
                percentField.style.display = 'block';
                amountField.style.display = 'none';
            } else {
                percentField.style.display = 'none';
                amountField.style.display = 'block';
            }
        }
        window.onload = toggleDiscountFields;
    </script>
    <script>
        function togglePromotionFields() {
            var promotionType = document.getElementById('promotion_type').value;
            var brandField = document.getElementById('brand_field');
            var productField = document.getElementById('product_field');

            if (promotionType === 'brand') {
                brandField.style.display = 'block';
                productField.style.display = 'none';
            } else {
                brandField.style.display = 'none';
                productField.style.display = 'block';
            }
        }
        window.onload = togglePromotionFields;
    </script>
@endpush
