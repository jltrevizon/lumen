<?php

namespace Database\Seeders;

use App\Models\Accessory;
use App\Models\Reception;
use Faker\Factory;
use Illuminate\Database\Seeder;

class AccessorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $accesories = $this->data();
       foreach($accesories as $accessory){
           Accessory::create([
            'name' => $accessory['name']
           ]);
       }
    }

    public function data(){
        return [
            [ 'name' => 'Ficha técnica' ],
            [ 'name' => 'Autorización de circulación' ],
            [ 'name' => 'Libro mantenimiento' ],
            [ 'name' => '2ª juego de llaves' ],
            [ 'name' => 'Rueda repuesto - KIT' ],
            [ 'name' => 'Gato y manivela' ],
            [ 'name' => 'Seguro' ],
            [ 'name' => 'Etiqueta medioambiental' ],
            [ 'name' => 'Autotización conductor' ],
            [ 'name' => 'Manual de entretenimiento' ],
            [ 'name' => 'Tarjeta SD navegación' ],
            [ 'name' => 'KIT de seguridad' ],
            [ 'name' => 'Baca' ],
            [ 'name' => 'Panelado' ],
            [ 'name' => 'Cerradura de seguridad' ],
            [ 'name' => '2ª fila de asientos' ],
            [ 'name' => '3ª fila de asientos' ],
            [ 'name' => 'Navegador INT' ],
            [ 'name' => 'Navegador TSD' ],
            [ 'name' => 'Escalera' ],
            [ 'name' => 'Rejillas' ],
            [ 'name' => 'Barra portaequipaje' ],
            [ 'name' => 'Enganche' ],
            [ 'name' => 'Alfombrillas' ],
            [ 'name' => 'Cable eléctrico poste' ],
            [ 'name' => 'Cabestrante' ],
            [ 'name' => 'Boquilla GLP' ],
            [ 'name' => 'Cable eléctrico casa' ]
        ];
    }

}
