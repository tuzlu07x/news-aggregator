<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecommendationResource;
use App\Services\Recommendation\RecommendationServiceImpl;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    public function __construct(private readonly RecommendationServiceImpl $recommendationService) {}

    public function index(Request $request)
    {
        $recommendations = $this->recommendationService->recommend($request->user()->id, $request->input('limit', 10));
        return RecommendationResource::collection($recommendations);
    }
}
