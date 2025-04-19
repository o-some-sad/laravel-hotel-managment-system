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
        Schema::table('users', function (Blueprint $table) {
            // Add the new fields to the users table
            $table->string('national_id')->nullable()->unique()->after('password');
            $table->string('avatar_image')->nullable()->after('national_id');
            $table->enum('role', ['admin', 'manager', 'receptionist', 'client'])->after('avatar_image');
            $table->string('mobile')->nullable()->after('role');
            $table->string('country')->nullable()->after('mobile');
            $table->enum('gender', ['male', 'female'])->nullable()->after('country');
            $table->timestamp('last_login_at')->nullable()->after('gender');
            $table->timestamp('approved_at')->nullable()->after('last_login_at');
            $table->foreignId('approved_by')->nullable()->after('approved_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove the added fields
            $table->dropColumn([
                'national_id',
                'avatar_image',
                'role',
                'mobile',
                'country',
                'gender',
                'last_login_at',
                'approved_at',
                'approved_by'
            ]);
        });
    }
};