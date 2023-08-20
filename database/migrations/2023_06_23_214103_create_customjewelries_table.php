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
        Schema::create('customjewelries', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('first_name');
            $table->string('last_name');
            $table->foreignId('country_id');
            $table->string('phone');
            $table->datetime('appointment')->nullable();
            $table->longText('other_details')->nullable();
            $table->text('images')->nullable();
            $table->string('status')->default('accepted');
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
        Schema::dropIfExists('customjewelries');
    }
};
