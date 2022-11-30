<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Manual Questionnaire
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Manual Questionnaire model",
 *     description="Manual Questionnaire model",
 * )
 */

class ManualQuestionnaire extends Model
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
     *     property="vehicle_id",
     *     type="integer",
     *     format="int64",
     *     description="Vehicle ID",
     *     title="Vehicle ID",
     * )
     *
     * @OA\Property(
     *     property="filled_in",
     *     type="boolean",
     *     description="Filled ID",
     *     title="Filled ID",
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

    protected $fillable = [
        'vehicle_id',
        'filled_in'
    ];
}
