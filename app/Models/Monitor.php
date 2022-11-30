<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Exception;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Monitor
 *
 * @package Focus API
 *
 *
 * @OA\Schema(
 *     title="Monitor model",
 *     description="Monitor model",
 * )
 */

class Monitor extends Model
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
     *     property="created_by",
     *     type="integer",
     *     format="int64",
     *     description="Created by",
     *     title="Created by",
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
     *     property="description",
     *     type="string",
     *     description="Description",
     *     title="Description",
     * )
     *
     * @OA\Property(
     *     property="data",
     *     type="string",
     *     description="Data",
     *     title="Data",
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

    use Filterable;

    protected $casts = [
        'data' => "array",
    ];

    /**
 * @param string $name
 * @param array $data
 * @param string|null $description
 */
public static function monitor(string $name, array $data, string $description = null)
{
    $data = [
        'name' => $name,
        'description' => $description,
        'data' => $data
    ];
    try {
        Monitor::forceCreate($data);
    } catch (Exception $exception) {
        info($exception->getMessage());
    }
}
}
