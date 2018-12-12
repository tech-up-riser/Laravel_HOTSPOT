<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('gender')->nullable();
            $table->string('year')->nullable();
            $table->string('locale')->nullable();
            $table->string('picture')->nullable();
            $table->string('country')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->boolean('activated')->default(false);
            $table->string('token');
            $table->ipAddress('signup_ip_address')->nullable();
            $table->ipAddress('signup_confirmation_ip_address')->nullable();
            $table->ipAddress('signup_sm_ip_address')->nullable();
            $table->ipAddress('admin_ip_address')->nullable();
            $table->ipAddress('updated_ip_address')->nullable();
            $table->ipAddress('deleted_ip_address')->nullable();
            $table->ipAddress('mac_address')->nullable();
            $table->string('image_url')->nullable();
            $table->string('profile_url')->nullable();
            $table->string('is_new')->nullable();
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
        Schema::dropIfExists('users');
    }
}
