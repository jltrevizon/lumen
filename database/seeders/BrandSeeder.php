<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = $this->data();
        foreach($brands as $brand){
            Brand::create([
                'name' => $brand['name']
            ]);
        }
    }

    public function data(){
        return [
            ['name' => 'Abarth'],
            ['name' => 'Alfa Romeo'],
            ['name' => 'Aston Martin'],
            ['name' => 'Audi'],
            ['name' => 'Bentley'],
            ['name' => 'BMW'],
            ['name' => 'byd'],
            ['name' => 'Chevrolet'],
            ['name' => 'Citroen'],
            ['name' => 'Dacia'],
            ['name' => 'DFSK'],
            ['name' => 'DS'],
            ['name' => 'Ferrari'],
            ['name' => 'Fiat'],
            ['name' => 'Ford'],
            ['name' => 'Honda'],
            ['name' => 'Hyundai'],
            ['name' => 'Infiniti'],
            ['name' => 'Isuzu'],
            ['name' => 'Jaguar'],
            ['name' => 'Jeep'],
            ['name' => 'Kia'],
            ['name' => 'Lada'],
            ['name' => 'Lamborghini'],
            ['name' => 'Lancia'],
            ['name' => 'Land Rover'],
            ['name' => 'Lexus'],
            ['name' => 'Mahindra'],
            ['name' => 'Maserati'],
            ['name' => 'Mazda'],
            ['name' => 'Mercedes'],
            ['name' => 'Mini'],
            ['name' => 'Mitsubishi'],
            ['name' => 'Morgan'],
            ['name' => 'Nissan'],
            ['name' => 'Opel'],
            ['name' => 'Peugeot'],
            ['name' => 'Porche'],
            ['name' => 'Renault'],
            ['name' => 'Roll-Royce'],
            ['name' => 'Seat'],
            ['name' => 'Skoda'],
            ['name' => 'Smart'],
            ['name' => 'Ssangyong'],
            ['name' => 'Subaru'],
            ['name' => 'Suzuki'],
            ['name' => 'Tata'],
            ['name' => 'Tesla'],
            ['name' => 'Toyota'],
            ['name' => 'Volkswagen'],
            ['name' => 'Volvo']
        ];
    }
}
