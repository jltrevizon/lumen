<?php

namespace App\EloquentFunctions;

class EloquentFunctions {

    public function getWiths($elements){
        return collect($elements ?? [])->toArray();
    }

}
