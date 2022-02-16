<?php

namespace App\Repositories;

use App\Models\Transport;
use App\Models\TypeDeliveryNote;
use Exception;

class TypeDeliveryNoteRepository {

    public function __construct()
    {

    }

    public function index(){
        return TypeDeliveryNote::all();
    }
}
