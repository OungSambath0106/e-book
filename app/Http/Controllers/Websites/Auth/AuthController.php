<?php

namespace App\Http\Controllers\Websites\Auth;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\helpers\GlobalFunction;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
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
        Cache::put('otp_' . $phone, $otp, now()->addMinutes(1));

        $response = GlobalFunction::sendOTP($phone, $otp);

        if ($response) {
            if (!$existingCustomer) {
                $customer = new Customer();
                $customer->name = $phone;
                $customer->phone = $phone;
                $customer->password = 'default_password';
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

    public function resendOTP(Request $request)
    {
        $request->validate([
            'phone' => 'required',
        ]);

        $phone = $request->phone;
        // $otp = Cache::get('otp_' . $phone);

        // if (!$otp) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'OTP not found',
        //     ], 400);
        // }

        $otp = rand(100000, 999999);
        Cache::put('otp_' . $phone, $otp, now()->addMinutes(1));

        $response = GlobalFunction::sendOTP($phone, $otp);

        if ($response) {
            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to send OTP',
        ], 500);
    }

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
        auth()->guard('customers')->logout();
        session()->forget('customer_info');
        return redirect()->route('home')->with('success', 'Logged out successfully');
    }
}
