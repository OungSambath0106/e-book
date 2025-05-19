<div class="book-card fade-in">
    <div class="book-card-img">
        <img src="
            @if ($book->image && file_exists(public_path('uploads/products/' . $book->image)))
                {{ asset('uploads/products/'. $book->image) }}
            @else
                {{ asset('uploads/default1.png') }}
            @endif
            " alt="{{ $book->name }}">
    </div>
    <div class="book-card-content">
        <h3>{{ $book->name }}</h3>
        <p class="book-author">by {{ $book->author->name }}</p>
        <div class="star-rating">
            @for ($i = 0; $i < 5; $i++)
                @if ($i < $book->rating)
                    <i class="fas fa-star star"></i>
                @else
                    <i class="far fa-star star"></i>
                @endif
            @endfor
        </div>
        <p class="book-price"> $ {{ $book->price }} </p>
    </div>
</div>
