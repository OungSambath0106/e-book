<!-- Modal HTML - Note: unique ID per product -->
<div class="modal fade" id="imageGalleryModal-{{ $item->product->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div id="galleryCarousel-{{ $item->product->id }}" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">

                        @foreach ($allImages as $index => $image)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <img src="{{ file_exists(public_path('uploads/products/' . $image)) ? asset('uploads/products/' . $image) : asset('uploads/default.png') }}"
                                    class="d-block w-100" style="object-fit: contain; max-height: 500px;"
                                    alt="Product Image">
                            </div>
                        @endforeach

                    </div>
                    <a class="carousel-control-prev" href="#galleryCarousel-{{ $item->product->id }}" role="button"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#galleryCarousel-{{ $item->product->id }}" role="button"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
