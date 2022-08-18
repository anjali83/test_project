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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile',20);
            $table->date('dob')->nullable();
            $table->enum('gender', ['Male', 'Female'])->nullable();
            $table->string('profile_photo')->nullable();
            $table->string('document')->nullable();
            $table->string('address')->nullable();;
            $table->integer('country')->default(0)->nullable();;
            $table->integer('state')->default(0)->nullable();;
            $table->integer('city')->default(0)->nullable();;
            $table->enum('registered_by', ['Manual', 'Google', 'Facebook'])->default('Manual');
            $table->integer('role_id')->default(2);
            $table->boolean('is_active')->default(1);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->softDeletes();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
