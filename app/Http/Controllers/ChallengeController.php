<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Challenge;
use App\Http\Requests\ChallengeRequest;

class ChallengeController extends Controller
{
    public static function activity(ChallengeRequest $request){
        
        $latitude = Challenge::convertDgr($request->latitude);
        $longitude = Challenge::convertDgr($request->lonitude);
        $scope = $request->scope;
        $affiliateList = Challenge::convertFile($request->affiliateList);
        
        $returnList = [];
        foreach($affiliateList as $affiliate){
            $distance = Challenge::distancia($latitude,$longitude, Challenge::convertDgr($affiliate->latitude), Challenge::convertDgr($affiliate->longitude));
            if($distance <= $scope){
                $returnList[] = ["id" => $affiliate->affiliate_id, 
                                "name" =>  $affiliate->name, 
                                "latitude" =>  $affiliate->latitude, 
                                "longitude" =>  $affiliate->longitude , 
                                "distance" =>  $distance];
            }
        }

        return $returnList;        
    }
}
