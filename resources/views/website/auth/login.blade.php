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

        .auth-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            z-index: 10;
        }

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
            margin-bottom: 40px;
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

        .logo span {
            font-size: 28px;
        }

        .auth-toggle {
            display: flex;
            background: #f8f9ff;
            border-radius: 12px;
            padding: 4px;
            margin-bottom: 40px;
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
        </div>

        <!-- Right Side - Form Content -->
        <div class="form-side">
            <div class="logo">
                <h1><span>📚</span> E-BOOK STORE</h1>
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

                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                </div>

                <!-- Register Form -->
                @include('website.auth.register')

                <!-- OTP Verification -->
                @include('website.auth.verify_otp')

                <!-- Setup Profile -->
                @include('website.auth.set_up_acc')

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

        // Login form
        document.getElementById('loginFormElement').addEventListener('submit', async (e) => {
            e.preventDefault();

            const countryCode = document.getElementById('countryCode').textContent;
            const phone = document.getElementById('loginPhone').value;
            const password = document.getElementById('loginPassword').value;
            const csrfToken = document.querySelector('input[name="_token"]').value;

            try {
                const response = await fetch("{{ route('customer.login') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ phone: countryCode + phone, password }),
                });
                const data = await response.json();

                if (response.ok) {
                    // Redirect to home route with token in URL
                    window.location.href = "{{ route('home') }}?token=" + encodeURIComponent(data.customer_info.token);
                } else {
                    showNotification(data.message || "Login failed.");
                }
            } catch (error) {
                console.error('Login error:', error);
                showNotification("An error occurred. Please try again.");
            }
        });

        // Register form
        document.getElementById('registerFormElement').addEventListener('submit', function(e) {
            e.preventDefault();

            const phone = document.getElementById('registerPhone').value.trim();
            const fullPhone = '855' + phone;

            if (phone === '') {
                showNotification('Please enter your phone number');
                return;
            }

            // Send AJAX request to backend
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
</body>

</html>
