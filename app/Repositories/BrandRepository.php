<?php

namespace App\Repositories;

use App\Models\Brand;
use Exception;
use Illuminate\Database\Eloquent\Builder;

class BrandRepository {

    public function __construct()
    {

    }

    public function getByNameFromExcel($name_brand){
        try{
            $brand = Brand::where('name', $name_brand)
                        ->first();
            if(!$brand) return $this->create($name_brand);
            return $brand;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function create($name_brand){
        try{
            $brand = new Brand();
            $brand->name = $name_brand;
            $brand->save();
            return $brand;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }

    }

}
