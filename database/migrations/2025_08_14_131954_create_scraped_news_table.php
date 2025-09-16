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
        Schema::create('scraped_news', function (Blueprint $table) {
            $table->id();
            $table->string('title',length: 500);
            $table->Text('lead');
            $table->Text('body')->nullable();
            $table->string('image_url');
            $table->string('url')->unique();
            $table->dateTime('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scraped_news');
    }
};
