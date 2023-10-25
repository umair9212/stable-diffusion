<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Text2ImageService;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class Text2ImageController extends Controller
{
    public function text2image(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'prompt' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        return Text2ImageService::Text2ImageService($request);
    }
}
