<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('registers a new user', function () {
    $data = [
        'name' => 'John Doe',
        'email' => 'johndoe' . uniqid() . '@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ];

    $response = $this->postJson('/api/register', $data);

    $response->assertStatus(201);
    $response->assertJsonStructure([
        'data' => [
            'name',
            'email',
        ],
    ]);

    $this->assertDatabaseHas('users', [
        'email' => $data['email'],
    ]);
});

it('logs in an existing user', function () {
    $user = User::factory()->create([
        'email' => 'johndoe' . uniqid() . '@example.com',
        'password' => Hash::make('password123'),
    ]);

    $data = [
        'email' => $user->email,
        'password' => 'password123',
    ];

    $response = $this->postJson('/api/login', $data);

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'access_token',
        ],
    ]);
});

it('fails to log in with invalid credentials', function () {
    $user = User::factory()->create([
        'email' => 'johndoe' . uniqid() . '@example.com',
        'password' => Hash::make('password123'),
    ]);

    $data = [
        'email' => $user->email,
        'password' => 'wrongpassword',
    ];

    $response = $this->postJson('/api/login', $data);

    $response->assertStatus(401);
    $response->assertJson([
        'message' => 'Invalid Credentials',
    ]);
});
