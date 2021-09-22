<?php

namespace Database\Factories;

use App\Model;
use App\Models\PeopleForReport;
use App\Models\TypeReport;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeopleForReportFactory extends Factory
{
    protected $model = PeopleForReport::class;

    public function definition(): array
    {
    	return [
    	    'user_id' => User::factory()->create()->id,
            'type_report_id' => TypeReport::factory()->create()->id
    	];
    }
}
