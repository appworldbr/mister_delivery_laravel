<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = 'key';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    public static function defaultData($settings)
    {
        if (isset($settings['logo']) && !strlen($settings['logo'])) {
            $settings['logo'] = '/default.png';
        }

        if (isset($settings['name']) && !strlen($settings['name'])) {
            $settings['name'] = __("Company Name");
        }

        if (isset($settings['order_canceled_timeout']) && !strlen($settings['order_canceled_timeout'])) {
            $settings['order_canceled_timeout'] = '10';
        }

        return $settings;
    }

    public static function set($values)
    {
        $settings = [];
        foreach ($values as $key => $value) {
            $settings[] = [
                'key' => $key,
                'value' => $value,
            ];
        }
        static::upsert($settings, ['key'], ['value']);
    }

    public static function get(...$keys)
    {
        $settings = static::whereIn('key', $keys)->get()->pluck('value', 'key')->toArray();
        foreach ($keys as $key) {
            if (!isset($settings[$key])) {
                $settings[$key] = '';
            }
        }

        $data = static::defaultData($settings);

        if (count($data) == 1) {
            return $data[$keys[0]];
        }
        return $data;
    }
}
