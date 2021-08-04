<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call('UsersTableSeeder');
        $this->call(AccessorySeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(DefleetVariableSeeder::class);
        $this->call(ProvinceSeeder::class);
        $this->call(QuestionSeeder::class);
        $this->call(RegionSeeder::class);
        $this->call(StatePendingTaskSeeder::class);
        $this->call(StateRequestSeeder::class);
        $this->call(StateSeeder::class);
        $this->call(SubStateSeeder::class);
        $this->call(TaskSeeder::class);
        $this->call(TradeStateSeeder::class);
        $this->call(TypeRequestSeeder::class);
        $this->call(TypeReservationSeeder::class);
        $this->call(TypeTaskSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(VehicleSeeder::class);
        $this->call(TypeUserAppSeeder::class);
        $this->call(OperationTypeSeeder::class);
    }
}
