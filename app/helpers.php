<?php

use App\Models\Setting;
use Illuminate\Support\Arr;

if(!function_exists("update_settings"))
{
    function update_settings(array $input, array $values)
    {
        $filteredValues = Arr::only($input, $values);
        $newArr = [];
        foreach($filteredValues as $key => $value){
            $newArr[] = [
                'key' => $key,
                'value'=> $value
            ];
        }
        Setting::upsert($newArr, ['key'], ['value']);
    }
}

if(!function_exists("setting"))
{
    function setting(string|array $key, string $value = null)
    {
        if(is_array($key)){
            $settings = Setting::whereIn('key', $key)->pluck('value', 'key')->all();
            return $settings;
        }


        if (!$value) {
            $setting = Setting::where('key', $key)->first();
        } else {
            $setting = Setting::firstOrNew([
                'key' => $key
            ]);
            $setting->value = $value;
            $setting->save();
        }
        return $setting ? $setting->value : '';
    }
}