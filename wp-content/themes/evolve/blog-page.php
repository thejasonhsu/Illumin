<?php
/**
 * Template Name: Blog
 *
 * @package EvoLve
 * @subpackage Template
 */

get_header();
$first = "";
?>


       <?php 
       
       global $authordata;
       $xyz = ""; 
       $options = get_option('evolve'); 
 		   $evolve_layout = evolve_get_option('evl_layout','2cl'); 
	     $evolve_post_layout = evolve_get_option('evl_post_layout','two');  
 		   $evolve_nav_links = evolve_get_option('evl_nav_links','after'); 
 		   $evolve_header_meta = evolve_get_option('evl_header_meta','single_archive'); 
       $evolve_excerpt_thumbnail = evolve_get_option('evl_excerpt_thumbnail','0'); 
	     $evolve_share_this = evolve_get_option('evl_share_this','single'); 
 	     $evolve_post_links = evolve_get_option('evl_post_links','after'); 
 	     $evolve_similar_posts = evolve_get_option('evl_similar_posts','disable'); 
       
       if ($evolve_layout == "1c") {  
       $imagewidth = "960";
       } elseif ($evolve_layout == "2cl" || $evolve_layout == "2cr") {
	     $imagewidth = "620";
       } else {
       $imagewidth = "506";
       }
 
 		  if (($evolve_layout == "1c"))    
  
    { ?>
  
  
  <?php } else { ?>

  <?php $options = get_option('evolve');
  
  if(get_post_meta($post->ID, 'evolve_full_width', true) == 'yes'):
  
  else:
  
  if (($evolve_layout == "3cm" || $evolve_layout == "3cl" || $evolve_layout == "3cr")) { ?>   
  
  <?php get_sidebar('2'); ?>
  
  
  <?php } ?>
  
  <?php endif; ?>
  
    <?php } ?>

		<?php get_template_part( 'content', 'blog' ); ?>
      
      
 <?php  
   if ($evolve_layout == "1c")  
  
  
    { ?>
  
  
  <?php } else { ?>


<?php wp_reset_query(); if(get_post_meta($post->ID, 'evolve_full_width', true) == 'yes'):
  
  else:       

get_sidebar(); 

endif; ?>

    <?php } ?>

<?php get_footer(); ?>

