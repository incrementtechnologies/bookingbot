<?php

namespace App\Http\Controllers;
use App\Ilinya\Http\Curl;
use Illuminate\Http\Request;

class facebookController extends APIController
{

    public function getFacebookPage(Request $request){
        $curl = new Curl();
        $response = $curl->getFbPage($request->user_id, $request->user_access_token);
        return response()->json($response);
    }
}
