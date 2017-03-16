<section id="sidebar">

    <div class="sidebar_content">

    	<?php if (option::get('banner_sidebar_enable') == 'on' && option::get('banner_sidebar_position') == 'Before widgets') { ?>
    		<div class="side_ad">

    			<?php if ( option::get('banner_sidebar_html') <> "") {
    				echo stripslashes(option::get('banner_sidebar_html'));
    			} else { ?>
    				<a href="<?php echo option::get('banner_sidebar_url'); ?>"><img src="<?php echo option::get('banner_sidebar'); ?>" alt="<?php echo option::get('banner_sidebar_alt'); ?>" /></a>
    			<?php } ?>

    		</div><!-- /.side_ad -->
    	<?php } ?>

     	<?php dynamic_sidebar('Sidebar'); ?>

     	<?php if (option::get('banner_sidebar_enable') == 'on' && option::get('banner_sidebar_position') == 'After widgets') { ?>
    		<div class="side_ad">

    			<?php if ( option::get('banner_sidebar_html') <> "") {
    				echo stripslashes(option::get('banner_sidebar_html'));
    			} else { ?>
    				<a href="<?php echo option::get('banner_sidebar_url'); ?>"><img src="<?php echo option::get('banner_sidebar'); ?>" alt="<?php echo option::get('banner_sidebar_alt'); ?>" /></a>
    			<?php } ?>

    		</div><!-- /#side_ad -->
    	<?php } ?>

    </div>

	<div class="clear"></div>
</section>
<div class="clear"></div>