@forelse ($new_arrivals as $product)
    <div class="book-card">
        <div class="book-card-img">
            <img src="{{ $product->image && file_exists(public_path('uploads/products/' . $product->image))
                    ? asset('uploads/products/' . $product->image)
                    : asset('uploads/default1.png') }}"
                alt="{{ @$product->name }}">
        </div>
        <div class="book-card-content">
            <a href="{{ route('book.detail', $product->id) }}"><h3>{{ @$product->name }}</h3></a>
            <p class="book-author">By {{ @$product->author->name }}</p>
            <div class="star-rating">
                @for ($i = 0; $i < 5; $i++)
                    <i class="{{ $i < @$product->rating ? 'fas' : 'far' }} fa-star"></i>
                @endfor
            </div>
            <p class="book-price">$ {{ @$product->price }}</p>
        </div>
    </div>
@empty
    <div class="no-results">
        <p>New arrival books are not available.</p>
    </div>
@endforelse