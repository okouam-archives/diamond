<?php 
    $results = search();

    $schools = array();

    foreach($results->properties as $property) {
        if ($property->longitude != 0 and $property->latitude != 0) {
            find_surrounding_schools($property, $schools);
        }
    }

    get_header();
?>

	<hgroup class="wrap head-row">
		<article class="grid-10">
		<h1 class="property-title"><?= $results->propertyCount ?> Properties Found</h1>
        <?php if ($results->propertyCount > 0) { ?>
		    <h2 class="quinary"><strong>Page <?= $results->page ?> of <?= $results->pageCount ?></strong></h2>
		<?php } ?>
        </article>
	</hgroup>



	<section class="wrap main results-page" role="main">
	
	<hr/>

        <?php if ($results->propertyCount > 0) { ?>

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
                <a href="/index.php/property?id=<?= $property->id ?>">
                    <img class="img" style="width: 162px; height: 119px" src="<?= $property->image ?>" /></a>
                <div class="media-text">
                    <h1 class="tertiary"><a href="/index.php/property?id=<?= $property->id ?>"><?= $property->displayAddress ?></a></h1>
                    <h2 class="quinary"><strong><?= $property->price ?></strong></h2>
                    <h3 class="quinary"><strong><?= format_bedrooms($property->bedrooms) ?> </strong></h3>
                    <p><?= $property->summary ?></p>
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

        <?php } ?>
			
	</section>

<?php if ($results->propertyCount > 0) { ?>

	<section class="wrap main">
	    <div class="grid-12 last"><div id="paginator" style="margin-bottom: 20px"></div></div>
	</section>

    <script type="text/javascript">

       $(function() {

           var results = <?= json_encode($results->properties); ?>;

            var mapProp = {
                center: new google.maps.LatLng(51.508742,-0.120850),
                minZoom: 10,
                maxZoom: 18,
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
                        icon: "<?= plugins_url('/assets/img/marker-house.png'); ?>"
                    });
                    google.maps.event.addListener(marker, 'click', function() {
                        window.location = "/index.php/property?id=" + item.id;
                    });
                }
            });

            map.fitBounds(bounds);

           var pagination = {
                items: <?= $results->propertyCount; ?>,
                itemsOnPage: 5,
                currentPage: <?= $results->page; ?>,
                cssStyle: 'dark-theme',
                onPageClick: function(pageNumber) {
                    var url = window.location.href;
                    var target = $.param.querystring(url, {pos: pageNumber});
                    window.location = $.param.querystring(url, {pos: pageNumber});
                    return false;
                }
            };

           $("#paginator").pagination(pagination);

           var ordering = qs("sort");

           setupTubeOverlay(map);
           setupSchoolsOverlay(map, <?= json_encode($schools) ?>, "<?= bloginfo('template_directory') . "/_/img/marker-schools.png" ?>");

           var sorter = $("#filter-results");

           if (ordering) sorter.val(ordering);

           sorter.change(function() {
               var url = window.location.href;
               window.location = $.param.querystring(url, {sort: $(this).val(), pos: 1});
           });
       })

    </script>

<style type="text/css">
    #paginator {text-align: center}
    #paginator .prev {float: left}
    #paginator .next {float: right}
    #paginator a, #paginator span {margin-left: 5px; margin-right: 5px}
</style>

<?php } ?>

<?php get_footer(); ?>
