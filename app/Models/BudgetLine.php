<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetLine extends Model
{

    use HasFactory;

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

    public function typeBudgetLine(){
        return $this->belongsTo(TypeBudgetLine::class);
    }

    public function tax(){
        return $this->belongsTo(Tax::class);
    }
}
