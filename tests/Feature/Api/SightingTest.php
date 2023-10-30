<?php

use App\Models\Sighting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('requires sanctum token', function () {
    $response = $this->postJson('/api/sighting/list-all', []);
    $response->assertStatus(401);
});

it('returns all sightings', function () {
    $response = $this->postJson('/api/sighting/list-all', []);
    $response->assertStatus(200);
});

it('returns user sightings', function () {
    $response = $this->postJson('/api/sighting/list-mine', []);
    $response->assertStatus(200);
});

it('does not create a sighting without required fields', function () {
    actingAsSanctum();
    $response = $this->postJson('/api/sighting/create', []);
    $response->assertStatus(422);
});

it('can create a sighting', function () {
    actingAsSanctum();
    $user = User::factory()->create();

    $attributes = Sighting::factory()
        ->for($user)
        ->raw();

    $response = $this->postJson('/api/sighting/create', $attributes);
    $response->assertStatus(201)->assertJson(['message' => 'Sighting has been created']);
    $this->assertDatabaseHas('sightings', $attributes);
});
