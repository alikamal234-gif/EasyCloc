<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = [
        'email',
        'token',
        'status',
        'flatshare_id',
    ];

    public function flatshare(){
        return $this->belongsTo(Flatshare::class);
    }

}
