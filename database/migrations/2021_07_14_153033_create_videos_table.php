<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('name')->nullable();
            $table->bigInteger('episode_id')->unsigned();
            $table->string('thumbnail')->nullable();
            $table->string('video_url')->nullable();
            $table->string('trailer_url')->nullable();
            $table->string('video_id')->nullable();
            $table->integer('total_hits')->nullable()->default(0);
            $table->softDeletes();
            $table->longText('details')->nullable();
            $table->boolean('status')->nullable()->default(0);
            $table->float('price',10,2)->nullable()->default(0.00);
            $table->timestamps();
            $table->foreign('episode_id')->references('id')->on('episodes')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
}
