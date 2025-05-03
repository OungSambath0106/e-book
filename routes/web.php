<?php

use App\Models\BusinessSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Backends\BanerController;
use App\Http\Controllers\Backends\BrandController;
use App\Http\Controllers\Backends\RoleController;
use App\Http\Controllers\Backends\UserController;
use App\Http\Controllers\Backends\LanguageController;
use App\Http\Controllers\Backends\DashboardController;
use App\Http\Controllers\Backends\FileManagerController;
use App\Http\Controllers\Backends\BusinessSettingController;
use App\Http\Controllers\Backends\CustomerController;
use App\Http\Controllers\Backends\OrderController;
use App\Http\Controllers\Backends\ProductController;
use App\Http\Controllers\Backends\PromotionController;
use App\Http\Controllers\Backends\ShoesSliderController;

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

Route::get('/admin/login', function () {
    return redirect('/admin/login');
});

Route::get('/', function () {
    return view('website.home.index');
})->name('home');

Route::get('/shop', function () {
    return view('website.shop.index');
})->name('shop');

// Route::get('/book-detail/{id}', function ($id) {
//     return view('website.shop.partials.book_detail', compact('id'));
// })->name('book.detail');
Route::get('book/{id}', function ($id) {
    // Static data for books
    $books = [
        1 => [
            'id' => 1,
            'title' => 'ផ្ទះត្រើយស្ទឹងម្ខាង',
            'author' => 'តាំង​ ហ៊ុយសេង',
            'price' => '$11.99',
            'reviews' => 100,
            'discount_percentage' => 20,
            'barcode' => '1234567890',
            'format' => 'Paperback',
            'discount_price' => '11.99',
            'price' => '15.99',
            'pages' => 300,
            'rating' => 4.5,
            'thumbnail' => 'book1.webp',
            'description' => '',
        ],
        2 => [
            'id' => 2,
            'title' => '15ឆ្នាំក្រោយជួបគ្នា',
            'author' => 'ម៉ុង ម៉ានិត',
            'price' => '$12.99',
            'reviews' => 100,
            'discount_percentage' => 20,
            'barcode' => '1234567890',
            'format' => 'Paperback',
            'discount_price' => '12.99',
            'price' => '15.99',
            'pages' => 300,
            'rating' => 4.0,
            'thumbnail' => 'book2.webp',
            'description' => '',
        ],
    ];

    // Fetch the book data based on the ID passed in the URL
    $book = $books[$id] ?? null;

    // Return the view and pass the book data
    return view('website.shop.partials.book_detail', compact('book'));
})->name('book.detail');

Route::get('/categories', function () {
    return view('website.categories.index');
})->name('categories');

Route::get('/authors', function () {
    return view('website.authors.index');
})->name('authors');

Route::get('/author-detail', function () {
    return view('website.authors.partials.author_detail');
})->name('author.detail');

Auth::routes();

Route::redirect('/admin', '/admin/dashboard');
// Route::redirect('/admin', '/admin/highlight');

// save temp file
Route::post('save_temp_file', [FileManagerController::class, 'saveTempFile'])->name('save_temp_file');
Route::get('remove_temp_file', [FileManagerController::class, 'removeTempFile'])->name('remove_temp_file');

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

        //Route for role
        Route::resource('roles', RoleController::class);

        //Route for promotion
        Route::resource('promotion', PromotionController::class);
        Route::post('promotion/update_status', [PromotionController::class, 'updateStatus'])->name('promotion.update_status');
        Route::delete('promotion/delete/gallery',[PromotionController::class, 'deletePromotionGallery'])->name('promotion.delete_gallery');

        // Route Baner-Slider
        Route::post('banner-slider/update_status', [BanerController::class, 'updateStatus'])->name('banner-slider.update_status');
        Route::resource('banner-slider', BanerController::class);
        Route::post('banner-slider/delete-image', [BanerController::class, 'deleteImage'])->name('banner-slider.delete_image');

        //Route for onboard
        Route::resource('shoes-slider', ShoesSliderController::class);
        Route::post('shoes-slider/update_status', [ShoesSliderController::class, 'updateStatus'])->name('shoes-slider.update_status');
        Route::post('shoes-slider/delete-image', [ShoesSliderController::class, 'deleteImage'])->name('shoes-slider.delete_image');

        // Route Brand
        Route::post('brand/update_status', [BrandController::class, 'updateStatus'])->name('brand.update_status');
        Route::resource('brand', BrandController::class);
        Route::post('brand/delete-image', [BrandController::class, 'deleteImage'])->name('brand.delete_image');

        // Route Product
        Route::post('product/update_status', [ProductController::class, 'updateStatus'])->name('product.update_status');
        Route::resource('product', ProductController::class);
        Route::post('product/upload/gallery', [ProductController::class, 'uploadNewGallery'])->name('product.upload_gallery');
        Route::delete('product/delete/gallery',[ProductController::class, 'deleteProductGallery'])->name('product.delete_gallery');

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

Route::middleware(['auth:web'])->group(function () {
    Route::get('/logout', [LoginController::class,'logout'])->name('logout');
});
