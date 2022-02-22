<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StateAuthorization extends Model
{
    
    use HasFactory;

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
