<?php

use App\Http\Controllers\admin\AdminAccountSettingController;
use App\Http\Controllers\admin\AdminBrandController;
use App\Http\Controllers\admin\AdminCategoryController;
use App\Http\Controllers\admin\AdminCustomerController;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\AdminDashBoardController;
use App\Http\Controllers\admin\AdminProductController;
use App\Http\Controllers\admin\AdminTempController;
use App\Http\Controllers\admin\AdminUserController;
use App\Http\Controllers\admin\AdminDisCountCodeController;
use App\Http\Controllers\admin\AdminOrderController;
use App\Http\Controllers\admin\AdminPageController;
use App\Http\Controllers\admin\AdminPostController;
use App\Http\Controllers\admin\AdminSliderController;
use App\Http\Controllers\client\AccountController;
use App\Http\Controllers\client\CartController;
use App\Http\Controllers\client\CheckoutController;
use App\Http\Controllers\client\HomeController;
use App\Http\Controllers\client\PostController;
use App\Http\Controllers\client\ShopController;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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
//*Front-End
Route::get('/', [HomeController::class, 'index'])->name('home');
//* Login
Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [AccountController::class, 'login'])->name('login');
    Route::post('/login/check', [AccountController::class, 'checkLogin'])->name('login.check');
    Route::get('/register', [AccountController::class, 'register'])->name('register');
    Route::post('/register/store', [AccountController::class, 'registerStore'])->name('register.store');
    Route::get('/verify/{rememberToken}', [AccountController::class, 'verify'])->name('verify');
    Route::get('/verify-successfully', [AccountController::class, 'verifySuccessfully'])->name('verify.successfully');
    Route::get('/verify-fail', [AccountController::class, 'verifyFail'])->name('verify.fail');
});

Route::group(['middleware' => 'auth.login'], function () {
    //Account 
    Route::get('/account', [AccountController::class, 'account'])->name('account');
    Route::post('/account/update/{customer}', [AccountController::class, 'update'])->name('account.update');
    Route::get('/account/change-password', [AccountController::class, 'changePassword'])->name('account.changePassword');
    Route::post('/account/change-password/{customer}', [AccountController::class, 'changePasswordStore'])->name('account.changePassword.store');
    Route::get('/account/logout', [AccountController::class, 'logout'])->name('account.logout');
    Route::get('/account/wishlist', [AccountController::class, 'wishlist'])->name('account.wishlist');
    Route::get('/account/wishlist-remove/{id}', [AccountController::class, 'wishlistRemove'])->name('account.wishlistRemove');
    Route::get('/account/my-order', [AccountController::class, 'myOrder'])->name('account.myOrder');
    Route::get('/account/order-detail/{id}', [AccountController::class, 'orderDetail'])->name('account.myOrderDetail');
});

Route::get('/account/wishlist-add', [AccountController::class, 'addWishList'])->name('account.wishlistAdd')->middleware('ajax.login');

//* Pages
Route::get('/page/{pageSlug}', [HomeController::class, 'page'])->name('page.detail');

//*Posts
Route::get('/news/{categoryPostSlug?}', [PostController::class, 'index'])->name('news.index');
Route::get('/news/{categoryPostSlug}/{postSlug}', [PostController::class, 'detail'])->name('news.detail');

