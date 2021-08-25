<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeBudgetLine extends Model
{

    use HasFactory;

    const REPLACEMENT = 1;
    const WORKFORCE = 2;
    const PAINTING = 3;

    protected $fillable = [
        'name'
    ];

    public function budgetLines(){
        return $this->hasMany(BudgetLine::class);
    }

}
