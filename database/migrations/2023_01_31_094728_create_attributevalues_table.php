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
        Schema::create('attributevalues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attribute_id');
            $table->string('title');
            $table->string('slug')->index();
            $table->string('colour')->nullable();
            $table->string('thumbnail')->nullable();
            $table->boolean('default')->default(0);
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
        Schema::dropIfExists('attributevalues');
    }
};
