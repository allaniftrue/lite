<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Subscriber;
use App\User;

class FetchSubscribersTest extends TestCase
{
    /** @var \App\User */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        factory(Subscriber::class, 20)->create();
    }

    /** @test */
    public function fetch_paginated_subscribers()
    {
        $this->actingAs($this->user)
            ->getJson('/api/subscribers')
            ->assertSuccessful()
            ->assertJsonStructure(['data', 'total', 'per_page', 'current_page'])
            ->assertJsonCount(10, 'data');
    }

    /** @test */
    public function fetch_raw_subscribers()
    {
        $this->actingAs($this->user)
            ->getJson('/api/subscribers/?raw=true')
            ->assertSuccessful()
            ->assertJsonStructure(['data'])
            ->assertJsonCount(20, 'data');
    }
}
