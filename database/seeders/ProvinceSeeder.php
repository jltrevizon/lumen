<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Province;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $provinces = $this->data();
        foreach($provinces as $province){
            Province::create([
                'region_id' => $province['region_id'],
                'province_code' => $province['province_code'],
                'name' => $province['name']
            ]);
        }
    }

    public function data(){
        return [
            [
                'region_id' => 14,
                'province_code' => 'VI',
                'name' => 'Álava'
            ],
            [
                'region_id' => 6,
                'province_code' => 'AB',
                'name' => 'Albacete'
            ],
            [
                'region_id' => 9,
                'province_code' => 'A',
                'name' => 'Alicante'
            ],[
                'region_id' => 1,
                'province_code' => 'AL',
                'name' => 'Almería'
            ],[
                'region_id' => 15,
                'province_code' => 'O',
                'name' => 'Asturias'
            ],[
                'region_id' => 5,
                'province_code' => 'AV',
                'name' => 'Ávila'
            ],[
                'region_id' => 10,
                'province_code' => 'BA',
                'name' => 'Badajoz'
            ],[
                'region_id' => 12,
                'province_code' => 'PM',
                'name' => 'Baleares'
            ],[
                'region_id' => 7,
                'province_code' => 'B',
                'name' => 'Barcelona'
            ],[
                'region_id' => 6,
                'province_code' => 'BU',
                'name' => 'Burgos'
            ],[
                'region_id' => 10,
                'province_code' => 'CC',
                'name' => 'Cáceres'
            ],[
                'region_id' => 1,
                'province_code' => 'CA',
                'name' => 'Cádiz'
            ],[
                'region_id' => 4,
                'province_code' => 'S',
                'name' => 'Cantabria'
            ],[
                'region_id' => 9,
                'province_code' => 'CS',
                'name' => 'Castellón'
            ],[
                'region_id' => 6,
                'province_code' => 'CR',
                'name' => 'Ciudad Real'
            ],[
                'region_id' => 1,
                'province_code' => 'CO',
                'name' => 'Córdoba'
            ],[
                'region_id' => 6,
                'province_code' => 'CU',
                'name' => 'Cuenca'
            ],[
                'region_id' => 7,
                'province_code' => 'GI',
                'name' => 'Gerona'
            ],[
                'region_id' => 1,
                'province_code' => 'GR',
                'name' => 'Granada'
            ],[
                'region_id' => 6,
                'province_code' => 'GU',
                'name' => 'Guadalajara'
            ],[
                'region_id' => 14,
                'province_code' => 'SS',
                'name' => 'Guizpúzcoa'
            ],[
                'region_id' => 1,
                'province_code' => 'H',
                'name' => 'Huelva'
            ],[
                'region_id' => 2,
                'province_code' => 'HU',
                'name' => 'Huesca'
            ],[
                'region_id' => 1,
                'province_code' => 'J',
                'name' => 'Jaén'
            ],[
                'region_id' => 11,
                'province_code' => 'C',
                'name' => 'La Coruña'
            ],[
                'region_id' => 13,
                'province_code' => 'LO',
                'name' => 'La Rioja'
            ],[
                'region_id' => 3,
                'province_code' => 'GC',
                'name' => 'Las Palmas'
            ],[
                'region_id' => 5,
                'province_code' => 'LE',
                'name' => 'León'
            ],[
                'region_id' => 7,
                'province_code' => 'L',
                'name' => 'Lérida'
            ],[
                'region_id' => 11,
                'province_code' => 'LU',
                'name' => 'Lugo'
            ],[
                'region_id' => 8,
                'province_code' => 'M',
                'name' => 'Madrid'
            ],[
                'region_id' => 1,
                'province_code' => 'MA',
                'name' => 'Málaga'
            ],[
                'region_id' => 16,
                'province_code' => 'MU',
                'name' => 'Murcia'
            ],[
                'region_id' => 17,
                'province_code' => 'NA',
                'name' => 'Navarra'
            ],[
                'region_id' => 11,
                'province_code' => 'OR',
                'name' => 'Orense'
            ],[
                'region_id' => 5,
                'province_code' => 'P',
                'name' => 'Palencia'
            ],[
                'region_id' => 11,
                'province_code' => 'PO',
                'name' => 'Pontevedra'
            ],[
                'region_id' => 5,
                'province_code' => 'SA',
                'name' => 'Salamanca'
            ],[
                'region_id' => 3,
                'province_code' => 'TF',
                'name' => 'Santa Cruz de Tenerife'
            ],[
                'region_id' => 5,
                'province_code' => 'SG',
                'name' => 'Segovia'
            ],[
                'region_id' => 1,
                'province_code' => 'SE',
                'name' => 'Sevilla'
            ],[
                'region_id' => 5,
                'province_code' => 'SO',
                'name' => 'Soria'
            ],[
                'region_id' => 7,
                'province_code' => 'T',
                'name' => 'Tarragona'
            ],[
                'region_id' => 2,
                'province_code' => 'TE',
                'name' => 'Teruel'
            ],[
                'region_id' => 6,
                'province_code' => 'TO',
                'name' => 'Toledo'
            ],[
                'region_id' => 9,
                'province_code' => 'V',
                'name' => 'Valencia'
            ],[
                'region_id' => 5,
                'province_code' => 'VA',
                'name' => 'Valladolid'
            ],[
                'region_id' => 14,
                'province_code' => 'VI',
                'name' => 'Vizcaya'
            ],[
                'region_id' => 5,
                'province_code' => 'ZA',
                'name' => 'Zamora'
            ],[
                'region_id' => 2,
                'province_code' => 'Z',
                'name' => 'Zaragoza'
            ],
        ];
    }
}
