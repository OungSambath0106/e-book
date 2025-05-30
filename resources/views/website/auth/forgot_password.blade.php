<div class="form-section" id="forgotPasswordForm">
    <div class="back-btn" onclick="goBackLogin()">← Back</div>
    <form id="forgotPasswordFormElement" method="POST" style="padding-top: 20px;">
        @csrf
        <div class="form-group">
            <label for="forgotPasswordPhone">Phone Number</label>
            <div class="input-wrapper">
                <span class="country-code">855</span>
                <input type="tel" id="forgotPasswordPhone" name="phone" class="form-input phone-input"
                    placeholder="Enter your phone number" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary" id="forgotPasswordOTPButton">Send OTP</button>
    </form>
</div>
