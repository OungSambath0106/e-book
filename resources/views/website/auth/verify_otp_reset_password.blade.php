<div class="form-section" id="otpResetPasswordForm">
    <div class="back-btn" onclick="goBackForgotPassword()">← Back</div>
    <h3 style="text-align: center; margin-bottom: 20px; color: #4a5568;">Verify Your OTP</h3>
    <div class="phone-display" id="phoneDisplayResetPassword"></div>
    <p style="text-align: center; color: #718096; margin-bottom: 20px;">
        Enter the 6-digit code sent to your phone to reset your password
    </p>

    <form id="otpResetPasswordFormElement">
        <div class="otp-container">
            <input type="text" class="otp-input" maxlength="1" oninput="moveToNext(this)">
            <input type="text" class="otp-input" maxlength="1" oninput="moveToNext(this)">
            <input type="text" class="otp-input" maxlength="1" oninput="moveToNext(this)">
            <input type="text" class="otp-input" maxlength="1" oninput="moveToNext(this)">
            <input type="text" class="otp-input" maxlength="1" oninput="moveToNext(this)">
            <input type="text" class="otp-input" maxlength="1" oninput="moveToNext(this)">
        </div>
        <div class="timer" id="timerResetPassword">Resend code in <span id="countdownResetPassword">60</span>s</div>
        <button type="submit" class="btn btn-primary">Verify OTP</button>
    </form>
    <div class="resend-code" id="resendCodeResetPassword" style="display: none;" onclick="resendOTPResetPassword()">
        Resend Code
    </div>
</div>
