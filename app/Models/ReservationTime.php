<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Company;

class ReservationTime extends Model
{
    public function company(){
        return $this->belongsTo(Company::class, 'company_id');
    }
}