//* Cart
Route::get('/cart/show', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/remove/{cart}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/destroy', [CartController::class, 'destroy'])->name('cart.destroy');

//*Apply Coupon
Route::post('/coupon-apply', [CartController::class, 'applyCoupon'])->name('cart.applyCoupon');
Route::get('/coupon-delete', [CartController::class, 'couponDelete'])->name('cart.couponDelete');

//*Checkout 
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/process-checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.processCheckout');
Route::get('/checkout-success/{orderId}', [CheckoutController::class, 'checkoutSuccess'])->name('checkout.success');
//* Shop
Route::get('/shop/{categorySlug?}/{subCategorySlug?}', [ShopController::class, 'index'])->name('shop.index');
Route::get('/product/{product}', [ShopController::class, 'productDetail'])->name('product.detail');






Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'admin.auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
Route::group(['middleware' => 'admin.guest'], function () {
    Route::get('admin/login', [AdminUserController::class, 'login'])->name('admin.login');
    Route::post('admin/login/process', [AdminUserController::class, 'loginProcess'])->name('login.process');
});

Route::group(['prefix' => 'admin', 'middleware' => 'admin.auth'], function () {
    Route::get('/logout', [AdminUserController::class, 'logout'])->name('admin.logout');
    //Module User
    Route::get('/user', [AdminUserController::class, 'index'])->name('user');
    Route::get('/create/user', [AdminUserController::class, 'create'])->name('user.create');
    Route::post('/create/store', [AdminUserController::class, 'store'])->name('user.store');
    Route::get('/user/delete/{user}', [AdminUserController::class, 'delete'])->name('user.delete');
    Route::get('/user/edit/{user}', [AdminUserController::class, 'edit'])->name('user.edit');
    Route::post('user/update/{user}', [AdminUserController::class, 'update'])->name('user.update');

    //Module Category
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('category.index');
    Route::get('/categories/create', [AdminCategoryController::class, 'create'])->name('category.create');
    Route::post('/categories/store', [AdminCategoryController::class, 'store'])->name('category.store');
    Route::get('/categories/delete/{category}', [AdminCategoryController::class, 'delete'])->name('category.delete');
    Route::get('/categories/edit/{category}', [AdminCategoryController::class, 'edit'])->name('category.edit');
    Route::post('/categories/update/{category}', [AdminCategoryController::class, 'update'])->name('category.update');
    Route::get('/categories/deleteImage/{category}', [AdminCategoryController::class, 'deleteImage'])->name('category.deleteImage');
    Route::post('/categories/action', [AdminCategoryController::class, 'action'])->name('category.action');

    //Module Product
    Route::get('/products', [AdminProductController::class, 'index'])->name('product.index');
    Route::get('/getSubCategory', [AdminProductController::class, 'getSubCategory'])->name('product.getSubCategory');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('product.create');
    Route::post('/products/store', [AdminProductController::class, 'store'])->name('product.store');
    Route::post('/products/action', [AdminProductController::class, 'action'])->name('product.action');
    Route::get('/product/edit/{product}', [AdminProductController::class, 'edit'])->name('product.edit');
    Route::post('/product/update/{product}', [AdminProductController::class, 'update'])->name('product.update');
    Route::get('/product/destroy/{product}', [AdminProductController::class, 'destroy'])->name('product.destroy');
    Route::get('/get-products', [AdminProductController::class, 'getProducts'])->name('product.getProducts');

    //Slider
    Route::get('/sliders', [AdminSliderController::class, 'index'])->name('slider.index');
    Route::get('/sliders/create', [AdminSliderController::class, 'create'])->name('slider.create');
    Route::post('/sliders/store', [AdminSliderController::class, 'store'])->name('slider.store');
    Route::get('/sliders/edit/{slider}', [AdminSliderController::class, 'edit'])->name('slider.edit');
    Route::post('/sliders/update/{slider}', [AdminSliderController::class, 'update'])->name('slider.update');
    Route::get('/sliders/delete/{slider}', [AdminSliderController::class, 'delete'])->name('slider.delete');
    Route::post('/sliders/deletes/', [AdminSliderController::class, 'deletes'])->name('slider.deletes');


    //Post
    Route::get('/posts', [AdminPostController::class, 'index'])->name('post.index');
    Route::get('/post/create', [AdminPostController::class, 'create'])->name('post.create');
    Route::post('/post/store', [AdminPostController::class, 'store'])->name('post.store');
    Route::get('/post/edit/{post}', [AdminPostController::class, 'edit'])->name('post.edit');
    Route::post('/post/update/{post}', [AdminPostController::class, 'update'])->name('post.update');
    Route::get('/post/delete/{post}', [AdminPostController::class, 'delete'])->name('post.delete');
    Route::get('/post-category/create', [AdminPostController::class, 'postCategoryCreate'])->name('postCategory.create');
    Route::post('/post-category/store', [AdminPostController::class, 'postCategoryStore'])->name('postCategory.store');
    Route::get('/post-category/edit/{postCategory}', [AdminPostController::class, 'postCategoryEdit'])->name('postCategory.edit');
    Route::post('/post-category/update/{postCategory}', [AdminPostController::class, 'postCategoryUpdate'])->name('postCategory.update');
    Route::get('/post-category/delete/{postCategory}', [AdminPostController::class, 'postCategoryDelete'])->name('postCategory.delete');
    Route::get('/post-category/search', [AdminPostController::class, 'searchCategoryPost'])->name('postCategory.search');

    //Temp
    Route::post('/temp/create', [AdminTempController::class, 'create'])->name('temp');
    Route::get('/temp/delete/{image}', [AdminTempController::class, 'delete'])->name('temp.delete');
    Route::get('/temp/delete', [AdminTempController::class, 'deleteTemp'])->name('temp.delete-temp');
    //Get Slug
    Route::get('/getSlug', function (Request $request) {
        $slug = '';
        if (!empty($request->title)) {
            $slug = Str::slug($request->title);
            return response()->json(['slug' => $slug]);
        }
        return false;
    })->name('getSlug');


    //Module Brands
    Route::get('/brands', [AdminBrandController::class, 'index'])->name('brand.index');
    Route::get('/brands/create', [AdminBrandController::class, 'create'])->name('brand.create');
    Route::post('/brands/store', [AdminBrandController::class, 'store'])->name('brand.store');
    Route::get('/brands/edit/{brand}', [AdminBrandController::class, 'edit'])->name('brand.edit');
    Route::post('/brands/update/{brand}', [AdminBrandController::class, 'update'])->name('brand.update');
    Route::get('/brands/destroy/{brand}', [AdminBrandController::class, 'destroy'])->name('brand.destroy');

    //Module Discount
    Route::get('/discount', [AdminDisCountCodeController::class, 'index'])->name('discount.index');
    Route::get('/discount/create', [AdminDisCountCodeController::class, 'create'])->name('discount.create');
    Route::post('/discount/store', [AdminDisCountCodeController::class, 'store'])->name('discount.store');
    Route::get('/discount/edit/{discountCode}', [AdminDisCountCodeController::class, 'edit'])->name('discount.edit');
    Route::post('/discount/update/{discountCode}', [AdminDisCountCodeController::class, 'update'])->name('discount.update');
    Route::get('/discount/delete/{discountCode}', [AdminDisCountCodeController::class, 'delete'])->name('discount.delete');
    Route::post('/discount/action', [AdminDisCountCodeController::class, 'action'])->name('discount.action');

    //Customers
    Route::get('/customers', [AdminCustomerController::class, 'index'])->name('customer.index');
    Route::get('/customers/create', [AdminCustomerController::class, 'create'])->name('customer.create');
    Route::post('/customers/store', [AdminCustomerController::class, 'store'])->name('customer.store');
    Route::get('/customers/edit/{customer}', [AdminCustomerController::class, 'edit'])->name('customer.edit');
    Route::post('/customers/update/{customer}', [AdminCustomerController::class, 'update'])->name('customer.update');
    Route::get('/customers/delete/{customer}', [AdminCustomerController::class, 'delete'])->name('customer.delete');


    //Module Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('order.index');
    Route::get('/orders-detail/{order}', [AdminOrderController::class, 'orderDetail'])->name('order.detail');
    Route::post('/orders-update-status/{id}', [AdminOrderController::class, 'updateStatus'])->name('order.updateStatus');
    Route::post('/orders-send-mail/{order} ', [AdminOrderController::class, 'sendMail'])->name('order.sendMail');
    Route::get('/orders-mail', function(){
        return view('admin.mail.order_customer');
    })->name('order.mail');

    //Account Admin
    Route::get('/settings', [AdminAccountSettingController::class, 'index'])->name('settings');
    Route::post('/update-account/{user}', [AdminAccountSettingController::class, 'updateAccount'])->name('settings.updateAccount');
    Route::get('/changePassword/{user}', [AdminAccountSettingController::class, 'changePassword'])->name('settings.changePassword');
    Route::post('/update-password/{user}', [AdminAccountSettingController::class, 'updatePassword'])->name('settings.updatePassword');



    //Page 
    Route::get('/pages', [AdminPageController::class, 'index'])->name('pages.index');
    Route::get('/pages/create', [AdminPageController::class, 'create'])->name('page.create');
    Route::post('/pages/store', [AdminPageController::class, 'store'])->name('page.store');
    Route::get('/pages/edit/{page}', [AdminPageController::class, 'edit'])->name('page.edit');
    Route::post('/pages/update/{page}', [AdminPageController::class, 'update'])->name('page.update');
    Route::get('/pages/delete/{page}', [AdminPageController::class, 'delete'])->name('page.delete');
    //Module Dashboard
    Route::get('/', [AdminDashBoardController::class, 'index'])->name('dashboard');
});
