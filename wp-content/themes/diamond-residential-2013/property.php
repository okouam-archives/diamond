<?php

    $context = new Context(null, "E1D57034-6C07-44C4-A458-425CAE9D9247", 1322, uniqid(), -1, 2104);
    $finder = new PropertyFinder();
    $property = getProperty($_GET["id"]);
    $finder->fetch($context, $_GET["id"]);
    $slices = array_chunk($property->features, count($property->features) / 2);
    $schools = array();
    if ($property->longitude != 0 and $property->latitude != 0) {
        find_surrounding_schools($property, $schools);
    }
    get_header();
?>

	<hgroup class="wrap head-row">
		<article class="grid-10">
            <h1 class="property-title">
                <?= format_bedrooms($property->bedrooms) ?> Flat,
                <?= $property->displayAddress ?>
            </h1>
            <h2 class="primary brand-color"><?= $property->price ?></h2>
		</article>
		
			</hgroup>
	
	<section class="wrap main" role="main">
	
		<article class="grid-half content">
		
			<ul class="property-share white-box nav clearfix brand-font">
				<li><a href="#"><i class="sprite viewing">Viewing:</i> Arrange a viewing</a></li>
				<li><a href="#"><i class="sprite callback">Callback:</i> Request a callback</a></li>
				<li><a href="#"><i class="sprite send">Send:</i> Send to a friend</a></li>
                <?php if ($property->floorplans) { ?>
				    <li><a href="<?= $property->floorplans . "&width=800" ?>"><i class="sprite floorplan">Floorplan:</i> View floorplans</a></li>
				<?php } else { ?>
                    <li class="missing"><a href="#"><i class="sprite floorplan">Floorplan:</i> View floorplans</a></li>
                <?php } ?>
                <?php if ($property->epc_chart) { ?>
                    <li><a href="<?= $property->epc_chart ?>"><i class="sprite epc">EPC:</i> View EPC Chart</a></li>
                <?php } else { ?>
                    <li class="missing"><a href="#"><i class="sprite epc">EPC:</i> View EPC Chart</a></li>
                <?php } ?>
				<li><a href="javascript:window.print()" title="Print property information"><i class="sprite print">Print:</i> Print this page</a></li>
			</ul>
			
			<p class="large-txt"><strong><?= $property->summary ?></strong></p>
			
			<p><?= $property->description ?> </p>
			
			<h3 class="brand-color">Key Features</h3>
			<ul class="grid-5">
                <?php foreach ($slices[0] as $feature) { ?>
                    <li><?= $feature ?></li>
                <?php } ?>
			</ul>
			
			<ul class="grid-5 last">
                <?php foreach ($slices[1] as $feature) { ?>
                <li><?= $feature ?></li>
                <?php } ?>
			</ul>
		
		</article>	
		
		<article class="grid-half last flexslider-wrap ">
		
		<div id="slider" class="flexslider">
		  <ul class="slides">
		    <?php foreach($property->images as $image) { ?>
              <li>
		  	    <img src="<?= $image ?>&width=501" />
		  		</li>
            <?php } ?>
		  </ul>
		</div>
		<div id="carousel" class="flexslider">
		  <ul class="slides clearfix">
              <?php foreach($property->images as $image) { ?>
              <li>
                  <img src="<?= $image ?>&width=200" />
              </li>
              <?php } ?>
		  </ul>
		</div>
		
		</article>	
			
	</section>

<?php if ($property->longitude != 0 and $property->latitude != 0) { ?>

	<section class="wrap main">
	
	<div class="grid-12 last">
	<h2>Local information and map</h2>
	
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

	<div id="property-map"  class="map">
	</div>

	</div>
			
	</section>

        <script type="text/javascript">
            $(function() {

                var longitude = <?= $property->longitude; ?>;
                var latitude = <?= $property->latitude; ?>;
                var coordinates = new google.maps.LatLng(latitude, longitude);
                var mapProp = {
                    center: coordinates,
                    zoom: 16,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                var map = new google.maps.Map(document.getElementById("property-map"), mapProp);
                var marker = new google.maps.Marker({
                    position: coordinates,
                    map: map,
                    title: "property",
                    icon: "<?= bloginfo('template_directory') . "/_/img/marker-house.png" ?>"
                });

                setupTubeOverlay(map);
                setupSchoolsOverlay(map, <?= json_encode($schools) ?>, "<?= bloginfo('template_directory') . '/_/img/marker-schools.png' ?>");

            })
        </script>
    <?php } ?>

<?php get_footer(); ?>
