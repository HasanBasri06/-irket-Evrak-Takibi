<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyWorkersResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'company_id' => $this->company_id,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'role' => $this->role,
            'user' => $this->user
        ];
    }
}
