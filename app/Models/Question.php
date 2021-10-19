<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

    use HasFactory, Filterable;

    protected $fillable = [
        'company_id',
        'question',
        'description'
    ];

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function question_answer(){
        return $this->hasMany(QuestionAnswer::class);
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByCompanyIds($query, array $ids){
        return $query->whereIn('company_id', $ids);
    }

    public function scopeByNameQuestion($query, string $question){
        return $query->where('question', 'like', "%$question%");
    }

}
