<?php

namespace Database\Seeders;

use App\Models\SeverityDamage;
use Illuminate\Database\Seeder;

class SeverityDamageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $severities = $this->data();
        foreach($severities as $severity){
            SeverityDamage::create([
                'description' => $severity['description']
            ]);
        }
    }

    private function data(){
        return [
            [ 'description' => 'Leve' ],
            [ 'description' => 'Media' ],
            [ 'description' => 'Grave' ],
        ];
    }
}
