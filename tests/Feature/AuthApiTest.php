<?php

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertAuthenticatedAs;
use function Pest\Laravel\assertGuest;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

test('POST /api/login 200', function () {
    $credentials = [
        'email' => 'someuser@example.com',
        'password' => 'sUpersEcretPasswordInTheEntireWorld123321!',
    ];

    $user = User::factory()->create($credentials);

    assertGuest();

    $headers = [
        'Origin' => 'localhost',
    ];
    postJson('/api/login', $credentials, $headers)
        ->assertStatus(200);

    assertAuthenticatedAs($user);
});

test('POST /api/logout 200', function () {
    $user = User::factory()->create();
    actingAs($user);

    assertAuthenticatedAs($user);

    $headers = [
        'Origin' => 'localhost',
    ];
    postJson('/api/logout', [], $headers)
        ->assertStatus(200);

    assertGuest();
});

test('GET /api/user 200', function () {
    $user = User::factory()->create();
    actingAs($user);

    assertAuthenticatedAs($user);

    $headers = [
        'Origin' => 'localhost',
    ];
    getJson('/api/user', $headers)
        ->assertStatus(200)
        ->assertJsonPath('data.id', $user->id);
});
