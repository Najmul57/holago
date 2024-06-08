<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

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

//Admin routes
Route::namespace('Admin')->name('admin.')->prefix('admin')->group(function(){
    //Admin Auth Route
    Route::namespace('Auth')->group(function(){
        Route::get('/','LoginController@showLoginForm')->name('login');
        Route::post('/','LoginController@login')->name('login');
        Route::get('/logout','LoginController@logout')->name('logout');

        // Admin Password Reset middleware('demo')->
        Route::name('password.')->prefix('password')->group(function(){
            Route::get('reset', 'ForgotPasswordController@showCodeRequestForm')->name('reset');
            Route::post('reset', 'ForgotPasswordController@sendResetCodeEmail');
            Route::get('verify', 'ForgotPasswordController@verify')->name('verify');
            Route::post('verify-code', 'ForgotPasswordController@verifyCode')->name('verify.code');
            Route::get('reset/{token}', 'ResetPasswordController@showResetForm')->name('reset.change');
            Route::post('reset/change', 'ResetPasswordController@reset')->name('reset.submit');
        });

    });

    //Admin panel's Route
    Route::middleware('admin')->group(function(){
        //Dashboard
        Route::get('dashboard','AdminController@dashboard')->name('dashboard');

        //Admin Profile Area
        Route::get('profile','AdminController@profile')->name('profile');
        Route::post('profile-update','AdminController@profileUpdate')->name('profile.update');
        Route::get('password-change','AdminController@password')->name('password.change');
        Route::post('password-update','AdminController@passwordUpdate')->name('password.update');

        //Users Route
        Route::name('users.')->prefix('users')->group(function(){
            Route::get('list','UserController@list')->name('list');
            Route::get('active','UserController@active')->name('active');
            Route::get('banned','UserController@banned')->name('banned');
            Route::get('unverified','UserController@unverified')->name('unverified');
            Route::get('details/{id}','UserController@details')->name('details');
            Route::post('update/{id}','UserController@update')->name('update');
            Route::get('send/email/{id}','UserController@sendMailUser')->name('send.mail');
            Route::post('send/email/{id}','UserController@submitMailUser');
            Route::get('login/{id}','UserController@login')->name('login');

            // Login History Route
            Route::get('login/history/{id}', 'UserController@userLoginHistory')->name('login.history');
            Route::get('ip/history/{ip}', 'UserController@ipHistory')->name('ip.login.history');
            Route::get('email/history/{id}', 'UserController@userEmailHistory')->name('email.history');
            Route::get('email/details/{id}', 'UserController@userEmailDetails')->name('email.details');
        });

        // Email Setting
        Route::name('email.')->prefix('email')->group(function(){
            Route::get('general', 'EmailController@generalEmail')->name('general');
            Route::post('general', 'EmailController@generalEmailUpdate');
            Route::post('setting', 'EmailController@emailSettingUpdate')->name('setting');
            Route::post('method', 'EmailController@emailMethodUpdate')->name('method');
            Route::get('index', 'EmailController@index')->name('index');
            Route::get('edit/{id}', 'EmailController@edit')->name('edit');
            Route::post('update/{id}', 'EmailController@update')->name('update');
            Route::post('send-test-mail', 'EmailController@sendTestMail')->name('test.mail');
        });

        //Setting Route
        Route::name('setting.')->prefix('setting')->group(function(){
            Route::get('/','SettingController@index')->name('index');
            Route::post('update','SettingController@update')->name('update');

            //logo Route
            Route::get('logo-favicon','SettingController@logFav')->name('logfav');
            Route::post('logo-favicon/update','SettingController@logFavUpdate')->name('logfav.update');

            //Extensions Route
            Route::get('extensions', 'ExtensionController@index')->name('extensions.index');
            Route::post('extensions/update/{id}', 'ExtensionController@update')->name('extensions.update');
            Route::post('extensions/activate', 'ExtensionController@activate')->name('extensions.activate');
            Route::post('extensions/deactivate', 'ExtensionController@deactivate')->name('extensions.deactivate');

            //SEO Setting Route
            Route::get('seo','SettingController@seo')->name('seo');
            Route::post('seo','SettingController@seoUpdate');
        });
        //Language
        Route::name('language.')->prefix('language')->group(function(){
            Route::get('/','LanguageController@index')->name('index');
            Route::post('create','LanguageController@create')->name('create');
            Route::post('edit/{id}','LanguageController@edit')->name('edit');
            Route::post('delete/{id}','LanguageController@delete')->name('delete');
            Route::get('translate/{id}','LanguageController@langTranslate')->name('translate');
            Route::post('store/key/{id}', 'LanguageController@storeJson')->name('store.key');
            Route::post('update/key/{id}', 'LanguageController@updateJson')->name('update.key');
            Route::post('delete/key/{id}', 'LanguageController@deleteJson')->name('delete.key');
        });

        //Template Route
        Route::name('theme.')->prefix('theme')->group(function(){
            Route::get('item/{key}','DiagramController@item')->name('item');
            Route::get('item/basis/create/{key}','DiagramController@create')->name('basis.create');
            Route::get('item/basis/edit/{key}/{id}','DiagramController@edit')->name('basis.edit');
            Route::post('item/basis/{id?}','DiagramController@basisSave')->name('basis');
            Route::post('item/basis/remove/{id}','DiagramController@remove')->name('basis.remove');
        });


        //System Route
        Route::get('system-infomation','SettingController@systemInfo')->name('system.info');
        Route::get('optimize', 'SettingController@optimize')->name('optimize');

        //Cookie Route
        Route::get('cookie','SettingController@setCookie')->name('cookie');
        Route::post('cookie','SettingController@setCookieSubmit');

        //Login History Route
        Route::get('all/login/history', 'HistoryController@loginHistory')->name('all.login.history');
        //Payment
        Route::get('/payments', 'PaymentController@list')->name('payment.history');
        //Purchase
        Route::get('/purchase/list', 'PaymentController@purchaseList')->name('purchase.list');

        //Subscribers Route
        Route::get('subscribers','SubscriberController@index')->name('subscriber.index');
        Route::post('subscribers/delete/{id}','SubscriberController@delete')->name('subscriber.delete');
        Route::get('subscribers/send-email','SubscriberController@sendMail')->name('subscriber.sendMail');
        Route::post('subscribers/send-email','SubscriberController@submitMail');

        Route::get('/review/list',[\App\Http\Controllers\RatingReviewController::class,'index'])->name('review.index');
        Route::get('/review/{id}',[\App\Http\Controllers\RatingReviewController::class,'delete'])->name('review.delete');
        // Route for category
        Route::name('category.')->prefix('category')->group(function(){
            Route::get('/', 'CategoryController@index')->name('index');
            Route::get('create', 'CategoryController@create')->name('create');
            Route::post('store', 'CategoryController@store')->name('store');
            Route::get('edit/{id}', 'CategoryController@edit')->name('edit');
            Route::post('update/{id}', 'CategoryController@update')->name('update');
           Route::get('delete/{id}', 'CategoryController@destroy')->name('delete');
            Route::post('disable/', 'CategoryController@disable')->name('disable');
            Route::post('enable/', 'CategoryController@enable')->name('enable');
        });


        // Route for sub_category
        Route::name('sub_category.')->prefix('sub_category')->group(function(){
            Route::get('/', 'SubCategoryController@index')->name('index');
            Route::get('create', 'SubCategoryController@create')->name('create');
            Route::post('store', 'SubCategoryController@store')->name('store');
            Route::get('edit/{id}', 'SubCategoryController@edit')->name('edit');
            Route::post('update/{id}', 'SubCategoryController@update')->name('update');
              Route::get('delete/{id}', 'SubCategoryController@destroy')->name('delete');
            Route::post('disable/', 'SubCategoryController@disable')->name('disable');
            Route::post('enable/', 'SubCategoryController@enable')->name('enable');
        });

        // Route for attribute
        Route::name('attribute.')->prefix('attribute')->group(function(){
            Route::get('/', 'AttributeController@index')->name('index');
            Route::post('/', 'AttributeController@store');
            Route::post('update/{id}', 'AttributeController@update')->name('update');
            Route::post('delete/{id}', 'AttributeController@destroy')->name('delete');
            Route::post('disable/', 'AttributeController@disable')->name('disable');
            Route::post('enable/', 'AttributeController@enable')->name('enable');
        });
        // Route for product
        Route::name('product.')->prefix('product')->group(function(){
            Route::get('/', 'ProductController@index')->name('index');
            Route::get('create', 'ProductController@create')->name('create');
            Route::post('store', 'ProductController@store')->name('store');
            Route::get('/export', 'ProductController@export')->name('export');
            Route::get('edit/{id}', 'ProductController@edit')->name('edit');
            Route::get('/delete-image/{imageId}', 'ProductController@deleteImage')->name('delete.image');
            Route::post('update/{id}', 'ProductController@update')->name('update');
           Route::get('delete/{id}', 'ProductController@destroy')->name('delete');
            Route::post('disable/', 'ProductController@disable')->name('disable');
            Route::post('enable/', 'ProductController@enable')->name('enable');

            //attribute
            Route::get('add-variant/{id}', 'ProductController@createAttribute')->name('attribute-add');
            Route::post('add-variant/{id}', 'ProductController@storeAttribute')->name('attribute-store');
            Route::get('edit-variant/{pid}/{aid}', 'ProductController@editAttribute')->name('attribute-edit');
            Route::post('edit-variant-update/{id}', 'ProductController@updateAttribute')->name('attribute-update');
            Route::post('delete-variant/{id}', 'ProductController@deleteAttribute')->name('attribute-delete');

            Route::get('add-variant-images/{id}', 'ProductController@addVariantImages')->name('add-variant-images');
            Route::post('add-variant-images/{id}', 'ProductController@saveVariantImages');

            //Stock
            Route::get('stock', 'ProductStocksController@stock')->name('stock');
            Route::any('stock/create/{product_id}', 'ProductStocksController@stockCreate')->name('stock.create');
            Route::post('add-to-stock/{product_id}', 'ProductStocksController@stockAdd')->name('stock.add');
            Route::get('stock/{id}/', 'ProductStocksController@stockLog')->name('stock.log');

            Route::get('stocks', 'ProductStocksController@stocks')->name('stocks');
            Route::get('stocks/low', 'ProductStocksController@stocksLow')->name('stocks.low');
            Route::get('stocks/empty', 'ProductStocksController@stocksEmpty')->name('stocks.empty');
        });

        // Route for product_category
        Route::name('product_category.')->prefix('product_category')->group(function(){
            Route::get('/', 'ProductCategoryController@index')->name('index');
            Route::post('/', 'ProductCategoryController@store');
            Route::post('update/{id}', 'ProductCategoryController@update')->name('update');
            Route::post('delete/{id}', 'ProductCategoryController@destroy')->name('delete');
            Route::post('disable/', 'ProductCategoryController@disable')->name('disable');
            Route::post('enable/', 'ProductCategoryController@enable')->name('enable');
        });

        // Route for product_attribute
        Route::name('product_attribute.')->prefix('product_attribute')->group(function(){
            Route::get('/', 'ProductAttributeController@index')->name('index');
            Route::post('/', 'ProductAttributeController@store');
            Route::post('update/{id}', 'ProductAttributeController@update')->name('update');
            Route::post('delete/{id}', 'ProductAttributeController@destroy')->name('delete');
            Route::post('disable/', 'ProductAttributeController@disable')->name('disable');
            Route::post('enable/', 'ProductAttributeController@enable')->name('enable');
        });

        // Route for product_image
        Route::name('product_image.')->prefix('product_image')->group(function(){
            Route::get('/', 'ProductImageController@index')->name('index');
            Route::post('/', 'ProductImageController@store');
            Route::post('update/{id}', 'ProductImageController@update')->name('update');
            Route::post('delete/{id}', 'ProductImageController@destroy')->name('delete');
            Route::post('disable/', 'ProductImageController@disable')->name('disable');
            Route::post('enable/', 'ProductImageController@enable')->name('enable');
        });

        // Route for product_stocks
        Route::name('product_stocks.')->prefix('product_stocks')->group(function(){
            Route::get('/', 'ProductStocksController@index')->name('index');
            Route::post('/', 'ProductStocksController@store');
            Route::post('update/{id}', 'ProductStocksController@update')->name('update');
            Route::post('delete/{id}', 'ProductStocksController@destroy')->name('delete');
            Route::post('disable/', 'ProductStocksController@disable')->name('disable');
            Route::post('enable/', 'ProductStocksController@enable')->name('enable');
        });

        // Route for product_review
        Route::name('product_review.')->prefix('product_review')->group(function(){
            Route::get('/', 'ProductReviewController@index')->name('index');
            Route::post('/', 'ProductReviewController@store');
            Route::post('update/{id}', 'ProductReviewController@update')->name('update');
            Route::post('delete/{id}', 'ProductReviewController@destroy')->name('delete');
            Route::post('disable/', 'ProductReviewController@disable')->name('disable');
            Route::post('enable/', 'ProductReviewController@enable')->name('enable');
        });

        // Route for shipping
        Route::name('shipping.')->prefix('shipping')->group(function(){
            Route::get('/', 'ShippingController@index')->name('index');
            Route::post('/', 'ShippingController@store');
            Route::post('update/{id}', 'ShippingController@update')->name('update');
            Route::post('delete/{id}', 'ShippingController@destroy')->name('delete');
            Route::post('disable/', 'ShippingController@disable')->name('disable');
            Route::post('enable/', 'ShippingController@enable')->name('enable');
        });

        // Route for order
        Route::name('order.')->prefix('order')->group(function(){
            Route::get('/', 'OrderController@index')->name('index');
            Route::get('create', 'OrderController@create')->name('create');
            Route::post('store', 'OrderController@store')->name('store');
            Route::get('edit/{id}', 'OrderController@edit')->name('edit');
            Route::get('details/{id}', 'OrderController@orderDetails')->name('show');
            Route::post('update/{id}', 'OrderController@update')->name('update');
             Route::get('delete/{id}', 'OrderController@destroy')->name('delete');
            Route::post('disable/', 'OrderController@disable')->name('disable');
            Route::post('enable/', 'OrderController@enable')->name('enable');
            Route::get('print/{id}', 'OrderController@print')->name('print');
            Route::put('/change/status/{id}', 'OrderController@changeStatus')->name('change_status');
            Route::put('/cancelled/status/{id}', 'OrderController@cancellStatus')->name('cancelled_status');
            Route::get('/item/{id}', 'OrderController@removeItem')->name('item.delete');
            
            Route::get("get-product-attribute/{id}", 'OrderController@getProductAttribute')->name('get-product-attribute');
            Route::get("get-product-attribute-quantity/{id}", 'OrderController@getProductAttributeQuantity')->name('get-product-attribute-quantity');
            Route::post("/productStore", 'OrderController@productStore')->name('productStore');
        });

        // Route for order_details
        Route::name('order_details.')->prefix('order_details')->group(function(){
            Route::get('/', 'OrderDetailsController@index')->name('index');
            Route::get('create', 'OrderDetailsController@create')->name('create');
            Route::post('store', 'OrderDetailsController@store')->name('store');
            Route::get('edit/{id}', 'OrderDetailsController@edit')->name('edit');
            Route::post('update/{id}', 'OrderDetailsController@update')->name('update');
            Route::post('delete/{id}', 'OrderDetailsController@destroy')->name('delete');
            Route::post('disable/', 'OrderDetailsController@disable')->name('disable');
            Route::post('enable/', 'OrderDetailsController@enable')->name('enable');
        });

        // Route for coupon
        Route::name('coupon.')->prefix('coupon')->group(function(){
            Route::get('/', 'CouponController@index')->name('index');
            Route::post('/', 'CouponController@store')->name('store');
            Route::post('update/{id}', 'CouponController@update')->name('update');
            Route::post('disable/', 'CouponController@disable')->name('disable');
            Route::post('enable/', 'CouponController@enable')->name('enable');
        });

        // Route for coupon_category
        Route::name('coupon_category.')->prefix('coupon_category')->group(function(){
            Route::get('/', 'CouponCategoryController@index')->name('index');
            Route::get('create', 'CouponCategoryController@create')->name('create');
            Route::post('store', 'CouponCategoryController@store')->name('store');
            Route::get('edit/{id}', 'CouponCategoryController@edit')->name('edit');
            Route::post('update/{id}', 'CouponCategoryController@update')->name('update');
            Route::post('delete/{id}', 'CouponCategoryController@destroy')->name('delete');
            Route::post('disable/', 'CouponCategoryController@disable')->name('disable');
            Route::post('enable/', 'CouponCategoryController@enable')->name('enable');
        });

        // Route for coupon_category
        Route::name('coupon_category.')->prefix('coupon_category')->group(function(){
            Route::get('/', 'CouponCategoryController@index')->name('index');
            Route::get('create', 'CouponCategoryController@create')->name('create');
            Route::post('store', 'CouponCategoryController@store')->name('store');
            Route::get('edit/{id}', 'CouponCategoryController@edit')->name('edit');
            Route::post('update/{id}', 'CouponCategoryController@update')->name('update');
            Route::post('delete/{id}', 'CouponCategoryController@destroy')->name('delete');
            Route::post('disable/', 'CouponCategoryController@disable')->name('disable');
            Route::post('enable/', 'CouponCategoryController@enable')->name('enable');
        });

        // Route for coupon_category
        Route::name('coupon_category.')->prefix('coupon_category')->group(function(){
            Route::get('/', 'CouponCategoryController@index')->name('index');
            Route::post('/', 'CouponCategoryController@store');
            Route::post('update/{id}', 'CouponCategoryController@update')->name('update');
            Route::post('delete/{id}', 'CouponCategoryController@destroy')->name('delete');
            Route::post('disable/', 'CouponCategoryController@disable')->name('disable');
            Route::post('enable/', 'CouponCategoryController@enable')->name('enable');
        });

        // Route for offer
        Route::name('offer.')->prefix('offer')->group(function(){
            Route::get('/', 'OfferController@index')->name('index');
            Route::post('/', 'OfferController@store');
            Route::post('update/{id}', 'OfferController@update')->name('update');
            Route::post('delete/{id}', 'OfferController@destroy')->name('delete');
            Route::post('disable/', 'OfferController@disable')->name('disable');
            Route::post('enable/', 'OfferController@enable')->name('enable');
        });

        // Route for offer_product
        Route::name('offer_product.')->prefix('offer_product')->group(function(){
            Route::get('/', 'OfferProductController@index')->name('index');
            Route::post('/', 'OfferProductController@store');
            Route::post('update/{id}', 'OfferProductController@update')->name('update');
            Route::post('delete/{id}', 'OfferProductController@destroy')->name('delete');
            Route::post('disable/', 'OfferProductController@disable')->name('disable');
            Route::post('enable/', 'OfferProductController@enable')->name('enable');
        });

        // Route for wishlist
        Route::name('wishlist.')->prefix('wishlist')->group(function(){
            Route::get('/', 'WishlistController@index')->name('index');
            Route::post('/', 'WishlistController@store');
            Route::post('update/{id}', 'WishlistController@update')->name('update');
            Route::post('delete/{id}', 'WishlistController@destroy')->name('delete');
            Route::post('disable/', 'WishlistController@disable')->name('disable');
            Route::post('enable/', 'WishlistController@enable')->name('enable');
        });

        // Route for cart
        Route::name('cart.')->prefix('cart')->group(function(){
            Route::get('/', 'CartController@index')->name('index');
            Route::post('/', 'CartController@store');
            Route::post('update/{id}', 'CartController@update')->name('update');
            Route::post('delete/{id}', 'CartController@destroy')->name('delete');
            Route::post('disable/', 'CartController@disable')->name('disable');
            Route::post('enable/', 'CartController@enable')->name('enable');
        });
        Route::get('/delete/item/{id}','OrderController@removeItem')->name('item_remove');
        Route::post('/update-order/{id}','OrderController@orderUpdate')->name('order_update');
        // Checkout (URL) Admin Part
        Route::get('/bkash/refund', [\App\Http\Controllers\BkashPaymentController::class, 'getRefund'])->name('url-get-refund');
        Route::post('/bkash/refund', [\App\Http\Controllers\BkashPaymentController::class, 'refundPayment'])->name('url-post-refund');
    });
});