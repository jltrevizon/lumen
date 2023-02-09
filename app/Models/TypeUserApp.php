<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Type User App
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Type User App model",
 *     description="Type User App model",
 * )
 */

class TypeUserApp extends Model
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

    const RESPONSABLE_CAMPA = 1;
    const OPERATOR_CAMPA = 2;
    const WORKSHOP_MECHANIC = 3;
    const WORKSHOP_CHAPA = 4;
    const FLEETS = 5;
    const WASHED = 6;
    const MOONS = 7;

    public function subStates(){
        return $this->belongsToMany(SubState::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }
}
