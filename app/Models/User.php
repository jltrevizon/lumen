<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Role;
use App\Models\Campa;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{

    use Authenticatable, Authorizable, HasFactory;

    protected $fillable = [
        'company_id',
        'role_id',
        'name',
        'surname',
        'email',
        'avatar',
        'phone',
        'first_login',
        'active'
    ];

    protected $hidden = [
        'password',
    ];

    public function campas(){
        return $this->belongsToMany(Campa::class);
    }

    public function role(){
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function type_user_app(){
        return $this->belongsTo(TypeUserApp::class);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

}
