<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_purchases', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id', false, true);
            $table->bigInteger('video_id', false, true);
            $table->decimal('amount_requested', 20, 2);
            $table->decimal('amount_paid', 20, 2);
            $table->dateTime('transaction_start_time');
            $table->dateTime('transaction_completion_time')->nullable();
            $table->string('status')->default('Failed');
            $table->string('transaction_id')->nullable();
            $table->string('payment_request_id')->nullable();
            $table->dateTime('payment_date')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('video_id')->references('id')->on('videos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('video_purchases');
    }
}
