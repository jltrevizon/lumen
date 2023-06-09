<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;
use App\Models\DefleetVariable;

class DefleetVariableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $variables = $this->data();
        foreach($variables as $variable){
            DefleetVariable::create([
                'company_id' => $variable['company_id'],
                'kms' => $variable['kms'],
                'years' => $variable['years']
            ]);
        }
    }

    public function data(){
        return [
            [
                'company_id' => Company::ALD,
                'kms' => '12000',
                'years' => random_int(1, 10)
            ]
        ];
    }
}
