<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StateAuthorization extends Model
{
    
    use HasFactory;

    const PENDING = 1;
    const APPROVED = 2;
    const REJECTED = 3;

    protected $fillable = [
        'name'
    ];

    protected $casts = [
        'name' => 'string'
    ];

    public function pendingAuthotizations(){
        return $this->hasMany(PendingAuthorization::class);
    }

}
