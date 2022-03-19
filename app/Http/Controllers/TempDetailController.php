<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TempDetail;

class TempDetailController extends Controller
{
    public function getTemp(Request $request){
        // $userID = Auth::user()->id;
         $temDetails = TempDetail::where('userId', 1)->get();
         return response()->json($temDetails);
     }
}
