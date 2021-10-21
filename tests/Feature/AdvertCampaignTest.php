<?php

namespace Tests\Feature;

use App\Models\AdvertCampaign;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AdvertCampaignTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testIfUnAuthenticatedUserCanCreateCampaigns()
    {
        $response = $this->postJson('/api/advert-campaigns');

        $response->assertUnauthorized();
    }

    public function testIfUnAuthenticatedUserCanEditACampaign()
    {
        $campaign = AdvertCampaign::factory()->create()->first();
        $payload = [
            'name' => $this->faker->name,
            'daily_budget' => 500,
        ];

        $response = $this->putJson("/api/advert-campaigns/{$campaign->id}", $payload);

        $response->assertUnauthorized();
    }

    public function testIfAuthenticatedUserCanCreateCampaigns()
    {
        $this->withoutExceptionHandling();
        $campaign = AdvertCampaign::factory()->makeOne();
        $payload = $campaign->toArray();

        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->postJson("/api/advert-campaigns", $payload);

        $response->assertSuccessful()
            ->assertJsonStructure([
                'data' => ['advert_campaign']
            ]);
    }
}
