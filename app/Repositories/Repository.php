<?php

namespace App\Repositories;

class Repository {

    public function getWiths($elements){
        return collect($elements ?? [])->toArray();
    }

}
