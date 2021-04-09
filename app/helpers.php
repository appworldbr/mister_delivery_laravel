<?php

use App\Models\Setting;
use Illuminate\Support\Arr;

if (!function_exists("update_settings")) {
    function update_settings(array $input, array $values)
    {
        $filteredValues = Arr::only($input, $values);
        $newArr = [];
        foreach ($filteredValues as $key => $value) {
            $newArr[] = [
                'key' => $key,
                'value' => $value ?? '',
            ];
        }
        Setting::upsert($newArr, ['key'], ['value']);
    }
}

if (!function_exists('get_setting_upload')) {
    function get_setting_upload($fieldName)
    {
        $setting = Setting::firstOrCreate([
            'key' => $fieldName,
        ]);
        $mediaResource = $setting->getMediaResource($fieldName);
        if ($mediaResource) {
            return $mediaResource;
        }
        return [];
    }
}

if (!function_exists("upload_setting")) {
    function upload_setting($fieldName)
    {
        $setting = Setting::firstOrCreate([
            'key' => $fieldName,
        ]);
        $setting->value = '...';
        $setting->clearMediaCollection($fieldName);
        $setting->addAllMediaFromTokens();
        $mediaResource = $setting->getMediaResource($fieldName)->first();
        if ($mediaResource) {
            $setting->value = $mediaResource['url'];
        }
        $setting->save();
    }
}

if (!function_exists("setting")) {
    function setting(string | array $key, string $value = null)
    {
        if (is_array($key)) {
            $settings = Setting::whereIn('key', $key)->pluck('value', 'key')->all();
            foreach ($key as $_key) {
                if (!isset($settings[$_key])) {
                    $settings[$_key] = '';
                }
            }
            return $settings;
        }

        if (!$value) {
            $setting = Setting::where('key', $key)->first();
        } else {
            $setting = Setting::firstOrNew([
                'key' => $key,
            ]);
            $setting->value = $value;
            $setting->save();
        }
        return $setting ? $setting->value : '';
    }
}

if (!function_exists('price_to_float')) {
    function price_to_float($price)
    {
        $price = str_replace(',', '.', $price);
        $price = preg_replace("/[^0-9\.]/", "", $price);
        $price = str_replace('.', '', substr($price, 0, -3)) . substr($price, -3);
        return (float) $price;
    }
}

if (!function_exists('float_to_price')) {
    function float_to_price($float)
    {
        return 'R$ ' . number_format((float) $float, '2', ',');
    }
}

if (!function_exists('zip_db_format')) {
    function zip_db_format($zip)
    {
        return preg_replace('/[^0-9]/', '', $zip);
    }
}

if (!function_exists('zip_format')) {
    function zip_format($zip_unformatted)
    {
        return preg_replace('/([0-9]{5})([0-9]{3})/', '$1-$2', $zip_unformatted);
    }
}
