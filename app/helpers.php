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
                'value'=> $value ?? ''
            ];
        }
        Setting::upsert($newArr, ['key'], ['value']);
    }
}

if(!function_exists('get_setting_upload'))
{
    function get_setting_upload($fieldName)
    {
        $setting = Setting::firstOrCreate([
            'key' => $fieldName
        ]);
        $mediaResource = $setting->getMediaResource($fieldName);
        if($mediaResource){
            return $mediaResource;
        }
        return [];
    }
}

if(!function_exists("upload_setting"))
{
    function upload_setting($fieldName)
    {
        $setting = Setting::firstOrCreate([
            'key' => $fieldName
        ]);
        $setting->value = '...';
        $setting->clearMediaCollection($fieldName);    
        $setting->addAllMediaFromTokens();
        $mediaResource = $setting->getMediaResource($fieldName)->first();
        if($mediaResource){
            $setting->value = $mediaResource['url'];
        }
        $setting->save();
    }
}

if(!function_exists("setting"))
{
    function setting(string|array $key, string $value = null)
    {
        if(is_array($key)){
            $settings = Setting::whereIn('key', $key)->pluck('value', 'key')->all();
            foreach($key as $_key){
                if(!isset($settings[$_key])){
                    $settings[$_key] = '';
                }
            }
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