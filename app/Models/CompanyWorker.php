<?php

namespace App\Models;

use App\Enums\IsActive;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CompanyWorker extends Model
{
    use HasFactory;

    protected $table = 'company_worker';
    protected $guarded = [];

    /**
     * @return HasOne
     */
    public function company(): HasOne
    {
        return $this->hasOne(Company::class, 'company_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeActiveCompanyWorker(Builder $query, int $userId) {
        $query->where('user_id', $userId)->where('status', IsActive::ACTIVE);
    }
}
