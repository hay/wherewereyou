<?php
class ReverseGeocode extends ApiCall {
    private $lat, $lng, $url, $dummy;
    
    function __construct() {
        $this->lat = !empty($_GET['lat']) ? $_GET['lat'] : false;
        $this->lng = !empty($_GET['lng']) ? $_GET['lng'] : false;
        $this->dummy = !empty($_GET['dummy']) ? $_GET['dummy'] : false;
        $this->url = sprintf(
            "http://maps.googleapis.com/maps/api/geocode/json?latlng=%s,%s&sensor=false",
            $this->lat, $this->lng
        );
        
        if ($this->dummy) {
            $data = array(
                "results" => array(
                    array(
                        "formatted_address" => "Fleplaan 23"
                    )
                )
            );
        } else {        
            $data = $this->request($this->url);
        }
        
        $this->response = ($data) ? $this->parse($data) : false;
    }

    function parse($data) {
        $adr = $data['results'][0]['formatted_address'];              
        return array("address" => $adr);
    }
}