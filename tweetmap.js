(function($) {
var map;

function getMap(lat, lng) {
    return new google.maps.Map(
        document.getElementById("map"), {
            zoom: 8,
            center: new google.maps.LatLng(lat, lng),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
    );
}

function putMarkers(markers) {
    $.each(markers, function() {
        new google.maps.Marker({
            position: new google.maps.LatLng(this.lat, this.lng),
            map: map,
            title : this.time
        });
    });
}

function getTweets(cb) {
    $.getJSON("gettweets.php?user=huskyr&local=1", function(d) {
        var geo = [];
        $.each(d.geo, function() {
            geo.push(this);
        });
        cb(geo);
    });
}

$(document).ready(function() {
    getTweets(function(geo) {
        map = getMap(geo[0].lat, geo[0].lng);
        putMarkers(geo);
    });
});
})(jQuery);