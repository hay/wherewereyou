<?php
class Tweets extends ApiCall {
    private $user, $local, $url;

    function __construct() {
        $this->user = !empty($_GET['user']) ? $_GET['user'] : false;
        $this->local = !empty($_GET['local']);

        if ($this->local) {
            $this->url = "user_timeline.json";
        } else {
            $this->url = "http://api.twitter.com/1/statuses/user_timeline.json?screen_name=" . $this->user . "&count=200&trim_user=true";
        }
        
        if (!$this->user) $this->error("No username given");

        $tweets = $this->request($this->url);
        
        $this->response = ($tweets) ? $this->parse($tweets) : false;
    }

    function parse($tweets) {
        $geo = array(
            "request_url" => $this->url,
            "geo" => array()
        );

        foreach ($tweets as $t) {
            if (!$t['geo']) continue;
            $geo['geo'][] = array(
                "lat" => $t['geo']['coordinates'][0],
                "lng" => $t['geo']['coordinates'][1],
                "time" => $t['created_at'],
                "text" => $t['text']
            );
        }

        if (empty($geo['geo'])) {
            $this->error("No tweets with geoinformation");
        }
        
        return $geo;
    }
}