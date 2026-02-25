<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
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
