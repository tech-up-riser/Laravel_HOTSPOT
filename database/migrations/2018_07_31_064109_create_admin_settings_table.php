<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('upload_promotion');
            $table->string('facebook')->default('on');
            $table->string('twitter')->default('on');
            $table->string('instagram')->default('on');
            $table->string('linkedin')->default('on');
            $table->string('wechat')->default('off');
            $table->string('vkontakte')->default('off');
            $table->string('facebook_text')->default('Facebook');
            $table->string('twitter_text')->default('Twitter');
            $table->string('instagram_text')->default('Instagram');
            $table->string('linkedin_text')->default('LinkedIn');
            $table->string('wechat_text')->default('Wechat');
            $table->string('vkontakte_text')->default('Vkontakte');
            $table->string('redirect_url');
            $table->integer('business_id')->unsigned()->index();
            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');

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
        Schema::dropIfExists('admin_settings');
    }
}
