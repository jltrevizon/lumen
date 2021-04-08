<?php

namespace Database\Seeders;

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
                'kms' => $variable['kms'],
                'years' => $variable['years']
            ]);
        }
    }

    public function data(){
        return [
            [
                'kms' => '12000',
                'years' => 6
            ]
        ];
    }
}
