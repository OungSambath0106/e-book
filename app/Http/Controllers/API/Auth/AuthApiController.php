<?php

namespace App\Http\Controllers\API\Auth;

use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\helpers\GlobalFunction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthApiController extends Controller
{
    public function registerPhoneOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        try {
            $phone = $request->phone;

            $existingCustomer = Customer::where('phone', $phone)->first();
            if ($existingCustomer && $existingCustomer->is_verify == 1) {
                return response()->json(['message' => 'Phone number has already been registered'], 400);
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

                return response()->json(['otp' => $otp], 200);
            } else {
                return response()->json(['message' => 'Failed to send OTP'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function verifyOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'otp' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        try {
            $phone = $request->phone;
            $otp = $request->otp;

            $cachedOtp = Cache::get('otp_' . $phone);
            if ($otp != $cachedOtp) {
                return response()->json(['message' => 'Phone and OTP do not match'], 400);
            }

            $name = $request->name;
            $password = $request->password;
            $confirmPassword = $request->confirm_password;

            $additionalValidator = Validator::make($request->all(), [
                'name' => 'required|string',
                'password' => 'required|string|min:6',
                'confirm_password' => 'required|string|min:6',
            ]);

            if ($additionalValidator->fails()) {
                return response()->json(['error' => $additionalValidator->errors()], 400);
            }

            if ($password !== $confirmPassword) {
                return response()->json(['message' => 'Password and confirm password do not match'], 400);
            }

            $customer = Customer::where('phone', $phone)->first();
            if (!$customer) {
                $customer = new Customer();
                $customer->phone = $phone;
                $customer->provider = 'phone';
            }

            $customer->name = $name;
            $customer->is_verify = 1;
            $customer->provider = 'phone';
            if (!empty($password)) {
                $customer->password = $password;
            }
            $customer->save();

            $apiToken = $customer->createToken('PhoneLogin')->accessToken;
            Cache::forget('otp_' . $phone);
            $customer_info = [
                'token' => $apiToken,
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
                'message' => 'Registered and logged in successfully',
                'success' => true,
                'customer_info' => $customer_info,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function loginPhoneOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        try {
            $credentials = $request->only('phone', 'password');
            $customer = Customer::where('phone', $credentials['phone'])->first();

            if (!$customer || !Hash::check($credentials['password'], $customer->password)) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            $customer->tokens->each(function ($token) {
                $token->delete();
            });

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
                'message' => 'Login successful',
                'success' => true,
                'customer_info' => $customer_info,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }

    public function logoutCustomer(Request $request)
    {
        try {
            $customer = $request->user();

            $customer->tokens->each(function ($token) {
                $token->delete();
            });

            return response()->json([
                'message' => 'Logged out successfully',
                'success' => true,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }

    public function forgetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $phone = $request->phone;
        $customer = Customer::where('phone', $phone)->first();

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $otp = rand(100000, 999999);
        Cache::put('otp_' . $phone, $otp, now()->addMinutes(5));

        $response = GlobalFunction::sendOTP($phone, $otp);
        if ($response) {
            return response()->json(['otp' => $otp], 200);
        } else {
            return response()->json(['message' => 'Failed to send OTP'], 500);
        }
    }

    public function verifyOTPAndResetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
            'otp' => 'required|numeric',
            'new_password' => 'required|string|min:6',
            'confirm_password' => 'required|string|same:new_password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $phone = $request->phone;
        $otp = $request->otp;
        $newPassword = $request->new_password;

        $cachedOtp = Cache::get('otp_' . $phone);

        if (!$cachedOtp || $cachedOtp != $otp) {
            return response()->json(['message' => 'Phone number and OTP do not match'], 400);
        }

        $customer = Customer::where('phone', $phone)->first();
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $customer->password = $newPassword;
        $customer->save();

        Cache::forget('otp_' . $phone);

        return response()->json([
            'message' => 'Password has been reset successfully',
            'success' => true,
        ], 200);
    }

    public function googleLogin(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'email' => 'required|email',
            'displayName' => 'required|string',
            'photoURL' => 'nullable|string',
            'uid' => 'required|string',
        ]);

        $customer = Customer::where('google_uid', $request->uid)
                    ->select('id','name','email','phone','image','is_verify','google_uid')
                    ->where('provider', 'google')
                    ->first();
                    // ->makeHidden('image');

        if (!$customer) {
            $customer = Customer::updateOrCreate([
                'google_uid'  => $request->uid,
            ],[
                'name'        => $request->displayName,
                'email'       => $request->email,
                'provider'    => 'google',
                'is_verify'   => 1,
                'image'       => $request->photoURL,
            ]);
        }

        $customer->tokens()->delete();
        $token = $customer->createToken('google_login')->accessToken;

        return response()->json([
            'token' => $token,
            'customer' => $customer,
            'is_google_login' => 1,
        ]);
    }

    public function deleteAccount(Request $request)
    {
        $customer = $request->user();

        // Revoke all tokens first
        $customer->tokens()->delete();

        // Soft delete the customer account
        $customer->delete();

        return response()->json([
            'message' => 'Account deleted successfully',
            'success' => true,
        ], 200);
    }
}
