(function($) {
var map;

function getMap() {
    return new google.maps.Map(
        document.getElementById("map"), {
            zoom: 8,
            center: new google.maps.LatLng(-34.397, 150.644),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
    );
}

function getTweets() {
    $.getJSON("gettweets.php", function(d) {
        console.log(d);
    });
}

$(document).ready(function() {
    map = getMap();
    getTweets();
});
})(jQuery);