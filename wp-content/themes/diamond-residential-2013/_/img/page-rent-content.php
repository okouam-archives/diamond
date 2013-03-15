<?php 
/*
Template Name: Rent Content
*/
get_header(); 
?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
	

			

			

			<section class="wrap main content">
			
				<article class="grid-9">
				
				<h1><?php the_title(); ?></h1>

				<?php the_content(); ?>

				

			</article>
			
			<article class="grid-3 last">
			
			<?php include (TEMPLATEPATH . '/sidebar-rent.php' ); ?>
			
			</article>
			
			</section>

			

	
		
	

		<?php endwhile; endif; ?>



<?php get_footer(); ?>
