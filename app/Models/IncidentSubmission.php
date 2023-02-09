<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Incidence Submission
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Incidence Submission model",
 *     description="Incidence Submission model",
 * )
 */

class IncidentSubmission extends Model
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
     *     property="email",
     *     type="string",
     *     format="email",
     *     description="Email",
     *     title="Email",
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
        'email'
    ];
}
