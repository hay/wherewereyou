<?php
    $user = !empty($_GET['user']) ? $_GET['user'] : false;
    $local = !empty($_GET['local']);
    $url = "http://api.twitter.com/1/statuses/user_timeline.json?screen_name=$user&count=200&trim_user=true";
    
    if (!$user) {
        die();
    }
    
    function getTweets($user) {
        global $local, $url;
        
        if ($local) {
            $url = "user_timeline.json";
        }
        
        $json = file_get_contents($url);
        return json_decode($json, true);
    }

    $tweets = getTweets($user);
    $geo = array(
        "request_url" => $url,
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
    echo json_encode($geo);
