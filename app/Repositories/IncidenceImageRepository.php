<?php

namespace App\Repositories;

use App\Models\IncidenceImage;
use App\Models\State;
use Exception;
use Illuminate\Database\Eloquent\Builder;

class IncidenceImageRepository extends Repository {

    public function __construct()
    {

    }

    public function index($request){
        return IncidenceImage::with($this->getWiths($request->with))
            ->filter($request->all())
            ->paginate($request->input('per_page'));
    }

    public function store($request){
        $incidenceImage = IncidenceImage::create($request->all());
        return $incidenceImage;
    }

    public function update($request, $id){
        $incidenceImage = IncidenceImage::findOrFail($id);
        $incidenceImage->update($request->all());
        return $incidenceImage;
    }

}
