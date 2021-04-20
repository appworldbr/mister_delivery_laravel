<?php

namespace App\Traits;

trait HasPrice
{
    public function getPriceAttribute($value)
    {
        return static::floatToPrice($value);
    }

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = static::priceToFloat($value);
    }

    public static function priceToFloat($price)
    {
        $price = str_replace(',', '.', $price);
        $price = preg_replace("/[^0-9\.]/", "", $price);
        $price = str_replace('.', '', substr($price, 0, -3)) . substr($price, -3);
        return (float) $price;
    }

    public static function floatToPrice($float)
    {
        return 'R$ ' . number_format((float) $float, '2', ',', '.');
    }
}
