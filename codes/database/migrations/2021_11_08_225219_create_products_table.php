<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
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
            $table->string('name');
            $table->string('slug');
            $table->string('product_group');

            $table->boolean('stock_status');
            
            $table->longtext('image');
            $table->longtext('images')->nullable();
            
            $table->string('excerpt')->nullable();
            $table->string('description')->nullable();
            
            $table->integer('mrp');
            $table->integer('offer_price');
            
            $table->integer('category_id')->nullable();

            $table->integer('brand_id')->nullable();
            $table->integer('size_id')->nullable();
            $table->integer('color_id')->nullable();
            $table->integer('style_id')->nullable();
            $table->integer('occasion_id')->nullable();
            $table->integer('idealfor_id')->nullable();
            
            $table->boolean('status');
            $table->longtext('admin_comments')->nullable();

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
        Schema::dropIfExists('products');
    }
}
