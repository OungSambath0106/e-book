<div class="page" id="page2">
    <h1 class="page-title">Shipping Address</h1>

    <!-- Address Selection Tabs -->
    <div class="address-tabs">
        <button class="address-tab active" onclick="switchAddressTab('existing')" id="existing-address-tab">
            📍 Use Existing Address
        </button>
        <button class="address-tab" onclick="switchAddressTab('new')" id="add-new-address-tab">
            ➕ Add New Address
        </button>
    </div>

    <!-- Existing Addresses Section -->
    <div class="address-section active" id="existing-address-section">
        <div class="saved-addresses">
            <div class="saved-address selected" onclick="selectAddress(1)">
                <div class="address-radio">
                    <input type="radio" name="selected-address" value="1" checked>
                </div>
                <div class="address-details">
                    <div class="address-label">🏠 Home</div>
                    <div class="address-name">John Doe</div>
                    <div class="address-text">
                        123 Main Street, Apt 4B<br>
                        New York, NY 10001<br>
                        United States
                    </div>
                    <div class="address-contact">john.doe@email.com • +1 (555) 123-4567</div>
                </div>
                <div class="address-actions">
                    <button class="edit-address-btn" onclick="editAddress(1)">✏️ Edit</button>
                    <button class="delete-address-btn" onclick="deleteAddress(1)">🗑️ Delete</button>
                </div>
            </div>

            <div class="saved-address" onclick="selectAddress(2)">
                <div class="address-radio">
                    <input type="radio" name="selected-address" value="2">
                </div>
                <div class="address-details">
                    <div class="address-label">🏢 Office</div>
                    <div class="address-name">John Doe</div>
                    <div class="address-text">
                        456 Business Ave, Suite 200<br>
                        New York, NY 10002<br>
                        United States
                    </div>
                    <div class="address-contact">john.doe@email.com • +1 (555) 987-6543</div>
                </div>
                <div class="address-actions">
                    <button class="edit-address-btn" onclick="editAddress(2)">✏️ Edit</button>
                    <button class="delete-address-btn" onclick="deleteAddress(2)">🗑️ Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- New Address Form Section -->
    <div class="address-section" id="new-address-section">
        <form id="new-address-form">
            <div class="form-group">
                <label class="form-label">Address Label *</label>
                <div class="address-label-container">
                    <button class="address-label-btn active" value="home" id="home-address-label">🏠 Home</button>
                    <button class="address-label-btn" value="office" id="office-address-label">🏢 Office</button>
                    <button class="address-label-btn" value="gift" id="gift-address-label">🎁 Gift Address</button>
                    <button class="address-label-btn" value="other" id="other-address-label">📍 Other</button>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Email Address *</label>
                <input type="email" class="form-input" placeholder="your@email.com" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">First Name *</label>
                    <input type="text" class="form-input" placeholder="John" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Last Name *</label>
                    <input type="text" class="form-input" placeholder="Doe" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Street Address *</label>
                <input type="text" class="form-input" placeholder="123 Main Street" required>
            </div>

            <div class="form-group">
                <label class="form-label">Apartment, suite, etc. (optional)</label>
                <input type="text" class="form-input" placeholder="Apt 4B">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">City *</label>
                    <input type="text" class="form-input" placeholder="New York" required>
                </div>
                <div class="form-group">
                    <label class="form-label">State/Province *</label>
                    <input type="text" class="form-input" placeholder="NY" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">ZIP/Postal Code *</label>
                    <input type="text" class="form-input" placeholder="10001" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Country *</label>
                    <select class="form-input" required>
                        <option value="">Select Country</option>
                        <option value="US">United States</option>
                        <option value="CA">Canada</option>
                        <option value="GB">United Kingdom</option>
                        <option value="AU">Australia</option>
                        <option value="KH">Cambodia</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Phone Number (optional)</label>
                <input type="tel" class="form-input" placeholder="+1 (555) 123-4567">
            </div>

            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" checked>
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