<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UpdateViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $sql = <<<SQL
        CREATE OR REPLACE VIEW view_kpis AS 
        SELECT 
    v.id as vehicle_id, v.type_model_order_id, v.sub_state_id, ss.state_id,
    i.kpi as in_kpi, i.month as in_month, i.year as in_year, 
    o.kpi as out_kpi, o.month as out_month,o.year as out_year, 
    s.day_diff
FROM 
    vehicles v, sub_states ss,
    (
        SELECT ve.vehicle_id, COUNT(ve.vehicle_id) as kpi, MONTH(ve.created_at) as month, YEAR(ve.created_at) as year FROM delivery_vehicles ve GROUP BY ve.vehicle_id, ve.created_at
    ) as o,
    (
        SELECT r.vehicle_id, COUNT(r.vehicle_id) as kpi, MONTH(r.created_at) as month, YEAR(r.created_at) as year FROM receptions r GROUP BY r.vehicle_id, r.created_at
    ) as i,
    (
        SELECT r.vehicle_id, TIMESTAMPDIFF(day, r.created_at, CURRENT_TIMESTAMP) AS day_diff FROM receptions r
    ) as s
WHERE 
	v.sub_state_id = ss.id and
    v.id = o.vehicle_id and v.id = i.vehicle_id and s.vehicle_id = v.id
SQL;
        DB::statement($sql);
    }
}
