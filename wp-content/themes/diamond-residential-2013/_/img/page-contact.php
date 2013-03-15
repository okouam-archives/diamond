<?php 
/*
Template Name: Contact Us
*/
get_header(); 
?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
	

			

			

			<section class="wrap main content contact-us">
			
			<h1><?php the_title(); ?></h1>
			
				<article class="grid-half">
				
				

				<?php the_content(); ?>
				


				

			</article>
			
			<article class="grid-half last">
			
			<?php echo do_shortcode('[contact-form-7 id="26" title="Contact Us Form"]'); ?>
			
			</article>
			
			</section>

			

	
		
	

		<?php endwhile; endif; ?>



<?php get_footer(); ?>
