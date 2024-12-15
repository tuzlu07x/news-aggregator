<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPreferenceRequest;
use App\Http\Resources\UserPreferenceResource;
use App\Models\UserPreference;
use App\Services\Preference\PreferenceServiceImpl;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserPreferenceController extends Controller
{
    public function __construct(private readonly PreferenceServiceImpl $userPreferenceService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $preferences =  $this->userPreferenceService->list($request->user(), $request->input('limit', 10));
        return UserPreferenceResource::collection($preferences);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserPreferenceRequest $request): UserPreferenceResource
    {
        $data = $request->validated();
        $preference = $this->userPreferenceService->create($request->user()->id, $data);
        return UserPreferenceResource::make($preference);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserPreferenceRequest $request, UserPreference $preference): UserPreferenceResource
    {
        $data = $request->validated();
        $preference = $this->userPreferenceService->update($preference->user_id, $preference->id, $data);
        return UserPreferenceResource::make($preference);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserPreference $preference): \Illuminate\Http\JsonResponse
    {
        $isDeleted = $this->userPreferenceService->delete($preference->user_id, $preference->id);
        if ($isDeleted) return response()->json(['message' => 'UserPreference deleted successfully'], 200);
        return response()->json(['message' => 'UserPreference not found'], 404);
    }
}
