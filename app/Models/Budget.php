<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{

    protected $fillable = [
        'sub_total',
        'tax',
        'total'
    ];

    public function budgetLines(){
        return $this->hasMany(BudgetLine::class);
    }

}
