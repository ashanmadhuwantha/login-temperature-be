<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TempDetail;
use Illuminate\Support\Facades\Auth;

class TempDetailController extends Controller
{
    public function getTemp(Request $request){
        $userID = Auth::user()->id;
        $isHottest = $request->hottest;
         $temDetails1 = TempDetail::where('userId', $userID);
         $temDetails2 = TempDetail::where('userId', $userID);
         if($isHottest == 'true'){
             $temDetails1 = $temDetails1->orderby('city_1_temp_celsius','DESC')->get();
             $temDetails2 = $temDetails2->orderby('city_2_temp_celsius','DESC')->get();
         }else{
            $temDetails1= $temDetails1->orderby('id','DESC')->get();
            $temDetails2 = $temDetails2->orderby('id','DESC')->get();
         }

         $output = array(
             'tempDetails1'=>$temDetails1,
             'tempDetails2'=> $temDetails2
         );
         return response()->json($output);
     }

}
