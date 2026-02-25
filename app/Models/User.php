<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'reputation_score',
        'is_banned',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }
    public function expenses(){
        return $this->hasMany(Expense::class);
    }
    public function paymentsAsDebtor(){
        return $this->hasMany(Payment::class,'debtor_id');
    }
    public function paymentsAsCreditor(){
        return $this->hasMany(Payment::class,'creditor_id');
    }
    public function flatshares(){
        return $this->belongsToMany(Flatshare::class,'flatshares_user')
        ->withPivot('joined_at','internal_role','left_at')
        ->withTimestamps();
    }
}
