<?php
namespace Adnane\Qibla;

class Qibla
{
    /**
    * GPS COORDINATES OF KAABA, SAUDI ARABIA in degree are 
    * 21.4225° N, 39.8262° E 
    * @source : https://latitude.to/articles-by-country/sa/saudi-arabia/345/kaaba
    * */
    const kaaba_cords = [
        'latitude' => 21.420164986,
        'longitude' => 39.822330044,
    ];
    
    /**
    * User GPS COORDINATES
    * */ 
    public static $user_cords = [
        'latitude' => null,
        'longitude' => null,
    ];
        
    /**
    * validate longitude & latitude
    *  
    * @param $latitude ,$longitude 
    * @return boolean 
    * */ 
    private static function isValid() : bool
    {
        if(!is_numeric(self::$user_cords['latitude']) || !is_numeric(self::$user_cords['longitude']))
        {
            return false;
        }
        return true;
    }

    /**
    * get the cardinal direction towards the Kaaba in degree
    *
    * @source : https://fr.wikipedia.org/wiki/Qibla => Formule de calcul de la Qibla
    * @param $cords 
    * @return int
    */
    public static function getDirection($longitude = null ,$latitude = null)
    {
        # set user cords 
        self::setUserCords($latitude ,$longitude);
        
        # validate 
        if(! self::isValid()) return 'invalid';
        
        # difference of longitude between elQaaba and the Target location (rad)
        $a =  deg2rad(self::kaaba_cords['longitude'] - self::$user_cords['longitude']);
        
        # latitude of the target location (positive from north and east & negative from south and west)
        $b = deg2rad(90 - self::$user_cords['latitude']);
        
        # latitude of the kaaba (positive from north and east & negative from south and west)
        $c = deg2rad(90 - self::kaaba_cords['latitude']);

        return self::applyFormula($a , $b , $c);
    }
    
    /**
    * apply the formula described in source 
    * 
    * @source : https://fr.wikipedia.org/wiki/Qibla => Formule de calcul de la Qibla
    * @param $a , $b , $c
    * @return int 
    */
    private static function applyFormula($a , $b ,$c)
    {
        # count cot_c & apply the formula 
        $cot_c = tan(M_PI_2 - $c);
        $Q = sin($b) * $cot_c - cos($b) * cos($a);
        $Q = atan2(sin($a) ,$Q);
        
        # angle must be returned in degree 
        $Q = rad2deg($Q);

        # transform results to positive in case of negative 
        $Q += 360 * ($Q < 0);

        return $Q;
    }

    /**
    * get the user cordinaters (latitude , longitude)
    * 
    * @uses http://www.geoplugin.net/json.gp
    * @param $a , $b , $c
    * @return int 
    */
    private static function setUserCords($longitude,$latitude)
    {
        # if user specified cords calculate from them 
        if(isset($latitude) && isset($longitude)){

            self::$user_cords['latitude'] = $latitude;
            self::$user_cords['longitude'] = $longitude;
        
        }
        # otherwise analyse IP 
        else
        {
            $ipAnalyse = file_get_contents('http://www.geoplugin.net/json.gp');

            if(!! $ipAnalyse)
            {
                $ipAnalyse = json_decode($ipAnalyse);
    
                self::$user_cords['latitude'] = $ipAnalyse->geoplugin_latitude;
                self::$user_cords['longitude'] = $ipAnalyse->geoplugin_longitude;
            }
        }


    }
}