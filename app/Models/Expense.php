<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'title',
        'amount',
        'date',
        'flatshare_id',
        'category_id',
        'user_id'
    ];

    public function flatshare(){
        return $this->belongsTo(Flatshare::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
