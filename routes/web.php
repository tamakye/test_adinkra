<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

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

require __DIR__.'/auth.php';

// admin
require __DIR__.'/admin.php';


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/command', function () {
    
    \Artisan::call("storage:link");
    
    return 'success';
});

Route::middleware(['auth', 'verified'])->group(function () {
	Route::get('/profile', [ProfileController::class, 'home'])->name('profile');
	Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::patch('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
	Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
	// orders
	Route::get('/my-wishlist', [ProfileController::class, 'myWishlist'])->name('my-wishlist');
	Route::get('/my-orders', [ProfileController::class, 'myOrders'])->name('my-orders');
	Route::get('/my-orders/{slug}/order-details', [ProfileController::class, 'myOrderDetails'])->name('order-details');
	Route::get('/my-address', [ProfileController::class, 'myAddress'])->name('address');
	Route::get('/my-address/create', [ProfileController::class, 'createAddress'])->name('address.create');
	Route::post('/my-address/create', [ProfileController::class, 'saveAddress'])->name('address.create');
	Route::get('/my-address/{slug}/edit', [ProfileController::class, 'editAddress'])->name('address.edit');
	Route::post('/my-address/{slug}/edit', [ProfileController::class, 'updateAddress'])->name('address.edit');
});



Route::get('/newsletter', [SubscribeController::class, 'newsletter'])->name('newsletter');
Route::post('/newsletter', [SubscribeController::class, 'saveNewsletter'])->name('newsletter');

// landing page
Route::get('/', [PagesController::class, 'welcome'])->name('welcome');
Route::get('/house-of-adinkra', [PagesController::class, 'houseOfAdinkra'])->name('house-of-adinkra');
Route::get('/custom-jewelry', [PagesController::class, 'customJewelry'])->name('custom-jewelry');
Route::post('/custom-jewelry', [PagesController::class, 'saveCustomJewelry'])->name('custom-jewelry');
Route::post('/store-media', [PagesController::class, 'storeMedia'])->name('store-media');
Route::get('/story-and-heritage', [PagesController::class, 'heritage'])->name('heritage');
Route::post('/country/fetch-regions', [PagesController::class, 'fetchRegions']);

// contact
Route::get('/contact', [PagesController::class, 'contact'])->name('contact');
Route::post('/contact', [PagesController::class, 'saveContact'])->name('contact');

// cart
Route::get('/cart', [CartController::class, 'showCart'])->name('cart');
Route::post('/cart/add', [CartController::class, 'addToCart']);
Route::post('/remove-from-cart', [CartController::class, 'removeItemFromCart']);
Route::post('/update-cart', [CartController::class, 'updateCart']);
// coupon
Route::post('/apply-coupon', [CartController::class, 'applyCoupon']);
Route::post('/calculate-shipping-cost', [CartController::class, 'calculatShippingCost']);

// wishlist
Route::post('/product/add-to-wish-list', [WishlistController::class, 'addToWishlist']);

// checkout
Route::get('/checkout', [CheckoutController::class, 'showCheckoutPage'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'ProcessPayment'])->name('checkout');
Route::get('/payment/callback', [CheckoutController::class, 'handleGatewayCallback'])->name('payments.callback');
Route::get('/orders/{slug}/summary', [CheckoutController::class, 'orderSummary'])->name('orders.summary');
Route::post('/load-customer-address', [CheckoutController::class, 'LoadAddress']);

// subscribe
Route::post('/subscribe', [SubscribeController::class, 'addUserToSubscribers']);

// products
Route::get('/{slug}/', [PagesController::class, 'showSingleProduct'])->name('products.single');
Route::get('/category/{slug}/', [PagesController::class, 'productListing'])->name('products.listing');



Route::fallback(function () {
	return abort(404);
});

