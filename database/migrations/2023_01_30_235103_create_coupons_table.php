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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('coupon');
            $table->string('coupon_type')->default('discount')->comment('Coupon types includes discount, shipping');
            $table->string('quantity')->nullable();
            $table->string('unlimited')->nullable();
            $table->string('discount')->nullable()->comment('Percentage if coupon type is discount');
            $table->string('apply_on')->nullable()->comment('What the discount should be applied on: all orders, a product, a customer. categories');
            $table->string('min_order_amount')->nullable()->comment('The minimum order amount the coupon should be applied on');
            $table->foreignId('product_id')->nullable()->onDelete('cascade')->comment('If the discount should be applied on a product');
            $table->foreignId('category_id')->nullable()->onDelete('cascade')->comment('If the discount should be applied on a category');
            $table->foreignId('user_id')->nullable()->onDelete('cascade')->comment('If the discount should be applied on a distributor');
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->string('expires')->nullable();
            $table->string('min_shipping_amount')->nullable()->comment('The minimum shipping amount the coupon should be applied on');
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
        Schema::dropIfExists('coupons');
    }
};
