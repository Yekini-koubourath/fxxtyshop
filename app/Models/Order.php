<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public const STATUSES = [
        'en_attente' => 'En attente',
        'confirmee'  => 'Confirmée',
        'livree'     => 'Livrée',
        'annulee'    => 'Annulée',
    ];

    protected $fillable = [
        'user_id', 'customer_name', 'phone', 'address', 'total', 'status',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}