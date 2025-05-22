<div class="page" id="page3">
    <h1 class="page-title">Payment Information</h1>

    <div class="security-info">
        <span>🔒</span>
        <span>Your payment information is encrypted and secure</span>
    </div>

    <div class="payment-methods">
        <div class="payment-method selected" onclick="selectPayment('card')">
            <div class="payment-icon">💳</div>
            <div>Credit/Debit Card</div>
        </div>
        <div class="payment-method" onclick="selectPayment('paypal')">
            <div class="payment-icon">🅿️</div>
            <div>PayPal</div>
        </div>
        <div class="payment-method" onclick="selectPayment('apple')">
            <div class="payment-icon">🍎</div>
            <div>Apple Pay</div>
        </div>
        <div class="payment-method" onclick="selectPayment('google')">
            <div class="payment-icon">🟡</div>
            <div>Google Pay</div>
        </div>
    </div>

    <form id="payment-form">
        <div class="form-group">
            <label class="form-label">Card Number *</label>
            <input type="text" class="form-input" placeholder="1234 5678 9012 3456" maxlength="19" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Expiry Date *</label>
                <input type="text" class="form-input" placeholder="MM/YY" maxlength="5" required>
            </div>
            <div class="form-group">
                <label class="form-label">CVV *</label>
                <input type="text" class="form-input" placeholder="123" maxlength="4" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Cardholder Name *</label>
            <input type="text" class="form-input" placeholder="John Doe" required>
        </div>
    </form>

    <div class="cart-summary">
        <h3 style="margin-bottom: 1rem;">Order Summary</h3>
        <div class="summary-row">
            <span>Subtotal:</span>
            <span>$22.00</span>
        </div>
        <div class="summary-row">
            <span>Shipping:</span>
            <span>Free</span>
        </div>
        <div class="summary-row">
            <span>Discount:</span>
            <span>$1.76</span>
        </div>
        <div class="summary-row total">
            <span>Total:</span>
            <span>$23.76</span>
        </div>
    </div>

    <div class="btn-group">
        <button class="btn btn-secondary" onclick="previousStep()">Back to Address</button>
        <button class="btn btn-primary" onclick="nextStep()">Complete Order</button>
    </div>
</div>