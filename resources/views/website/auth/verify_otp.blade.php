<div class="form-section" id="otpForm">
    <div class="back-btn" onclick="goBack()">← Back</div>
    <h3 style="text-align: center; margin-bottom: 20px; color: #4a5568;">Verify Your Phone</h3>
    <div class="phone-display" id="phoneDisplay"></div>
    <p style="text-align: center; color: #718096; margin-bottom: 20px;">Enter the 6-digit code sent to
        your phone</p>

    <form id="otpFormElement">
        <div class="otp-container">
            <input type="text" class="otp-input" maxlength="1" oninput="moveToNext(this, 1)">
            <input type="text" class="otp-input" maxlength="1" oninput="moveToNext(this, 2)">
            <input type="text" class="otp-input" maxlength="1" oninput="moveToNext(this, 3)">
            <input type="text" class="otp-input" maxlength="1" oninput="moveToNext(this, 4)">
            <input type="text" class="otp-input" maxlength="1" oninput="moveToNext(this, 5)">
            <input type="text" class="otp-input" maxlength="1" oninput="moveToNext(this, 6)">
        </div>
        <div class="timer" id="timer">Resend code in 60s</div>
        <button type="submit" class="btn btn-primary">Verify OTP</button>
    </form>
    <div class="resend-code" id="resendCode" style="display: none;" onclick="resendOTP()">Resend
        Code</div>
</div>
