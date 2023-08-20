<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number');
            $table->datetime('order_date');
            $table->foreignId('user_id')->nullable();
            $table->text('user')->nullable();
            $table->foreignId('address_id');
            $table->string('status')->default('pending')->comment('Pending, Processing, Completed, Cancelled, On-hold, Failed, Draft, Refunded, Trash');
            $table->datetime('refunded_at')->nullable();
            $table->string('coupon')->nullable();
            $table->string('coupon_amount')->nullable();
            $table->string('subtotal');
            $table->string('shipping_method')->nullable();
            $table->string('shipping_amount')->nullable();
            $table->string('vat')->nullable();
            $table->string('total_items');
            $table->string('grand_total');
            $table->boolean('isPaid')->default(0);
            $table->string('transaction_id')->nullable();
            $table->string('payment_type')->default('card')->comment('card, bank, momo');
            $table->datetime('payment_date')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('order_country')->nullable();
            $table->text('order_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
