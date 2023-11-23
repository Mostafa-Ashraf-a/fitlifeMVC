<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BodyPartResource;
use App\Models\BodyPart;
use App\Traits\ApiResponse;

class BodyPartController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        \request()->headers->set('Accept','application/json');
    }

    public function index()
    {
        $perPage = \request()->query('per_page') ?? 5;
        $exerciseTypes = BodyPart::withTranslation(app()->getLocale())->paginate($perPage)->appends(
            ['per_page' => $perPage]
        );
        $result = BodyPartResource::collection($exerciseTypes);
        return $this->responseWithPagination($result,$result->all(),$result->currentPage());
    }

}
