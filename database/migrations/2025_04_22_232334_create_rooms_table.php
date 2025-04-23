<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('floor_id')->constrained();
            $table->unsignedInteger('number')->unique();
            $table->unsignedInteger('capacity');
            $table->unsignedBigInteger('price');
            $table->string('image_url')->nullable(); // Add this line for storing Cloudinary URL
            $table->boolean('is_reserved')->default(false); 
            $table->foreignId('reserved_by')->nullable()->constrained('users');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
