<?php 

    function getPageNumber($params) {
        return isset($params['page']) ? $params['page'] : 1;
    }

	function getPageSize($params) {
        return isset($params['per_page']) ? $params['per_page'] : 5;
    }

    function search() {
        $context = new Context(null, "E1D57034-6C07-44C4-A458-425CAE9D9247", 1322, uniqid(), -1, 2104);
        $page = getPageNumber($_GET);
        $perPage = getPageSize($_GET);
        $finder = new PropertyFinder();
        $query = $finder->getQuery($_GET);
        return $finder->search($context, $query, $page, $perPage);
    }

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
					<input id="tube-on" name="tube" value="on" type="radio" checked>
					<label for="tube-on" onclick="">On</label>
			
					<input id="tube-off" name="tube" value="off" type="radio">
					<label for="tube-off" onclick="">Off</label>
					
					<span class="slide-button"></span>
			</div>
		</li>
		
			<li class="field-wrap">
				<label for="schools" class="inline-label">Schools</label>
				<div class="switch">
						<input id="schools-on" name="schools" type="radio" checked>
						<label for="schools-on" onclick="">On</label>
				
						<input id="schools-off" name="schools" type="radio">	
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
	
	<div class="grid-12 last">

        <div id="paginator" style="margin-bottom: 20px">sdfgdsf</div>
	</div>
			
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
                            title: item.displayAddress
                        });
                        google.maps.event.addListener(marker, 'click', function() {
                            var url = window.location.href;
                            window.location = $.param.querystring(url, {id: item.id});
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

               function qs(key) {
                   key = key.replace(/[*+?^$.\[\]{}()|\\\/]/g, "\\$&"); // escape RegEx meta chars
                   var match = location.search.match(new RegExp("[?&]"+key+"=([^&]+)(&|$)"));
                   return match && decodeURIComponent(match[1].replace(/\+/g, " "));
               }

               var ordering = qs("sort");

               var tubeLayer = new google.maps.FusionTablesLayer({
                   query: {
                       select: 'Name',
                       from: '1cSgCdnxhgtMIlRQ75_4SEt_1r3dmRU7Eg6TC6xI'
                   }
               });

               var tubeSelector = $("input[name='tube']");
               tubeSelector.change(function() {
                   console.debug($(this).val());
                    if ($(this).val() == "on") {
                        tubeLayer.setMap(map);
                    } else {
                        tubeLayer.setMap(null);
                        console.alert("");
                    }
               });

               var schoolsSelector = $("input[name='schools']");
               schoolsSelector.change(function() {
                   console.debug("schools");
               });

               var sorter = $("#filter-results");

               if (ordering) sorter.val(ordering);

               sorter.change(function() {
                   var url = window.location.href;
                   window.location = $.param.querystring(url, {sort: $(this).val(), page: 1});
               })

               $("")
           })

    </script>



<?php get_footer(); ?>
