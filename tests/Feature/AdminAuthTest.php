<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_cannot_access_admin_dashboard_stats(): void
    {
        $response = $this->getJson('/api/admin/dashboard-stats');
        $response->assertStatus(401);
    }

    public function test_unauthenticated_user_cannot_access_admin_properties(): void
    {
        $response = $this->getJson('/api/admin/properties');
        $response->assertStatus(401);
    }

    public function test_unauthenticated_user_cannot_access_admin_me(): void
    {
        $response = $this->getJson('/api/admin/me');
        $response->assertStatus(401);
    }

    public function test_authenticated_admin_can_access_dashboard_stats(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/admin/dashboard-stats');
        $response->assertStatus(200)
                 ->assertJson(['success' => true]);
    }

    public function test_authenticated_admin_can_access_admin_me(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/admin/me');
        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'user' => ['id' => $user->id, 'email' => $user->email]
                 ]);
    }
}
