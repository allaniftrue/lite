<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use App\Subscriber;
use App\Field;

class AddSubscriberFieldTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        factory(Subscriber::class, 20)->create()->each(function ($subscriber) {
            $subscriber->fields()->sync([
                factory(Field::class)->create()->id,
                factory(Field::class)->create()->id,
            ]);
        });
    }

    /** @test */
    public function get_subscriber_with_fields()
    {
        $this->actingAs($this->user)
            ->getJson('/api/subscribers')
            ->assertSuccessful()
            ->assertJsonCount(2, 'data.0.fields');
    }
}
