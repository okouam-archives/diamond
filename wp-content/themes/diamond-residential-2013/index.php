<?php get_header(); ?>

	<section class="wrap main content">
		<article class="grid-7">
		<h2 class="primary">Welcome to Diamond Residential</h2>
		<p class="home-intro">
		Diamond Residential is a family run, independent Estate Agency bringing a
		fresh approach to the property industry in Little Venice and the surrounding
		areas. Our business is dedicated to offering a first class and friendly service.
		Within our team we have a wealth of experience to call upon to ensure our
		clients receive the assistance they need every step of the way.
		</p>

            <a class="grey-btn lrg-btn noise btn" href="<?= get_option('home'); ?>/about-diamond-residential/" title="Read more about Diamond Residential">Read More</a>
		</article>
		
		<article class="grid-5 last"><img class="home-img" src="<?php bloginfo('template_directory'); ?>/_/img/diamond-residential-london-shop-front.jpg" /></article>
	</section>
	
	<section class="wrap main home-boxes"">
	
		<article class="grid-half white-box">

            <?php $properties = getLatestBuyProperties(); ?>

            <h2>Featured properties for sale</h2>
			
			<article class="grid-half">
			 <a href="/index.php/property?id=<?= $properties[0]->id ?>" class="content"><img style="width: 228px; height: 173px" src="<?= $properties[0]->image ?>"</a>
			  <h3><a href="/index.php/property?id=<?= $properties[0]->id ?>"><?= $properties[0]->displayAddress ?></a></h3>
			  <p class="content"><?= $properties[0]->price ?></p>
			  <p class="content"><?= format_bedrooms($properties[0]->bedrooms) ?></p>
			  
			</article>
			
			<article class="grid-half last">
			  <a href="/index.php/property?id=<?= $properties[1]->id ?>" class="content"><img style="width: 228px; height: 173px" src="<?= $properties[1]->image ?>"</a>
			  <h3><a href="/index.php/property?id=<?= $properties[1]->id ?>"><?php echo $properties[1]->displayAddress ?></a></h3>
			  <p class="content"><?= $properties[1]->price ?></p>
			  <p class="content"><?= format_bedrooms($properties[1]->bedrooms) ?></p>
			</article>
		
		</article>
		
		<article class="grid-half white-box last">

            <?php $properties = getLatestRentProperties(); ?>

            <h2>Featured properties for rent</h2>
			
			<article class="grid-half">
			 <a href="/index.php/property?id=<?= $properties[0]->id ?>" class="content"><img style="width: 228px; height: 173px" src="<?= $properties[0]->image ?>" /></a>
			  <h3><a href="/index.php/property?id=<?= $properties[0]->id ?>"><?= $properties[0]->displayAddress ?></a></h3>
			  <p class="content"><?= $properties[0]->price ?></p>
			  <p class="content"><?= format_bedrooms($properties[0]->bedrooms) ?></p>
			</article>
			
			<article class="grid-half last">
			  <a href="/index.php/property?id=<?= $properties[1]->id ?>" class="content"><img style="width: 228px; height: 173px" src="<?= $properties[1]->image ?>" /></a>
			  <h3><a href="/index.php/property?id=<?= $properties[1]->id ?>"><?= $properties[1]->displayAddress ?></a></h3>
			  <p class="content"><?= $properties[1]->price ?></p>
			  <p class="content"><?= format_bedrooms($properties[1]->bedrooms) ?></p>
			</article>
		
		</article>
	
	</section>
	
	<section class="wrap main home-snippets content">
	
		<article class="grid-one-third">
			<h2>Register as rental applicant</h2>
			<p>Pellentesque habitant morbi tristique 
			senectus et netus.
			</p>
			
			<a class="sml-btn btn pink-btn" href="<?= get_option('home'); ?>/register-with-us/register-as-rental-applicant/" title="Register with us as a rental applicant">Register as rental applicant</a>
		</article>
		<article class="grid-one-third">
			<h2>Register as sales applicant</h2>
			
			<p>Pellentesque habitant morbi tristique 
			senectus et netus.
			</p>
			
			<a class="sml-btn btn pink-btn" href="<?= get_option('home'); ?>/register-with-us/register-as-sales-applicant/" title="Register with us as a sales applicant">Register as sales applicant</a>
		</article>
		<article class="grid-one-third last">
			<h2>Free valuation for Landlord</h2>
			
			<p>Pellentesque habitant morbi tristique 
			senectus et netus.
			</p>
			
			<a class="sml-btn btn pink-btn" href="#">Free valuation</a>
		</article>
	
	</section>

<?php get_footer(); ?>
