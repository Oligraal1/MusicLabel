<?php

namespace App\Local;

//use App\Entity\Event;

class Localisation {
    
    private $url;

    function __construct($url)
    {
        $this->url=$url;
    }
    function array_value_recursive($key, array $arr)
   {
       $val = array();
       array_walk_recursive($arr, function ($v, $k) use ($key, &$val) {
           if ($k == $key) array_push($val, $v);
       });
       return count($val) > 1 ? $val : array_pop($val);
   }

    function findCity(string $ville) {
        $city = curl_init();
        \curl_setopt($city, CURLOPT_URL, $this->url . $ville);
        \curl_setopt($city, CURLOPT_HEADER, 0);
        \curl_setopt($city, CURLOPT_RETURNTRANSFER, 1);
        $response=curl_exec($city);
        curl_close($city);
       return json_decode($response, true);  
    }
    function oneCity(string $city) : array
    {
       return ($this->findCity($city))['features'][0]['geometry']['coordinates'];
    }

}