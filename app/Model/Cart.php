<?php

namespace Framework2f4\Model;

class Cart extends BaseModel
{
    protected static string $table = 'carts';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
}