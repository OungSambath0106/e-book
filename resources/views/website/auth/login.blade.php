<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $setting = \App\Models\BusinessSetting::all();

        $data['fav_icon'] = @$setting->where('type', 'fav_icon')->first()->value ?? '';
        $data['company_name'] = @$setting->where('type', 'company_name')->first()->value ?? '';
    @endphp
    <title>@yield('page_title', $data['company_name'])</title>
    <link rel="icon" type="image/x-icon" href="
        @if ($data['fav_icon'] && file_exists('uploads/business_settings/' . $data['fav_icon']))
            {{ asset('uploads/business_settings/' . $data['fav_icon']) }}
        @else
            {{ asset('uploads/image/default.png') }}
        @endif">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 1000px;
            min-height: 600px;
            display: flex;
            position: relative;
            overflow: hidden;
        }

        /* .auth-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            z-index: 10;
        } */

        /* Left Side - Visual Content */
        .visual-side {
            flex: 1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            overflow: hidden;
        }

        .visual-content {
            text-align: center;
            z-index: 2;
            padding: 40px;
            position: absolute;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            pointer-events: none;
        }

        .visual-content.active {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        .visual-content h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            background: linear-gradient(45deg, #fff, #e2e8f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .visual-content p {
            font-size: 1.1rem;
            line-height: 1.6;
            opacity: 0.9;
            margin-bottom: 30px;
        }

        .visual-icon {
            font-size: 6rem;
            margin-bottom: 30px;
            display: block;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .decorative-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: drift 15s infinite linear;
        }

        .circle:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .circle:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            left: 80%;
            animation-delay: -5s;
        }

        .circle:nth-child(3) {
            width: 60px;
            height: 60px;
            top: 80%;
            left: 20%;
            animation-delay: -10s;
        }

        @keyframes drift {
            0% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }

            100% {
                transform: translateY(0px) rotate(360deg);
            }
        }

        /* Right Side - Form Content */
        .form-side {
            flex: 1;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: white;
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo h1 {
            color: #667eea;
            font-size: 24px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .auth-toggle {
            display: flex;
            background: #f8f9ff;
            border-radius: 12px;
            padding: 4px;
            margin-bottom: 30px;
            position: relative;
        }

        .toggle-btn {
            flex: 1;
            padding: 12px 20px;
            text-align: center;
            cursor: pointer;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            z-index: 2;
        }

        .toggle-btn.active {
            color: white;
            background: linear-gradient(135deg, #667eea, #764ba2);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .form-container {
            position: relative;
            overflow: hidden;
            min-height: 300px;
        }

        .form-section {
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            position: absolute;
            width: 100%;
            top: 0;
        }

        .form-section.active {
            opacity: 1;
            transform: translateX(0);
            position: relative;
        }

        .form-section.slide-out {
            opacity: 0;
            transform: translateX(-100%);
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #4a5568;
            font-size: 14px;
        }

        .input-wrapper {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: white;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            /* transform: translateY(-2px); */
        }

        .phone-input {
            padding-left: 70px;
        }

        .country-code {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-weight: 600;
            color: #667eea;
            border-right: 1px solid #e2e8f0;
            padding-right: 10px;
        }

        .otp-container {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin: 20px 0;
        }

        .otp-input {
            width: 50px;
            height: 50px;
            text-align: center;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 18px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .otp-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: scale(1.05);
        }

        .btn {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            color: #667eea;
            cursor: pointer;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .success-icon {
            text-align: center;
            margin-bottom: 20px;
        }

        .success-icon span {
            display: inline-block;
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            line-height: 80px;
            font-size: 40px;
            color: white;
            animation: successPulse 0.6s ease-out;
        }

        .social-login {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1rem;
            padding-top: .5rem;
        }

        .social-login .btn {
            text-decoration: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1px solid #e2e8f0;
            margin: 0;
            padding: 0;
        }

        .divider {
            color: #999;
            font-size: 14px;
            padding: 2rem 0 1.5rem;
            position: relative;
            display: flex;
            align-items: center;
            text-align: center;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e0e0e0;
        }

        .divider::before {
            margin-right: 16px;
        }

        .divider::after {
            margin-left: 16px;
        }

        .social-buttons {
            display: flex;
            justify-content: center;
            gap: 24px;
            margin-bottom: 0.5rem;
        }

        .social-btn {
            width: 56px;
            height: 56px;
            border: none;
            border-radius: 16px;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .social-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        .social-btn img {
            width: 24px;
            height: 24px;
        }

        .forgot-password {
            text-align: right;
            font-size: 14px;
            color: #667eea;
            font-weight: 600;
            text-decoration: none;
        }

        @keyframes successPulse {
            0% {
                transform: scale(0);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        .phone-display {
            background: #f8f9ff;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
            color: #667eea;
        }

        .timer {
            text-align: center;
            margin-top: 10px;
            color: #a0aec0;
            font-size: 14px;
        }

        .resend-code {
            text-align: center;
            margin-top: 15px;
            color: #667eea;
            cursor: pointer;
            font-weight: 600;
        }

        .resend-code:hover {
            text-decoration: underline;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .auth-container {
                flex-direction: column;
                max-width: 450px;
                min-height: auto;
            }

            .visual-side {
                min-height: 200px;
                padding: 30px 20px;
            }

            .visual-content h2 {
                font-size: 1.8rem;
                margin-bottom: 15px;
            }

            .visual-content p {
                font-size: 1rem;
                margin-bottom: 20px;
            }

            .visual-icon {
                font-size: 3rem;
                margin-bottom: 20px;
            }

            .form-side {
                padding: 40px 30px;
            }

            .otp-container {
                gap: 10px;
            }

            .otp-input {
                width: 45px;
                height: 45px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }

            .form-side {
                padding: 30px 20px;
            }

            .auth-container {
                border-radius: 16px;
            }
        }
    </style>
</head>

<body>
    @php
        $setting = App\Models\BusinessSetting::all();
        $web_header_logo = $setting->where('type', 'web_header_logo')->first()->value ?? '';
        $company_name = $setting->where('type', 'company_name')->first()->value ?? '';
    @endphp

    <div class="auth-container">
        <!-- Left Side - Visual Content -->
        <div class="visual-side">
            <div class="decorative-elements">
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
            </div>

            <!-- Login Visual -->
            <div class="visual-content active" id="loginVisual">
                <span class="visual-icon">📚</span>
                <h2>Welcome Back!</h2>
                <p>Dive back into your favorite stories and discover new adventures in our vast digital library. Your
                    next great read is just a login away.</p>
            </div>

            <!-- Register Visual -->
            <div class="visual-content" id="registerVisual">
                <span class="visual-icon">🌟</span>
                <h2>Join Our Community!</h2>
                <p>Start your reading journey with thousands of bestselling eBooks. Create your account and unlock
                    unlimited access to amazing stories.</p>
            </div>

            <!-- OTP Visual -->
            <div class="visual-content" id="otpVisual">
                <span class="visual-icon">🔐</span>
                <h2>Secure Verification</h2>
                <p>We're keeping your account safe and secure. Please verify your phone number to continue with the
                    registration process.</p>
            </div>

            <!-- Setup Visual -->
            <div class="visual-content" id="setupVisual">
                <span class="visual-icon">⚙️</span>
                <h2>Almost There!</h2>
                <p>Just a few more details to complete your profile. Choose your username and create a secure password
                    for your new account.</p>
            </div>

            <!-- Success Visual -->
            <div class="visual-content" id="successVisual">
                <span class="visual-icon">🎉</span>
                <h2>Welcome Aboard!</h2>
                <p>Your account is now ready! Start exploring our extensive collection of eBooks and begin your amazing
                    reading adventure today.</p>
            </div>

            <!-- Forgot Password Visual -->
            <div class="visual-content" id="forgotPasswordVisual">
                <span class="visual-icon">🔐</span>
                <h2>Forgot Password</h2>
                <p>Enter your phone number to reset your password. We will send you an OTP to your phone number.</p>
            </div>

            <!-- OTP Verification Reset Password Visual -->
            <div class="visual-content" id="otpResetPasswordVisual">
                <span class="visual-icon">🔐</span>
                <h2>Verify Your OTP</h2>
                <p>Enter the 6-digit code sent to your phone to reset your password</p>
            </div>

            <!-- Reset Password Visual -->
            <div class="visual-content" id="resetPasswordVisual">
                <span class="visual-icon">🔐</span>
                <h2>Reset Password</h2>
                <p>Enter your new password to reset your account. Please enter your phone number and OTP to reset your password.</p>
            </div>
        </div>

        <!-- Right Side - Form Content -->
        <div class="form-side">
            <div class="logo">
                <h1>{{ $company_name }}</h1>
            </div>

            <!-- Main Toggle -->
            <div class="auth-toggle" id="mainToggle">
                <div class="toggle-btn active" data-tab="login">Login</div>
                <div class="toggle-btn" data-tab="register">Register</div>
            </div>

            <div class="form-container" id="formContainer">
                <!-- Login Form -->
                <div class="form-section active" id="loginForm">
                    <form id="loginFormElement">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label for="loginPhone">Phone Number</label>
                            <div class="input-wrapper">
                                <span class="country-code" id="countryCode">855</span>
                                <input type="tel" id="loginPhone" name="phone" class="form-input phone-input"
                                    placeholder="Enter your phone number" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="loginPassword">Password</label>
                            <input type="password" id="loginPassword" name="password" class="form-input"
                                placeholder="Enter your password" required>
                        </div>

                        <div class="form-group">
                            <a href="javascript:void(0)" class="forgot-password" onclick="showForm('forgotPasswordForm', 'forgotPassword')">Forgot Password?</a>
                        </div>

                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                    <div class="divider"> Or </div>
                    <div class="social-buttons">
                        <button class="social-btn" onclick="signInWithGoogle()">
                            <svg width="24" height="24" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                        </button>

                        <button class="social-btn" onclick="signInWithFacebook()">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="#1877F2">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </button>

                        <button class="social-btn" onclick="signInWithApple()">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Register Form -->
                @include('website.auth.register')

                <!-- OTP Verification -->
                @include('website.auth.verify_otp')

                <!-- Setup Profile -->
                @include('website.auth.set_up_acc')

                <!-- Forgot Password -->
                @include('website.auth.forgot_password')

                <!-- OTP Verification Reset Password -->
                @include('website.auth.verify_otp_reset_password')

                <!-- Reset Password -->
                @include('website.auth.reset_password')

                <!-- Success Message -->
                <div class="form-section" id="successForm">
                    <div class="success-icon">
                        <span>✓</span>
                    </div>
                    <h3 style="text-align: center; margin-bottom: 20px; color: #4a5568;">Welcome to E-Book Store!</h3>
                    <p style="text-align: center; color: #718096; margin-bottom: 30px;">Your account has been created
                        successfully. You can now start exploring our digital Books Store.</p>
                    <button class="btn btn-primary" onclick="window.location.href='{{ route('home') }}'">
                        Login
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentStep = 'login';
        let registeredPhone = '';
        let timer = null;
        let countdown = 60;

        // Tab switching
        document.querySelectorAll('.toggle-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const tab = btn.dataset.tab;
                switchTab(tab);
            });
        });

        function switchTab(tab) {
            if (tab === currentStep) return;

            document.querySelectorAll('.toggle-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelector(`[data-tab="${tab}"]`).classList.add('active');

            const currentForm = document.querySelector('.form-section.active');
            const newForm = document.getElementById(tab + 'Form');

            // Switch visual content
            switchVisualContent(tab);

            currentForm.classList.add('slide-out');

            setTimeout(() => {
                currentForm.classList.remove('active', 'slide-out');
                newForm.classList.add('active', 'fade-in');
                currentStep = tab;

                setTimeout(() => {
                    newForm.classList.remove('fade-in');
                }, 500);
            }, 200);
        }

        function switchVisualContent(step) {
            // Remove active class from all visual contents
            document.querySelectorAll('.visual-content').forEach(visual => {
                visual.classList.remove('active');
            });

            // Add active class to the target visual
            const newVisual = document.getElementById(step + 'Visual');
            if (newVisual) {
                setTimeout(() => {
                    newVisual.classList.add('active');
                }, 100);
            }
        }

        // Login form formatting
        document.getElementById('loginPhone').addEventListener('input', function (e) {
            // Remove non-digit characters
            let digits = e.target.value.replace(/\D/g, '');

            // Format based on starting digit
            let formatted = '';
            if (digits.startsWith('0')) {
                if (digits.length <= 3) {
                    formatted = digits;
                } else if (digits.length <= 6) {
                    formatted = `${digits.slice(0, 3)} ${digits.slice(3)}`;
                } else {
                    formatted = `${digits.slice(0, 3)} ${digits.slice(3, 6)} ${digits.slice(6, 10)}`;
                }
            } else {
                if (digits.length <= 2) {
                    formatted = digits;
                } else if (digits.length <= 5) {
                    formatted = `${digits.slice(0, 2)} ${digits.slice(2)}`;
                } else {
                    formatted = `${digits.slice(0, 2)} ${digits.slice(2, 5)} ${digits.slice(5, 9)}`;
                }
            }

            e.target.value = formatted;
        });

        // Login form
        document.getElementById('loginFormElement').addEventListener('submit', async (e) => {
            e.preventDefault();

            const countryCode = document.getElementById('countryCode').textContent;
            let rawPhone = document.getElementById('loginPhone').value;
            const password = document.getElementById('loginPassword').value.trim();
            const csrfToken = document.querySelector('input[name="_token"]').value;

            // Remove spaces
            rawPhone = rawPhone.replace(/\s/g, '');
            // Remove leading 0 if present
            if (rawPhone.startsWith('0')) {
                rawPhone = rawPhone.slice(1);
            }
            // Validate again: ensure it's only digits and length is valid
            if (!/^\d+$/.test(rawPhone) || rawPhone.length < 8) {
                showNotification("Invalid phone number.");
                return;
            }

            try {
                const response = await fetch("{{ route('customer.login') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ phone: countryCode + rawPhone, password }),
                });

                const data = await response.json();

                if (response.ok) {
                    window.location.href = "{{ route('home') }}";
                } else {
                    showNotification(data.message || "Login failed.");
                }
            } catch (error) {
                console.error('Login error:', error);
                showNotification("An error occurred. Please try again.");
            }
        });

        // Register form formatting
        const phoneInput = document.getElementById('registerPhone');
        // Allow only number keys
        phoneInput.addEventListener('keypress', function (e) {
            const char = String.fromCharCode(e.which);
            if (!/[0-9]/.test(char)) {
                e.preventDefault();
            }
        });

        // Handle paste (prevent letters/symbols)
        phoneInput.addEventListener('paste', function (e) {
            const pasted = (e.clipboardData || window.clipboardData).getData('text');
            if (!/^\d+$/.test(pasted)) {
                e.preventDefault();
            }
        });

        // Auto-format on input
        phoneInput.addEventListener('input', function (e) {
            let value = e.target.value.replace(/\s+/g, ''); // Remove spaces

            let formatted = '';
            if (value.startsWith('0')) {
                formatted = value.slice(0, 3);
                if (value.length > 3) formatted += ' ' + value.slice(3, 6);
                if (value.length > 6) formatted += ' ' + value.slice(6, 9);
            } else {
                formatted = value.slice(0, 2);
                if (value.length > 2) formatted += ' ' + value.slice(2, 5);
                if (value.length > 5) formatted += ' ' + value.slice(5, 8);
            }

            e.target.value = formatted.trim();
        });

        // Register form
        document.getElementById('registerFormElement').addEventListener('submit', function (e) {
            e.preventDefault();

            const rawPhone = document.getElementById('registerPhone').value;
            // Remove all spaces
            let cleanedPhone = rawPhone.replace(/\s+/g, '');
            // Remove leading zero only if it's the first character
            if (cleanedPhone.startsWith('0')) {
                cleanedPhone = cleanedPhone.substring(1);
            }
            const fullPhone = '855' + cleanedPhone;
            if (cleanedPhone === '') {
                showNotification('Please enter your phone number');
                return;
            }

            fetch('{{ route("customer.registerPhoneOTP") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ phone: fullPhone })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('phoneDisplay').textContent = fullPhone;
                    sessionStorage.setItem('phone', fullPhone);
                    sessionStorage.setItem('otp', data.otp);
                    showForm('otpForm', 'otp');
                    startTimer();
                } else {
                    showNotification(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An unexpected error occurred.');
            });
        });

        // OTP form
        document.getElementById('otpFormElement').addEventListener('submit', async (e) => {
            e.preventDefault();

            const otpInputs = document.querySelectorAll('.otp-input');
            const otp = Array.from(otpInputs).map(input => input.value.trim()).join('');
            const phone = sessionStorage.getItem('phone');

            if (otp.length === 6) {
                try {
                    const response = await fetch('{{ route("customer.verifyOnlyOTP") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ phone, otp })
                    });

                    if (!response.ok) {
                        const errorText = await response.text();
                        throw new Error(errorText);
                    }

                    const data = await response.json();

                    if (data.success) {
                        clearInterval(timer);
                        // Hide OTP form and show setup form
                        showForm('setupForm', 'setup');
                    } else {
                        showNotification(data.message || 'OTP verification failed.');
                    }
                } catch (error) {
                    console.error('OTP Fetch error:', error);
                    showNotification('Something went wrong while verifying the OTP.');
                }
            } else {
                showNotification('Please enter the complete 6-digit code');
            }
        });

        // Setup form
        document.getElementById('setupFormElement').addEventListener('submit', async (e) => {
            e.preventDefault();

            const name = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const phone = sessionStorage.getItem('phone');

            if (password !== confirmPassword) {
                showNotification('Passwords do not match');
                return;
            }

            try {
                const response = await fetch('{{ route("customer.setupAccount") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        phone,
                        name,
                        password,
                        confirm_password: confirmPassword
                    })
                });

                if (response.redirected) {
                    window.location.href = response.url;
                } else {
                    const data = await response.json();
                    if (data.errors) {
                        showNotification(Object.values(data.errors).join("\n"));
                    }
                }
            } catch (error) {
                console.error('Setup Fetch error:', error);
                showNotification('Something went wrong during account setup.');
            }
        });

        // Forgot Password form
        document.getElementById('forgotPasswordFormElement').addEventListener('submit', async (e) => {
            e.preventDefault();

            const phone = document.getElementById('forgotPasswordPhone').value.trim();
            const fullPhone = '855' + phone;
            const csrfToken = document.querySelector('input[name="_token"]').value;

            try {
                const response = await fetch('{{ route("customer.forgetPassword") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ phone: fullPhone })
                });

                if (response.ok) {
                    const data = await response.json();
                    if (data.success) {
                        document.getElementById('phoneDisplayResetPassword').textContent = fullPhone;
                        showForm('otpResetPasswordForm', 'otpResetPassword');
                        showNotificationSuccess(data.message);
                        startTimerResetPassword();
                    } else if (!data.success) {
                        showNotification(data.message);
                    }
                }
            } catch (error) {
                console.error('Forgot Password error:', error);
                showNotification('An error occurred. Please try again.');
            }
        });

        // OTP Verification Reset Password form
        document.getElementById('otpResetPasswordFormElement').addEventListener('submit', async (e) => {
            e.preventDefault();

            const otpInputs = document.querySelectorAll('.otp-input');
            const otp = Array.from(otpInputs).map(input => input.value.trim()).join('');
            const phone = sessionStorage.getItem('phone');

            if (otp.length === 6) {
                try {
                    const response = await fetch('{{ route("customer.verifyOnlyOTP") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ phone, otp })
                    });

                    if (!response.ok) {
                        const errorText = await response.text();
                        throw new Error(errorText);
                    }

                    const data = await response.json();

                    if (data.success) {
                        clearInterval(timer);
                        // Hide OTP form and show reset password form
                        showForm('resetPasswordForm', 'resetPassword');
                    } else {
                        showNotification(data.message || 'OTP verification failed.');
                    }
                } catch (error) {
                    console.error('OTP Fetch error:', error);
                    showNotification('Something went wrong while verifying the OTP.');
                }
            } else {
                showNotification('Please enter the complete 6-digit code');
            }
        });

        // Reset Password form
        document.getElementById('resetPasswordFormElement').addEventListener('submit', async (e) => {
            e.preventDefault();

            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const phone = sessionStorage.getItem('phone');

            if (newPassword !== confirmPassword) {
                showNotification('Passwords do not match');
                return;
            }

            try {
                const response = await fetch('{{ route("customer.resetPassword") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        phone,
                        new_password: newPassword,
                        confirm_password: confirmPassword
                    })
                });

                if (response.ok) {
                    const data = await response.json();
                    if (data.success) {
                        showNotificationSuccess(data.message);
                        clearInterval(timer);
                        showForm('loginForm', 'login');
                    } else {
                        showNotification(data.message);
                    }
                }
            } catch (error) {
                console.error('Reset Password error:', error);
                showNotification('An error occurred. Please try again.');
            }
        });

        function showForm(formId, visualId) {
            const currentForm = document.querySelector('.form-section.active');
            const newForm = document.getElementById(formId);

            // Hide main toggle for non-main forms
            const mainToggle = document.getElementById('mainToggle');
            if (formId === 'loginForm' || formId === 'registerForm') {
                mainToggle.style.display = 'flex';
            } else {
                mainToggle.style.display = 'none';
            }

            // Switch visual content
            switchVisualContent(visualId);

            currentForm.classList.add('slide-out');

            setTimeout(() => {
                currentForm.classList.remove('active', 'slide-out');
                newForm.classList.add('active', 'fade-in');

                setTimeout(() => {
                    newForm.classList.remove('fade-in');
                }, 500);
            }, 200);
        }

        function goBack() {
            showForm('registerForm', 'register');
            document.getElementById('mainToggle').style.display = 'flex';
            clearInterval(timer);
        }

        function goBackLogin() {
            showForm('loginForm', 'login');
            document.getElementById('mainToggle').style.display = 'flex';
            clearInterval(timer);
        }

        function goBackForgotPassword() {
            showForm('forgotPasswordForm', 'forgotPassword');
            document.getElementById('mainToggle').style.display = 'flex';
            clearInterval(timer);
        }

        function moveToNext(current, nextIndex) {
            if (current.value.length === 1 && nextIndex <= 6) {
                const nextInput = document.querySelectorAll('.otp-input')[nextIndex];
                if (nextInput) nextInput.focus();
            }
        }

        function startTimer() {
            countdown = 60;
            document.getElementById('resendCode').style.display = 'none';
            document.getElementById('timer').style.display = 'block';

            timer = setInterval(() => {
                countdown--;
                document.getElementById('timer').textContent = `Resend code in ${countdown}s`;

                if (countdown <= 0) {
                    clearInterval(timer);
                    document.getElementById('timer').style.display = 'none';
                    document.getElementById('resendCode').style.display = 'block';
                }
            }, 1000);
        }

        function startTimerResetPassword() {
            countdown = 60;
            document.getElementById('resendCodeResetPassword').style.display = 'none';
            document.getElementById('timerResetPassword').style.display = 'block';

            timer = setInterval(() => {
                countdown--;
                document.getElementById('timerResetPassword').textContent = `Resend code in ${countdown}s`;

                if (countdown <= 0) {
                    clearInterval(timer);
                    document.getElementById('timerResetPassword').style.display = 'none';
                    document.getElementById('resendCodeResetPassword').style.display = 'block';
                }
            }, 1000);
        }

        function resendOTP() {
            const phone = sessionStorage.getItem('phone');
            fetch('{{ route("customer.resendOTP") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ phone: phone })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotificationSuccess(data.message);
                    document.querySelectorAll('.otp-input').forEach(input => input.value = '');
                    document.querySelectorAll('.otp-input')[0].focus();
                    showNotificationSuccess('New OTP sent to ' + phone);
                    startTimer();
                } else {
                    showNotification(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An unexpected error occurred.');
            });
        }

        function resendOTPResetPassword() {
            const phone = sessionStorage.getItem('phone');
            fetch('{{ route("customer.resendOTP") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ phone: phone })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotificationSuccess(data.message);
                    document.querySelectorAll('.otp-input').forEach(input => input.value = '');
                    document.querySelectorAll('.otp-input')[0].focus();
                    showNotificationSuccess('New OTP sent to ' + phone);
                    startTimerResetPassword();
                } else {
                    showNotification(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An unexpected error occurred.');
            });
        }

        // Auto-focus first input when OTP form is shown
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.target.id === 'otpForm' && mutation.target.classList.contains('active')) {
                    setTimeout(() => {
                        document.querySelectorAll('.otp-input')[0].focus();
                    }, 100);
                }
            });
        });

        document.querySelectorAll('.form-section').forEach(section => {
            observer.observe(section, {
                attributes: true,
                attributeFilter: ['class']
            });
        });

        window.showNotificationSuccess = (message) => {
                const notification = document.createElement('div');
                notification.style.position = 'fixed';
                notification.style.top = '80px';
                notification.style.right = '20px';
                notification.style.backgroundColor = '#10b981';
                notification.style.color = 'white';
                notification.style.padding = '15px 20px';
                notification.style.borderRadius = '5px';
                notification.style.boxShadow = '0 5px 15px rgba(0,0,0,0.1)';
                notification.style.zIndex = '1001';
                notification.style.transform = 'translateX(120%)';
                notification.style.transition = 'transform 0.3s ease';
                notification.innerHTML = '<i class="fas fa-check-circle"></i> ' + message;

                document.body.appendChild(notification);

                // Show notification
                setTimeout(() => {
                    notification.style.transform = 'translateX(0)';
                }, 100);

                // Hide and remove notification
                setTimeout(() => {
                    notification.style.transform = 'translateX(120%)';
                    setTimeout(() => {
                        document.body.removeChild(notification);
                    }, 300);
                }, 3000);
            }

            window.showNotification = (message) => {
                const notification = document.createElement('div');
                notification.style.position = 'fixed';
                notification.style.top = '80px';
                notification.style.right = '20px';
                notification.style.backgroundColor = '#ef4444';
                notification.style.color = 'white';
                notification.style.padding = '15px 20px';
                notification.style.borderRadius = '5px';
                notification.style.boxShadow = '0 5px 15px rgba(0,0,0,0.1)';
                notification.style.zIndex = '1001';
                notification.style.transform = 'translateX(120%)';
                notification.style.transition = 'transform 0.3s ease';
                notification.innerHTML = '<i class="fas fa-exclamation-triangle"></i> ' + message;

                document.body.appendChild(notification);

                // Show notification
                setTimeout(() => {
                    notification.style.transform = 'translateX(0)';
                }, 100);

                // Hide and remove notification
                setTimeout(() => {
                    notification.style.transform = 'translateX(120%)';
                    setTimeout(() => {
                        document.body.removeChild(notification);
                    }, 300);
                }, 3000);
            }
    </script>
    <!-- Include Firebase SDK -->
    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/11.8.1/firebase-app.js";
        import { getAuth, GoogleAuthProvider, signInWithPopup } from "https://www.gstatic.com/firebasejs/11.8.1/firebase-auth.js";

        const firebaseConfig = {
            apiKey: "AIzaSyCI2t3yWm5BVrLtodKsmaBXvizjfWeXaOg",
            authDomain: "e-book-store-c0106.firebaseapp.com",
            projectId: "e-book-store-c0106",
            storageBucket: "e-book-store-c0106.appspot.com",
            messagingSenderId: "1033729348961",
            appId: "1:1033729348961:web:5a67768d0e379ae959e120",
            measurementId: "G-DFD58B2FQP"
        };

        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const provider = new GoogleAuthProvider();
        provider.setCustomParameters({ prompt: 'select_account' });

        window.signInWithGoogle = function () {
            signInWithPopup(auth, provider)
                .then((result) => {
                    const user = result.user;
                    fetch("{{ route('customer.googleLogin') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            email: user.email,
                            displayName: user.displayName,
                            photoURL: user.photoURL,
                            uid: user.uid
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.is_google_login) {
                            window.location.href = "{{ route('home') }}";
                        }
                    })
                    .catch(error => {
                        console.error("Fetch error:", error);
                    });
                })
                .catch((error) => {
                    console.error("Google Auth Error:", error);
                });
        };
    </script>

    <!-- Facebook Login -->
    <script>
        window.fbAsyncInit = function () {
        FB.init({
            appId: '961679482581695',
            cookie: true,
            xfbml: true,
            version: 'v19.0'
        });
        };

        (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <script>
        function signInWithFacebook() {
        FB.login(function (response) {
            if (response.authResponse) {
            FB.api('/me', { fields: 'id,name,email,picture' }, function (userInfo) {
                fetch("{{ route('customer.facebookLogin') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    facebook_id: userInfo.id,
                    name: userInfo.name,
                    email: userInfo.email,
                    photo: userInfo.picture.data.url
                })
                })
                .then(response => response.json())
                .then(data => {
                if (data.success) {
                    window.location.href = "{{ route('home') }}";
                }
                });
            });
            } else {
            console.log("User cancelled login or did not fully authorize.");
            }
        }, { scope: 'email,public_profile' });
        }
    </script>
</body>

</html>
