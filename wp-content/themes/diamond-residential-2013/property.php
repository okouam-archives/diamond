<?php

    $context = new Context(null, "E1D57034-6C07-44C4-A458-425CAE9D9247", 1322, uniqid(), -1, 2104);
    $finder = new PropertyFinder();
    $property = $finder->fetch($context, $_GET["id"]);
    $slices = array_chunk($property->features, count($property->features) / 2);
    get_header();
?>

	<hgroup class="wrap head-row">
		<article class="grid-10">
            <h1 class="property-title">
                <?php echo $property->bedrooms ?> Bedroom Flat,
                <?php echo $property->displayAddress ?>
            </h1>
            <h2 class="primary brand-color"><?php echo $property->price ?></h2>
		</article>
		
			</hgroup>
	
	<section class="wrap main" role="main">
	
		<article class="grid-half content">
		
			<ul class="property-share white-box nav clearfix brand-font">
				<li><a href="#"><i class="sprite viewing">Viewing:</i> Arrange a viewing</a></li>
				<li><a href="#"><i class="sprite callback">Callback:</i> Request a callback</a></li>
				<li><a href="#"><i class="sprite send">Send:</i> Send to a friend</a></li>
				<li><a href="#"><i class="sprite floorplan">Floorplan:</i> View floorplans</a></li>
				<li><a href="#"><i class="sprite epc">EPC:</i> View EPC Chart</a></li>
				<li><a href="javascript:window.print()" title="Print property information"><i class="sprite print">Print:</i> Print this page</a></li>
			</ul>
			
			<p class="large-txt"><strong><?php echo $property->summary ?></strong></p>
			
			<p><?php echo $property->description ?> </p>
			
			<h3 class="brand-color">Key Features</h3>
			<ul class="grid-5">
                <?php foreach ($slices[0] as $feature) { ?>
                    <li><?php echo $feature ?></li>
                <?php } ?>
			</ul>
			
			<ul class="grid-5 last">
                <?php foreach ($slices[1] as $feature) { ?>
                <li><?php echo $feature ?></li>
                <?php } ?>
			</ul>
		
		</article>	
		
		<article class="grid-half last flexslider-wrap ">
		
		<div id="slider" class="flexslider">
		  <ul class="slides">
		    <?php foreach($property->images as $image) { ?>
              <li>
		  	    <img src="<?php echo $image ?>&width=501" />
		  		</li>
            <?php } ?>
		  </ul>
		</div>
		<div id="carousel" class="flexslider">
		  <ul class="slides clearfix">
              <?php foreach($property->images as $image) { ?>
              <li>
                  <img src="<?php echo $image ?>&width=200" />
              </li>
              <?php } ?>
		  </ul>
		</div>
		
		</article>	
			
	</section>
	
	<section class="wrap main">
	
	<div class="grid-12 last">
	<h2>Local information and map</h2>
	
	<form>
	<ul class="nav form-fields clearfix">
	
	<li class="field-wrap">
		<label for="tube" class="inline-label">Tube stations</label>
		<div class="switch">
				<input id="tube-on" name="tube" type="radio" checked>
				<label for="tube-on" onclick="">On</label>
		
				<input id="tube-off" name="tube" type="radio">	
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
	
	<div id="property-map"  class="map">
	</div>
	
	</div>
			
	</section>

    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDY0kkJiTPVd2U7aTOAwhc9ySH6oHxOIYM&sensor=false"></script>
    <script type="text/javascript" src="http://github.com/cowboy/jquery-bbq/raw/v1.2.1/jquery.ba-bbq.min.js"></script>
    <script type="text/javascript">
        function initialize()
        {
            var longitude = <?php echo $property->longitude; ?>;
            var latitude = <?php echo $property->latitude; ?>;
            var coordinates = new google.maps.LatLng(latitude, longitude);
            var mapProp = {
                center: coordinates,
                zoom: 16,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(document.getElementById("property-map"), mapProp);
            var bounds = new google.maps.LatLngBounds();
             var marker = new google.maps.Marker({
                position: coordinates,
                map: map,
                title: "property"
            });
            google.maps.event.addListener(marker, 'click', function() {
                var url = window.location.href;
                window.location = $.param.querystring(url, {id: <?php echo $property->id; ?>});
            });
        }
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>

<?php get_footer(); ?>
