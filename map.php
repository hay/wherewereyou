<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
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
        }
        
        #map {
            width: 70%;
            float: right;
        }               
    </style>
</head>
<body>
<div id="controls">
    <input id="user" value="huskyr" />
    <button id="lookup">Look up</button>
    <select id="list" multiple></select>
</div>
<div id="map"></div>
<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>    
<script src="tweetmap.js"></script>
</body>
</html>