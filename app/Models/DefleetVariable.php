<?php

namespace App\Models;

use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DefleetVariable extends Model
{

    use HasFactory;

    protected $fillable = [
        'company_id',
        'kms',
        'years'
    ];

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function scopeByCompany($query, $request){
        $userRepository = new UserRepository();
        $user = $userRepository->getById($request, Auth::id());
        return $query->where('company_id', $user['campas'][0]['company_id'])
                ->first();
    }

}
