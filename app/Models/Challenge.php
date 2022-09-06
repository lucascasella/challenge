<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;

    public static function distancia($lat1, $lon1, $lat2, $lon2) {

        $lat1 = deg2rad($lat1);
        $lat2 = deg2rad($lat2);
        $lon1 = deg2rad($lon1);
        $lon2 = deg2rad($lon2);
        
        $dist = (6371 * acos( cos( $lat1 ) * cos( $lat2 ) * cos( $lon2 - $lon1 ) + sin( $lat1 ) * sin($lat2) ) );
        $dist = number_format($dist, 2, '.', '');
        return $dist;
    }

    public static function convertFile($file){
        $affiliateList = [];
        $handle = fopen($file, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $temp = json_decode($line);
                if(key_exists("latitude", $temp) && 
                    key_exists("affiliate_id", $temp) &&
                    key_exists("name", $temp) &&
                    key_exists("longitude", $temp))
                {
                    $affiliateList[] = $temp;
                }
            }

            fclose($handle);
        }
        return $affiliateList;   
    }

    public static function convertDgr($dgr){
        return ($dgr * M_PI / 180);
    }
}
