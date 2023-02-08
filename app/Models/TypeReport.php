<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Type Report
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Type Report model",
 *     description="Type Report model",
 * )
 */

class TypeReport extends Model
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

    const ENTRY = 1;
    const EXITS = 2;
    const STOCK = 3;
    const STATISTICS = 4;
    const PENDING_TASKS = 5;

    protected $fillable = [
        'name',
        'schedule'
    ];
    protected $casts = [
        'schedule' => 'array'
    ];
    public function peopleForReports(){
        return $this->hasMany(PeopleForReport::class);
    }
}
