<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'domain' => $this->domain,
            'company_email' => $this->company_email,
            'logo' => $this->logo,
            'description' => $this->description,
            'companies' => CompanyWorkersResources::collection($this['employes'])
        ];
    }
}
