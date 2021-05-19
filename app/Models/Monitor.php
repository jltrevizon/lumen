<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;

class Monitor extends Model
{

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
