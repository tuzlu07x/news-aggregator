<?php

use Mockery;
use App\Models\User;
use App\Models\UserPreference;
use App\Services\Preference\PreferenceServiceImpl;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class)->group('user_preferences');

beforeEach(function () {
    $this->mockArticleService = Mockery::mock(PreferenceServiceImpl::class);
    app()->instance(PreferenceServiceImpl::class, $this->mockArticleService);
});

it('can list preferences', function () {
    $user = User::factory()->create();

    $preferencesCollection = collect([
        ['id' => 1, 'user_id' => $user->id, 'areas_of_interest' => 'technology', 'created_at' => now(), 'updated_at' => now()],
        ['id' => 2, 'user_id' => $user->id, 'areas_of_interest' => 'politics', 'created_at' => now(), 'updated_at' => now()],
    ]);

    $paginator = Mockery::mock(LengthAwarePaginator::class);
    $paginator->shouldReceive('count')->andReturn($preferencesCollection->count());
    $paginator->shouldReceive('items')->andReturn($preferencesCollection->all());
    $paginator->shouldReceive('getCollection')->andReturn($preferencesCollection);

    $this->mockArticleService->shouldReceive('list')
        ->once()
        ->with($user, 10)
        ->andReturn($paginator);

    $preferences = $this->mockArticleService->list($user, 10);
    expect($preferences->count())->toBe(2);
    expect(collect($preferences->items())->first()['areas_of_interest'])->toBe('technology');
});

it('can create an preferences', function () {
    $user = User::factory()->create();

    $data = [
        'areas_of_interest' => 'sports',
    ];

    $this->mockArticleService->shouldReceive('create')
        ->once()
        ->with($user->id, $data)
        ->andReturn(new UserPreference($data));

    $preference = $this->mockArticleService->create($user->id, $data);

    expect($preference->areas_of_interest)->toBe('sports');
});

it('can update an preferences', function () {
    $user = User::factory()->create();
    $preference = new UserPreference([
        'id' => 1,
        'user_id' => $user->id,
        'areas_of_interest' => 'politics',
    ]);
    $preference->save();

    $data = [
        'areas_of_interest' => 'technology',
    ];
    $this->mockArticleService->shouldReceive('update')
        ->once()
        ->with($user->id, $preference->id, $data)
        ->andReturn(tap($preference, function ($preference) use ($data) {
            $preference->areas_of_interest = $data['areas_of_interest'];
        }));

    $updatedPreference = $this->mockArticleService->update($user->id, $preference->id, $data);
    expect($updatedPreference->areas_of_interest)->toBe('technology');
});


it('can delete an preferences', function () {
    $user = User::factory()->create();
    $preference = new UserPreference([
        'id' => 1,
        'user_id' => $user->id,
        'areas_of_interest' => 'politics',
    ]);
    $preference->save();

    $this->mockArticleService->shouldReceive('delete')
        ->once()
        ->with($user->id, $preference->id)
        ->andReturn(true);

    $deletedArticle = $this->mockArticleService->delete($preference->user_id, $preference->id);
    expect($deletedArticle)->toBeTrue();
});
