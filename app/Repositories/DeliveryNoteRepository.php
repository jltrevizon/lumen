<?php

namespace App\Repositories;

use App\Models\DeliveryNote;

class DeliveryNoteRepository extends Repository 
{

    public function create($data, $type){
        $deliveryNote = new DeliveryNote();
        $deliveryNote->type_delivery_note_id = $type;
        $deliveryNote->body = json_encode($data);
        $deliveryNote->save();
        return $deliveryNote;
    }

}