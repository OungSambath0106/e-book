<?php

use App\Http\Controllers\Websites\ShopController;
use App\Models\BusinessSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Backends\AuthorController;
use App\Http\Controllers\Backends\BanerController;
use App\Http\Controllers\Backends\RoleController;
use App\Http\Controllers\Backends\UserController;
use App\Http\Controllers\Backends\LanguageController;
use App\Http\Controllers\Backends\DashboardController;
use App\Http\Controllers\Backends\FileManagerController;
use App\Http\Controllers\Backends\BusinessSettingController;
use App\Http\Controllers\Backends\CategoryController;
use App\Http\Controllers\Backends\CustomerController;
use App\Http\Controllers\Backends\OrderController;
use App\Http\Controllers\Backends\ProductController;
use App\Http\Controllers\Backends\PromotionController;
use App\Http\Controllers\Websites\Auth\AuthController as WebsitesAuthController;
use App\Http\Controllers\Websites\AuthorController as WebsitesAuthorController;
use App\Http\Controllers\Websites\CategoryController as WebsitesCategoryController;
use App\Http\Controllers\Websites\CheckoutController;
use App\Http\Controllers\Websites\HomeController as WebsitesHomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// change language
Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    $language = \App\Models\BusinessSetting::where('type', 'language')->first();
    session()->put('language_settings', $language);
    return redirect()->back();
})->name('change_language');

// Customer routes
Route::get('/register', [WebsitesAuthController::class, 'showRegisterForm'])->name('customer.registerForm');
Route::post('/registerPhoneOTP', [WebsitesAuthController::class, 'registerPhoneOTP'])->name('customer.registerPhoneOTP');
Route::post('/resend-otp', [WebsitesAuthController::class, 'resendOTP'])->name('customer.resendOTP');
Route::post('/verify-only-otp', [WebsitesAuthController::class, 'verifyOnlyOTP'])->name('customer.verifyOnlyOTP');
Route::get('/setup-account', [WebsitesAuthController::class, 'showSetupForm'])->name('customer.setupForm');
Route::post('/setup-account', [WebsitesAuthController::class, 'setupAccount'])->name('customer.setupAccount');
Route::get('/login', [WebsitesAuthController::class, 'showLoginForm'])->name('customer.loginForm');
Route::post('/login', [WebsitesAuthController::class, 'loginPhoneOTP'])->name('customer.login');
Route::post('/customer/logout', [WebsitesAuthController::class, 'logout'])->name('customer.logout');

// website routes
Route::get('/', [WebsitesHomeController::class, 'index'])->name('home');
Route::get('/books/all', [WebsitesHomeController::class, 'showAllBooks'])->name('all.books.show');
Route::get('/books/search', [WebsitesHomeController::class, 'searchBooks'])->name('books.search');
Route::get('/categories', [WebsitesCategoryController::class, 'index'])->name('categories');
Route::get('/categories/filter-products/{categoryId}', [WebsitesCategoryController::class, 'filterProducts'])->name('categories.filter-products');
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
// Route::post('/shop/add-to-cart', [ShopController::class, 'addToCart'])->name('add.to.cart');
Route::get('/shop/filter-products/{categoryId}', [ShopController::class, 'filterProducts'])->name('shop.filter');
Route::get('/book-detail/{id}', [ShopController::class, 'bookDetail'])->name('book.detail');
Route::get('/authors', [WebsitesAuthorController::class, 'index'])->name('authors');
Route::get('/author-detail/{id}', [WebsitesAuthorController::class, 'show'])->name('author.detail');

Route::middleware(['web', 'CheckUserLogin', 'SetSessionData'])->group(function () {
    Route::post('/shop/add-to-cart', [ShopController::class, 'addToCart'])->name('add.to.cart');
    Route::post('/shop/buy-now', [ShopController::class, 'buyNow'])->name('buy.now');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/save-address', [CheckoutController::class, 'saveAddress'])->name('checkout.save-address');
    Route::post('/cart/update-quantity', [CheckoutController::class, 'updateQuantity'])->name('cart.update-quantity');
    Route::post('/cart/remove-item', [CheckoutController::class, 'removeItem'])->name('cart.remove-item');
});

// Auth::routes();

// admin login
Route::prefix('admin')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
});

