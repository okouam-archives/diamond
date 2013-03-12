<?php foreach($result->images as $image) { ?>

	<img src="<?php echo $image ?>&width=200" />

<?php } ?>

<h3>Features</h3>

<ul>
	<li>Location: <?php echo $result->displayAddress ?></li>
	<li>Price: <?php echo $result->price ?></li>
	<li>Bedrooms: <?php echo $result->bedrooms ?></li>
	<li>Bathrooms: <?php echo $result->bathrooms ?></li>
	<li>Receptions: <?php echo $result->receptions ?></li>
	<li>Garages: <?php echo $result->garages ?></li>
	<li>Gardens: <?php echo $result->gardens ?></li>
	<li>Other Rooms: <?php echo $result->otherRooms ?></li>
	<li>Parking Spaces: <?php echo $result->parkingSpaces ?></li>
	<li>Property Type: <?php echo $result->propertyType ?></li>
</ul>

<p><?php echo $result->description ?></p>
