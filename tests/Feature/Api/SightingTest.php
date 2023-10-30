<?php

use App\Models\Sighting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

it('requires sanctum token', function () {
    $response = $this->getJson('/api/sighting/list-all', []);
    $response->assertStatus(401);
});

it('returns all sightings', function () {
    actingAsSanctum();
    $response = $this->getJson('/api/sighting/list-all', []);
    $response->assertStatus(200);
});

it('returns user sightings', function () {
    actingAsSanctum();
    $response = $this->getJson('/api/sighting/list-mine', []);
    $response->assertStatus(200);
});

it('does not create a sighting without required fields', function () {
    actingAsSanctum();
    $response = $this->postJson('/api/sighting/create', []);
    $response->assertStatus(422);
});

it('can create a sighting', function () {
    $user = User::factory()->create();
    Sanctum::actingAs(
        $user,
        ['*']
    );
    $attributes = Sighting::factory()
        ->for($user)
        ->raw();
    $response = $this->postJson('/api/sighting/create', $attributes);
    $response->assertStatus(201)->assertJson(['message' => 'Sighting has been created']);
    $this->assertDatabaseHas('sightings', $attributes);
});
