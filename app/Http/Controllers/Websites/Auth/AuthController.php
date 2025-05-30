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
                'otp' => $otp,
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

        $otp = rand(100000, 999999);
        Cache::put('otp_' . $phone, $otp, now()->addMinutes(1));

        $response = GlobalFunction::sendOTP($phone, $otp);

        if ($response) {
            return response()->json([
                'success' => true,
                'phone' => $phone,
                'otp' => $otp,
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

        return redirect()->route('home')->with('success', 'Account created successfully')->with('customer_info', $customer_info);
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

    public function forgetPassword(Request $request)
    {
        $request->validate([
            'phone' => 'required',
        ]);

        $phone = $request->phone;
        $customer = Customer::where('phone', $phone)->first();

        if (!$customer) {
            return response()->json(['message' => 'Phone number not found', 'success' => false], 404);
        }

        $otp = rand(100000, 999999);
        Cache::put('otp_' . $phone, $otp, now()->addMinutes(1));

        $response = GlobalFunction::sendOTP($phone, $otp);
        if ($response) {
            return response()->json([
                'success' => true,
                'phone' => $phone,
                'otp' => $otp,
                'message' => 'OTP sent successfully',
            ], 200);
        } else {
            return response()->json(['message' => 'Failed to send OTP', 'success' => false], 500);
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'otp' => 'required|numeric',
            'new_password' => 'required|string|min:6',
            'confirm_password' => 'required|string|same:new_password',
        ]);

        $phone = $request->phone;
        $otp = $request->otp;
        $newPassword = $request->new_password;

        $cachedOtp = Cache::get('otp_' . $phone);

        if (!$cachedOtp || $cachedOtp != $otp) {
            return response()->json(['message' => 'Phone number and OTP do not match', 'success' => false], 400);
        }

        $customer = Customer::where('phone', $phone)->first();
        if (!$customer) {
            return response()->json(['message' => 'Customer not found', 'success' => false], 404);
        }

        $customer->password = $newPassword;
        $customer->save();

        Cache::forget('otp_' . $phone);

        return response()->json([
            'success' => true,
            'message' => 'Password has been reset successfully',
        ], 200);
    }

    public function googleLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'displayName' => 'required|string',
            'photoURL' => 'nullable|string',
            'uid' => 'required|string',
        ]);

        $customer = Customer::where('google_uid', $request->uid)
                    ->where('provider', 'google')
                    ->first();

        if (!$customer) {
            $customer = Customer::updateOrCreate([
                'google_uid' => $request->uid,
            ], [
                'name'      => $request->displayName,
                'email'     => $request->email,
                'provider'  => 'google',
                'is_verify' => 1,
                'image'     => $request->photoURL,
            ]);
        }

        auth()->guard('customers')->login($customer);
        $customer->save();
        $customer->tokens()->delete();
        $token = $customer->createToken('google_login')->accessToken;

        return response()->json([
            'token' => $token,
            'customer' => $customer,
            'is_google_login' => $customer->provider == 'google' ? 1 : 0,
        ]);
    }

    public function facebookLogin(Request $request)
    {
        $request->validate([
            'facebook_id' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email',
            'photo' => 'nullable|string',
        ]);

        $customer = Customer::where('facebook_uid', $request->facebook_id)
                            ->where('provider', 'facebook')
                            ->first();

        if (!$customer) {
            $customer = Customer::create([
                'facebook_uid' => $request->facebook_id,
                'name'         => $request->name,
                'email'        => $request->email,
                'provider'     => 'facebook',
                'image'        => $request->photo,
                'is_verify'    => 1
            ]);
        }

        auth()->guard('customers')->login($customer);
        $customer->tokens()->delete();
        $token = $customer->createToken('facebook_login')->accessToken;

        return response()->json([
            'success' => true,
            'token' => $token,
            'customer' => $customer,
            'is_facebook_login' => $customer->provider == 'facebook' ? 1 : 0,
        ]);
    }
}
