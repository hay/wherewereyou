(function($) {
var map, gecoder, debug;

function loading(b) {
    if (b) {
        $("#spinner").show();
    } else {
        $("#spinner").hide();
    }
}

function getMap(lat, lng) {
    return new google.maps.Map(
        document.getElementById("map"), {
            zoom: 8,
            center: new google.maps.LatLng(lat, lng),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
    );
}

function getDay(day) {
    var days = [
        "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"
    ]
    return days[day];
}

function formatDate(date, format) {
    var d = new Date(date);

    function f(s) {
        return (s < 10) ? "0" + s : s;
    }

    if (format == "date") {
        return ''.concat(
            getDay(d.getDay()), ' ',
            f(d.getDate()), '-',
            f(d.getMonth() + 1), '-',
            f(d.getFullYear())
        );
    } else if (format == "time") {
        return f(d.getHours()) + ':' + f(d.getMinutes());
    }
}

function getLocation(lat, lng, cb) {
    var url = "inc/api.php?method=reverse.geocode&lat=" + lat + "&lng=" + lng;

    if (debug) url += "&dummy=1";

    $.getJSON(url, function(data) {
        cb(data.address);
    });
}

function fillDates(items) {
    var dates = {};

    $.each(items, function() {
        var date = formatDate(this.time, "date");
        if (!dates[date]) {
            var $li = $($("#list-li").html());
            $li.find("h2 time").html(date);
            $li.attr('data-date', this.date);
            $("#list ul").append($li);
            dates[date] = true;
        }
    });
}

function fillList(items) {
    $.each(items, function() {
        // Do JSON calls to get the proper address
        var self = this,
            $loc = $($("#list-loc").html()),
            date = formatDate(self.time, "date"),
            time = formatDate(self.time, "time");

        getLocation(this.lat, this.lng, function(address) {
            $loc.find(".time").html(time);
            $loc.find(".place .name").html(self.place_name);
            $loc.find(".place .address").html(address);
            $loc.attr('data-lat', self.lat);
            $loc.attr('data-lng', self.lng);

            // Search for the correct date and add it there
            $("#list li").each(function() {
                if ($(this).attr('data-date') == self.date) {
                    $(this).find("table").append($loc);
                    return false;
                }
            });
        });
    });

    $("#list .loc").live('click', function() {
        var lat = $(this).attr('data-lat'),
            lng = $(this).attr('data-lng');

        map.panTo(new google.maps.LatLng(lat, lng));
        map.setZoom(16);
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
                "content" : ''.concat(
                    formatDate(self.time, "date"), ', ',
                    formatDate(self.time, "time"), '<br />',
                    self.text
                )
            });
            iw.open(map, m);
        });

    });
}

function getTweets(user, cb) {
    var url = "inc/api.php?method=tweets&user=" + user;
    if (debug) url += "&local=1";

    $.getJSON(url, function(d) {
        if (d.error) {
            alert(d.error);
            loading(false);
            return false;
        }

        // Fill the profile in the list
        $("#list img").attr('src', d.avatar);
        $("#list h1").html(d.name);

        var geo = [];
        $.each(d.geo, function() {
            geo.push(this);
        });
        cb(geo);
    });
}

$(document).ready(function() {
    $("#lookup").click(function(e) {
        e.preventDefault();

        // Delete the old stuff
        $("#list").find("img").attr('src', '').end().find("h1, ul").empty();


        loading(true);

        var user = $("#user").val();
        debug = window.location.search.indexOf("debug") !== -1;
        getTweets(user, function(geo) {
            geocoder = new google.maps.Geocoder();
            map = getMap(geo[0].lat, geo[0].lng);
            fillDates(geo);
            fillList(geo);
            putMarkers(geo);
            $("#list").fadeIn();

            // For some reason Google Maps sets this back to 'relative..' and
            // i need a timer to fix it.. Weird stuff
            google.maps.event.addListener(map, 'tilesloaded', function() {
                $("#map").css('position', 'fixed');
            });
            loading(false);
        });
    });
});
})(jQuery);