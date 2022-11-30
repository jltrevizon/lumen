<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Province;
use App\Models\Request;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Customer
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Customer model",
 *     description="Customer model",
 * )
 */

class Customer extends Model
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
     *     description="Company ID",
     *     title="Company ID",
     * )
     *
     * @OA\Property(
     *     property="province_id",
     *     type="integer",
     *     format="int64",
     *     description="Province ID",
     *     title="Province ID",
     * )
     *
     * @OA\Property(
     *     property="name",
     *     type="string",
     *     description="Name",
     *     title="Name",
     * )
     *
     * @OA\Property(
     *     property="cif",
     *     type="string",
     *     description="Cif",
     *     title="Cif",
     * )
     *
     * @OA\Property(
     *     property="phone",
     *     type="integer",
     *     format="int32",
     *     description="Phone",
     *     title="Phone",
     * )
     *
     * @OA\Property(
     *     property="address",
     *     type="string",
     *     description="Address",
     *     title="Address",
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
        'province_id',
        'name',
        'cif',
        'phone',
        'address'
    ];

    public function province(){
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function company(){
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function requests(){
        return $this->hasMany(Request::class, 'customer_id');
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByCompany($query, int $companyId){
        return $query->where('company_id', $companyId);
    }

    public function scopeByCompanies($query, array $ids){
        return $query->whereIn('company_id', $ids);
    }

    public function scopeByProvince($query, array $ids){
        return $query->whereIn('province_id', $ids);
    }

    public function scopeByName($query, string $name){
        return $query->where('name','like',"%$name%");
    }

    public function scopeByCif($query, string $cif){
        return $query->where('cif','like',"%$cif%");
    }

    public function scopeByPhone($query, string $phone){
        return $query->where('phone','like',"%$phone%");
    }

    public function scopeByAddress($query, string $address){
        return $query->where('address','like',"%$address%");
    }
}
