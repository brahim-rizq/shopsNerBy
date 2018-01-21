<?php 
// src/AppBundle/Twig/AppExtension.php
namespace AppBundle\Twig;

class AppExtension extends \Twig_Extension
{

    public function getName() {
        return 'sortbyfield';
    }
    public function getFilters() {
        return array(
            new \Twig_SimpleFilter('sortbyfield', array($this, 'sortByFieldFilter'))
        );
    }
    /**
     * The "sortByField" filter sorts an array of entries (objects or arrays) by the specified field's value
     *
     * Usage: {% for entry in master.entries|sortbyfield('ordering', 'desc') %}
     */
    public function sortByFieldFilter($content, $sort_by = null, $direction = 'asc') {
        if (is_a($content, 'Doctrine\Common\Collections\Collection')) {
            $content = $content->toArray();
        }
        if (!is_array($content)) {
            throw new \InvalidArgumentException('Variable passed to the sortByField filter is not an array');
        } elseif (count($content) < 1) {
            return $content;
        } elseif ($sort_by === null) {
            throw new Exception('No sort by parameter passed to the sortByField filter');
        } elseif (!self::isSortable(current($content), $sort_by)) {
            throw new Exception('Entries passed to the sortByField filter do not have the field "' . $sort_by . '"');
        } else {
            // Unfortunately have to suppress warnings here due to __get function
            // causing usort to think that the array has been modified:
            // usort(): Array was modified by the user comparison function
            @usort($content, function ($a, $b) use ($sort_by, $direction) {
                $flip = ($direction === 'desc') ? -1 : 1;
                if (is_array($a))
                    $a_sort_value = $a[$sort_by];
                else if (method_exists($a, 'get' . ucfirst($sort_by)))
                    $a_sort_value = $a->{'get' . ucfirst($sort_by)}();
                else
                    $a_sort_value = $a->$sort_by;
                if (is_array($b))
                    $b_sort_value = $b[$sort_by];
                else if (method_exists($b, 'get' . ucfirst($sort_by)))
                    $b_sort_value = $b->{'get' . ucfirst($sort_by)}();
                else
                    $b_sort_value = $b->$sort_by;
                if ($a_sort_value == $b_sort_value) {
                    return 0;
                } else if ($a_sort_value > $b_sort_value) {
                    return (1 * $flip);
                } else {
                    return (-1 * $flip);
                }
            });
        }
        return $content;
    }
    /**
     * Validate the passed $item to check if it can be sorted
     * @param $item mixed Collection item to be sorted
     * @param $field string
     * @return bool If collection item can be sorted
     */
    private static function isSortable($item, $field) {
        if (is_array($item))
            return array_key_exists($field, $item);
        elseif (is_object($item))
            return isset($item->$field) || property_exists($item, $field);
        else
            return false;
    }




















    
    // public function getFilters()
    // {
    //     return array(
    //         new \Twig_SimpleFilter('distance', array($this, 'distanceFilter')),
    //     );
    // }

 //    public function distanceFilter($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo){
 //    $rad = M_PI / 180;
 //    //Calculate distance from latitude and longitude
 //    $theta = $longitudeFrom - $longitudeTo;
 //    $dist = sin($latitudeFrom * $rad) * sin($latitudeTo * $rad) +  cos($latitudeFrom * $rad) * cos($latitudeTo * $rad) * cos($theta * $rad);

 //    return acos($dist) / $rad * 60 *  1.853;

	// }
    // public function distanceFilter($point1_lat, $point1_long, $point2_lat, $point2_long, $unit = 'km', $decimals = 2) {
    //     // Calculate the distance in degrees
    //     $degrees = rad2deg(acos((sin(deg2rad($point1_lat))*sin(deg2rad($point2_lat))) + (cos(deg2rad($point1_lat))*cos(deg2rad($point2_lat))*cos(deg2rad($point1_long-$point2_long)))));
     
    //     // Convert the distance in degrees to the chosen unit (kilometres, miles or nautical miles)
    //     switch($unit) {
    //         case 'km':
    //             $distance = $degrees * 111.13384; // 1 degree = 111.13384 km, based on the average diameter of the Earth (12,735 km)
    //             break;
    //         case 'mi':
    //             $distance = $degrees * 69.05482; // 1 degree = 69.05482 miles, based on the average diameter of the Earth (7,913.1 miles)
    //             break;
    //         case 'nmi':
    //             $distance =  $degrees * 59.97662; // 1 degree = 59.97662 nautic miles, based on the average diameter of the Earth (6,876.3 nautical miles)
    //         default:
    //         $distance = $degrees * 111.13384;
    //     }

    //     $result = round($distance, $decimals) ;

    //     return round(abs($result),$decimals);
    // }

    // public function distanceFilter($lat1, $lng1, $lat2, $lng2, $miles = false)
    // {
    //     $pi80 = M_PI / 180;
    //     $lat1 *= $pi80;
    //     $lng1 *= $pi80;
    //     $lat2 *= $pi80;
    //     $lng2 *= $pi80;
     
    //     $r = 6372.797; // mean radius of Earth in km
    //     $dlat = $lat2 - $lat1;
    //     $dlng = $lng2 - $lng1;
    //     $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
    //     $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    //     $km = $r * $c;
     
    //     return ($miles ? ($km * 0.621371192) : $km);
    // }

// public function distanceFilter($addressFrom, $addressTo){
//     //Change address format
//     $formattedAddrFrom = str_replace(' ','+',$addressFrom);
//     $formattedAddrTo = str_replace(' ','+',$addressTo);
    
//     //Send request and receive json data
//     $geocodeFrom = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$formattedAddrFrom.'&sensor=false&key=AIzaSyA01KSbDR5lYBF_6IzxFHtngS8AHIvowug');
//     $outputFrom = json_decode($geocodeFrom);
//     $geocodeTo = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$formattedAddrTo.'&sensor=false&key=AIzaSyA01KSbDR5lYBF_6IzxFHtngS8AHIvowug');
//     $outputTo = json_decode($geocodeTo);
    
//     //Get latitude and longitude from geo data
//     $latitudeFrom = $outputFrom->results[0]->geometry->location->lat;
//     $longitudeFrom = $outputFrom->results[0]->geometry->location->lng;
//     $latitudeTo = $outputTo->results[0]->geometry->location->lat;
//     $longitudeTo = $outputTo->results[0]->geometry->location->lng;
    
//     //Calculate distance from latitude and longitude
//     $theta = $longitudeFrom - $longitudeTo;
//     $dist = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
//     $dist = acos($dist);
//     $dist = rad2deg($dist);
//     $miles = $dist * 60 * 1.1515;
//     return ($miles * 1.609344);
// }
}