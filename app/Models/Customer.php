<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_user',
        'name',
        'phone',
        'address',
        'photo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function menuReviews()
    {
        return $this->hasMany(Review::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
