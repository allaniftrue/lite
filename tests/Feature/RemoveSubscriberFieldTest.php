<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use App\Field;
use App\Subscriber;

class RemoveSubscriberFieldTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        factory(Subscriber::class)->create()->each(function ($subscriber) {
            $subscriber->fields()->sync([
                factory(Field::class)->create()->id,
                factory(Field::class)->create()->id,
            ]);
        });
    }

    /** @test */
    public function user_can_delete_subscriber_field()
    {
        $payload = [
            'id' => 1,
            'subscriber' => 1,
        ];

        $this->actingAs($this->user)
            ->deleteJson('/api/subscriber/fields', $payload)
            ->assertSuccessful();

        $this->actingAs($this->user)
            ->getJson('/api/subscribers')
            ->assertSuccessful()
            ->assertJsonCount(1, 'data.0.fields');
    }
}
