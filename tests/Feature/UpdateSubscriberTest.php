<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class UpdateSubscriberTest extends TestCase
{
    /** @var \App\User */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        factory(\App\Subscriber::class)->create();
    }

    /** @test */
    public function a_subscriber_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $payload = [
            'id' => 1,
            'name' => 'Allan Joseph',
            'email' => 'ajmcagadas@mailerlite.com',
            'status' => 'ACTIVE'
        ];

        $this->actingAs($this->user)
            ->patchJson('/api/subscriber', $payload)
            ->assertSuccessful();

        $this->assertDatabaseHas('subscribers', $payload);
    }

    public function update_subscriber_with_invalid_data()
    {
        $this->withoutExceptionHandling();

        $payload = [
            'id' => 'id',
            'name' => '',
            'email' => 'ajmcagadas@mailerlite.com',
            'status' => 'SAMPLE_123'
        ];

        $this->actingAs($this->user)
            ->patchJson('/api/subscriber', $payload)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['status', 'email', 'name', 'id']);
    }
}
