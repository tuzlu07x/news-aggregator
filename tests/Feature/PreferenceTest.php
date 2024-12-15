<?php

use App\Http\Resources\UserPreferenceResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\getJson;
use function Pest\Laravel\putJson;

uses(RefreshDatabase::class);

use App\Models\User;
use App\Models\UserPreference;

it('returns a list of preferences', function () {
    $user = User::factory()->create();
    UserPreference::factory()->count(15)->create([
        'user_id' => $user->id,
    ]);
    $token = $user->createToken('Test Token')->plainTextToken;

    $response = getJson('/api/preference?limit=10', [
        'Authorization' => 'Bearer ' . $token,
    ]);

    $response->assertStatus(200);
    expect($response->json('data'))->toHaveCount(10);
});

it('creates a new preference', function () {
    $user = User::factory()->create();
    $token = $user->createToken('Test Token')->plainTextToken;

    $this->withHeaders(['Authorization' => 'Bearer ' . $token]);
    $data = [
        "user_id" => $user->id,
        "areas_of_interest" => "politics",
    ];

    $response = $this->postJson('/api/preference', $data);

    $response->assertStatus(201);

    $preference = UserPreference::first();
    $expectedJson = (new UserPreferenceResource($preference))->response()->getData(true);
    $response->assertExactJson($expectedJson);
});

it('updates an existing preference', function () {
    $user = User::factory()->create();
    $token = $user->createToken('Test Token')->plainTextToken;
    $this->withHeaders(['Authorization' => 'Bearer ' . $token]);

    $preference = UserPreference::factory()->create();
    $updatedData = [
        "user_id" => $user->id,
        "areas_of_interest" => "politics",
    ];

    $response = putJson("/api/preference/{$preference->id}", $updatedData);
    $response->assertStatus(200);
    $preference->refresh();
    $expectedJson = (new UserPreferenceResource($preference))->response()->getData(true);
    $response->assertExactJson($expectedJson);
});

it('deletes a preference', function () {
    $user = User::factory()->create();
    $token = $user->createToken('Test Token')->plainTextToken;
    $this->withHeaders(['Authorization' => 'Bearer ' . $token]);

    $preference = UserPreference::factory()->create(['user_id' => $user->id]);

    $response = $this->deleteJson("/api/preference/{$preference->id}");

    $response->assertStatus(200);
    expect(UserPreference::find($preference->id))->toBeNull();
});
