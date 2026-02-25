<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Payment extends Model
{
     /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
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
