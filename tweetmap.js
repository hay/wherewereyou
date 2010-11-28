(function($) {
var map, gecoder, debug;

function getMap(lat, lng) {
    return new google.maps.Map(
        document.getElementById("map"), {
            zoom: 8,
            center: new google.maps.LatLng(lat, lng),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
    );
}

function formatDate(date) {
    var d = new Date(date);
    return ''.concat(
        d.getDate(), '-',
        d.getMonth(), '-',
        d.getFullYear(), ' : ',
        d.getHours(), ':',
        d.getMinutes()
    );
}

function getLocation(lat, lng, cb) {
    var url = "api.php?method=reverse.geocode&lat=" + lat + "&lng=" + lng;

    if (debug) url += "&dummy=1";

    $.getJSON(url, function(data) {
        cb(data.address);
    });
}


function fillList(items) {
    $.each(items, function() {
        // Do JSON calls to get the proper address
        var self = this;
        getLocation(this.lat, this.lng, function(address) {
            $("#list").append(''.concat(
                '<option data-lat="' + self.lat + '" data-lng="' + self.lng + '">',
                formatDate(self.time) + ': ' + address + '</option>'
            ));
        });
    });

    $("#list option").click(function() {
        var lat = $(this).attr('data-lat'),
            lng = $(this).attr('data-lng');

        map.panTo(new google.maps.LatLng(lat, lng));
    });
}

function putMarkers(markers) {
    $.each(markers, function() {
        var self = this;
        var m = new google.maps.Marker({
            position: new google.maps.LatLng(this.lat, this.lng),
            map: map
        });

        google.maps.event.addListener(m, 'click', function() {
            var iw = new google.maps.InfoWindow({
                "content" : formatDate(self.time) + '<br />' + self.text
            });
            iw.open(map, m);
        });

    });
}

function getTweets(user, cb) {
    var url = "api.php?method=tweets&user=" + user;
    if (debug) url += "&local=1";

    $.getJSON(url, function(d) {
        if (d.error) {
            alert(d.error);
            return false;
        }

        var geo = [];
        $.each(d.geo, function() {
            geo.push(this);
        });
        cb(geo);
    });
}

$(document).ready(function() {
    $("#lookup").click(function() {
        var user = $("#user").val();
        debug = window.location.search.indexOf("debug") !== -1;
        getTweets(user, function(geo) {
            geocoder = new google.maps.Geocoder();
            map = getMap(geo[0].lat, geo[0].lng);
            fillList(geo);
            putMarkers(geo);
        });
    });
});
})(jQuery);