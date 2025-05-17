@extends('backends.layouts.admin')
@section('page_title', __('Edit Product'))
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

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            padding-bottom: 3px ! important;
        }
    </style>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{ route('admin.product.update', $product->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="name">{{ __('Name') }}</label>
                                                <input type="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                                    name="name" placeholder="{{ __('Enter Name') }}" value="{{ $product['name'] }}">
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            {{-- <div class="form-group col-md-12">
                                                <label
                                                    for="description">{{ __('Description') }}</label>
                                                <textarea type="text" id="description" class="form-control @error('description') is-invalid @enderror" name="description"
                                                    placeholder="{{ __('Enter Description') }}" value="">{{ $product['description'] }}</textarea>
                                                @error('description')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div> --}}
                                            <div class="form-group row col-md-12 mb-0">
                                                <div class="form-group col-md-2">
                                                    <label class="switch" for="new-arrival">
                                                        {{ __('New Arrival') }}
                                                        <input type="checkbox" class="status" id="new-arrival" name="new-arrival" {{ $product->new_arrival ? 'checked' : '' }}>
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
                                                    <label class="switch" for="recommended">
                                                        {{ __('Recommended') }}
                                                        <input type="checkbox" class="status" id="recommended" name="recommended" {{ $product->recommended ? 'checked' : '' }}>
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
                                                    <label class="switch" for="popular">
                                                        {{ __('Most Popular') }}
                                                        <input type="checkbox" class="status" id="popular" name="popular" {{ $product->popular ? 'checked' : '' }}>
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
                                                    <label class="switch" for="bestseller">
                                                        {{ __('Bestseller') }}
                                                        <input type="checkbox" class="status" id="bestseller" name="bestseller" {{ $product->bestseller ? 'checked' : '' }}>
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
                                                <label class="required_label" for="categories">{{ __('Categories') }}</label>
                                                <select name="categories[]" id="categories" multiple
                                                    class="form-control select2 @error('categories') is-invalid @enderror">
                                                    <option value="">{{ __('Select Category') }}</option>
                                                    @foreach ($categories as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ in_array($item->id, old('categories', $category_productId)) ? 'selected' : '' }}>
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('categories')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6 ">
                                                <label class="required_label" for="author">{{ __('Author') }}</label>
                                                <select name="author_id" id="author"
                                                    class="form-control select2 @error('author_id') is-invalid @enderror">
                                                    <option value="">{{ __('Select Author') }}</option>
                                                    @foreach ($authors as $item)
                                                        <option value="{{ $item -> id }}" {{ old('author_id', $product->author_id) == $item->id ? 'selected' : '' }}>
                                                            {{ $item -> name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('author_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="required_label" for="price">{{ __('Price') }}</label>
                                                <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" placeholder="{{ __('Enter Price') }}" value="{{ old('price', $product->price) }}" step="0.1">
                                                @error('price')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="required_label" for="qty">{{ __('Quantity') }}</label>
                                                <input type="number" name="qty" id="qty" class="form-control @error('qty') is-invalid @enderror" placeholder="{{ __('Enter Quantity') }}" value="{{ old('qty', $product->qty) }}">
                                                @error('qty')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="publish">{{ __('Published Date') }}</label>
                                                <input type="date" name="publish" id="publish" class="form-control flatpickr @error('publish') is-invalid @enderror" placeholder="{{ __('Enter Published Date') }}" value="{{ old('publish', $product->publish) }}">
                                                @error('publish')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="required_label" for="pages">{{ __('Pages') }}</label>
                                                <input type="number" name="pages" id="pages" class="form-control @error('pages') is-invalid @enderror" placeholder="{{ __('Enter Pages') }}" value="{{ old('pages', $product->pages) }}">
                                                @error('pages')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="required_label" for="reviews">{{ __('Reviews') }}</label>
                                                <input type="number" name="reviews" id="reviews" class="form-control @error('reviews') is-invalid @enderror" placeholder="{{ __('Enter Reviews') }}" value="{{ old('reviews', $product->reviews) }}">
                                                @error('reviews')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="required_label" for="barcode">
                                                    {{ __('Barcode') }}
                                                    <a class="text-info text-xs cursor-pointer" onclick="document.getElementById('barcode').value = getRndInteger()"> {{ __('Generate Code') }} </a>
                                                </label>
                                                <input type="text" name="barcode" id="barcode" class="form-control @error('barcode') is-invalid @enderror" placeholder="{{ __('Enter Barcode') }}" value="{{ old('barcode', $product->barcode) }}">
                                                @error('barcode')
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
                                                        <option value="{{ $i }}" {{ old('rating', $product->rating) == $i ? 'selected' : '' }}>
                                                            {{ $i }} @if($i < 2){{ __('Star') }}@else{{ __('Stars') }}@endif
                                                        </option>
                                                    @endfor
                                                </select>
                                                @error('rating')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="required_label" for="format">{{ __('Format') }}</label>
                                                <select name="format" id="format" class="form-control select2 @error('format') is-invalid @enderror">
                                                    <option value="">{{ __('Select Format') }}</option>
                                                    <option value="paperback" {{ old('format', $product->format) == 'paperback' ? 'selected' : '' }}>{{ __('Paperback') }}</option>
                                                    <option value="hardback" {{ old('format', $product->format) == 'hardback' ? 'selected' : '' }}>{{ __('Hardback') }}</option>
                                                    <option value="e-book" {{ old('format', $product->format) == 'e-book' ? 'selected' : '' }}>{{ __('E-Book') }}</option>
                                                </select>
                                                @error('format')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-12 px-0">
                                                <label for="dropifyInput">{{ __('Thumbnail') }} <span class="text-info text-xs"> {{ __('Recommend size 1200 px') }} </span> </label>
                                                <input type="hidden" name="image_names" class="image_names_hidden">
                                                <input type="file" id="dropifyInput" class="dropify custom-file-input" name="image"
                                                    data-default-file="{{ isset($product) && $product->image && file_exists(public_path('uploads/products/' . $product->image))
                                                    ? asset('uploads/products/' . $product->image)
                                                    : '' }}" accept="image/png, image/jpeg, image/jpg, image/gif, image/webp">
                                                <div class="progress mt-2" style="height: 10px; display: none;">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">0%</div>
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
        function getRndInteger() {
            return Math.floor(Math.random() * 90000) + 100000;
        }
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
            var productId = "{{ isset($product) ? $product->id : null }}";
            var deleteConfirmed = false;

            dropifyInstance.on('dropify.beforeClear', function (event, element) {
                if (!deleteConfirmed) {
                    $('#deleteImageModal').modal('show');
                    return false;
                }
                deleteConfirmed = false;
            });

            $('.btn-confirm-modal').click(function () {
                if (productId) {
                    $.ajax({
                        url: "{{ route('admin.product.delete_image') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            product_id: productId
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
