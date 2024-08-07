<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryMenu extends Model
{
    use HasFactory;

    protected $table = 'categorymenu';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'description',
    ];

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}