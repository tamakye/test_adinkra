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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable();
            $table->string('name');
            $table->longText('description');
            $table->string('product_number')->nullable();
            $table->string('sku')->nullable();
            $table->string('quantity_in_stock');
            $table->double('price');
            $table->double('retail_price');
            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->longText('product_image')->nullable();
            $table->string('status')->default('Draft')->comment('Published, Draft, Pending');
            $table->foreignId('collection_id')->nullable();
            $table->foreignId('material_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['name', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
