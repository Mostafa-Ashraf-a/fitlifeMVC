<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\EquipmentResource;
use App\Models\Equipment;
use App\Traits\ApiResponse;

class EquipmentController extends Controller
{
    public function __construct()
    {
        \request()->headers->set('Accept','application/json');
    }
    use ApiResponse;
    public function index()
    {
        $perPage = \request()->query('per_page') ?? 10;
        $equipments = Equipment::withTranslation(app()->getLocale())->paginate($perPage)->appends(
            ['per_page' => $perPage]
        );
        $result = EquipmentResource::collection($equipments);
        return $this->responseWithPagination($result,$result->all(),$result->currentPage());
    }
}
