<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyLoginRequest;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\AuthCompanyResources;
use App\Services\CompanyService;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
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

    public function myCompanies() {
        $isHaveCompany = $this->companyService->isHaveCompany(Auth::id());

        if ($isHaveCompany['status']) {
            return $this->success(new AuthCompanyResources($isHaveCompany), 'şirketler listelenmiştir', 200);
        }

        return $this->info(null, 'Henüz bir şirket bulunamadı.', 200);
    }

    /**
     * @param CompanyRequest $request
     * @return mixed
     */
    public function register(CompanyRequest $request): mixed {
        return $this->companyService->store($request->all());
    }

    public function addCompanyWorker(Request $request)
    {

    }

    public function sendRequestCompany(Request $request)
    {
        $companyId = $request->company_id;

        dd($this->companyService->requestCompanyIsWorking($companyId));
    }
}
