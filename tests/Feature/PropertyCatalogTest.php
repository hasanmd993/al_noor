<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Location;
use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PropertyCatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_published_properties(): void
    {
        $cat = Category::create(['name' => 'Signature Residential', 'is_active' => true]);
        $loc = Location::create(['name' => 'Gulshan 2', 'city' => 'Dhaka', 'is_active' => true]);

        Property::create([
            'name' => 'Al-Noor Crown Palace',
            'category_id' => $cat->id,
            'location_id' => $loc->id,
            'address' => 'Gulshan 2, Dhaka',
            'status' => 'ongoing',
            'type' => 'residential',
            'price_from' => 50000000,
            'is_published' => true,
        ]);

        Property::create([
            'name' => 'Unpublished Project',
            'category_id' => $cat->id,
            'location_id' => $loc->id,
            'address' => 'Banani, Dhaka',
            'status' => 'upcoming',
            'type' => 'residential',
            'is_published' => false,
        ]);

        $response = $this->getJson('/api/properties');
        $response->assertStatus(200)
                 ->assertJson(['success' => true])
                 ->assertJsonCount(1, 'data')
                 ->assertJsonFragment(['name' => 'Al-Noor Crown Palace'])
                 ->assertJsonMissing(['name' => 'Unpublished Project']);
    }

    public function test_can_search_properties_by_keyword(): void
    {
        $cat = Category::create(['name' => 'Commercial', 'is_active' => true]);
        $loc = Location::create(['name' => 'Banani', 'city' => 'Dhaka', 'is_active' => true]);

        Property::create([
            'name' => 'Al-Noor Prime Nexus',
            'category_id' => $cat->id,
            'location_id' => $loc->id,
            'address' => 'Banani 11, Dhaka',
            'status' => 'ongoing',
            'type' => 'commercial',
            'is_published' => true,
        ]);

        $response = $this->getJson('/api/properties?search=Nexus');
        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'Al-Noor Prime Nexus']);

        $responseNotFound = $this->getJson('/api/properties?search=NonExistent');
        $responseNotFound->assertStatus(200)
                         ->assertJsonCount(0, 'data');
    }

    public function test_single_property_returns_details_and_related(): void
    {
        $cat = Category::create(['name' => 'Signature Residential', 'is_active' => true]);
        $loc = Location::create(['name' => 'Dhanmondi', 'city' => 'Dhaka', 'is_active' => true]);

        $prop = Property::create([
            'name' => 'Al-Noor Grand Vista',
            'category_id' => $cat->id,
            'location_id' => $loc->id,
            'address' => 'Road 27, Dhanmondi',
            'status' => 'completed',
            'type' => 'residential',
            'is_published' => true,
        ]);

        $response = $this->getJson('/api/properties/' . $prop->id);
        $response->assertStatus(200)
                 ->assertJson(['success' => true])
                 ->assertJsonPath('data.name', 'Al-Noor Grand Vista');

        $notFound = $this->getJson('/api/properties/99999');
        $notFound->assertStatus(404);

        // Unpublished property should NOT be accessible publicly
        $draft = Property::create([
            'name' => 'Al-Noor Secret Project',
            'category_id' => $cat->id,
            'location_id' => $loc->id,
            'address' => 'Gulshan 2',
            'status' => 'upcoming',
            'type' => 'residential',
            'is_published' => false,
        ]);

        $publicDraftRes = $this->getJson('/api/properties/' . $draft->id);
        $publicDraftRes->assertStatus(404);

        // Admin should be able to view unpublished draft via admin API
        $admin = User::factory()->create();
        $adminDraftRes = $this->actingAs($admin, 'sanctum')->getJson('/api/admin/properties/' . $draft->id);
        $adminDraftRes->assertStatus(200)
                      ->assertJsonPath('data.name', 'Al-Noor Secret Project');
    }

    public function test_admin_can_manage_property_images_and_units(): void
    {
        $admin = User::factory()->create();
        $cat = Category::create(['name' => 'Signature Residential', 'is_active' => true]);
        $loc = Location::create(['name' => 'Gulshan', 'city' => 'Dhaka', 'is_active' => true]);

        $prop = Property::create([
            'name' => 'Al-Noor Tower X',
            'category_id' => $cat->id,
            'location_id' => $loc->id,
            'address' => 'Gulshan Avenue',
            'status' => 'ongoing',
            'type' => 'residential',
            'is_published' => true,
        ]);

        // Add gallery image
        $imageRes = $this->actingAs($admin, 'sanctum')->postJson("/api/admin/properties/{$prop->id}/images", [
            'image_path' => '/storage/media/test_gallery.webp',
            'caption' => 'Penthouse Living Room',
            'sort_order' => 1,
        ]);
        $imageRes->assertStatus(201)
                 ->assertJson(['success' => true]);
        $imageId = $imageRes->json('data.id');

        // Add unit
        $unitRes = $this->actingAs($admin, 'sanctum')->postJson("/api/admin/properties/{$prop->id}/units", [
            'unit_type' => 'Duplex Penthouse',
            'size_sqft' => 4500,
            'bedrooms' => 5,
            'bathrooms' => 6,
            'price' => 75000000,
            'is_available' => true,
        ]);
        $unitRes->assertStatus(201)
                ->assertJson(['success' => true]);
        $unitId = $unitRes->json('data.id');

        // Delete gallery image
        $delImgRes = $this->actingAs($admin, 'sanctum')->deleteJson("/api/admin/properties/{$prop->id}/images/{$imageId}");
        $delImgRes->assertStatus(200);

        // Delete unit
        $delUnitRes = $this->actingAs($admin, 'sanctum')->deleteJson("/api/admin/properties/{$prop->id}/units/{$unitId}");
        $delUnitRes->assertStatus(200);
    }

    public function test_property_destroy_cleans_up_storage_files(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('media/facade.webp', 'fake image content');
        Storage::disk('public')->put('brochures/brochure.pdf', 'fake pdf content');

        $admin = User::factory()->create();
        $cat = Category::create(['name' => 'Commercial', 'is_active' => true]);
        $loc = Location::create(['name' => 'Tejgaon', 'city' => 'Dhaka', 'is_active' => true]);

        $prop = Property::create([
            'name' => 'Al-Noor Trade Center',
            'category_id' => $cat->id,
            'location_id' => $loc->id,
            'address' => 'Tejgaon I/A',
            'status' => 'ongoing',
            'type' => 'commercial',
            'featured_image' => '/storage/media/facade.webp',
            'brochure_pdf' => '/storage/brochures/brochure.pdf',
            'is_published' => true,
        ]);

        Storage::disk('public')->assertExists('media/facade.webp');
        Storage::disk('public')->assertExists('brochures/brochure.pdf');

        $response = $this->actingAs($admin, 'sanctum')->deleteJson('/api/admin/properties/' . $prop->id);
        $response->assertStatus(200);

        Storage::disk('public')->assertMissing('media/facade.webp');
        Storage::disk('public')->assertMissing('brochures/brochure.pdf');
    }
}
