<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('city')->default('Dhaka');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
                        $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
                        $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->foreignId('location_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('address')->nullable();
            $table->enum('status', ['upcoming', 'ongoing', 'completed', 'handed_over'])->default('ongoing');
            $table->enum('type', ['residential', 'commercial', 'mixed'])->default('residential');
            $table->decimal('land_area', 10, 2)->nullable();
            $table->string('land_unit')->default('katha');
            $table->integer('total_floors')->nullable();
            $table->integer('apartments_per_floor')->nullable();
            $table->integer('total_units')->nullable();
            $table->decimal('price_from', 15, 2)->nullable();
            $table->decimal('price_to', 15, 2)->nullable();
            $table->string('price_label')->nullable(); // e.g. "Starting from 1.5 Cr"
            $table->integer('progress_percentage')->default(0);
            $table->date('launch_date')->nullable();
            $table->date('expected_completion')->nullable();
            $table->date('handover_date')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_special_offer')->default(false);
            $table->boolean('is_published')->default(false);
            $table->string('featured_image')->nullable();
            $table->string('video_url')->nullable();
            $table->string('brochure_pdf')->nullable();
            $table->json('amenities')->nullable();
            $table->json('nearby_landmarks')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('property_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->string('unit_type'); // e.g. "Type A", "Type B"
            $table->decimal('size_sqft', 10, 2);
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->integer('balconies')->default(0);
            $table->integer('parking_spaces')->default(0);
            $table->string('floor_plan_image')->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->boolean('is_available')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('property_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->string('image_path');
            $table->string('caption')->nullable();
            $table->enum('type', ['exterior', 'interior', 'floorplan', 'construction', 'amenity'])->default('exterior');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('construction_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('milestone', ['land_acquired', 'design_approved', 'foundation', 'structure', 'brickwork', 'plumbing_electrical', 'finishing', 'handover'])->nullable();
            $table->integer('progress_percentage')->nullable();
            $table->json('photos')->nullable();
            $table->date('update_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('construction_updates');
        Schema::dropIfExists('property_images');
        Schema::dropIfExists('property_units');
        Schema::dropIfExists('properties');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('locations');
    }
};