// back-end
Route::middleware(['auth','CheckUserLogin', 'SetSessionData'])->group(function () {

    Route::group(['prefix'=>'admin', 'as'=>'admin.'], function () {

        Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard');

        // setting
        Route::group(['prefix' => 'setting', 'as' => 'setting.'], function () {
            Route::get('/', [BusinessSettingController::class, 'index'])->name('index');
            Route::put('/update', [BusinessSettingController::class, 'update'])->name('update');

            // mail
            Route::get('/mail', [BusinessSettingController::class, 'smtp_settings'])->name('smtp_settings.index');
            Route::put('/mail', [BusinessSettingController::class, 'update_environment'])->name('update.environment');

            // language setup
            Route::group(['prefix' => 'language', 'as' => 'language.'], function () {
                Route::get('/', [LanguageController::class, 'index'])->name('index');
                Route::get('/create', [LanguageController::class, 'create'])->name('create');
                Route::post('/', [LanguageController::class, 'store'])->name('store');
                Route::get('/edit', [LanguageController::class, 'edit'])->name('edit');
                Route::put('/update', [LanguageController::class, 'update'])->name('update');
                Route::delete('delete/', [LanguageController::class, 'delete'])->name('delete');

                Route::get('/update-status', [LanguageController::class, 'updateStatus'])->name('update-status');
                Route::get('/update-default-status', [LanguageController::class, 'update_default_status'])->name('update-default-status');
                Route::get('/translate', [LanguageController::class, 'translate'])->name('translate');
                Route::post('translate-submit/{lang}', [LanguageController::class, 'translate_submit'])->name('translate.submit');
            });
        });
        // Route for user
        Route::get('/show_info/{id}', [UserController::class, 'showProfile'])->name('show_info');
        Route::POST('/update_info/{id}', [UserController::class, 'updateProfile'])->name('update_info');
        Route::resource('user', UserController::class);
        Route::post('user/delete-image', [UserController::class, 'deleteImage'])->name('user.delete_image');

        //Route for Customer
        Route::resource('customer', CustomerController::class);
        Route::post('customer/delete-image', [CustomerController::class, 'deleteImage'])->name('customer.delete_image');
        Route::post('customer/update_status', [CustomerController::class, 'updateStatus'])->name('customer.update_status');

        //Route for Author
        Route::resource('author', AuthorController::class);
        Route::post('author/delete-image', [AuthorController::class, 'deleteImage'])->name('author.delete_image');

        //Route for role
        Route::resource('roles', RoleController::class);

        //Route for promotion
        Route::resource('promotion', PromotionController::class);
        Route::post('promotion/update_status', [PromotionController::class, 'updateStatus'])->name('promotion.update_status');
        Route::delete('promotion/delete/gallery',[PromotionController::class, 'deletePromotionGallery'])->name('promotion.delete_gallery');

        // Route Baner
        Route::post('banner/update_status', [BanerController::class, 'updateStatus'])->name('banner.update_status');
        Route::resource('banner', BanerController::class);
        Route::post('banner/delete-image', [BanerController::class, 'deleteImage'])->name('banner.delete_image');

        // Route Category
        Route::post('category/update_status', [CategoryController::class, 'updateStatus'])->name('category.update_status');
        Route::resource('category', CategoryController::class);
        Route::post('category/delete-image', [CategoryController::class, 'deleteImage'])->name('category.delete_image');

        // Route Product
        Route::post('product/update_status', [ProductController::class, 'updateStatus'])->name('product.update_status');
        Route::resource('product', ProductController::class);
        Route::post('product/delete-image', [ProductController::class, 'deleteImage'])->name('product.delete_image');
        Route::get('product/barcode/{id}', [ProductController::class, 'barcode'])->name('product.barcode');
        // Route::post('product/upload/gallery', [ProductController::class, 'uploadNewGallery'])->name('product.upload_gallery');
        // Route::delete('product/delete/gallery',[ProductController::class, 'deleteProductGallery'])->name('product.delete_gallery');

        // Route Transaction
        Route::post('order/update_status', [OrderController::class, 'updateStatus'])->name('order.update_status');
        Route::resource('order', OrderController::class);
        Route::get('order/{id}', [OrderController::class, 'show'])->name('order.show');
        Route::get('order/edit-address', [OrderController::class, 'editAddress'])->name('order.edit-address');
        Route::get('order/invoice/pdf/{id}', [OrderController::class, 'invoicePdf'])->name('order.invoice.pdf');
        Route::post('order/update_payment_status/{id}', [OrderController::class, 'updatePaymentStatus'])->name('order.update_payment_status');
        Route::post('order/update_order_status/{id}', [OrderController::class, 'updateOrderStatus'])->name('order.update_order_status');
    });
});

// save temp file
Route::post('save_temp_file', [FileManagerController::class, 'saveTempFile'])->name('save_temp_file');
Route::get('remove_temp_file', [FileManagerController::class, 'removeTempFile'])->name('remove_temp_file');

Route::middleware(['auth:web'])->group(function () {
    Route::get('/logout', [LoginController::class,'logout'])->name('logout');
});
