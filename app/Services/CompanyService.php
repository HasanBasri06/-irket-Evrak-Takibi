<?php

namespace App\Services;

use App\Jobs\SendNotificationCompanyRequest;
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
    public function hasCompanyByEmail(string $email = null): bool {
        return $this->companyRepository->hasCompanyByEmail($email);
    }

    /**
     * @param int $userId
     * @return array
     */
    public function isHaveCompany(int $userId): array {
        $isHaveCompany = $this->companyRepository->isHaveCompany($userId);

        if ($isHaveCompany->isNotEmpty()) {
            return [
                'status' => true,
                'companies' => $isHaveCompany
            ];
        }

        return [
            'status' => false,
            'companies' => null
        ];
    }

    public function requestCompanyIsWorking(int $companyId) {
        if (!$this->hasCompany($companyId)) {
            return [
                'status' => false,
                'message' => 'Böyle bir şirket bulunamadı.',
            ];
        }

        $requestCompany = $this->companyRepository->requestCompany($companyId);

        if (!$requestCompany) {
            return [
                'status' => false,
                'message' => 'Bu şirket de zaten başvurunuz bulunmaktadır.',
            ];
        }

        SendNotificationCompanyRequest::dispatch($companyId)->onQueue('send_request_company');

        return [
            'status' => true,
            'message' => 'Şirkete başvurunuz gönderilmiştir.',
        ];
    }

    /**
     * @param int $companyId
     * @return bool
     */
    public function hasCompany(int $companyId): bool {
        if ($this->companyRepository->hasCompany($companyId)) {
            return true;
        }

        return false;
    }
}
