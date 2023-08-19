<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\PythonExec;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function prompt(Request $request, PythonExec $exec)
    {
        $this->validate($request, [
            'message' => 'required'
        ]);

        $response = $exec->prompt($request->message);
        return response()->json($response);
    }
}
