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

        <button type="submit" class="btn btn-primary" id="registerPhoneOTPButton">Register</button>
        <hr style="margin-top: 3rem; margin-bottom: 1rem;">
        <div class="social-login" style="">
            <a href="#" class="btn">
                <i class="fab fa-google"></i>
            </a>
            <a href="#" class="btn">
                <i class="fab fa-facebook"></i>
            </a>
            <a href="#" class="btn">
                <i class="fab fa-twitter"></i>
            </a>
        </div>
    </form>
</div>
