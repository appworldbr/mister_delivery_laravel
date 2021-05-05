<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\UserTelephone;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TelephoneApiController extends Controller
{
    public function index()
    {
        $telephones = Auth::user()->telephones;
        return response()->json(compact('telephones'));
    }

    public function show($id)
    {
        $telephone = UserTelephone::currentUser()->where('id', $id)->first();

        if (!$telephone) {
            abort(404, __("Telephone Not Found"));
        }

        return response()->json(compact('telephone'));
    }

    public function store(Request $request)
    {
        $data = $request->only(['telephone']);

        Validator::make($data, [
            'telephone' => ['required', 'string', 'min:10', 'max:11'],
        ])->validate();

        $data['user_id'] = Auth::id();
        $data['is_default'] = false;

        $telephone = UserTelephone::create($data);

        return response()->json(compact('telephone'));
    }

    public function update($id, Request $request)
    {
        $data = $request->only(['telephone']);

        Validator::make($data, [
            'telephone' => ['required', 'string', 'min:10', 'max:11'],
        ])->validate();

        $telephone = UserTelephone::currentUser()->where('id', $id)->first();

        if (!$telephone) {
            abort(404, __('Telephone Not Found'));
        }

        $telephone->update($data);

        return response()->json(compact('telephone'));
    }

    public function setDefault($id)
    {
        $telephone = UserTelephone::setDefault($id);
        if (!$telephone) {
            abort(404, __('Telephone Not Found'));
        }
        return response()->json(compact('telephone'));
    }

    public function delete($id)
    {
        $telephone = UserTelephone::currentUser()->where('id', $id)->first();

        if (!$telephone) {
            abort(404, __('Telephone Not Found'));
        }

        if ($telephone->is_default) {
            abort(302, __('Telephone Is Default'));
        }

        $telephone->delete();

        return response()->json(["success" => true]);
    }
}
