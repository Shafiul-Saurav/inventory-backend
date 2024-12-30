<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function order_details() : HasMany
    {
        return $this->hasMany(OrderDetails::class);
    }

    public function customer() : HasOne
    {
        return $this->hasOne(User::class, 'id', 'customer_id');
    }
}
