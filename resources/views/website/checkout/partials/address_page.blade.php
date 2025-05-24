<div class="page address-page" id="page2">
    <h1 class="page-title">Shipping Address</h1>

    <!-- Address Selection Tabs -->
    <div class="address-tabs">
        <button class="address-tab active" onclick="switchAddressTab('pickup')" id="pickup-address-tab">
            🛍️ Pickup
        </button>
        <button class="address-tab" onclick="switchAddressTab('delivery')" id="delivery-address-tab">
            📍 Delivery
        </button>
        <button class="address-tab" onclick="switchAddressTab('new')" id="add-new-address-tab">
            ➕ Add New Address
        </button>
    </div>

    <!-- Pickup Address Section -->
    <div class="address-section active" id="pickup-address-section">
        <input type="hidden" name="order_type" value="pickup">
    </div>

    <!-- Delivery Addresses Section -->
    <div class="address-section" id="delivery-address-section">
        <input type="hidden" name="order_type" value="delivery">
        <div class="saved-addresses">
            @foreach ($shippingAddresses as $address)
                <div class="saved-address {{ $loop->first ? 'selected' : '' }}" onclick="selectAddress({{ $address->id }})">
                    <div class="address-radio">
                        <input type="radio" name="selected-address" value="{{ $address->id }}" {{ $loop->first ? 'checked' : '' }}>
                    </div>
                    <div class="address-details">
                        <div class="address-label">
                            @if ($address->label == 'home')
                                🏠
                            @elseif ($address->label == 'office')
                                🏢
                            @elseif ($address->label == 'gift')
                                🎁
                            @elseif ($address->label == 'other')
                                📍
                            @endif
                            {{ strtoupper($address->label) }}
                        </div>
                        <div class="address-name">{{ $address->first_name }} {{ $address->last_name }}</div>
                        <div class="address-text">
                            {{ $address->address }}
                        </div>
                        <div class="address-contact">{{ $address->email }} • {{ $address->phone }}</div>
                    </div>
                    <div class="address-actions">
                        <button class="edit-address-btn" onclick="editAddress({{ $address->id }})">✏️ Edit</button>
                        <button class="delete-address-btn" onclick="deleteAddress({{ $address->id }})">🗑️ Delete</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- New Address Form Section -->
    <div class="address-section" id="new-address-section">
        <form id="new-address-form" action="{{ route('checkout.save-address') }}" method="post">
            @csrf
            <div class="form-group">
                <label class="form-label">Address Label *</label>
                <div class="address-label-container">
                    <button type="button" class="address-label-btn active" value="home">🏠 Home</button>
                    <button type="button" class="address-label-btn" value="office">🏢 Office</button>
                    <button type="button" class="address-label-btn" value="gift">🎁 Gift Address</button>
                    <button type="button" class="address-label-btn" value="other">📍 Other</button>
                </div>

                <input type="hidden" name="label" id="selected-label" value="home">
            </div>

            <div class="form-group">
                <label class="form-label">Email Address *</label>
                <input type="email" class="form-input" placeholder="your@email.com" name="email" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">First Name *</label>
                    <input type="text" class="form-input" placeholder="John" name="first_name" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Last Name *</label>
                    <input type="text" class="form-input" placeholder="Doe" name="last_name" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Address *</label>
                <input type="text" class="form-input" placeholder="123 Main Street, Province, Country" name="address" required>
            </div>

            <div class="form-group">
                <label class="form-label">Phone Number (optional)</label>
                <input type="tel" class="form-input" placeholder="+855 (0) 12-345-678" name="phone">
            </div>

            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" id="save-address" name="save_address">
                    <span class="checkmark"></span>
                    Save this address for future purchases
                </label>
            </div>
        </form>
    </div>

    <div class="btn-group">
        <button class="btn btn-secondary" onclick="previousStep()">Back to Cart</button>
        <button class="btn btn-primary" onclick="nextStep()">Continue to Payment</button>
    </div>
</div>