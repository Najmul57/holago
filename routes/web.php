<?php

use App\Http\Controllers\PublicSslCommerzPaymentController;
use App\Http\Controllers\SslCommerzPaymentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\BkashController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderConteoller;




//User routes
Route::name('user.')->prefix('user')->group(function () {
    //User Auth Route
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');
    Route::get('test_verify', 'Auth\RegisterController@testVerify')->name('testVerify');
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');

    // User Password Reset
    Route::name('password.')->prefix('password')->group(function () {
        Route::get('reset', 'Auth\ForgotPasswordController@showCodeRequestForm')->name('reset');
        Route::post('reset', 'Auth\ForgotPasswordController@sendResetCodeEmail');
        Route::get('verify', 'Auth\ForgotPasswordController@verify')->name('verify');
        Route::post('verify-code', 'Auth\ForgotPasswordController@verifyCode')->name('verify.code');
        Route::get('reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('reset.change');
        Route::post('reset/change', 'Auth\ResetPasswordController@reset')->name('reset.submit');
    });

    Route::middleware('auth')->group(function () {
        //Verification
        Route::get('verification', 'Auth\VerificationController@index')->name('verification');
        Route::get('verify/resend', 'Auth\VerificationController@verifyResend')->name('verify.resend');
        Route::get('verify/{hash}', 'Auth\VerificationController@verify')->name('verify');
        Route::post('verify-sms', 'Auth\VerificationController@smsVerification')->name('verify_sms');
        Route::get('verification/banned', 'Auth\VerificationController@banned')->name('banned');

        Route::middleware('verified')->group(function () {
            //Dashboard
            Route::get('dashboard', 'UserController@dashboard')->name('dashboard');
            Route::get('my-order', 'UserController@myOrder')->name('my.order');
            Route::get('my-order/{id}', 'UserController@myOrderDetails')->name('my.order.data');

            //Edit Profile
            Route::get('address-update', 'UserController@addressUp')->name('address.update');
            Route::get('edit/profile', 'UserController@editProfile')->name('edit.profile');
            Route::post('edit/profile', 'UserController@updateProfile');
            Route::post('profile/update', 'UserController@editUpdate')->name('profile.update');
            Route::post('profile/image-update', 'UserController@imageUpdate')->name('profile.image.update');
            Route::post('profile/cover/image-update', 'UserController@coverImageUpdate')->name('profile.cover.image.update');


            Route::get('my-points/', 'UserController@myPoints')->name('my.points');
            Route::post('my-points/', 'UserController@userBirthday')->name('birthday.update');
            Route::post('/checkout/{type}', 'OrderController@confirmOrder')->name('checkout-to-payment');
        });
    });
});

Route::get('/', 'SiteController@home')->name('home');
//Product section
Route::get('/product-details/{slug}', 'SiteController@productDetails')->name('product.details');
Route::get('/product/view/modal/{id}', 'SiteController@ProductViewAjax')->name('product.view');
Route::post('/get-stock-by-atrribute','SiteController@getStockByAttribute')->name('product.getStockByAttribute');



Route::get('category/{slug}', 'SiteController@productsByCategory')->name('products.category');
Route::get('subcategory/{slug}', 'SiteController@productsBySubCategory')->name('products.subcategory');
Route::get('/shop', 'SiteController@shop')->name('shop');
Route::get('/products/sort', 'SiteController@sort')->name('sort_by');

Route::get('/about', 'HomeController@about')->name('about-us');
Route::get('/location', 'HomeController@location')->name('location');
Route::get('/user/privacy-policy', 'HomeController@privacyPolicy')->name('privacy.policy');
Route::get('/membership', 'HomeController@club')->name('holago.club');
Route::get('/user/refund', 'HomeController@refund')->name('refund');
Route::get('/tou', 'HomeController@tou')->name('tou');
Route::get('/request-callback', 'HomeController@requestCallback')->name('request-callback');
Route::get('/order-tracking', 'HomeController@orderTracking')->name('order-tracking');
Route::get('/need/help', 'HomeController@needHelp')->name('need-help');

Route::get('/career-tips', 'SiteController@blog')->name('blog');
Route::get('/career-tips/{slug}/{id}', 'SiteController@blogDetails')->name('blog.details');
Route::get('/about-us', 'SiteController@about')->name('about');
Route::get('language/{code}', 'SiteController@changeLang');
Route::post('subscribe', 'SiteController@subscribe')->name('subscribe');
Route::get('links/{id}', 'SiteController@linkDetails')->name('link.details');
Route::get('contact', 'SiteController@contact')->name('contact');
Route::post('contact', 'SiteController@contactSubmit');
Route::get('/cookie/accept', 'SiteController@cookieAccept')->name('cookie.accept');

//Wishlist
Route::get('add_to_wishlist/', 'WishlistController@addToWishList')->name('add-to-wishlist');
Route::get('get_wishlist_data/', 'WishlistController@getWsihList')->name('get-wishlist-data');
Route::get('get_wishlist_total/', 'WishlistController@getWsihListTotal')->name('get-wishlist-total');
Route::get('wishlist/', 'WishlistController@wishList')->name('wishlist');
Route::get('wishlist/remove/{id}', 'WishlistController@removeFromwishList')->name('removeFromWishlist')->where('id', '[0-9]+');;

//Cart
Route::post('add_to_cart/', 'CartController@addToCart')->name('add-to-cart');
Route::get('get_cart/', 'CartController@getCart')->name('get-cart-data');
Route::get('get_cart-total/', 'CartController@getCartTotal')->name('get-cart-total');
Route::get('mycart/', 'CartController@shoppingCart')->name('shopping-cart');

Route::post('update-cart',        "CartController@update")->name("update-cart");

Route::post('help/store/', 'SiteController@needHelp')->name('need.help');
Route::get('order/track/', 'SiteController@orderTrack')->name('order.track');

//search
Route::get('search', 'SiteController@search')->name('search');
Route::get('offer/product', 'SiteController@offerProduct')->name('offer.product');
Route::get('search/by/category', 'SiteController@sortByCategory')->name('search.by.category');

Route::post('apply_coupon/', 'CartController@applyCoupon')->name('applyCoupon');
Route::post('remove_coupon/', 'CouponController@removeCoupon')->name('removeCoupon');
Route::post('remove_cart_item/{id}', 'CartController@removeCartItem')->name('remove-cart-item');
Route::post('update_cart_item/{id}', 'CartController@updateCartItem')->name('update-cart-item');
Route::get('product/get-stock-by-variant/', 'SiteController@getStockByVariant')->name('product.get-stock-by-variant');
Route::get('product/get-image-by-variant/', 'SiteController@getImageByVariant')->name('product.get-image-by-variant');

Route::post('ipn/stripe', 'SiteController@stripeIpn')->name('ipn.stripe');
Route::post('ipn/paypal', 'SiteController@paypalIpn')->name('ipn.paypal');
Route::post('ipn/skrill', 'SiteController@skrillIpn')->name('ipn.skrill');
Route::post('ipn/razorpay', 'SiteController@razorpayIpn')->name('ipn.razorpay');
Route::get('ipn/flutterwave/{trx_number}/{type}', 'SiteController@flutterwaveIpn')->name('ipn.flutterwave');
Route::get('quick-view/', 'SiteController@quickView')->name('quick-view');
Route::post('/review/store', [\App\Http\Controllers\RatingReviewController::class, 'store'])->name('review.store');

// point redeem
Route::post('point/redeem', 'OrderConteoller@redeem')->name('point.redeem');

//check out
Route::get('checkout/', 'CartController@checkout')->name('checkout');
Route::post('order/store', 'OrderConteoller@saveOrder')->name('order.store');
Route::get('order/success','OrderConteoller@successOrder')->name('order.success');
Route::get('order/failed','OrderConteoller@failedOrder')->name('order.failed');
Route::get('order/cancel','OrderConteoller@cancelOrder')->name('order.cancel');



Route::post('/checkout/payment', [OrderConteoller::class, 'payment'])->name('checkout.payment');

// Checkout (URL) User Part
Route::get('/bkash/pay', [\App\Http\Controllers\BkashPaymentController::class, 'payment'])->name('url-pay');
Route::post('/bkash/create', [\App\Http\Controllers\BkashPaymentController::class, 'createPayment'])->name('url-create');
Route::get('/bkash/callback', [\App\Http\Controllers\BkashPaymentController::class, 'callback'])->name('url-callback');


// SSLCOMMERZ Start
Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
Route::get('/HostedCheckout', [SslCommerzPaymentController::class, 'exampleHostedCheckout'])->name('hosted.checkout');

Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END


Route::get('/export/{filename}', 'SiteController@export')->name('export');