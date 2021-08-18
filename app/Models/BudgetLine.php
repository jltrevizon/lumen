<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetLine extends Model
{
    protected $fillable = [
        'budget_id',
        'type_budget_line_id',
        'tax_id',
        'name',
        'sub_total',
        'tax',
        'total'
    ];

    public function budget(){
        return $this->belongsTo(Budget::class);
    }
}
