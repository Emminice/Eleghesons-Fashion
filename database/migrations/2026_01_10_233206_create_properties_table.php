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
            $table->foreignId('agent_id')->constrained('users')->onDelete('cascade'); // agent who owns the property
            $table->string('title');
            $table->text('description');
            $table->string('location');
            $table->decimal('price', 12, 2);
            $table->integer('beds')->default(0);
            $table->integer('baths')->default(0);
            $table->string('area')->nullable(); // e.g., "1200 sqft"
            $table->json('images')->nullable(); // store multiple image URLs
            $table->json('features')->nullable(); // store features like ["24/7 Security", "Parking Space"]
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
