<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingDownload extends Model
{

    use HasFactory;

    protected $fillable = [
        'user_id',
        'type_document',
        'sended'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
