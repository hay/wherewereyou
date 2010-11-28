<?php
class ReverseGeocode extends ApiCall {
    private $lat, $lng, $url;
    
    function __construct() {
        $this->lat = !empty($_GET['lat']) ? $_GET['lat'] : false;
        $this->lng = !empty($_GET['lng']) ? $_GET['lng'] : false;
        $this->url = sprintf(
            "http://maps.googleapis.com/maps/api/geocode/json?latlng=%s,%s&sensor=false",
            $this->lat, $this->lng
        );
        
        $data = $this->request($url);
        
        if ($data) {
            return $this->parse($data);
        } else {
            return false;
        }
    }

    function parse($data) {
        
    }
}