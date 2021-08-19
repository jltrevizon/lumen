<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingDownload extends Model
{
    protected $fillable = [
        'user_id',
        'type_document',
        'sended'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
