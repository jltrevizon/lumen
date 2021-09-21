<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeopleForReport extends Model
{

    protected $fillable = [
        'user_id',
        'type_report_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function typeReportId(){
        return $this->belongsTo(TypeReport::class);
    }

}
