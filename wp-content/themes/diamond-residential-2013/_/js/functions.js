(function($){})(window.jQuery);

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
      $('.select-box').customSelect();
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

function setupSchoolsOverlay(map, schools, icon, infowindow) {
    var markers = [];

    for(var i = 0; i < schools.length; i++) {
        var school = schools[i];
        var coordinates = new google.maps.LatLng(school.latitude, school.longitude);
        var marker = new google.maps.Marker({
            position: coordinates,
            icon: icon,
            title: school.name
        });
        marker.info = school;
        markers.push(marker);
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.content = "<b>" + this.info.name + "</b><br/>" + this.info.category;
            infowindow.open(map, this);
        });
    }

    $("input[name='schools']").change(function() {
        if ($(this).val() == "on") {
            for(var i = 0; i < markers.length; i++) {
                markers[i].setMap(map);
            }
        } else {
            for(var i = 0; i < markers.length; i++) {
                markers[i].setMap(null);
                infowindow.map = null;
                infowindow.marker = null;
                infowindow.close();
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

function createMap(id) {
    var mapProp = {
        center: new google.maps.LatLng(51.508742,-0.120850),
        minZoom: 10,
        maxZoom: 18,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    return new google.maps.Map(document.getElementById(id), mapProp);
}

function displayProperty(property, map, infowindow, bounds, icon) {
    var longitude = property.longitude;
    var latitude = property.latitude;
    if (longitude != 0 && latitude != 0) {
        var coordinates = new google.maps.LatLng(latitude, longitude);
        bounds.extend(coordinates);
        var marker = createPropertyMarker(property, coordinates, icon, map);
        google.maps.event.addListener(marker, 'click', function() {
            openInfoWindow(infowindow, map, this);
        });
    }
}

function setupSorting(sorter) {
    var ordering = qs("sort");
    if (ordering) sorter.val(ordering);
    sorter.change(function() {
        var url = window.location.href;
        window.location = $.param.querystring(url, {sort: $(this).val(), pos: 1});
    });
}

function openInfoWindow(infowindow, map, marker) {
    infowindow.content = "<div id='infowindow'><strong>"
        + marker.displayAddress
        + "</strong><br/>"
        + marker.summary
        + "<br/><a href='"
        + "/index.php/property?id=" + marker.id
        + "'>Details</a></div>";
    infowindow.open(map, marker);
}

function createPropertyMarker(property, coordinates, icon, map) {
    var marker = new google.maps.Marker({
        position: coordinates,
        title: property.displayAddress,
        icon: icon
    });
    if (property.bedrooms < 1) {
        marker.summary = "Studio";
    } else if (property.bedrooms < 2) {
        marker.summary = "1 Bedroom";
    } else {
        marker.summary = property.bedrooms + " Bedrooms";
    }
    marker.summary = marker.summary + ", "  + property.price;
    marker.displayAddress = property.displayAddress;
    marker.id = property.id;
    marker.setMap(map);
    return marker;
}

function setupPagination(el, propertyCount, currentPage) {
    el.pagination({
        items: propertyCount,
        itemsOnPage: 5,
        currentPage: currentPage,
        onPageClick: handlePageClick
    });
}

function handlePageClick(pageNumber) {
    var search = window.location.search;
    var pos = qs('pos');
    if (pos) {
        search = search.replace("pos=" + pos, "pos=" + pageNumber);
    } else {
        search = search + "&pos=" + pageNumber;
    }
    var url = window.location.href.substring(0, window.location.href.indexOf("?"));
    window.location = url + search;
    return false;
}


function setupOverlays(map, infowindow, icon, schools) {
    setupTubeOverlay(map);
    setupSchoolsOverlay(map, schools, icon, infowindow);
}

function displayProperties(map, properties, infowindow, icon) {
    var bounds = new google.maps.LatLngBounds();
    for(var i = 0; i < properties.length; i++) {
        displayProperty(properties[i], map, infowindow, bounds, icon);
    }
    map.fitBounds(bounds);
}


