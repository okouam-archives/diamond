<?php 

    $results = search();
    get_header();
?>

	<hgroup class="wrap head-row">
		<article class="grid-10">
		<h1 class="property-title"><?php echo $results->propertyCount ?> Properties Found</h1>
		<h2 class="quinary"><strong>Page <?php echo $results->page ?> of <?php echo $results->pageCount ?></strong></h2>
		</article>
	</hgroup>

	<section class="wrap main results-page" role="main">
	
	<hr/>
	
		<article class="grid-half">
            <h2>List View</h2>
            <form>
                <ul class="nav form-fields clearfix">
                    <li class="field-wrap filter">
                        <label for="filter-results">Filter Results:</label>
                        <select name="filter-results" id="filter-results" class="select-box">
                            <option value="true">Highest Price</option>
                            <option value="false">Lowest Price</option>
                        </select>
                    </li>
                </ul>
            </form>

            <?php foreach($results->properties as $property) { ?>

            <article class="media white-box listing">
                <a href="/index.php/property?id=<?php echo $property->id ?>">
                    <img class="img" style="width: 162px; height: 119px" src="<?php echo $property->images[0] ?>" /></a>
                <div class="media-text">
                    <h1 class="tertiary"><a href="/index.php/property?id=<?php echo $property->id ?>"><?php echo $property->displayAddress ?></a></h1>
                    <h2 class="quinary"><strong><?php echo $property->price ?></strong></h2>
                    <?php if ($property->bedrooms > 1) { ?>
                    <h3 class="quinary"><strong><?php echo $property->bedrooms ?> Bedrooms</strong></h3>
                    <?php } else if ($property->bedrooms > 0) { ?>
                    <h3 class="quinary"><strong>1 Bedroom</strong></h3>
                    <?php } else { ?>
                    <h3 class="quinary"><strong>Studio</strong></h3>
                    <?php } ?>
                    <p><?php echo $property->description ?></p>
                </div>
            </article>

            <?php } ?>

		</article>	
		
		<article class="grid-half last">
		
            <h2>Map View</h2>

            <form>
                <ul class="nav form-fields clearfix">
                    <li class="field-wrap">
                        <label for="tube" class="inline-label">Tube stations</label>
                        <div class="switch">
                            <input id="tube-on" name="tube" value="on" type="radio" >
                            <label for="tube-on" onclick="">On</label>
                            <input id="tube-off" name="tube" value="off" type="radio" checked>
                            <label for="tube-off" onclick="">Off</label>
                            <span class="slide-button"></span>
                        </div>
                    </li>
                    <li class="field-wrap">
                        <label for="schools" class="inline-label">Schools</label>
                        <div class="switch">
                            <input id="schools-on" name="schools" value="on" type="radio" >
                            <label for="schools-on" onclick="">On</label>
                            <input id="schools-off" name="schools" value="off" type="radio" checked>
                            <label for="schools-off" onclick="">Off</label>
                            <span class="slide-button"></span>
                        </div>
                    </li>
                </ul>
            </form>

            <div id="results-map" class="map"></div>
		
		</article>	
			
	</section>
	
	<section class="wrap main">
	    <div class="grid-12 last"><div id="paginator" style="margin-bottom: 20px"></div></div>
	</section>

    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDY0kkJiTPVd2U7aTOAwhc9ySH6oHxOIYM&sensor=false"></script>
    <script type="text/javascript" src="https://raw.github.com/okouam/jquery-bbq/master/jquery.ba-bbq.min.js"></script>
    <script type="text/javascript" src="<?php echo plugins_url('/assets/js/jquery.simplePagination.js'); ?>"></script>
    <script type="text/javascript">

           $(function() {

                var results = <?php echo json_encode($results->properties); ?>;

                var mapProp = {
                    center: new google.maps.LatLng(51.508742,-0.120850),
                    zoom: 5,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                var map = new google.maps.Map(document.getElementById("results-map"), mapProp);
                var bounds = new google.maps.LatLngBounds();
                $.each(results, function(i, item) {
                    var longitude = item.longitude;
                    var latitude = item.latitude;
                    var coordinates = new google.maps.LatLng(latitude, longitude);
                    if (longitude != 0 && latitude != 0) {
                        bounds.extend(coordinates);
                        var marker = new google.maps.Marker({
                            position: coordinates,
                            map: map,
                            title: item.displayAddress,
                            icon: "<?php echo plugins_url('/assets/img/marker-house.png'); ?>"
                        });
                        google.maps.event.addListener(marker, 'click', function() {
                            window.location = "/index.php/property?id=" + item.id;
                        });
                    }
                });

                map.fitBounds(bounds);

               var pagination = {
                    items: <?php echo $results->propertyCount; ?>,
                    itemsOnPage: 10,
                    currentPage: <?php echo $results->page; ?>,
                    cssStyle: 'dark-theme',
                    onPageClick: function(pageNumber) {
                        var url = window.location.href;
                        window.location = $.param.querystring(url, {page: pageNumber});
                    }
                };

               $("#paginator").pagination(pagination);

               var ordering = qs("sort");

               setupMapOverlays(map);

               var sorter = $("#filter-results");

               if (ordering) sorter.val(ordering);

               sorter.change(function() {
                   var url = window.location.href;
                   window.location = $.param.querystring(url, {sort: $(this).val(), page: 1});
               });
           })

    </script>

<?php get_footer(); ?>
