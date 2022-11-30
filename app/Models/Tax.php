<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tax
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Tax model",
 *     description="Tax model",
 * )
 */

class Tax extends Model
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
     *     property="name",
     *     type="string",
     *     description="Name",
     *     title="Name",
     * )
     *
     * @OA\Property(
     *     property="value",
     *     type="number",
     *     format="double",
     *     description="Value",
     *     title="Value",
     * )
     *
     * @OA\Property(
     *     property="description",
     *     type="string",
     *     description="Description",
     *     title="Description",
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
    use HasFactory;

    const IVA_GENERAL = 1;
    const IVA_REDUCED = 2;
    const IVA_SUPER_REDUCED = 3;
    const IGIC_GENERAL = 4;
    const IGIC_REDUCED = 5;
    const IGIC_CERO = 6;

    protected $fillable = [
        'name',
        'value',
        'description'
    ];

    public function budgetLines(){
        return $this->hasMany(BudgetLine::class);
    }

}
