<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\FAQResource;
use App\Models\Faq;
use App\Traits\V2\ApiResponseStructure;

class FAQController extends Controller
{
    use ApiResponseStructure;

    public function __construct()
    {
        \request()->headers->set('Accept','application/json');
    }

    public function index()
    {
        $perPage = \request()->query('per_page') ?? 10;
        $faqs = Faq::query()->latest();
        return $this->sendResponse(FAQResource::collection($faqs->paginate($perPage))->response()->getData(true), ' ', true,200);
    }

}
