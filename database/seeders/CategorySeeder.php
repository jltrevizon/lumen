<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = $this->data();
        foreach($categories as $category){
            Category::create([
                'name' => $category['name']
            ]);
        }
    }

    public function data(){
        return [
            [ 'name' => '44'],
            [ 'name' => '4F'],
            [ 'name' => 'CDG2'],
            [ 'name' => 'CH'],
            [ 'name' => 'D1'],
            [ 'name' => 'D2'],
            [ 'name' => 'D4'],
            [ 'name' => 'DC'],
            [ 'name' => 'DF'],
            [ 'name' => 'EDC'],
            [ 'name' => 'EDF'],
            [ 'name' => 'ET2'],
            [ 'name' => 'F1'],
            [ 'name' => 'F2'],
            [ 'name' => 'F3'],
            [ 'name' => 'F6'],
            [ 'name' => 'F9'],
            [ 'name' => 'FBD1'],
            [ 'name' => 'FMD1'],
            [ 'name' => 'G3'],
            [ 'name' => 'G6'],
            [ 'name' => 'ICD3'],
            [ 'name' => 'IFD1'],
            [ 'name' => 'LC'],
            [ 'name' => 'M3'],
            [ 'name' => 'M6'],
            [ 'name' => 'M9'],
            [ 'name' => 'PC'],
            [ 'name' => 'PF'],
            [ 'name' => 'PK'],
            [ 'name' => 'SV'],
            [ 'name' => 'T1'],
            [ 'name' => 'T2'],
            [ 'name' => 'T3'],
            [ 'name' => 'TBD1'],
            [ 'name' => 'TC'],
            [ 'name' => 'TG'],
            [ 'name' => 'TP'],
            [ 'name' => 'TTE2'],
            [ 'name' => 'VR']
        ];
    }
}
