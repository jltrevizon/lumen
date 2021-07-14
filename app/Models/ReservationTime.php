<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReservationTime extends Model
{

    use HasFactory;

    public function company(){
        return $this->belongsTo(Company::class, 'company_id');
    }
}
