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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique();
            $table->string('intern_reference')->unique();
            $table->string('title');
            $table->string('street')->nullable();
            $table->string('number')->nullable();
            $table->string('zip_code')->nullable();

            $table->boolean('is_active')->default(true);
            $table->boolean('is_sell')->default(false);
            $table->boolean('is_rent')->default(false);
            $table->decimal('sell_price', 12, 2)->nullable();
            $table->decimal('rental_price', 12, 2)->nullable();
            $table->integer('built_m2');

            $table->foreignId('office_id')->constrained();
            $table->foreignId('property_type_id')->constrained();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('secondary_user_id')->nullable()->constrained('users');

            $table->foreignId('neighborhood_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('district_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('municipality_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('region_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('location_id')->nullable()->constrained()->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
