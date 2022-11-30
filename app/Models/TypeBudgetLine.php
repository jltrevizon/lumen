<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Type Budget Line
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Type Budget Line model",
 *     description="Type Budget Line model",
 * )
 */

class TypeBudgetLine extends Model
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

    const REPLACEMENT = 1;
    const WORKFORCE = 2;
    const PAINTING = 3;

    protected $fillable = [
        'name'
    ];

    public function budgetLines(){
        return $this->hasMany(BudgetLine::class);
    }

}
