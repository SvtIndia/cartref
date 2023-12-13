<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryComponentSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_component_sliders', function (Blueprint $table) {
            $table->id();
            $table->string('category_slug')->nullable();
            $table->string('icon')->nullable();
            $table->string('title')->nullable();
            $table->boolean('is_active')->default(false)->nullable();
            $table->string('order')->nullable();
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
        Schema::dropIfExists('category_component_sliders');
    }
}
