(function($){})(window.jQuery);

$(document).ready(function (){
	 $('.select-box').customSelect();
});

(function($) {
      $(window).load(function(){
      $('#carousel').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        itemWidth: 130,
        itemMargin: 5,
        asNavFor: '#slider'
      });
       
      $('#slider').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        sync: "#carousel"
      });
    });
})(jQuery);

function qs(key) {
    key = key.replace(/[*+?^$.\[\]{}()|\\\/]/g, "\\$&"); // escape RegEx meta chars
    var match = location.search.match(new RegExp("[?&]"+key+"=([^&]+)(&|$)"));
    return match && decodeURIComponent(match[1].replace(/\+/g, " "));
}

function setupSchoolsOverlay(map, schools, icon) {
    var markers = [];
    for(var i = 0; i < schools.length; i++) {
        var school = schools[i];
        var coordinates = new google.maps.LatLng(school.latitude, school.longitude);
        var marker = new google.maps.Marker({
            position: coordinates,
            icon: icon,
            title: school.name
        });
        markers.push(marker);
    }

    $("input[name='schools']").change(function() {
        if ($(this).val() == "on") {
            for(var i = 0; i < markers.length; i++) {
                markers[i].setMap(map);
            }
        } else {
            for(var i = 0; i < markers.length; i++) {
                markers[i].setMap(null);
            }
        }
    });
}

function setupTubeOverlay(map) {
    toggleTubeOverlay($("input[name='tube']"), new google.maps.TransitLayer(), map)
}

function toggleTubeOverlay(selector, layer, map) {
    selector.change(function() {
        if ($(this).val() == "on") {
            layer.setMap(map);
        } else {
            layer.setMap(null);
        }
    });
}