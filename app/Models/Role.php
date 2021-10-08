<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    const ADMIN = 1;
    const GLOBAL_MANAGER = 2;
    const CAMPA_MANAGET = 3;
    const USER_APP = 4;
    const RECEPTION = 5;
    const COMMERCIAL = 6;
    const CONTROL = 7;
    const MANAGER_MECHANIC = 8;
    const MANAGER_CHAPA = 9;

    protected $fillable = [
        'description'
    ];

    public function users(){
        return $this->hasMany(User::class, 'user_id');
    }
}
