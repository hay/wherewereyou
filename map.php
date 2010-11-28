<!doctype html>
<html>
<head>
    <title>Where were you: uses your Twitter tweets to show you places you've been</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Josefin+Slab:regular,bold&subset=latin" />
    <style>
        * {
            margin: 0;
            padding: 0;
        }
        
        html, body, #map {
            height: 100%;
        }
        
        #controls {
            float: left;
            width: 30%;
            padding: 15px;
            font-family: 'Josefin Slab', Helvetica, Arial, sans-serif;
        }
        
        h1 {
            color: #0970b2;
        }
        
        h2 {
            color: #666;
        }
        
        h1, h2 {
            font-weight: normal;
        }
        
        #map {
            width: 70%;
            float: right;
        }               
    </style>
</head>
<body>
<div id="controls">
    <h1>Where were you?</h1>
    <h2>Enter your twitter username to view all the places you've been on a map</h2>
       
    <input id="user" placeholder="Your twitter username here" />
    <button id="lookup">Look up</button>
    <select id="list" multiple></select>
    
    <a href="http://www.haykranen.nl/?utm_source=wherewereyou&utm_medium=site&utm_campaign=logo">
        <p>A project coded by Hay Kranen</p>
        <img src="logohk.png" alt="Hay Kranen" />
    </a>
</div>
<div id="map"></div>
<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>    
<script src="tweetmap.js"></script>
</body>
</html>