<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';
    protected $primaryKey = 'id';

    protected $fillable = ['name', 'description', 'photo', 'price', 'stok', 'category', 'id_merchant'];


    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}