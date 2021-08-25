<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{

    use HasFactory;

    const IVA_GENERAL = 1;
    const IVA_REDUCED = 2;
    const IVA_SUPER_REDUCED = 3;
    const IGIC_GENERAL = 4;
    const IGIC_REDUCED = 5;
    const IGIC_CERO = 6;

    protected $fillable = [
        'name',
        'value',
        'description'
    ];

    public function budgetLines(){
        return $this->hasMany(BudgetLine::class);
    }

}
