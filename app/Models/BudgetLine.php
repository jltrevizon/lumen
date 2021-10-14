<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetLine extends Model
{

    use HasFactory, Filterable;

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

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByBudgetIds($query, array $ids){
        return $query->whereIn('budget_id', $ids);
    }

    public function scopeByTaxIds($query, array $ids){
        return $query->whereIn('tax_id', $ids);
    }

    public function scopeByName($query, $name){
        return $query->where('name','like',"%$name%");
    }
}
