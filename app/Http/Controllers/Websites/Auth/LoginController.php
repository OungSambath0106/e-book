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
            return redirect()->back()->withErrors(['phone' => 'Phone number has already been registered']);
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

            return redirect()->route('verify.otp.form')->with('phone', $phone);
        }

        return redirect()->back()->withErrors(['otp' => 'Failed to send OTP']);
    }

    public function showVerifyForm()
    {
        $phone = session('phone');
        if (!$phone) return redirect()->route('register.form');

        return view('website.auth.verify_otp', compact('phone'));
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'otp' => 'required|numeric',
            'name' => 'required|string',
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|string|min:6|same:password',
        ]);

        $phone = $request->phone;
        $otp = $request->otp;

        $cachedOtp = Cache::get('otp_' . $phone);
        if ($otp != $cachedOtp) {
            return redirect()->back()->withErrors(['otp' => 'Phone and OTP do not match']);
        }

        $customer = Customer::where('phone', $phone)->first();
        if (!$customer) {
            $customer = new Customer();
            $customer->phone = $phone;
            $customer->provider = 'phone';
        }

        $customer->name = $request->name;
        $customer->is_verify = 1;
        $customer->provider = 'phone';
        $customer->password = Hash::make($request->password);
        $customer->save();

        auth()->login($customer);

        Cache::forget('otp_' . $phone);

        return redirect()->route('home')->with('success', 'Registered and logged in successfully');
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
            return redirect()->back()->withErrors(['login' => 'Invalid credentials']);
        }

        auth()->login($customer);

        return redirect()->route('home')->with('success', 'Login successful');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('sign-in')->with('success', 'Logged out successfully');
    }
}
