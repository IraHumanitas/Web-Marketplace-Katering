<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    use HasFactory;

    protected $table = 'merchant';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_user',
        'company_name',
        'address',
        'city',
        'state',
        'postal_code',
        'contact_number',
        'description',
        'photo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}