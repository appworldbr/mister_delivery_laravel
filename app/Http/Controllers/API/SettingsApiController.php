<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Storage;

class SettingsApiController extends Controller
{
    public function index()
    {
        $settings = Setting::get(['logo', 'name', 'description', 'address']);
        if (strlen($settings['logo'])) {
            $settings['logo'] = Storage::disk('public')->url($settings['logo']);
        }
        return response()->json(compact('settings'));
    }
}
