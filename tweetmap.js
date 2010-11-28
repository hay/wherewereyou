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

function getLocation(lat, lng) {
    // Not working, but why ?
    return;
    
    var geocoder = new google.maps.Geocoder(),
        loc = new google.maps.LatLng(lat, lng);
        
    geocoder.geocode({
        "latLng" : loc
    }, function(results, status) {
        if (results) {
            return results[0].formatted_address;
        } else {
            return "Unknown location";
        }
    });
}       
                

function fillList(items) {
    $.each(items, function() {
        $("#list").append(''.concat(
            '<option data-lat="' + this.lat + '" data-lng="' + this.lng + '">',
            formatDate(this.time) + ': ' + getLocation(this.lat, this.lng) + '</option>'
        ));
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
    $.getJSON("gettweets.php?user=" + user, function(d) {
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
        getTweets(user, function(geo) {
            map = getMap(geo[0].lat, geo[0].lng);
            fillList(geo);
            putMarkers(geo);
        });
    });
});
})(jQuery);