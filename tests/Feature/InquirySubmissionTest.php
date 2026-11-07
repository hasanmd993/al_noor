<?php

namespace Tests\Feature;

use App\Models\Inquiry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class InquirySubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_submit_valid_lead_inquiry(): void
    {
        $payload = [
            'name' => 'Dr. Kamal Hossain',
            'email' => 'kamal@example.com',
            'phone' => '+8801711223344',
            'subject' => 'VIP Viewing Request',
            'property_interest' => 'Al-Noor Crown Palace',
            'source' => 'property_inquiry',
            'message' => 'I would like to schedule a private tour this Saturday.',
        ];

        $response = $this->postJson('/api/inquiries', $payload);
        $response->assertStatus(201)
                 ->assertJson(['success' => true]);

        $this->assertDatabaseHas('inquiries', [
            'email' => 'kamal@example.com',
            'name' => 'Dr. Kamal Hossain',
            'status' => 'new',
            'is_read' => false,
        ]);
    }

    public function test_inquiry_requires_valid_email_and_name(): void
    {
        $response = $this->postJson('/api/inquiries', [
            'email' => 'invalid-email',
            'message' => 'Short message',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name', 'email']);
    }

    public function test_honeypot_traps_spam_bots(): void
    {
        $response = $this->postJson('/api/inquiries', [
            'name' => 'Spam Bot',
            'email' => 'bot@spammer.com',
            'message' => 'Buy cheap links now',
            'website' => 'http://spamsite.com', // Honeypot filled
        ]);

        $response->assertStatus(200);

        // Should not be in database
        $this->assertDatabaseMissing('inquiries', [
            'email' => 'bot@spammer.com',
        ]);
    }

    public function test_admin_can_update_inquiry_status(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $inquiry = Inquiry::create([
            'name' => 'Zubair Ahmed',
            'email' => 'zubair@example.com',
            'message' => 'Interested in Landowner JV',
            'source' => 'landowner',
            'is_read' => false,
            'status' => 'new',
        ]);

        $response = $this->putJson('/api/admin/inquiries/' . $inquiry->id, [
            'status' => 'contacted',
            'is_read' => true,
        ]);

        $response->assertStatus(200)
                 ->assertJson(['success' => true]);

        $this->assertDatabaseHas('inquiries', [
            'id' => $inquiry->id,
            'status' => 'contacted',
            'is_read' => true,
        ]);
    }
}

