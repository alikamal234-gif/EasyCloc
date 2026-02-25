<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Category extends Model
{
     /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'flatshare_id'
    ];

    public function flatshare(){
        return $this->belongsTo(Flatshare::class);
    }
    public function expenses(){
        return $this->hasMany(Expense::class);
    }
}
