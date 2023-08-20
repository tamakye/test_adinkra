<?php
namespace App\Traits;

use App\Models\Order;

trait OrderTrait{

	/**
	 * Soft deletes an order
	 *
	 * @param      <type>  $order_number  The order number
	 */
	public function moveToBin($order_number){
		$order = Order::where('order_number', $order_number)->first();
		$order->update([
			'status' => 'trash',
		]);

		$order->delete();
	}

	/**
	 * Restores deleted orders
	 *
	 * @param      <type>  $order_number  The order number
	 */
	public function restoreOrder($order_number){

		$order = Order::withTrashed()->where('order_number', $order_number)->first();

		$order->update([
			'status' => 'pending',
		]);

		$order->restore();
	}

	/**
	 * Permanently deletes and order
	 *
	 * @param      <type>  $order_number  The order number
	 */
	public function deletePermanently($order_number){

		$order = Order::withTrashed()->where('order_number', $order_number)->first();

		$order->products()->sync([]);

		$order->forceDelete();
	}


	/**
	 * Saves an update.
	 *
	 * @param      <type>  $order_number  The order number
	 */
	public function saveUpdate($order_number){

		// update status
		$order = Order::withTrashed()->where('order_number', $order_number)->first();

		$order->update([
			'status' => request()->status,
			'deleted_at' => null,
		]);
	}
}