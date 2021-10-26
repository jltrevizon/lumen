<?php

namespace App\Models;

use App\Repositories\UserRepository;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DefleetVariable extends Model
{

    use HasFactory, Filterable;

    protected $fillable = [
        'company_id',
        'kms',
        'years'
    ];

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function scopeByCompany($query, int $companyId){
        return $query->where('company_id', $companyId);
    }

}
