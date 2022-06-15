<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HistoryLocation;


class FixUserNullHistoryLocation extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HistoryLocation::whereNull('user_id')->update([
            'user_id'=> 1
        ]);
    }
}
