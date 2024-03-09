<?php 

namespace App\Services;

use App\Repositories\CompanyRepositoryInterface;
use App\Traits\FileService;

class CompanyService {    

    use FileService;

    public function __construct(
        private CompanyRepositoryInterface $companyRepository,
    )
    {
        $this->companyRepository = $companyRepository;
    }

    public function store($company) {
        $companyCollection = collect([
            'logo' => null,
            'name' => null,
            'domain' => null,
            'company_email' => null,
            'description' => null,
        ]);

        if (request()->hasFile('logo')) {
            $fileStore = $this->storeAs($company['logo']);

            $companyCollection->put('logo', $fileStore);
        }   

        $companyCollection->put('name', $company['name']);
        $companyCollection->put('domain', $company['domain']);
        $companyCollection->put('company_email', $company['company_email']);
        $companyCollection->put('description', $company['description']);

        return $this->companyRepository->store($companyCollection);
    }

    /**
     * @param string $email
     * @return bool
     */
    public function hasCompanyByEmail(string $email): bool {
        return $this->companyRepository->hasCompanyByEmail($email);
    }   
}