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

function setupMapOverlays(map) {
    setupTubeOverlay(map);
    setupSchoolsOverlay(map);
}

function setupSchoolsOverlay(map) {
    var layer = new google.maps.FusionTablesLayer({
        query: {
            select: 'EstablishmentName',
            from: '1nzc6Ismj8WlHLlgo5zNUgf4EV-4A5qzqu4kS2G4'
        },
        styles: [{
            markerOptions: {
                iconName: 'schools'
            }
        }]
    });
    setupOverlay($("input[name='schools']"), layer, map);
}

function setupTubeOverlay(map) {
    setupOverlay($("input[name='tube']"), new google.maps.TransitLayer(), map)
}

function setupOverlay(selector, layer, map) {
    selector.change(function() {
        if ($(this).val() == "on") {
            layer.setMap(map);
        } else {
            layer.setMap(null);
        }
    });
}