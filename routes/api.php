<?php

use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\API\Auth\AuthApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// create api here


// (login)
Route::post('login', [ApiController::class, 'login']);

//Route for onboard
Route::get('get_shoes_sliders',[ApiController::class,'getShoesSlider']);
// (Get Promotion)
Route::get('get_promotions', [ApiController::class, 'getPromotion']);
// (Get Promotion Detail)
Route::get('get_promotion_detail', [ApiController::class, 'getPromotionDetail']);
// (Get Baner Slider)
Route::get('get_banner_sliders', [ApiController::class, 'getBannerSlider']);
// (Get Brand)
Route::get('get_brands', [ApiController::class, 'getBrand']);
// (Get Brand Detail)
Route::get('get_brand_detail', [ApiController::class, 'getBrandDetail']);
// (Get Product)
Route::get('get_products', [ApiController::class, 'getProduct']);
// (Get Product New Arrival)
Route::get('get_products_new_arrival', [ApiController::class, 'getProductNewArrival']);
// (Get Product Recommended)
Route::get('get_products_recommended', [ApiController::class, 'getProductRecommended']);
// (Get Product Popular)
Route::get('get_products_popular', [ApiController::class, 'getProductPopular']);
// (Get Product by Brand)
Route::get('get_products_by_brand', [ApiController::class, 'getProductByBrand']);
// (Search Product)
Route::get('/products/search', [ApiController::class, 'searchProduct']);
// (Get Product Detail)
Route::get('get_product_detail', [ApiController::class, 'GetProductDetail']);
// Business Setting
Route::get('get_config', [ApiController::class, 'getConfig']);

Route::middleware(['auth:customers'])->group(function () {
    Route::post('/orders', [ApiController::class, 'storeOrder']);
    Route::get('order/history', [ApiController::class, 'orderHistory']);
    Route::get('order/detail', [ApiController::class, 'orderDetail']);

    Route::get('customer-profile', [ApiController::class, 'customerProfile']);
    Route::post('update-profile', [ApiController::class, 'updateCustomerProfile']);
    Route::post('logout', [AuthApiController::class, 'logoutCustomer']);
    Route::delete('delete-account', [AuthApiController::class, 'deleteAccount']);
});

Route::post('/register-with-phone',[AuthApiController::class,'registerPhoneOTP']);
Route::post('/verify-otp',[AuthApiController::class,'verifyOTP']);
Route::post('login-with-phone', [AuthApiController::class, 'loginPhoneOTP']);
Route::post('forget-password', [AuthApiController::class, 'forgetPassword']);
Route::post('verify-otp-and-reset-password', [AuthApiController::class, 'verifyOTPAndResetPassword']);
Route::post('google-login', [AuthApiController::class, 'googleLogin']);
