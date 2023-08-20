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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('top_slider_one')->nullable();
            $table->string('top_slider_two')->nullable();
            $table->string('top_slider_three')->nullable();

            $table->string('adinkra_text')->nullable();
            $table->string('adinkra_image_heading')->nullable();
            $table->string('adinkra_image_text')->nullable();

            $table->string('legacy_text')->nullable();
            $table->string('legacy_image_heading')->nullable();
            $table->string('legacy_image_text')->nullable();

            $table->string('custom_text')->nullable();
            $table->string('custom_image_heading')->nullable();
            $table->string('custom_image_text')->nullable();


            $table->string('art_text')->nullable();
            $table->string('art_image_heading')->nullable();
            $table->string('art_image_text')->nullable();


            $table->string('digital_text')->nullable();
            $table->string('digital_image_heading')->nullable();
            $table->string('digital_image_text')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
};
