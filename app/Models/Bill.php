<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{

    protected $fillable = [
        'reservation_id',
        'user_id',
        'table_id'
    ];

    protected $casts = [
        'paid' => 'boolean'
    ];
    public function table(){
        return $this->belongsTo(Table::class);
    }

    public function getSum() {
        $sum = 0;
        foreach($this->products as $product) {
            $sum += $product->price * $product->pivot->quantity;
        }
        return number_format($sum, 2);
    }
    public function products() {
        return $this->belongsToMany(Product::class, 'bill_products', 'bill_id', 'product_id')->withPivot('quantity');
    }

}
