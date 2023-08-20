<?php

/**
 * Gets the order status.
 *
 * @param      string  $status  The status
 *
 * @return     string  The order status.
 */
function get_order_status_color($status){

	switch ($status) {
		case $status == 'processing':
		$bg = 'badge-primary';
		// $bg = 'status-processing';
		break;

		case $status == 'completed':
		$bg = 'badge-success';
		// $bg = 'status-completed';
		break;

		case $status == 'cancelled':
		$bg = 'badge-secondary';
		// $bg = 'status-cancelled';
		break;

		case $status == 'on-hold':
		$bg = 'badge-warning';
		// $bg = 'status-on-hold';
		break;

		case $status == 'failed':
		$bg = 'badge-danger';
		// $bg = 'status-failed';
		break;

		case $status == 'draft':
		$bg = 'badge-dark';
		// $bg = 'status-draft';
		break;
		
		default:
		// $status == 'pending'
		$bg = 'badge-info';
		// $bg = 'status-pending';
		break;
	}

	return $bg;
}