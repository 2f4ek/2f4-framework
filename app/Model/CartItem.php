<?php

namespace Framework2f4\Model;

class CartItem extends BaseModel
{
    protected static string $table = 'cart_items';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
}