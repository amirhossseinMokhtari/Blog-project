<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', length: 25)->unique();
            $table->string('email', length: 255)->unique();
            $table->string('first_name',length: 255);
            $table->string('last_name',length: 255);
            $table->enum('gender', ['male', 'female']);
            $table->string('phone', length: 13);
            $table->date('birth_date')->nullable();
            $table->string('password',length: 255);
            $table->string('profile_image')->nullable();
            $table->string('bio',length: 255)->nullable();
            $table->string('x_url',length: 255)->nullable();
            $table->string('instagram_url',length: 255)->nullable();
            $table->boolean('verify')->default(0);
            $table->integer('number_of_visit')->default(0);
            $table->foreignId('deleted_by')->nullable();
            $table->timestamps(precision: 0);
            $table->softDeletes();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
