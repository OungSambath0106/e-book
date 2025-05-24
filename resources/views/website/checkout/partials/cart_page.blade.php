<div class="page cart-page active" id="page1">
    <h1 class="page-title">Shopping Cart</h1>

    <div id="cart-items">
        @foreach ($cartItems as $cartItem)
            @php
                $current_price = $cartItem->product->price;
                if ($cartItem->product->promotions->count() > 0) {
                    foreach ($cartItem->product->promotions as $promotion) {
                        if ($promotion->discount_type == 'percent') {
                            $current_price = $cartItem->product->price * (1 - $promotion->percent / 100);
                        } else {
                            $current_price = $cartItem->product->price - $promotion->amount;
                        }
                    }
                }
            @endphp

            <div class="cart-item position-relative" data-id="{{ $cartItem->id }}">
                <img src="{{ asset('uploads/products/' . $cartItem->product->image) }}" alt="{{ $cartItem->product->name }}" class="book-image">
                <div class="book-details">
                    <div class="book-title">{{ $cartItem->product->name }}</div>
                    <div class="book-author">By {{ $cartItem->product->author->name }}</div>
                    <div class="book-format text-capitalize">{{ $cartItem->product->format }} • {{ $cartItem->product->pages }} pages</div>
                    <div class="quantity-controls">
                        <button class="qty-btn" onclick="updateQuantity({{ $cartItem->product_id }}, -1)">-</button>
                        <input type="number" class="qty-input" value="{{ $cartItem->quantity }}" id="qty{{ $cartItem->product_id }}"
                            onchange="updateQuantity({{ $cartItem->product_id }}, 0)">
                        <button class="qty-btn" onclick="updateQuantity({{ $cartItem->product_id }}, 1)">+</button>
                    </div>
                </div>
                <div class="price-section">
                    <button class="remove-btn" onclick="removeItem({{ $cartItem->id }})">
                        <i class="fas fa-trash"></i>
                    </button>
                    <div class="current-price">${{ number_format($current_price, 2) }}</div>
                    @if ($cartItem->product->promotions->count() > 0)
                        <div class="original-price">${{ number_format($cartItem->product->price, 2) }}</div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    @if ($cartItems->count() > 0)
        <div class="cart-summary">
            <div class="summary-row">
                <span>Subtotal:</span>
                <span id="subtotal">$0.00</span>
            </div>
            <div class="summary-row">
                <span>Discount:</span>
                <span id="discount">- $0.00</span>
            </div>
            <div class="summary-row total">
                <span>Total:</span>
                <span id="total">$ 0.00</span>
            </div>
        </div>
    @else
        <div class="cart-summary">
            <div class="summary-row m-0 justify-content-center">
                <span>No items in cart.</span>
            </div>
        </div>
    @endif

    <div class="btn-group">
        <button class="btn btn-secondary" onclick="goHome()">Continue Shopping</button>
        <button class="btn btn-primary" @if ($cartItems->count() == 0) disabled @endif onclick="nextStep()">Proceed to Checkout</button>
    </div>
</div>
