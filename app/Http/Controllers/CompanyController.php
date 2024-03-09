<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Services\CompanyService;
use App\Traits\HttpResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Response;
use OpenApi\Attributes as QA;

class CompanyController extends Controller
{
    use HttpResponse;

    /**
     * @param CompanyService $companyService
     */
    public function __construct(
        private CompanyService $companyService,
    )
    {
        $this->companyService = $companyService;
    }

    #[QA\Get(
        path: '/',
        responses: [
            new QA\Response(response: 200, description: 'deneme')
        ]
    )]
    public function index() {

    }

    public function register(CompanyRequest $request) {
        return $this->companyService->store($request->all());
    }
}