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

            var propertyCount = <?= $results->propertyCount; ?>;
            var schoolIcon = "<?= bloginfo('template_directory') . "/_/img/marker-schools.png" ?>";
            var currentPage = <?= $results->page; ?>;
            var properties = <?= json_encode($results->properties); ?>;
            var propertyIcon = "<?= plugins_url('/assets/img/marker-house.png'); ?>";
            var schools = <?= json_encode($schools) ?>;

            var infowindow = new google.maps.InfoWindow({content: ""});
            var map = createMap("results-map");
            displayProperties(map, properties, infowindow, propertyIcon);
            setupPagination($("#paginator"), propertyCount, currentPage);
            setupOverlays(map, infowindow, schoolIcon, schools);
            setupSorting($("#filter-results"));
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
