<!doctype html>
<html lang="en">

<head>
    <title>BeFree Store</title>
    @php
        $setting = \App\Models\BusinessSetting::all();
        $data['fav_icon'] = @$setting->where('type', 'fav_icon')->first()->value ?? '';
    @endphp
    <link rel="icon" type="image/x-icon"
        href="
            @if ($data['fav_icon'] && file_exists('uploads/business_settings/' . $data['fav_icon'])) {{ asset('uploads/business_settings/' . $data['fav_icon']) }}
            @else
                {{ asset('uploads/image/default.png') }} @endif">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{ asset('backend/login-form/css/style.css') }}">

    {{--
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"> --}}
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f6fb;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            background-color: white;
            border-radius: 16px;
            /* Modern 3D shadow effect */
            box-shadow:
                0 10px 30px rgba(0, 0, 0, 0.1),
                0 1px 8px rgba(0, 0, 0, 0.07),
                0 20px 40px rgba(79, 70, 229, 0.08);
            width: 420px;
            padding: 45px;
            transform: translateY(0);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .login-container:hover {
            transform: translateY(-5px);
            box-shadow:
                0 15px 35px rgba(0, 0, 0, 0.12),
                0 5px 15px rgba(0, 0, 0, 0.08),
                0 25px 50px rgba(79, 70, 229, 0.1);
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo h4 {
            font-weight: 600;
            color: #3d95d0;
            font-size: 24px;
            letter-spacing: -0.5px;
        }

        .custom-logo {
            width: 40px;
        }

        @media screen and (max-width: 768px) {
            .custom-logo {
                width: 30px;
            }

            .login-container {
                width: 90%;
                padding: 30px;
            }
        }

        h2 {
            font-size: 22px;
            font-weight: 600;
            color: #333;
            margin-bottom: 25px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 24px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 500;
            color: #444;
        }

        input {
            width: 100%;
            padding: 14px 18px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.2s ease;
            background-color: #f8fafc;
        }

        input:focus {
            border-color: #4f46e5;
            outline: none;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
            background-color: #fff;
        }

        .error {
            color: #e53e3e;
            font-size: 12px;
            margin-top: 6px;
        }

        button {
            display: block;
            width: 100%;
            padding: 14px;
            background-color: #4f46e5;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        button:hover {
            background-color: #4338ca;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
        }

        button:active {
            transform: translateY(0);
        }

        .form-group.text-center {
            text-align: center;
            font-size: 13px;
            color: #666;
        }
    </style>
</head>

<body>
    @php
        $business = \App\Models\BusinessSetting::first();
        $data['company_name'] = @$business->where('type', 'company_name')->first()->value ?? '';
        $data['copy_right_text'] = @$business->where('type', 'copy_right_text')->first()->value ?? '';
    @endphp
    <div class="login-container">
        <div class="logo">
            <h4>{{ $data['company_name'] }}</h4>
        </div>

        <h2 class="pb-2">Sign In</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email') }}" required autocomplete="Email" autofocus>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                    required autocomplete="current-password">
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit">Sign In</button>
            </div>
        </form>
        <div class="form-group text-center pt-3 mb-0">
            <span>{{ $data['copy_right_text'] }}</span>
        </div>
    </div>
</body>
</html>
