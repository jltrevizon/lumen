<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Region;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regions = $this->data();
        foreach($regions as $region){
            Region::create([
                'name' => $region['name']
            ]);
        }
    }

    public function data(){
        return [
            [ 'name' => 'Andalucía' ],
            [ 'name' => 'Aragón' ],
            [ 'name' => 'Canarias' ],
            [ 'name' => 'Cantabria' ],
            [ 'name' => 'Castilla y León' ],
            [ 'name' => 'Castilla-La Mancha' ],
            [ 'name' => 'Cataluña' ],
            [ 'name' => 'Comunidad de Madrid' ],
            [ 'name' => 'Comunidad Valenciana' ],
            [ 'name' => 'Extremadura' ],
            [ 'name' => 'Galicia' ],
            [ 'name' => 'Islas Baleares' ],
            [ 'name' => 'La Rioja' ],
            [ 'name' => 'País Vasco' ],
            [ 'name' => 'Principado de Asturias' ],
            [ 'name' => 'Región de Murcia' ],
            [ 'name' => 'Navarra' ],
        ];
    }
}
