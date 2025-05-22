@forelse ($recommended as $product)
    <div class="book-card">
        @php $promotion = $product->latestPromotion(); @endphp
        @if ($promotion)
            <div class="badges-tag">
                <p>
                    @if ($promotion->discount_type == 'percent')
                        <span class="firstLine">{{ $promotion->percent }}%</span>
                    @else
                        <span class="firstLine">${{ $promotion->amount }}</span>
                    @endif
                    <span class="secondLine">OFF</span>
                </p>
            </div>
        @endif
        <div class="book-card-img">
            <img src="{{ $product->image && file_exists(public_path('uploads/products/' . $product->image))
                    ? asset('uploads/products/' . $product->image)
                    : asset('uploads/default1.png') }}"
                alt="{{ @$product->name }}">
        </div>
        @php
            $current_price = $product->price;
            if ($promotion) {
                $current_price = $product->price;
                if ($promotion->discount_type == 'percent') {
                    $current_price = $product->price * (1 - $promotion->percent / 100);
                } else {
                    $current_price = $product->price - $promotion->amount;
                }
            }
        @endphp
        <div class="book-card-content">
            <a href="{{ route('book.detail', $product->id) }}"><h3>{{ @$product->name }}</h3></a>
            <p class="book-author">By {{ @$product->author->name }}</p>
            <div class="star-rating">
                @for ($i = 0; $i < 5; $i++)
                    <i class="{{ $i < @$product->rating ? 'fas' : 'far' }} fa-star"></i>
                @endfor
            </div>
            <div class="price-container d-inline-flex align-items-center pt-1" style="gap: 7px;">
                <p class="book-price current-price">$ {{ number_format($current_price, 2) }}</p>
                @if ($promotion)
                    <p class="original-price">$ {{ number_format($product->price, 2) }}</p>
                @endif
            </div>
        </div>
    </div>
@empty
    <div class="no-results">
        <p>Recommended books are not available.</p>
    </div>
@endforelse