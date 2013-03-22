<div id="sidebar" role="complimentary">

  
            <?php
    if($post->post_parent)
    $children = wp_list_pages("title_li=&child_of=".$post->post_parent."&echo=0");
    else
    $children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0");
    if ($children) {
  $parent_title = get_the_title($post->post_parent);?>
  <section class="sub-nav noise">
  <ul>
  <li class="parent-sub"><a href="<?php echo get_permalink($post->post_parent) ?>"><?php echo $parent_title;?></a></li>
    <?php echo $children; ?>
    </ul>
     </section>
    <?php } ?>
  
  <section class="noise prop-feed">
 <?php $properties = getLatestBuyProperties(); ?>
  	
  			
  				<h3>Featured properties for sale</h3>
  				<ul>
  				
  				<li class="media">
  				 <a href="/index.php/property?id=<?php echo $properties[0]->id ?>" class="content"><img class="img" src="<?php echo $properties[0]->images[0] ?>" /></a>
  				 <div class="media-text">
  				  <h3><a href="/index.php/property?id=<?php echo $properties[0]->id ?>"><?php echo $properties[0]->displayAddress ?></a></h3>
  				  <p><?php echo $properties[0]->price ?></p>
  				  <p><?php echo $properties[0]->bedrooms ?> Bedrooms</p>
  				  </div>
  				</li>
  				
  				<li class="media">
  				  <a href="/index.php/property?id=<?php echo $properties[1]->id ?>" class="content"><img class="img" src="<?php echo $properties[1]->images[0] ?>" /></a>
  				  <div class="media-text">
  				  <h3><a href="/index.php/property?id=<?php echo $properties[1]->id ?>"><?php echo $properties[1]->displayAddress ?></a></h3>
  				  <p class="content"><?php echo $properties[1]->price ?></p>
  				  <p class="content"><?php echo $properties[1]->bedrooms ?> Bedrooms</p>
  				  </div>
  				</li>
  				</ul>
  			
  	
  </section>
 

</div>