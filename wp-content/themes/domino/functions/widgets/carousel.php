<?php

/*------------------------------------------*/
/* WPZOOM: Carousel Slider                  */
/*------------------------------------------*/


$wpzoomColors = array();
$wpzoomColors['blue'] = 'Blue';
$wpzoomColors['red'] = 'Red';
$wpzoomColors['green'] = 'Green';
$wpzoomColors['black'] = 'Black';
$wpzoomColors['orange'] = 'Orange';
$wpzoomColors['purple'] = 'Purple';


class Wpzoom_Carousel_Slider extends WP_Widget {

	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'carousel-slider', 'description' => 'A horizontal carousel that displays latests posts from different sources.' );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'wpzoom-carousel-slider' );

		/* Create the widget. */
		parent::__construct( 'wpzoom-carousel-slider', 'WPZOOM: Carousel Slider', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {

		extract( $args );

		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$color = $instance['color'];
		$show_count = $instance['show_count'];
		$auto_scroll = $instance['auto_scroll'] == true;
 		$show_date = $instance['show_date'] ? true : false;
		$show_category = $instance['show_category'] ? true : false;
 		$type = $instance['type'];
 		$category = $instance['category'];
		$slugs = $instance['slugs'];

		if ($type == 'tag') {
			$postsq = $slugs;
		} elseif ($type == 'cat') {
			$postsq = implode(', ', (array) $category);
			$firstcategory = get_category($instance['category'][0]);

			if ($firstcategory) {
				$category_link = get_category_link($firstcategory);
			}
		}

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )

			echo '<h3 class="title title-color-'.$color.'">'.$title.'';

			echo $after_title;

		?>


		<div id="loading-<?php echo $this->get_field_id('id'); ?>">
		    <div class="spinner">
		        <div class="rect1"></div> <div class="rect2"></div> <div class="rect3"></div> <div class="rect4"></div> <div class="rect5"></div>
		    </div>
		</div>

		<div class="carousel_widget_wrapper" id="carousel_widget_wrapper-<?php echo $this->get_field_id('id'); ?>">

			<div id="carousel-<?php echo $this->get_field_id('id'); ?>">

			<?php $sq = new WP_Query( array( $type => $postsq, 'showposts' => $show_count, 'orderby' => 'date', 'order' => 'DESC' ) ); ?>

	 		<?php

		   	if ( $sq->have_posts() ) : while( $sq->have_posts() ) : $sq->the_post(); global $post;


				echo '<div class="post-item">';

				?>

				<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">


					<div class="background-overlay"></div>


					<?php get_the_image( array( 'size' => 'carousel', 'width' => 350, 'height' => 230, 'before' => '<div class="post-thumb">', 'after' => '</div>', 'link_to_post' => false ) );

					?>

					<div class="post-item-content">

						<h3 class="entry-title"><?php the_title(); ?></h3>

						<div class="entry-meta">
							<?php

								if ( $show_category ) { ?><span class="cat-links"><?php foreach((get_the_category()) as $category) { echo $category->cat_name . ' '; } ?></span><?php }
								if ( $show_date ) { ?><span><?php echo get_the_date(); ?></span><?php }
							?>

						</div>

						</div>

					</a>


				<?php
				echo '</div>';
	 			endwhile;
				endif;

				//Reset query_posts
				wp_reset_query();

			?></div>
  			<div class="clear"></div>

  		</div>

		<script type="text/javascript">
			jQuery(function($) {

				var $c = $('#carousel-<?php echo $this->get_field_id('id'); ?>');

				$c.imagesLoaded( function(){

					$('#carousel_widget_wrapper-<?php echo $this->get_field_id('id'); ?>').show();
				 	$('#loading-<?php echo $this->get_field_id('id'); ?>').hide();

	 				$c.flickity({
	 					autoPlay: <?php echo $auto_scroll === true ? 'true' : 'false'; ?>,
	 					cellAlign: 'left',
	 					contain: true,
	 					percentPosition: false,
	  					pageDots: false,
	 					wrapAround: true,
	 					imagesLoaded: true,
	 					accessibility: false
					});

				});

			});
		</script><?php

		/* After widget (defined by themes). */
		echo $after_widget;
	}


	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['color'] = $new_instance['color'];
		$instance['show_count'] = $new_instance['show_count'];
		$instance['auto_scroll'] = $new_instance['auto_scroll'] == 'on';
 		$instance['show_date'] = $new_instance['show_date'];
		$instance['show_category'] = $new_instance['show_category'];
 		$instance['type'] = $new_instance['type'];
 		$instance['category'] = $new_instance['category'];
		$instance['slugs'] = $new_instance['slugs'];
		$instance['posts'] = $new_instance['posts'];

		return $instance;
	}

	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => '', 'color' => '', 'show_count' => 10, 'show_date' => 'on', 'auto_scroll' => true, 'show_category' => 'on', 'type' => 'cat', 'category' => '', 'slugs' => '' );
		$instance = wp_parse_args( (array) $instance, $defaults );

		global $wpzoomColors;

		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title', 'wpzoom'); ?>:</label><br />
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" type="text" class="widefat" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('color'); ?>"><?php _e('Widget Title Color:', 'wpzoom'); ?></label>
			<select id="<?php echo $this->get_field_id('color'); ?>" name="<?php echo $this->get_field_name('color'); ?>" style="width:90%;">
			<?php
				foreach ($wpzoomColors as $key => $value) {
				$option = '<option value="'.$key;
				if ($key == $instance['color']) { $option .='" selected="selected';}
				$option .= '">';
				$option .= $value;
				$option .= '</option>';
				echo $option;
				}
			?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'show_count' ); ?>"><?php _e('Show', 'wpzoom'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'show_count' ); ?>" name="<?php echo $this->get_field_name( 'show_count' ); ?>" value="<?php echo $instance['show_count']; ?>" type="text" size="2" /> <?php _e('posts', 'wpzoom'); ?>
		</p>

		<p>
			<label>
				<input class="checkbox" type="checkbox" <?php checked( $instance['auto_scroll'] ); ?> id="<?php echo $this->get_field_id( 'auto_scroll' ); ?>" name="<?php echo $this->get_field_name( 'auto_scroll' ); ?>" />
				<?php _e( 'Auto-Scroll', 'wpzoom' ); ?>
			</label>
			<span class="howto"><?php _e( 'Automatically scroll through the posts', 'wpzoom' ); ?></span>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_category'], 'on' ); ?> id="<?php echo $this->get_field_id( 'show_category' ); ?>" name="<?php echo $this->get_field_name( 'show_category' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_category' ); ?>"><?php _e('Show Category', 'wpzoom'); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_date'], 'on' ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e('Show Date', 'wpzoom'); ?></label>
		</p>

 		<p>
			<label for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Posts to Display:', 'wpzoom'); ?></label>
			<select id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>" style="width:90%;">
			<option value="cat"<?php if ($instance['type'] == 'cat') { echo ' selected="selected"';} ?>><?php _e('Categories', 'wpzoom'); ?></option>
			<option value="tag"<?php if ($instance['type'] == 'tag') { echo ' selected="selected"';} ?>><?php _e('Tag(s)', 'wpzoom'); ?></option>
			</select>
		</p>


		<p>
			<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category (if selected above):', 'wpzoom'); ?></label>
			<?php
			$activeoptions = $instance['category'];
			if (!$activeoptions)
			{
				$activeoptions = array();
			}
			?>

			<select multiple="true" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>[]" style="width:90%; height: 100px;">

			<?php
				$cats = get_categories('hide_empty=0');

				foreach ($cats as $cat) {
				$option = '<option value="'.$cat->term_id;
				if ( in_array($cat->term_id,$activeoptions)) { $option .='" selected="selected'; }
				$option .= '">';
				$option .= $cat->cat_name;
				$option .= ' ('.$cat->category_count.')';
				$option .= '</option>';
				echo $option;
				}
			?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'slugs' ); ?>"><?php _e('Tag slugs (if selected above, separated by comma ","):', 'wpzoom'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'slugs' ); ?>" name="<?php echo $this->get_field_name( 'slugs' ); ?>" value="<?php echo $instance['slugs']; ?>" />
		</p>

		<?php
	}
}

function wpzoom_register_cs_widget() {
	register_widget('Wpzoom_Carousel_Slider');
}
add_action('widgets_init', 'wpzoom_register_cs_widget');