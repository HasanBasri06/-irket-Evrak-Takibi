<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Company extends Model
{
    use HasFactory;

    protected $table = 'company';
    protected $guarded = [];

    /**
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function owner() {
        return $this->hasOne(User::class, 'id', 'company_owner_id');
    }
}
