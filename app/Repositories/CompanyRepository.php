<?php 

namespace App\Repositories;

use App\Models\Company;
use App\Traits\HttpResponse;
use Illuminate\Http\JsonResponse;

class CompanyRepository implements CompanyRepositoryInterface {

    use HttpResponse;

    public function __construct(
        private Company $company,
    )
    {
        $this->company = $company;
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

    public function hasCompanyByEmail(string $email): bool
    {
        if ($this->company->where('company_email', $email)->first()) {
            return true;
        }

        return false;
    }
}