<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Events\UserUpdated;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Define the relationship with Role.
     */
    public function roles()
    {
        return $this->belongsTo(Role::class, 'role');
    }

    /**
     * Define the relationship with Merchant.
     */
    public function merchant()
    {
        return $this->hasOne(Merchant::class, 'id_user');
    }

    /**
     * Define the relationship with Customer.
     */
    public function customer()
    {
        return $this->hasOne(Customer::class, 'id_user');
    }

    /**
     * Define events that should be dispatched for the model.
     *
     * @var array<string, mixed>
     */
    protected $dispatchesEvents = [
        'saved' => UserUpdated::class,
        'deleted' => UserUpdated::class,
    ];
}
