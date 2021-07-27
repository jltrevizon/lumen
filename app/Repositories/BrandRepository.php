<?php

namespace App\Repositories;

use App\Models\Brand;
use Exception;
use Illuminate\Database\Eloquent\Builder;

class BrandRepository extends Repository {

    public function __construct()
    {

    }

    public function getAll($request){
        return ['brands' => Brand::with($this->getWiths($request->with))->get()];
    }

    public function getById($request, $id){
        $brand = Brand::with($this->getWiths($request->with))->findOrFail($id);
        return ['brand' => $brand];
    }

    public function getByNameFromExcel($name_brand){
        $brand = Brand::where('name', $name_brand)
                    ->first();
        if(!$brand) return $this->create($name_brand);
        return $brand;
    }

    public function create($name_brand){
        $brand = new Brand();
        $brand->name = $name_brand;
        $brand->save();
        return $brand;
    }

}
