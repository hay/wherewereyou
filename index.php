<!doctype html>
<html>
<head>
    <title>Where were you? Type in your Twitter username and see all the places you've been on a map</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="css/base.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="http://static.haykranen.nl/fonts/klill/style.css" />
</head>
<body>
<div id="map"></div>

<div id="controls">
    <h1>Where were you?</h1>
    <h2>Enter your Twitter username to view all the places you've been on a map</h2>

    <form id="user-lookup">
        <input id="user" placeholder="Your twitter username here" />
        <button id="lookup" class="blue-pill">Look up</button>
    </form>

    <img id="spinner" src="img/spinner.gif" alt="Loading..." class="hide" />

    <div id="list" class="hide">
        <img src="" id="avatar" />
        <h1></h1>

        <ul></ul>
    </div>
    
    <h1><a id="geolocation" href="">Show me we're i'm now</a></h1>
    <img id="spinner" src="img/spinner.gif" alt="Loading..." class="hide" />

    <footer>
        <a href="http://www.haykranen.nl/?utm_source=wherewereyou&utm_medium=site&utm_campaign=logo">
            <img src="img/logohk.png" alt="Hay Kranen" />
            <p>A project coded by Hay Kranen</p>
        </a>
    </footer>
    
    <div id="fold" class="hide">&laquo;</div>
</div>

<script id="list-li" type="text/html">
    <li data-date="">
        <table>
            <tr>
                <td colspan=2><h2><time datetime=""></time></h2></td>
            </tr>
        </table>
    </li>
</script>

<script id="list-loc" type="text/html">
    <tr class="loc" data-lat="" data-lng="">
        <td class="time"></td>
        <td class="place">
            <span class="name"></span><br />
            <span class="address"></span>
        </td>
    </tr>
</script>

<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="js/main.js"></script>

<!-- Clicky -->
<script src="http://static.getclicky.com/15420.js" type="text/javascript"></script>
<noscript><p><img alt="Clicky" src="http://in.getclicky.com/15420ns.gif" /></p></noscript>
<!-- /Clicky -->

<!-- Google Analytics -->
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl" : "http://www");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try{
    var pageTracker = _gat._getTracker("UA-8052007-2");
    pageTracker._initData();
    pageTracker._trackPageview();
} catch(err) {}
</script>
<!-- /Google Analytics -->
</body>
</html>