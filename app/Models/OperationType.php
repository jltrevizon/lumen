<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationType extends Model
{

    use HasFactory;

    const REPAIR = 1;
    const REPLACE = 2;

    protected $fillable = [
        'name'
    ];

    public function operations(){
        return $this->hasMany(Operation::class);
    }

}
