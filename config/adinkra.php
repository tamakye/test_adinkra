<?php

use Illuminate\Support\Facades\Facade;

return [

	'currency' => env('DEFAULT_CURRENCY', 'GHS'),

	'currency_code' => env('DEFAULT_CURRENCY_CODE', '₡'),

	'payment_methods' => ['cash', 'paystack', 'back'],

	/**
	 * This enables the payment method allowed at checkout
	 * 
	 * The available payment option at checkout are 'cash', 'paystack' and 'bank'
	 * 
	 * setting to 'true' will and enable and is the default
	 * 
	 * */
	'cash_status' => false, 

	'paystack_status' => true,

	'bank_status' => false

];