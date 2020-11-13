<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\GoogleSheetController;

class SheetController extends APIController
{
    //
    public function save(Request $request){
        $googleSheet = new GoogleSheetController('1mQHZ_HFCEhHeRCcbOIaTYr-_8dE6ViqpOnY4MBUWM00', 'A:E');
        $values = [
            "column test",
            "column 1",
            "column 2",
            "column 3",
            "column 4"
        ];
        $_return = $googleSheet->write($values);
        return response()->json($_return);
    }
    
    public function fetch(Request $request){
        $googleSheet = new GoogleSheetController('1mQHZ_HFCEhHeRCcbOIaTYr-_8dE6ViqpOnY4MBUWM00', 'A:E');
        $_return = $googleSheet->retrieve();
        return response()->json($_return);
    }
}
