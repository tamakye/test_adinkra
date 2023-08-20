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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->boolean('default')->default(0);
            $table->string('slug')->nullable();
            
            $table->string('billing_first_name');
            $table->string('billing_last_name');
            $table->string('billing_address_one');
            $table->string('billing_address_two');
            $table->string('billing_country');
            $table->string('billing_region');
            $table->string('billing_city');
            $table->string('billing_zip_code');
            $table->string('billing_phone');
            $table->string('billing_email')->nullable();
            $table->string('billing_vat')->nullable();

            $table->string('shipping_first_name');
            $table->string('shipping_last_name');
            $table->string('shipping_address_one');
            $table->string('shipping_address_two');
            $table->string('shipping_country');
            $table->string('shipping_region');
            $table->string('shipping_city');
            $table->string('shipping_zip_code');
            $table->string('shipping_phone');
            $table->string('shipping_email')->nullable();
            $table->string('shipping_vat')->nullable();

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
        Schema::dropIfExists('addresses');
    }
};
