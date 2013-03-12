<form>

	<label>Minimum Price</label>
	<select name="pf_min_price" id="pf_min_price">
		<option value="0" <?php echo isset($_GET['pf_min_price']) && $_GET['pf_min_price'] == 0 ? "selected" : "" ?>>Any</option>
		<option value="100" <?php echo isset($_GET['pf_min_price']) && $_GET['pf_min_price'] == 100 ? "selected" : "" ?>>100</option>
		<option value="200" <?php echo isset($_GET['pf_min_price']) && $_GET['pf_min_price'] == 200 ? "selected" : "" ?>>200</option>
		<option value="300" <?php echo isset($_GET['pf_min_price']) && $_GET['pf_min_price'] == 300 ? "selected" : "" ?>>300</option>
		<option value="400" <?php echo isset($_GET['pf_min_price']) && $_GET['pf_min_price'] == 400 ? "selected" : "" ?>>400</option>
		<option value="500" <?php echo isset($_GET['pf_min_price']) && $_GET['pf_min_price'] == 500 ? "selected" : "" ?>>500</option>
	</select>
	<label>Maximum Price</label>
	<select name="pf_max_price" id="pf_max_price">
		<option value="0" <?php echo isset($_GET['pf_max_price']) && $_GET['pf_max_price'] == 0 ? "selected" : "" ?>>Any</option>
		<option value="100" <?php echo isset($_GET['pf_max_price']) && $_GET['pf_max_price'] == 100 ? "selected" : "" ?>>100</option>
		<option value="200" <?php echo isset($_GET['pf_max_price']) && $_GET['pf_max_price'] == 200 ? "selected" : "" ?>>200</option>
		<option value="300" <?php echo isset($_GET['pf_max_price']) && $_GET['pf_max_price'] == 300 ? "selected" : "" ?>>300</option>
		<option value="400" <?php echo isset($_GET['pf_max_price']) && $_GET['pf_max_price'] == 400 ? "selected" : "" ?>>400</option>
		<option value="500" <?php echo isset($_GET['pf_max_price']) && $_GET['pf_max_price'] == 500 ? "selected" : "" ?>>500</option>
	</select>
	<label>Minimum Bedrooms</label>
	<select name="pf_bedrooms" id="pf_bedrooms">
		<option <?php echo isset($_GET['pf_bedrooms']) && $_GET['pf_bedrooms'] == 1 ? "selected" : "" ?>>1</option>
		<option <?php echo isset($_GET['pf_bedrooms']) && $_GET['pf_bedrooms'] == 2 ? "selected" : "" ?>>2</option>
		<option <?php echo isset($_GET['pf_bedrooms']) && $_GET['pf_bedrooms'] == 3 ? "selected" : "" ?>>3</option>
		<option <?php echo isset($_GET['pf_bedrooms']) && $_GET['pf_bedrooms'] == 4 ? "selected" : "" ?>>4</option>
		<option <?php echo isset($_GET['pf_bedrooms']) && $_GET['pf_bedrooms'] == 5 ? "selected" : "" ?>>5</option>
	</select>
	<input type="submit" />
</form>

<?php if (count($result->properties) > 0 ) { ?>

	<?php foreach($result->properties as $property) { ?>
		<ul style="list-style-type: none">
			<li style="margin-left: 20px; font-size: 11px; line-height: 16px">
				<div style="float: left; display: inline-block; width: 200px">
					<a href="/?pf_id=<?php echo $property->id ?>"><img src="<?php echo $property->images[0] ?>" width="150" /></a>
				</div>
				<div style="float: left; width: 350px">
					<h3><?php echo $property->price ?> pcm</h3>
					<p><?php echo $property->description ?></p>
					<p><?php echo $property->displayAddress ?></p>
				</div>
			</li>
		</ul>
	<?php } ?>

	<div style="clear: both"/></div>

	<div id="paginator" style="margin-bottom: 20px"></div>

	<script>
		$(function() {
		    $("#paginator").pagination({
		        items: <?php echo $result->propertyCount; ?>,
		        itemsOnPage: 10,
		        currentPage: <?php echo $result->page; ?>,
		        cssStyle: 'dark-theme',
		        onPageClick: function(pageNumber) {
		        	var url = window.location.href;
					window.location = $.param.querystring(url, {pf_page: pageNumber});	
		        }
		    });
		});
	</script>

	<div style="clear: both"/></div>
	<style type="text/css" href="/assets/css/simplePagination.css"></style>
	<script>
		function initialize()
		{
			var mapProp = {
		  		center: new google.maps.LatLng(51.508742,-0.120850),
		  		zoom: 5,
		  		mapTypeId: google.maps.MapTypeId.ROADMAP
		  	};
			var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
			var results = <?php echo json_encode($result->properties); ?>;
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
				    	title: "property " + i
					});		
					google.maps.event.addListener(marker, 'click', function() {
						var url = window.location.href;
						window.location = $.param.querystring(url, {pf_id: item.id});
					});
				}
			});
			if (console && console.debug) console.debug(bounds);
			map.fitBounds(bounds);
		}
		google.maps.event.addDomListener(window, 'load', initialize);
	</script>
	<div id="googleMap" style="width:500px;height:380px;border: 1px solid black"></div>

<?php } else { ?>
	
	<p>No matching properties were found.</p>

<?php } ?>