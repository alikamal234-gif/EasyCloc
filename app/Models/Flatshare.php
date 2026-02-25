<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flatshare extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    public function categories(){
        return $this->hasMany(Category::class);
    }
    public function expenses(){
        return $this->hasMany(Expense::class);
    }
    public function invitations(){
        return $this->hasMany(Invitation::class);
    }
    public function payments(){
        return $this->hasMany(Payment::class);
    }

    public function users(){
        return $this->belongsToMany(User::class,'flatshares_user')
        ->withPivot('joined_at','internal_role','left_at')
        ->withTimestamps();
    }
}
