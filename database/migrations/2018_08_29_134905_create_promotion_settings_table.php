<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotion_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->string('title')->nullable();
            $table->boolean('default')->default(false);
            $table->integer('business_id')->unsigned()->index();
            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
            $table->integer('promotion_id')->unsigned()->index();
            $table->foreign('promotion_id')->references('id')->on('business_promotions')->onDelete('cascade');

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
        Schema::dropIfExists('promotion_settings');
    }
}
