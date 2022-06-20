<?php

namespace Database\Seeders;

use App\Models\StateAuthorization;
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
        $this->call(AccessoryTypeSeeder::class);
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
        $this->call(TypeReportSeeder::class);
        $this->call(IncidenceTypeSeeder::class);
        $this->call(StateAuthorizationSeeder::class);
        $this->call(DamageTypeSeeder::class);
        $this->call(SeverityDamageSeeder::class);
        $this->call(ZoneLeganesSeeder::class);
        $this->call(StreetLeganesSeeder::class);
        $this->call(SquareLeganesSeeder::class);
        $this->call(StateBudgetPendingTaskSeeder::class);
        $this->call(StatusDamageSeeder::class);
        $this->call(SubStateTypeUserSeeder::class);
        $this->call(TypeBudgetLineSeeder::class);
        $this->call(TypeDeliverySeeder::class);
        $this->call(TypeModelOrderSeeder::class);
        $this->call(TypeDeliverySeeder::class);
    }
}
