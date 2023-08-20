<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

// Dashboard
// Route::get('/mss-admin/login', [LoginController::class, 'showAdminLoginForm'])->name('admin.login');
// Route::post('/mss-admin/login', [LoginController::class, 'login'])->name('admin.login');
// Route::post('/mss-admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

Route::group(['middleware' => ['auth', 'auth.admin']], function(){
	// dashboard
	Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');

	// pages
	Route::get('/dashboard/pages/home', [DashboardController::class, 'pagesHome'])->name('pages.home');
	// save home
	Route::post('/dashboard/pages/home', [DashboardController::class, 'savePage'])->name('pages');

	// orders
	Route::get('/dashboard/orders', [OrderController::class, 'getOrders'])->name('orders');
	Route::post('/dashboard/fetch-order', [OrderController::class, 'fetchOrder']);
	Route::post('/dashboard/update-order', [OrderController::class, 'updateOrder']);
	Route::post('/dashboard/empty-bin', [OrderController::class, 'emptyBin']);
	Route::get('/dashboard/orders/create', [OrderController::class, 'create'])->name('orders.create');
	Route::post('/dashboard/orders/create', [OrderController::class, 'saveOrder'])->name('orders.create');
	Route::post('/dashboard/orders/add-product', [OrderController::class, 'addProduct']);
	Route::post('/dashboard/orders/update-product', [OrderController::class, 'updateProduct']);
	Route::post('/dashboard/orders/remove-product', [OrderController::class, 'removeProduct']);
	Route::post('/dashboard/orders/add-tax', [OrderController::class, 'addTax']);
	Route::post('/dashboard/orders/remove-tax', [OrderController::class, 'removeTax']);
	Route::get('/dashboard/orders/{slug}/edit', [OrderController::class, 'editOrder'])->name('orders.edit');
	Route::post('/dashboard/orders/{slug}/edit', [OrderController::class, 'saveChanges'])->name('orders.update');

	// customers
	Route::get('/fetch-customers', [CustomerController::class, 'fetchCustomers']);
	Route::post('/dashboard/load-customer-address', [CustomerController::class, 'loadCustomer']);

	// products
	Route::get('/dashboard/products', [ProductController::class, 'products'])->name('products');
	Route::get('/dashboard/products/new', [ProductController::class, 'addProduct'])->name('add-product');
	Route::post('/dashboard/products/new', [ProductController::class, 'saveProduct'])->name('add-product');
	Route::get('/dashboard/products/create', [ProductController::class, 'create'])->name('admin.products.create');
	Route::post('/dashboard/products/processing', [ProductController::class, 'saveBulkUploadPage'])->name('admin.products.process-upload');
	Route::get('/dashboard/products/{slug}/edit', [ProductController::class, 'editProduct'])->name('edit-product');
	Route::post('/dashboard/products/{slug}/edit', [ProductController::class, 'updateProduct'])->name('edit-product');
	Route::get('/fetch-products', [ProductController::class, 'fetchProducts']);
	Route::post('/dashboard/products/import', [ProductController::class, 'processImport'])->name('admin.products.upload');
	Route::post('/dashboard/products/move-to-bin', [ProductController::class, 'moveToBin']);
	Route::post('/dashboard/products/bulk-action', [ProductController::class, 'bulkAction'])->name('admin.products.bulk-action');
	Route::post('/dashboard/products/fetch-attributes', [ProductController::class, 'fetchProductAttributes']);
	Route::post('/dashboard/products/fetch-attributes/values', [ProductController::class, 'fetchProductAttributeValues']);

	  // attributes
	Route::get('/dashboard/product-attributes', [AttributeController::class ,'index'])->name('attributes');
	Route::get('/dashboard/attributes/create', [AttributeController::class ,'createAttribute'])->name('attribute.create');
	Route::post('/dashboard/attributes/save', [AttributeController::class ,'saveAttribute'])->name('attributes.save');
	Route::get('/dashboard/attributes/{slug}/edit', [AttributeController::class ,'editAttribute'])->name('attributes.edit');
	Route::post('/dashboard/attributes/{slug}/edit', [AttributeController::class ,'updateAttribute'])->name('attributes.update');


	// Category
	Route::get('/product-categories', [CategoryController::class, 'index'])->name('categories');
	Route::post('/product-categories', [CategoryController::class, 'saveCategory'])->name('categories');
	Route::get('/product-category/{slug}/edit', [CategoryController::class, 'editCategory'])->name('categories.edit');
	Route::post('/product-categories/{slug}/edit', [CategoryController::class, 'updateCategory'])->name('categories.update');
	Route::post('/dashboard/products/fetch-categories', [CategoryController::class, 'fetchCategory']);

	// collections
	Route::get('/dashboard/collections', [FilterController::class, 'showCollections'])->name('collections');
	Route::post('/dashboard/collections', [FilterController::class, 'saveCollections'])->name('collections');
	Route::get('/dashboard/collections/{slug}/edit', [FilterController::class, 'editCollections'])->name('edit-collections');
	Route::post('/dashboard/collections/{slug}/edit', [FilterController::class, 'updateCollections'])->name('edit-collections');
	
	// conditions
	Route::get('/dashboard/conditions', [FilterController::class, 'showConditions'])->name('conditions');
	Route::post('/dashboard/conditions', [FilterController::class, 'saveConditions'])->name('conditions');
	Route::get('/dashboard/conditions/{slug}/edit', [FilterController::class, 'editConditions'])->name('edit-conditions');
	Route::post('/dashboard/conditions/{slug}/edit', [FilterController::class, 'updateConditions'])->name('edit-conditions');
	
	// materials
	Route::get('/dashboard/materials', [FilterController::class, 'showMaterials'])->name('materials');
	Route::post('/dashboard/materials', [FilterController::class, 'saveMaterials'])->name('materials');
	Route::get('/dashboard/materials/{slug}/edit', [FilterController::class, 'editMaterials'])->name('edit-materials');
	Route::post('/dashboard/materials/{slug}/edit', [FilterController::class, 'updateMaterials'])->name('edit-materials');

	// taxes
	Route::get('/dashboard/taxes', [TaxController::class, 'index'])->name('admin.taxes');
	Route::get('/dashboard/taxes/create', [TaxController::class, 'create'])->name('admin.taxes.create');
	Route::post('/dashboard/taxes/create', [TaxController::class, 'store'])->name('admin.taxes.create');
	Route::get('/dashboard/taxes/{slug}/edit', [TaxController::class, 'edit'])->name('admin.taxes.edit');

	// coupons
	Route::get('/dashboard/coupons', [CouponController::class, 'index'])->name('admin.coupons');
	Route::get('/dashboard/coupons/create', [CouponController::class, 'create'])->name('admin.coupons.create');
	Route::post('/dashboard/coupons/create', [CouponController::class, 'store'])->name('admin.coupons.create');
	Route::get('/dashboard/coupons/{slug}/edit', [CouponController::class, 'edit'])->name('admin.coupons.edit');
	Route::post('/dashboard/coupons/{slug}/edit', [CouponController::class, 'update'])->name('admin.coupons.edit');
	Route::post('/dashboard/coupons/delete', [CouponController::class, 'delete']);

	// shiping
	Route::get('/dashboard/shipping', [ShippingController::class, 'index'])->name('admin.shipping');
	Route::post('/dashboard/fetch-shipping-countries', [ShippingController::class, 'fetchCountries'])->name('admin.shipping.fetch-countries');
	Route::get('/dashboard/shipping/create', [ShippingController::class, 'create'])->name('admin.shipping.create');
	Route::post('/dashboard/shipping/create', [ShippingController::class, 'store'])->name('admin.shipping.create');
	Route::get('/dashboard/shipping/{slug}/edit', [ShippingController::class, 'edit'])->name('admin.shipping.edit');
	Route::post('/dashboard/shipping/{slug}/edit', [ShippingController::class, 'update'])->name('admin.shipping.edit');

	// users
	Route::get('/dashboard/end-users', [UserController::class, 'index'])->name('admin.users');
	Route::get('/dashboard/end-users/create', [UserController::class, 'create'])->name('admin.users.create');
	Route::post('/dashboard/end-users/import', [UserController::class, 'processImport'])->name('admin.users.upload');
	Route::post('/dashboard/end-users/processing', [UserController::class, 'saveBulkUploadPage'])->name('admin.users.process-upload');

	// register-warranties
	// Route::get('/dashboard/registered-warranties', [WarrantController::class, 'index'])->name('admin.warranties');

	// mailing list
	Route::get('/dashboard/mailing/subscribers', [MailingController::class, 'subscribers'])->name('admin.mailing.subscribers');
	Route::post('/dashboard/mailing/subscribers/{slug}/delete', [MailingController::class, 'deleteSubscriber'])->name('admin.mailing.subscribers.delete');
	Route::get('/dashboard/mailing/news-letter', [MailingController::class, 'newsLetter'])->name('admin.mailing.newsletter');
	Route::get('/dashboard/mailing/custom-jewelry', [MailingController::class, 'customJewelry'])->name('admin.mailing.custom-jewelry');
	Route::get('/dashboard/mailing/custom-jewelry/{slug}/show', [MailingController::class, 'showCustomJewelry'])->name('admin.mailing.custom-jewelry.show');

	// tickets
	// Route::get('/dashboard/tickets', [TicketController::class, 'showTickets'])->name('admin.tickets.list');
	// Route::get('/dashboard/support/view/{ticket_id}', [TicketController::class, 'viewTicket'])->name('admin.tickets.view');
	// Route::post('/dashboard/support/view/ticket/comment', [TicketController::class, 'saveComment'])->name('admin.view-ticket.comment');
	// // tickets categories
	// Route::get('/dashboard/tickets/categories', [TicketController::class, 'showTiciketCategory'])->name('admin.tickets.categories');
	// Route::post('/dashboard/tickets/categories', [TicketController::class, 'addTiciketCategory'])->name('admin.tickets.categories');
	// Route::get('/dashboard/tickets/categories/{id}/delete', [TicketController::class, 'deleteTiciketCategory'])->name('admin.tickets.delete-categories');
});