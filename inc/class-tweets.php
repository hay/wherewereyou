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
    
    function getUserMeta() {
        $url = "http://api.twitter.com/1/users/show.json?screen_name=" . $this->user;
        $r = new HttpRequest("get", $url);
        if ($r->getError()) {
            $this->error("Could not get user information");
        } else {
            return json_decode($r->getResponse(), true);
        }
    }

    function parse($tweets) {
        $user = $this->getUserMeta();

        $geo = array(
            "request_url" => $this->url,
            "avatar" => $user['profile_image_url'],
            "name" => $user['name'],
            "geo" => array()
        );

        foreach ($tweets as $t) {
            if (!$t['geo']) continue;
            $geo['geo'][] = array(
                "lat" => $t['geo']['coordinates'][0],
                "lng" => $t['geo']['coordinates'][1],
                "time" => $t['created_at'],
                "date" => date("Y-m-d", strtotime($t['created_at'])),
                "text" => $t['text'],
                "place_name" => $t['place']['full_name']
            );
        }       

        if (empty($geo['geo'])) {
            $this->error("No tweets with geoinformation");
        }
        
        return $geo;
    }
}