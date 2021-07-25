<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEpisodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->bigInteger('category_id')->unsigned();
            $table->string('name');
            $table->string('picture')->nullable();
            $table->text('cast')->nullable();
            $table->longText('details')->nullable();
            $table->date('release_date')->nullable();
            $table->softDeletes();
            $table->boolean('type')->default(1)->comment('1=episode,2=movies');
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('episodes');
    }
}
