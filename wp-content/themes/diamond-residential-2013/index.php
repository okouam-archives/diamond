<?php get_header(); ?>

<?php

    $context = new Context(null, "E1D57034-6C07-44C4-A458-425CAE9D9247", 1322, uniqid(), -1, 2104);
    $finder = new PropertyFinder();

?>

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
		
		<a class="grey-btn lrg-btn noise btn">Read More</a>
		</article>
		
		<article class="grid-5 last"><img class="home-img" src="<?php bloginfo('template_directory'); ?>/_/img/diamond-residential-london-shop-front.jpg" /></article>
	</section>
	
	<section class="wrap main">
	
		<article class="grid-half white-box">

            <?php

            $query = new Query(new PriceRange(0, 1000000000), 0, SearchType::Sales, null, true);
            $results = $finder->search($context, $query, 1, 2);
            $properties = $results->properties;
            ?>

			<h2><a href="#">Latest Properties for sale</a></h2>
			
			<article class="grid-half">
			 <a href="/index.php/property?id=<?php echo $properties[0]->id ?>" class="content"><img style="width: 228px; height: 173px" src="<?php echo $properties[0]->images[0] ?>"</a>
			  <h3><a href="/index.php/property?id=<?php echo $properties[0]->id ?>"><?php echo $properties[0]->displayAddress ?></a></h3>
			  <p class="content"><?php echo $properties[0]->price ?></p>
			  <p class="content"><?php echo $properties[0]->bedrooms ?> Bedrooms</p>
			  
			</article>
			
			<article class="grid-half last">
			  <a href="/index.php/property?id=<?php echo $properties[1]->id ?>" class="content"><img style="width: 228px; height: 173px" src="<?php echo $properties[1]->images[0] ?>"</a>
			  <h3><a href="/index.php/property?id=<?php echo $properties[1]->id ?>"><?php echo $properties[1]->displayAddress ?></a></h3>
			  <p class="content"><?php echo $properties[1]->price ?></p>
			  <p class="content"><?php echo $properties[1]->bedrooms ?> Bedrooms</p>
			</article>
		
		</article>
		
		<article class="grid-half white-box last">

            <?php

                $query = new Query(new PriceRange(0, 1000000000), 0, SearchType::Lettings, null, true);
                $results = $finder->search($context, $query, 1, 2);
                $properties = $results->properties;
            ?>

			<h2><a href="#">Latest Properties for rent</a></h2>
			
			<article class="grid-half">
			 <a href="/index.php/property?id=<?php echo $properties[0]->id ?>" class="content"><img style="width: 228px; height: 173px" src="<?php echo $properties[0]->images[0] ?>" /></a>
			  <h3><a href="/index.php/property?id=<?php echo $properties[0]->id ?>"><?php echo $properties[0]->displayAddress ?></a></h3>
			  <p class="content"><?php echo $properties[0]->price ?></p>
			  <p class="content"><?php echo $properties[0]->bedrooms ?> Bedrooms</p>
			</article>
			
			<article class="grid-half last">
			  <a href="/index.php/property?id=<?php echo $properties[1]->id ?>" class="content"><img style="width: 228px; height: 173px" src="<?php echo $properties[1]->images[0] ?>" /></a>
			  <h3><a href="/index.php/property?id=<?php echo $properties[1]->id ?>"><?php echo $properties[1]->displayAddress ?></a></h3>
			  <p class="content"><?php echo $properties[1]->price ?></p>
			  <p class="content"><?php echo $properties[1]->bedrooms ?> Bedrooms</p>
			</article>
		
		</article>
	
	</section>
	
	<section class="wrap main home-snippets content">
	
		<article class="grid-one-third">
			<h2>Register as rental applicant</h2>
			<p>Pellentesque habitant morbi tristique 
			senectus et netus.
			</p>
			
			<a class="sml-btn btn pink-btn" href="#">Register as rental applicant</a>
		</article>
		<article class="grid-one-third">
			<h2>Register as sales applicant</h2>
			
			<p>Pellentesque habitant morbi tristique 
			senectus et netus.
			</p>
			
			<a class="sml-btn btn pink-btn" href="#">Register as sales applicant</a>
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
