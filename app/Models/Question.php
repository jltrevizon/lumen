<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

    use HasFactory;

    protected $fillable = [
        'company_id',
        'question',
        'description'
    ];

    public function company(){
        return $this->belongsTo(Company::class);
    }
}
