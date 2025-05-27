<?php

namespace App\Http\Controllers\Websites\Auth;

use App\helpers\GlobalFunction;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showRegisterForm()
    {
        return view('website.auth.login');
    }

    public function registerPhoneOTP(Request $request)
    {
        $request->validate([
            'phone' => 'required',
        ]);

        $phone = $request->phone;
        $existingCustomer = Customer::where('phone', $phone)->first();

        if ($existingCustomer && $existingCustomer->is_verify == 1) {
            return response()->json([
                'success' => false,
                'message' => 'Phone number has already been registered',
            ], 400);
        }

        $otp = rand(100000, 999999);
        Cache::put('otp_' . $phone, $otp, now()->addMinutes(5));

        $response = GlobalFunction::sendOTP($phone, $otp);

        if ($response) {
            if (!$existingCustomer) {
                $customer = new Customer();
                $customer->name = $phone;
                $customer->phone = $phone;
                $customer->password = Hash::make('default_password');
                $customer->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully',
                'phone' => $phone,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to send OTP',
        ], 500);
    }

    public function showVerifyForm()
    {
        $phone = session('phone');
        if (!$phone) return redirect()->route('customer.registerForm');

        return view('website.auth.verify_otp', compact('phone'));
    }

    public function showSetupForm()
    {
        $phone = session('phone');
        if (!$phone) return redirect()->route('customer.registerForm');

        return view('website.auth.set_up_acc', compact('phone'));
    }

    // public function verifyOTP(Request $request)
    // {
    //     $request->validate([
    //         'phone' => 'required',
    //         'otp' => 'required|numeric',
    //         'name' => 'required|string',
    //         'password' => 'required|string|min:6',
    //         'confirm_password' => 'required|string|min:6|same:password',
    //     ]);

    //     $phone = $request->phone;
    //     $otp = $request->otp;

    //     $cachedOtp = Cache::get('otp_' . $phone);
    //     if ($otp != $cachedOtp) {
    //         return redirect()->back()->withErrors(['otp' => 'Phone and OTP do not match']);
    //     }

    //     $customer = Customer::where('phone', $phone)->first();
    //     if (!$customer) {
    //         $customer = new Customer();
    //         $customer->phone = $phone;
    //         $customer->provider = 'phone';
    //     }

    //     $customer->name = $request->name;
    //     $customer->is_verify = 1;
    //     $customer->provider = 'phone';
    //     $customer->password = Hash::make($request->password);
    //     $customer->save();

    //     auth()->login($customer);

    //     Cache::forget('otp_' . $phone);

    //     return redirect()->route('home')->with('success', 'Registered and logged in successfully');
    // }
    public function verifyOnlyOTP(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'otp' => 'required|numeric',
        ]);

        $phone = $request->phone;
        $otp = $request->otp;

        $cachedOtp = Cache::get('otp_' . $phone);
        if (!$cachedOtp || $otp != $cachedOtp) {
            return response()->json(['success' => false, 'message' => 'Invalid OTP']);
        }

        session(['otp_verified' => true]);

        return response()->json(['success' => true]);
    }

    public function setupAccount(Request $request)
    {
        if (!session('otp_verified')) {
            return redirect()->route('customer.registerForm')->withErrors(['otp' => 'OTP not verified']);
        }

        $request->validate([
            'phone' => 'required',
            'name' => 'required|string',
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|string|min:6|same:password',
        ]);

        $phone = $request->phone;

        $customer = Customer::firstOrNew(['phone' => $phone]);
        $customer->provider = 'phone';
        $customer->name = $request->name;
        $customer->is_verify = 1;
        $customer->password = $request->password;
        $customer->save();

        auth()->guard('customers')->login($customer);
        $token = $customer->createToken('PhoneLogin')->accessToken;

        Cache::forget('otp_' . $phone);
        session()->forget('otp_verified');

        $customer_info = [
            'token' => $token,
            'id' => $customer->id,
            'name' => $customer->name,
            'phone' => $customer->phone,
            'email' => $customer->email,
        ];

        return redirect()->route('home', ['token' => $token])->with('success', 'Account created successfully')->with('customer_info', $customer_info);
    }

    public function showLoginForm()
    {
        return view('website.auth.login');
    }

    public function loginPhoneOTP(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required|string',
        ]);

        $customer = Customer::where('phone', $request->phone)->first();

        if (!$customer || !Hash::check($request->password, $customer->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        auth()->guard('customers')->login($customer);

        $token = $customer->createToken('PhoneLogin')->accessToken;

        $customer_info = [
            'token' => $token,
            'id' => $customer->id,
            'name' => $customer->name,
            'phone' => $customer->phone,
            'email' => $customer->email,
            'image_url' => $customer->image_url,
            'is_verify' => $customer->is_verify,
            'provider' => $customer->provider,
            'is_google_login' => $customer->provider == 'google' ? 1 : 0,
        ];

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'customer_info' => $customer_info,
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('sign-in')->with('success', 'Logged out successfully');
    }
}
