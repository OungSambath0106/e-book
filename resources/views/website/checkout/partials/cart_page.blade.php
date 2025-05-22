<div class="page active" id="page1">
    <h1 class="page-title">Shopping Cart</h1>

    <div id="cart-items">
        <div class="cart-item">
            <img src="/api/placeholder/80/120" alt="Book Cover" class="book-image">
            <div class="book-details">
                <div class="book-title">ប្រវត្តិ៖ ខែ៣០០០០៖ រាជបុត្រដុំ ៨</div>
                <div class="book-author">By អុក ចាំអីត</div>
                <div class="book-format">Hardback • 382 pages</div>
                <div class="quantity-controls">
                    <button class="qty-btn" onclick="updateQuantity(1, -1)">-</button>
                    <input type="number" class="qty-input" value="1" id="qty1"
                        onchange="updateQuantity(1, 0)">
                    <button class="qty-btn" onclick="updateQuantity(1, 1)">+</button>
                </div>
            </div>
            <div class="price-section">
                <div class="current-price">$6.00</div>
                <div class="original-price">$10.00</div>
                <button class="remove-btn" onclick="removeItem(1)">Remove</button>
            </div>
        </div>
    </div>

    <div class="cart-summary">
        <div class="summary-row">
            <span>Subtotal:</span>
            <span id="subtotal">$22.00</span>
        </div>
        <div class="summary-row">
            <span>Shipping:</span>
            <span>Free</span>
        </div>
        <div class="summary-row">
            <span>Discount:</span>
            <span id="discount">$1.76</span>
        </div>
        <div class="summary-row total">
            <span>Total:</span>
            <span id="total">$23.76</span>
        </div>
    </div>

    <div class="btn-group">
        <button class="btn btn-secondary" onclick="goHome()">Continue Shopping</button>
        <button class="btn btn-primary" onclick="nextStep()">Proceed to Checkout</button>
    </div>
</div>