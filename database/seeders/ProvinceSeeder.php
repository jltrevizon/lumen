<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Province;
use App\Models\Region;

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
                'region_id' => Region::PAIS_VASCO,
                'province_code' => 'VI',
                'name' => 'Álava'
            ],
            [
                'region_id' => Region::CASTILLA_LA_MANCHA,
                'province_code' => 'AB',
                'name' => 'Albacete'
            ],
            [
                'region_id' => Region::COMMUNITY_VALENCIA,
                'province_code' => 'A',
                'name' => 'Alicante'
            ],[
                'region_id' => Region::ANDALUCIA,
                'province_code' => 'AL',
                'name' => 'Almería'
            ],[
                'region_id' => Region::ASTURIAS,
                'province_code' => 'O',
                'name' => 'Asturias'
            ],[
                'region_id' => Region::CASTILLA_LEON,
                'province_code' => 'AV',
                'name' => 'Ávila'
            ],[
                'region_id' => Region::EXTREMADURA,
                'province_code' => 'BA',
                'name' => 'Badajoz'
            ],[
                'region_id' => Region::BALEARES,
                'province_code' => 'PM',
                'name' => 'Baleares'
            ],[
                'region_id' => Region::CATALUÑA,
                'province_code' => 'B',
                'name' => 'Barcelona'
            ],[
                'region_id' => Region::CASTILLA_LA_MANCHA,
                'province_code' => 'BU',
                'name' => 'Burgos'
            ],[
                'region_id' => Region::EXTREMADURA,
                'province_code' => 'CC',
                'name' => 'Cáceres'
            ],[
                'region_id' => Region::ANDALUCIA,
                'province_code' => 'CA',
                'name' => 'Cádiz'
            ],[
                'region_id' => Region::CANTABRIA,
                'province_code' => 'S',
                'name' => 'Cantabria'
            ],[
                'region_id' => Region::COMMUNITY_VALENCIA,
                'province_code' => 'CS',
                'name' => 'Castellón'
            ],[
                'region_id' => Region::CASTILLA_LA_MANCHA,
                'province_code' => 'CR',
                'name' => 'Ciudad Real'
            ],[
                'region_id' => Region::ANDALUCIA,
                'province_code' => 'CO',
                'name' => 'Córdoba'
            ],[
                'region_id' => Region::CASTILLA_LA_MANCHA,
                'province_code' => 'CU',
                'name' => 'Cuenca'
            ],[
                'region_id' => Region::CATALUÑA,
                'province_code' => 'GI',
                'name' => 'Gerona'
            ],[
                'region_id' => Region::ANDALUCIA,
                'province_code' => 'GR',
                'name' => 'Granada'
            ],[
                'region_id' => Region::CASTILLA_LA_MANCHA,
                'province_code' => 'GU',
                'name' => 'Guadalajara'
            ],[
                'region_id' => Region::PAIS_VASCO,
                'province_code' => 'SS',
                'name' => 'Guizpúzcoa'
            ],[
                'region_id' => Region::ANDALUCIA,
                'province_code' => 'H',
                'name' => 'Huelva'
            ],[
                'region_id' => Region::ARAGON,
                'province_code' => 'HU',
                'name' => 'Huesca'
            ],[
                'region_id' => Region::ANDALUCIA,
                'province_code' => 'J',
                'name' => 'Jaén'
            ],[
                'region_id' => Region::GALICIA,
                'province_code' => 'C',
                'name' => 'La Coruña'
            ],[
                'region_id' => Region::LA_RIOJA,
                'province_code' => 'LO',
                'name' => 'La Rioja'
            ],[
                'region_id' => Region::CANARIAS,
                'province_code' => 'GC',
                'name' => 'Las Palmas'
            ],[
                'region_id' => Region::CASTILLA_LA_MANCHA,
                'province_code' => 'LE',
                'name' => 'León'
            ],[
                'region_id' => Region::CATALUÑA,
                'province_code' => 'L',
                'name' => 'Lérida'
            ],[
                'region_id' => Region::GALICIA,
                'province_code' => 'LU',
                'name' => 'Lugo'
            ],[
                'region_id' => Region::COMMUNITY_MADRID,
                'province_code' => 'M',
                'name' => 'Madrid'
            ],[
                'region_id' => Region::ANDALUCIA,
                'province_code' => 'MA',
                'name' => 'Málaga'
            ],[
                'region_id' => Region::MURCIA,
                'province_code' => 'MU',
                'name' => 'Murcia'
            ],[
                'region_id' => Region::NAVARRA,
                'province_code' => 'NA',
                'name' => 'Navarra'
            ],[
                'region_id' => Region::GALICIA,
                'province_code' => 'OR',
                'name' => 'Orense'
            ],[
                'region_id' => Region::CASTILLA_LEON,
                'province_code' => 'P',
                'name' => 'Palencia'
            ],[
                'region_id' => Region::GALICIA,
                'province_code' => 'PO',
                'name' => 'Pontevedra'
            ],[
                'region_id' => Region::CASTILLA_LEON,
                'province_code' => 'SA',
                'name' => 'Salamanca'
            ],[
                'region_id' => Region::CANARIAS,
                'province_code' => 'TF',
                'name' => 'Santa Cruz de Tenerife'
            ],[
                'region_id' => Region::CASTILLA_LEON,
                'province_code' => 'SG',
                'name' => 'Segovia'
            ],[
                'region_id' => Region::ANDALUCIA,
                'province_code' => 'SE',
                'name' => 'Sevilla'
            ],[
                'region_id' => Region::CASTILLA_LEON,
                'province_code' => 'SO',
                'name' => 'Soria'
            ],[
                'region_id' => Region::CATALUÑA,
                'province_code' => 'T',
                'name' => 'Tarragona'
            ],[
                'region_id' => Region::ARAGON,
                'province_code' => 'TE',
                'name' => 'Teruel'
            ],[
                'region_id' => Region::CASTILLA_LA_MANCHA,
                'province_code' => 'TO',
                'name' => 'Toledo'
            ],[
                'region_id' => Region::COMMUNITY_VALENCIA,
                'province_code' => 'V',
                'name' => 'Valencia'
            ],[
                'region_id' => Region::CASTILLA_LEON,
                'province_code' => 'VA',
                'name' => 'Valladolid'
            ],[
                'region_id' => Region::PAIS_VASCO,
                'province_code' => 'VI',
                'name' => 'Vizcaya'
            ],[
                'region_id' => Region::CASTILLA_LEON,
                'province_code' => 'ZA',
                'name' => 'Zamora'
            ],[
                'region_id' => Region::ARAGON,
                'province_code' => 'Z',
                'name' => 'Zaragoza'
            ],
        ];
    }
}
