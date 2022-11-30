<?php

namespace App\Models;

use App\Repositories\UserRepository;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class Defleet Variable
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Defleet variable model",
 *     description="Defleet variable model",
 * )
 */

class DefleetVariable extends Model
{

    /**
     * @OA\Property(
     *     property="id",
     *     type="integer",
     *     format="int64",
     *     description="ID",
     *     title="ID",
     * )
     *
     * @OA\Property(
     *     property="company_id",
     *     type="integer",
     *     format="int64",
     *     description="ID",
     *     title="ID",
     * )
     *
     *  @OA\Property(
     *     property="kms",
     *     type="integer",
     *     format="int32",
     *     description="Kms",
     *     title="Kms",
     * )
     *
     * @OA\Property(
     *     property="years",
     *     type="integer",
     *     format="int32",
     *     description="Years",
     *     title="Years",
     * )
     *
     * @OA\Property(
     *     property="created_at",
     *     type="string",
     *     format="date-time",
     *     description="When was created",
     *     title="Created at",
     * )
     *
     * @OA\Property(
     *     property="updated_at",
     *     type="string",
     *     format="date-time",
     *     description="When was last updated",
     *     title="Updated at",
     * )
     */

    use HasFactory, Filterable;

    protected $fillable = [
        'company_id',
        'kms',
        'years'
    ];

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function scopeByCompany($query, int $companyId){
        return $query->where('company_id', $companyId);
    }

}
