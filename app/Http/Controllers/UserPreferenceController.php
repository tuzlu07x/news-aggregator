<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPreferenceRequest;
use App\Models\UserPreference;
use App\Services\Preference\PreferenceServiceImpl;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class UserPreferenceController extends Controller
{
    public function __construct(private readonly PreferenceServiceImpl $userPreferenceService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): LengthAwarePaginator
    {
        return $this->userPreferenceService->list($request->user(), $request->input('limit', 10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserPreferenceRequest $request): UserPreference
    {
        $data = $request->validated();
        return $this->userPreferenceService->create($request->user()->id, $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserPreferenceRequest $request, UserPreference $preference): UserPreference
    {
        $data = $request->validated();
        return $this->userPreferenceService->update($request->user()->id, $preference->id, $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserPreference $preference): bool
    {
        return $this->userPreferenceService->delete($preference->user_id, $preference->id);
    }
}
