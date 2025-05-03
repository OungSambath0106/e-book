<div class="col-md-12 px-0 pt-2">
    <div class="card p-2  mb-0" id="card-validation-room"
        style="box-shadow: none !important; border: 1px solid #E1E1E1">
        <div class="image-grid">
            <div class="upload-box custom-file m-0" id="upload-box" style="cursor: pointer; text-align: center;">
                <div class="mt-3"><i class="fa-solid fa-plus fa-lg" style="color:#666666;font-size: 7rem !important;"></i></div>
                <div>{{ __('Drop files or click to upload') }}</div>
                <input type="hidden" name="image_names" class="image_names_hidden" value="">
                <input type="file" class="custom-file-input" name="gallery[]" id="fileUpload"
                    accept="image/png, image/jpeg, image/gif, image/webp" style="display: none;" multiple>
            </div>
        </div>
        <div id="galleryError" class="invalid-feedback error d-none mt-2" role="alert">
            <strong>{{ __('Please upload at least one image.') }}</strong>
        </div>
    </div>
</div>
