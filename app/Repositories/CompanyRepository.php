<?php

namespace App\Repositories;

use App\Enums\IsActive;
use App\Models\Company;
use App\Models\CompanyUserRequest;
use App\Models\CompanyWorker;
use App\Traits\HttpResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CompanyRepository implements CompanyRepositoryInterface {

    use HttpResponse;

    public function __construct(
        private Company $company,
        private CompanyWorker $companyWorker,
        private CompanyUserRequest $companyUserRequest,
    )
    {
        $this->company = $company;
        $this->companyWorker = $companyWorker;
        $this->$companyUserRequest = $companyUserRequest;
    }

    /**
     * @param $company
     * @return void
     */
    public function store($company): JsonResponse
    {
        try {
            if ($this->company->create($company->toArray())) {
                return $this->success(null, 'Şirket başarılı bir şekilde eklendi.', 201);
            }
        } catch (\Throwable $th) {
            return $this->success(null, 'Şirket eklemede beklenmedik bir hata oluştu.', 500);
        }
    }

    public function hasCompanyByEmail(string $email = null): bool
    {
        if ($this->company->where('company_email', $email)->first()) {
            return true;
        }

        return false;
    }

    /**
     * @param int $userId
     * @return mixed
     */
    public function isHaveCompany(int $userId)
    {
        return $this->company
            ->hasUserCompanies()
            ->with(['employes' => function ($query) {
                $query->whereHas('user', function ($query) {
                    $query->where('status', IsActive::ACTIVE);
                });
            }])
            ->get();

    }

    public function hasCompany(int $companyId)
    {
        return $this->company
            ->where('id', $companyId)
            ->where('status', IsActive::ACTIVE)
            ->first();
    }

    /**
     * @param int $companyId
     * @return mixed
     */
    public function requestCompany(int $companyId)
    {
        $isAlreadyExistRequestForCompany = $this->companyUserRequest
            ->where('company_id', $companyId)
            ->where('user_id', Auth::id())
            ->first();

        if ($isAlreadyExistRequestForCompany) {
            return false;
        }

        $this->companyUserRequest->create([
            'company_id' => $companyId,
            'user_id' => Auth::id(),
            'status' => IsActive::ACTIVE,
        ]);

        return true;
    }
}
