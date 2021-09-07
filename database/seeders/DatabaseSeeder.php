<?php

namespace Database\Seeders;

use App\Models\Campa;
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
        //$this->call(AccessorySeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(RegionSeeder::class);
        $this->call(ProvinceSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(CampaSeeder::class);
        $this->call(DefleetVariableSeeder::class);
        $this->call(QuestionSeeder::class);
        $this->call(StatePendingTaskSeeder::class);
        $this->call(StateRequestSeeder::class);
        $this->call(StateSeeder::class);
        $this->call(State1Seeder::class);
        $this->call(SubStateSeeder::class);
        $this->call(SubState1Seeder::class);
        $this->call(SubState2Seeder::class);
        $this->call(OperationTypeSeeder::class);
        $this->call(TypeTaskSeeder::class);
        $this->call(TaskSeeder::class);
        $this->call(Task1Seeder::class);
        $this->call(Task2Seeder::class);
        $this->call(TradeStateSeeder::class);
        $this->call(TypeRequestSeeder::class);
        $this->call(TypeReservationSeeder::class);
        $this->call(TypeUserAppSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(TaxSeeder::class);
        $this->call(VehicleSeeder::class);
    }
}
