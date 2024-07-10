<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'order';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_customer',
        'id_merchant',
        'order_date',
        'total_amount',
        'status',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}