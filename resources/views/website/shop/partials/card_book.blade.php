<div class="book-card">
    @php $promotion = $book->latestPromotion(); @endphp
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
        <img src="{{ $book->image && file_exists(public_path('uploads/products/' . $book->image))
                ? asset('uploads/products/' . $book->image)
                : asset('uploads/default1.png') }}"
            alt="{{ @$book->name }}">
    </div>
    @php
        $current_price = $book->price;
        if ($promotion) {
            $current_price = $book->price;
            if ($promotion->discount_type == 'percent') {
                $current_price = $book->price * (1 - $promotion->percent / 100);
            } else {
                $current_price = $book->price - $promotion->amount;
            }
        }
    @endphp
    <div class="book-card-content">
        <a href="{{ route('book.detail', $book->id) }}"><h3>{{ @$book->name }}</h3></a>
        <p class="book-author">By {{ @$book->author->name }}</p>
        <div class="star-rating">
            @for ($i = 0; $i < 5; $i++)
                <i class="{{ $i < @$book->rating ? 'fas' : 'far' }} fa-star"></i>
            @endfor
        </div>
        <div class="price-container d-inline-flex align-items-center pt-1" style="gap: 7px;">
            <p class="book-price current-price">$ {{ number_format($current_price, 2) }}</p>
            @if ($promotion)
                <p class="original-price">$ {{ number_format($book->price, 2) }}</p>
            @endif
        </div>
    </div>
</div>