<?php
class ApiCall {
    protected $response = false;

    function __construct() {
        $method = (isset($_GET['method'])) ? $_GET['method'] : false;

        if (!$method) {
            $this->error("No method given");
        } else {
            switch($method) {
                case "tweets":
                    $call = new Tweets();
                    break;
                case "reversegeocode":
                    $call = new ReverseGeocode();
                    break;
                default:
                    $this->error("Invalid method name");
            }

            if ($call->getResponse()) {
                $this->output($call->getResponse());
            } else {
                $this->error("Error while doing the call");
            }
        }
    }

    protected function error($msg) {
        $this->output(array("error" => $msg));
    }

    protected function output($data) {
        $json = json_encode($data);
        if ($json) {
            die($json);
        } else {
            die($this->error("Data parsing error"));
        }
    }

    protected function request($url) {
        // Check if this is an url or a filename
        if (substr($url, 0, 4) != "http") {
            // File
            return json_decode(file_get_contents($url), true);
        } else {
            $r = new HttpRequest("get", $url);
            if ($r->getError()) {
                return false;
            } else {
                return json_decode($r->getResponse(), true);
            }
        }
    }

    protected function getResponse() {
        return $this->response;
    }
}