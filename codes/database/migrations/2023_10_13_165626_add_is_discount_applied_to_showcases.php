<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsDiscountAppliedToShowcases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('showcases', function (Blueprint $table) {
            $table->boolean('is_discount_applied')->default(false)->nullable();
            $table->boolean('is_reward_point_applied')->default(false)->nullable();
            $table->boolean('is_credit_applied')->default(false)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('showcases', function (Blueprint $table) {
            $table->dropColumn('is_discount_applied');
            $table->dropColumn('is_reward_point_applied');
            $table->dropColumn('is_credit_applied');
        });
    }
}
