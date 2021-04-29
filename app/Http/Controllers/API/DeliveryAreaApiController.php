<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DeliveryArea;
use Illuminate\Support\Facades\Validator;

class DeliveryAreaApiController extends Controller
{
    public function index($zip)
    {
        Validator::make(['zip' => $zip], [
            'zip' => 'size:8',
        ])->validate();

        $area = DeliveryArea::validationZip($zip);

        $responseData = [
            'deliverable' => !!$area,
            'price' => $area ? round((float) $area->getRawOriginal('price'), 2) : 0,
        ];

        return response()->json($responseData);
    }
}
