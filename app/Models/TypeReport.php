<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeReport extends Model
{

    const ENTRY = 1;
    const EXITS = 2;
    const STOCK = 3;

    protected $fillable = [
        'name'
    ];

    public function peopleForReports(){
        return $this->hasMany(PeopleForReport::class);
    }
}
