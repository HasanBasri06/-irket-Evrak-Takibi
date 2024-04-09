<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class Company extends Model
{
    use HasFactory;

    protected $table = 'company';
    protected $guarded = [];

    /**
     * @return HasOne
     */
    public function owner(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'company_owner_id');
    }

    /**
     * @return HasMany
     */
    public function employes(): HasMany
    {
        return $this->hasMany(CompanyWorker::class, 'company_id', 'id');
    }

    /**
     * @param Builder $query
     * @return void
     */
    public function scopeHasUserCompanies(Builder $query): void {
        $query->where('company_owner_id', Auth::id());
    }
}
