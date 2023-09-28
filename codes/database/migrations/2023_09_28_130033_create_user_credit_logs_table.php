<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCreditLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_credit_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->default(0)->nullable();
            $table->bigInteger('order_id')->default(0)->nullable();
            $table->enum('type', ['in', 'out'])->nullable();
            $table->decimal('amount',10,2)->default(0)->nullable();
            $table->string('closing_bal')->nullable()->default(0);
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
        Schema::dropIfExists('user_credit_logs');
    }
}
