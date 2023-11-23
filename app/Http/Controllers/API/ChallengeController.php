<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChallengeResource;
use App\Models\Challenge;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ChallengeController extends Controller
{
    use ApiResponse;
    public function __construct()
    {
        \request()->headers->set('Accept','application/json');
    }

    public function index()
    {
        $perPage = \request()->query('per_page') ?? 5;
        $challenges = Challenge::withTranslation(app()->getLocale())
            ->latest()
            ->paginate($perPage)->appends(['per_page' => $perPage]);
        $result = ChallengeResource::collection($challenges);
        return $this->responseWithPagination($result,$result->all(),$result->currentPage());
    }
    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $challenge = Challenge::query()->with('exercises')->withTranslation(app()->getLocale())->findOrFail($id);
        return $this->success(" ",new ChallengeResource($challenge));
    }


}
