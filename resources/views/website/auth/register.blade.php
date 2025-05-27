<div class="form-section" id="registerForm">
    <form id="registerFormElement" method="POST">
        @csrf
        <div class="form-group">
            <label for="registerPhone">Phone Number</label>
            <div class="input-wrapper">
                <span class="country-code">855</span>
                <input type="tel" id="registerPhone" name="phone" class="form-input phone-input"
                    placeholder="Enter your phone number" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary" id="registerPhoneOTPButton">Send OTP</button>
    </form>
</div>
