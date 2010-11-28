<!doctype html>
<html>
<head>
    <title>Where were you: uses your Twitter tweets to show you places you've been</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="css/base.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="http://static.haykranen.nl/fonts/klill/style.css" />
</head>
<body>
<div id="controls">
    <h1>Where were you?</h1>
    <h2>Enter your twitter username to view all the places you've been on a map</h2>
    
    <form id="user-lookup">       
        <input id="user" placeholder="Your twitter username here" />
        <button id="lookup" class="blue-pill">Look up</button>
    </form>
    
    <img id="spinner" src="img/spinner.gif" alt="Loading..." class="hide" />
    
    <footer>    
        <a href="http://www.haykranen.nl/?utm_source=wherewereyou&utm_medium=site&utm_campaign=logo">
            <img src="img/logohk.png" alt="Hay Kranen" />
            <p>A project coded by Hay Kranen</p>        
        </a>
    </footer>
</div>
<div id="map"></div>
<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>    
<script src="js/main.js"></script>
</body>
</html>