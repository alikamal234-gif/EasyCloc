<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'amount',
        'paid_at',
        'debtor_id',
        'creditor_id',
        'flatshare_id'
    ];

    public function debtor(){
        return $this->belongsTo(User::class,'debtor_id');
    }
    public function creditor(){
        return $this->belongsTo(User::class,'creditor_id');
    }
    public function flatshare(){
        return $this->belongsTo(Flatshare::class);
    }

}
