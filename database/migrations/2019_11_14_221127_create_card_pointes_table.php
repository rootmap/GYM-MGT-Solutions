<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardPointesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_pointes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_id')->nullable()->default(0);
            $table->string('card_number')->nullable()->default(0);
            $table->string('card_holder_name')->nullable()->default(0);
            $table->string('card_expire_month')->nullable()->default(0);
            $table->string('card_expire_year')->nullable()->default(0);
            $table->string('card_cvc')->nullable()->default(0);
            $table->string('amount')->nullable()->default(0);

            $table->string('authCode')->nullable()->default(0);
            $table->string('token')->nullable()->default(0);
            $table->string('account')->nullable()->default(0);
            $table->string('retref')->nullable()->default(0);
            $table->string('resptext')->nullable()->default('Successful');
            $table->string('respstat')->nullable()->default('N');
            $table->string('commcard')->nullable()->default('N');
            $table->string('respcode')->nullable()->default('99');
            $table->string('refund_status')->nullable()->default('0');
            $table->integer('store_id')->default(0);
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
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
        Schema::dropIfExists('card_pointes');
    }
}
