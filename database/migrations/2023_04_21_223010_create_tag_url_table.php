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
        Schema::create('tag_url', function (Blueprint $table) {
            // $table->bigIncrements('id');
            $table->bigIncrements('id');
            $table->unsignedBigInteger('url_id');
            $table->foreign('url_id')->references('id')->on('urls')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('tag_id');
            $table->foreign('tag_id')->references('id')->on('tags')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->unique(['tag_id', 'url_id']);
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
        Schema::dropIfExists('tag_url');
    }
};
