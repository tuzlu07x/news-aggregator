<?php

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;
use function Pest\Laravel\deleteJson;

uses(RefreshDatabase::class);

use App\Models\User;

it('returns a list of articles', function () {
    $user = User::factory()->create();
    $token = $user->createToken('Test Token')->plainTextToken;

    Article::factory()->count(15)->create();

    $response = getJson('/api/article?limit=10', [
        'Authorization' => 'Bearer ' . $token,
    ]);

    $response->assertStatus(200);
    expect($response->json('data'))->toHaveCount(10);
});

it('creates a new article', function () {
    $user = User::factory()->create();
    $token = $user->createToken('Test Token')->plainTextToken;
    $this->withHeaders(['Authorization' => 'Bearer ' . $token]);

    $data = [
        "title" => "Cum qui debitis ad magnam consequatur voluptas et.",
        "content" => "Voluptatibus libero earum odit distinctio inventore est. Qui reiciendis odit doloribus quibusdam. Eos quod mollitia eum accusamus dolorem qui.",
        "category" => "politics",
        "author" => "Lacey Kulas",
        "source" => "Google",
        "published_at" => "1975-06-02 04:49:06",
    ];

    $response = postJson('/api/article', $data);

    $response->assertStatus(201);
    $response->assertJsonPath('data.title', $data['title']);
    $response->assertJsonPath('data.content', $data['content']);
});

it('shows a single article', function () {
    $user = User::factory()->create();
    $token = $user->createToken('Test Token')->plainTextToken;
    $this->withHeaders(['Authorization' => 'Bearer ' . $token]);
    $article = Article::factory()->create();

    $response = getJson("/api/article/{$article->id}");

    $response->assertStatus(200);
    $response->assertJsonPath('data.id', $article->id);
});

it('updates an existing article', function () {
    $user = User::factory()->create();
    $token = $user->createToken('Test Token')->plainTextToken;
    $this->withHeaders(['Authorization' => 'Bearer ' . $token]);

    $article = Article::factory()->create();
    $updatedData = [
        'title' => 'Updated Title',
        'content' => 'Updated content.',
        'category' => 'politics',
        'author' => 'Lacey Kulas',
        'source' => 'Google',
        'published_at' => '2010-06-02 04:49:06',
    ];

    $response = putJson("/api/article/{$article->id}", $updatedData);
    $response->assertStatus(200);
    $response->assertJsonPath('data.title', $updatedData['title']);
    $response->assertJsonPath('data.content', $updatedData['content']);
});
it('deletes an article', function () {
    $user = User::factory()->create();
    $token = $user->createToken('Test Token')->plainTextToken;
    $this->withHeaders(['Authorization' => 'Bearer ' . $token]);

    $article = Article::factory()->create();
    $response = deleteJson("/api/article/{$article->id}");
    $response->assertStatus(200);
    expect(Article::find($article->id))->toBeNull();
});
