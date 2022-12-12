<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Budget Line
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Budget line model",
 *     description="Budget line model",
 * )
 */

class BudgetLine extends Model
{

    /**
     * @OA\Schema(
     *      schema="BudgetLinePaginate",
     *      allOf = {
     *          @OA\Schema(ref="#/components/schemas/Paginate"),
     *          @OA\Schema(
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/BudgetLine"),
     *              ),
     *          ),
     *      },
     * )
     * @OA\Property(
     *     property="id",
     *     type="integer",
     *     format="int64",
     *     description="ID",
     *     title="ID",
     * )
     *
     * @OA\Property(
     *     property="budget_id",
     *     type="integer",
     *     format="int64",
     *     description="Budget ID",
     *     title="Budget ID",
     * )
     *
     * @OA\Property(
     *     property="type_budget_line_id",
     *     type="integer",
     *     format="int64",
     *     description="Type of Budget Line ID",
     *     title="Type of Budget Line ID",
     * )
     *
     * @OA\Property(
     *     property="tax_id",
     *     type="integer",
     *     format="int64",
     *     description="Tax ID",
     *     title="Tax ID",
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
     *     property="price",
     *     type="number",
     *     format="double",
     *     description="Price",
     *     title="Price",
     * )
     *
     * @OA\Property(
     *     property="amount",
     *     type="number",
     *     format="double",
     *     description="Amount",
     *     title="Amount",
     * )
     *
     * @OA\Property(
     *     property="approved",
     *     type="boolean",
     *     description="Approved",
     *     title="Approved",
     * )
     *
     * @OA\Property(
     *     property="sub_total",
     *     type="number",
     *     format="double",
     *     description="Sub total",
     *     title="Sub total",
     * )
     *
     * @OA\Property(
     *     property="tax",
     *     type="number",
     *     format="double",
     *     description="Tax",
     *     title="Tax",
     * )
     *
     * @OA\Property(
     *     property="total",
     *     type="number",
     *     format="double",
     *     description="Total",
     *     title="Total",
     * )
     *
     * @OA\Property(
     *     property="created_at",
     *     type="string",
     *     format="date-time",
     *     description="when was created",
     *     title="Created at",
     * )
     *
     * @OA\Property(
     *     property="updated_at",
     *     type="string",
     *     format="date-time",
     *     description="when was last updated",
     *     title="Updated at",
     * )
     */

    use HasFactory, Filterable;

    protected $fillable = [
        'budget_id',
        'type_budget_line_id',
        'tax_id',
        'name',
        'sub_total',
        'tax',
        'total'
    ];

    public function budget(){
        return $this->belongsTo(Budget::class);
    }

    public function typeBudgetLine(){
        return $this->belongsTo(TypeBudgetLine::class);
    }

    public function tax(){
        return $this->belongsTo(Tax::class);
    }

    public function scopeByIds($query, array $ids){
        return $query->whereIn('id', $ids);
    }

    public function scopeByBudgetIds($query, array $ids){
        return $query->whereIn('budget_id', $ids);
    }

    public function scopeByTaxIds($query, array $ids){
        return $query->whereIn('tax_id', $ids);
    }

    public function scopeByName($query, $name){
        return $query->where('name','like',"%$name%");
    }
}
