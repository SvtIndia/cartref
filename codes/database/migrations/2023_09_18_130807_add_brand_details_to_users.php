<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBrandDetailsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('brand_description')->nullable()->after('brands');
            $table->string('brand_logo')->nullable()->after('brand_description');
            $table->string('brand_bg_color')->nullable()->after('brand_logo');
            $table->string('brand_store_rating')->nullable()->after('brand_bg_color');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('brand_description');
            $table->dropColumn('brand_logo');
            $table->dropColumn('brand_bg_color');
            $table->dropColumn('brand_store_rating');
        });
    }
}
