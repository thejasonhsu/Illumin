<?php
/**
 * Functions - general template functions that are used throughout EvoLve
 *
 * @package evolve
 * @subpackage Functions
 */
 
add_action('admin_head', 'evolve_admin_message');
add_action('wp_ajax_evolve_dynamic_css', 'evolve_dynamic_css');
add_action('wp_ajax_nopriv_evolve_dynamic_css', 'evolve_dynamic_css');

function evolve_admin_message() { 
	
	//Tweaked the message on theme activate
	?>
    <script type="text/javascript">
    jQuery(function(){
    	
        var message = '<p>This theme comes with an <a href="<?php echo admin_url('themes.php?page=theme_options'); ?>">options panel</a> to configure settings. This theme also supports widgets, please visit the <a href="<?php echo admin_url('widgets.php'); ?>">widgets settings page</a> to configure them.</p>';
    	jQuery('.themes-php #message2').html(message);
    
    });
    </script>
    <?php
	
}

function evolve_dynamic_css() {
	global $wp_customize;  
	
	if ( method_exists($wp_customize,'is_preview') and ! is_admin() ) {} else {
		header('Content-type: text/css');  
	}
	
	require (get_template_directory().'/custom-css.php');
	exit;
}

function evolve_media() {
	$template_url = get_template_directory_uri();
	$options = get_option('evolve');
	$evolve_css_data = '';
  
	$evolve_pagination_type = evolve_get_option('evl_pagination_type', 'pagination');
	$evolve_pos_button = evolve_get_option('evl_pos_button','right');                                                                       
	$evolve_carousel_slider = evolve_get_option('evl_carousel_slider', '1');
	$evolve_parallax_slider = evolve_get_option('evl_parallax_slider_support', '1');
	$evolve_status_gmap = evolve_get_option('evl_status_gmap','1');
	$evolve_recaptcha_public = evolve_get_option('evl_recaptcha_public','');
	$evolve_recaptcha_private = evolve_get_option('evl_recaptcha_private','');
  
	if( is_admin() ) return;
	
	wp_enqueue_script( 'jquery' );
	wp_deregister_script( 'hoverIntent' );   

	if ($evolve_parallax_slider == "1") {   
		wp_enqueue_script( 'parallax', EVOLVEJS . '/parallax/parallax.js' );
		wp_enqueue_style( 'parallaxcss', EVOLVEJS . '/parallax/parallax.css' );
		wp_enqueue_script( 'modernizr', EVOLVEJS . '/parallax/modernizr.js' ); 
	}
   
	if ($evolve_carousel_slider == "1") { wp_enqueue_script( 'carousel', EVOLVEJS . '/carousel.js' ); }
	wp_enqueue_script( 'tipsy', EVOLVEJS . '/tipsy.js' );
	wp_enqueue_script( 'fields', EVOLVEJS . '/fields.js' );
	wp_enqueue_script( 'tabs', EVOLVEJS . '/tabs.js', array(), '', true );

	if ($evolve_pagination_type == "infinite") {
		wp_enqueue_script( 'jscroll', EVOLVEJS . '/jquery.infinite-scroll.min.js' );
	}

	if ($evolve_pos_button == "disable" || $evolve_pos_button == "") {} else { wp_enqueue_script( 'jquery_scroll', EVOLVEJS . '/jquery.scroll.pack.js' ); }      
	wp_enqueue_script( 'supersubs', EVOLVEJS . '/supersubs.js' );
	wp_enqueue_script( 'superfish', EVOLVEJS . '/superfish.js' );
	wp_enqueue_script( 'hoverIntent', EVOLVEJS . '/hoverIntent.js' );
	wp_enqueue_script( 'buttons', EVOLVEJS . '/buttons.js' );
	wp_enqueue_script( 'ddslick', EVOLVEJS . '/ddslick.js' );
	wp_enqueue_script( 'main', EVOLVEJS . '/main.js', array(), '', true );
  
	if ($evolve_status_gmap == "1") {
		wp_enqueue_script( 'googlemaps', '//maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false&amp;language='.mb_substr(get_locale(), 0, 2) );        
		wp_enqueue_script( 'gmap', EVOLVEJS . '/gmap.js', array(), '', true);
	}
	
	if ($evolve_recaptcha_public && $evolve_recaptcha_private) {
		wp_enqueue_script( 'googlerecaptcha', 'https://www.google.com/recaptcha/api.js' );        
	}	
	
	$blog_title = evolve_get_option('evl_title_font');
	$blog_tagline = evolve_get_option('evl_tagline_font');
	$post_title = evolve_get_option('evl_post_font');
	$content_font = evolve_get_option('evl_content_font');	
    $heading_font = evolve_get_option('evl_heading_font');		
    $bootstrap_font = evolve_get_option('evl_bootstrap_slide_title_font');
    $bootstrap_desc = evolve_get_option('evl_bootstrap_slide_desc_font');    	
    $parallax_font = evolve_get_option('evl_parallax_slide_title_font');
    $parallax_desc = evolve_get_option('evl_parallax_slide_desc_font');
    $carousel_font = evolve_get_option('evl_carousel_slide_title_font');
    $carousel_desc = evolve_get_option('evl_carousel_slide_desc_font');    
    $menu_font = evolve_get_option('evl_menu_font');

	$selected_fonts[0] = $blog_title['face'];
	$selected_fonts[1] = $blog_tagline['face'];
	$selected_fonts[2] = $post_title['face'];
	$selected_fonts[3] = $content_font['face'];
    $selected_fonts[4] = $heading_font['face'];
    $selected_fonts[5] = $parallax_font['face'];
    $selected_fonts[6] = $parallax_desc['face'];
    $selected_fonts[7] = $carousel_font['face'];
    $selected_fonts[8] = $carousel_desc['face'];    
    $selected_fonts[9] = $menu_font['face'];
    $selected_fonts[10] = $bootstrap_font['face'];
    $selected_fonts[11] = $bootstrap_desc['face'];    
		
		
	$font_face_all = '';
	$j = 0;
	$font_storage[] = '';
	for ( $i=0; $i<12; $i++ ) {		
		if (in_array($selected_fonts[$i], $font_storage )) {}
		else {
			$font_storage[] = $selected_fonts[$i];
			$font_face = explode(',',$selected_fonts[$i]);	
			$font_face = str_replace(" ", "+", $font_face[0]);
			if($font_face != 'Arial' && $font_face != 'Calibri' && $font_face != 'Georgia' && $font_face != 'Impact' && $font_face != 'Lucida+Sans+Unicode' && $font_face != 'Myriad+Pro*' && $font_face != 'Palatino+Linotype' && $font_face != 'Tahoma' && $font_face != 'Times+New+Roman' && $font_face != 'Trebuchet+MS' && $font_face != 'Verdana'){
				if($j>0){$ext = '|';} else {$ext = '';}
				$j++;
				$font_face = $ext.$font_face.':r,b,i';
				$font_face_all = $font_face_all.$font_face;	
			}
		}
	}
	
	if($font_face_all){
		wp_enqueue_style('googlefont', "//fonts.googleapis.com/css?family=".$font_face_all);    
	}

	wp_enqueue_style( 'cloudtypography', "//cloud.typography.com/6510154/726346/css/fonts.css", false);   
  
	// FontAwesome 
	wp_enqueue_style( 'fontawesomecss', EVOLVEJS . '/fontawesome/css/font-awesome.css' );    
  
	// Main Stylesheet
	function evolve_styles() {
		global $wp_customize;
  
		wp_enqueue_style('maincss', get_stylesheet_uri(), false);

		if ( method_exists($wp_customize,'is_preview') and ! is_admin() ){
			// Custom CSS for Customizer
			require_once( get_template_directory() . '/custom-css.php' ); 
			wp_add_inline_style( 'maincss', $evolve_css_data ); 
		} else {
			// Custom CSS for Live website
			wp_enqueue_style( 'dynamic-css', admin_url('admin-ajax.php').'?action=evolve_dynamic_css');
		}
	}
	add_action( 'wp_enqueue_scripts', 'evolve_styles' );  

	// Bootstrap Elements
	wp_enqueue_script( 'bootstrap', EVOLVEJS . '/bootstrap/js/bootstrap.js' ); 
	wp_enqueue_style( 'bootstrapcss', EVOLVEJS . '/bootstrap/css/bootstrap.css', array('maincss') );
	wp_enqueue_style( 'bootstrapcsstheme', EVOLVEJS . '/bootstrap/css/bootstrap-theme.css', array('bootstrapcss') ); 

}

/**
 * evolve_menu - adds css class to the <ul> tag in wp_page_menu.
 *
 * @since 0.3
 * @filter evolve_menu_ulclass
 * @needsdoc
 */
function evolve_menu_ulclass( $ulclass ) {
	$classes = apply_filters( 'evolve_menu_ulclass', (string) 'nav-menu' ); // Available filter: evolve_menu_ulclass
	return preg_replace( '/<ul>/', '<ul class="'. $classes .'">', $ulclass, 1 );
}

/**
 * evolve_nice_terms clever terms
 *
 * @since 0.2.3
 * @needsdoc
 */
function evolve_nice_terms( $term = '', $normal_separator = ', ', $penultimate_separator = ' and ', $end = '' ) {
	if ( !$term ) return;
	switch ( $term ):
		case 'cats':
			$terms = evolve_get_terms( 'cats', $normal_separator );
			break;
		case 'tags':
			$terms = evolve_get_terms( 'tags', $normal_separator );
			
			break;
	endswitch;
	if ( empty($term) ) return;
	$things = explode( $normal_separator, $terms );
	
	$thelist = '';
	$i = 1;
	$n = count( $things );
		
	foreach ( $things as $thing ) {
		
		$data = trim( $thing, ' ' );
		
		$links = preg_match( '/>(.*?)</', $thing, $link );
		$hrefs = preg_match( '/href="(.*?)"/', $thing, $href );
		$titles = preg_match( '/title="(.*?)"/', $thing, $title );
		$rels = preg_match( '/rel="(.*?)"/', $thing, $rel );
		
		if (1 < $i and $i != $n) {
			$thelist .= $normal_separator;
		}

		if (1 < $i and $i == $n) {
			$thelist .= $penultimate_separator;
		}
		$thelist .= '<a rel="'. $rel[1] .'" href="'. $href[1] .'"';
		if ( !$term = 'tags' )
			$thelist .= ' title="'. $title[1] .'"';
		$thelist .= '>'. $link[1] .'</a>';
		$i++;
	}
	$thelist .= $end;
	return apply_filters( 'evolve_nice_terms', (string) $thelist );
}

/**
 * evolve_get_terms() Returns other terms except the current one (redundant)
 *
 * @since 0.2.3
 * @usedby evolve_entry_footer()
 */
function evolve_get_terms( $term = NULL, $glue = ', ' ) {
	if ( !$term ) return;
	
	$separator = "\n";
	switch ( $term ):
		case 'cats':
			$current = single_cat_title( '', false );
			$terms = get_the_category_list( $separator );
			break;
		case 'tags':
			$current = single_tag_title( '', '',  false );
			$terms = get_the_tag_list( '', "$separator", '' );
			break;
	endswitch;
	if ( empty($terms) ) return;
	
	$thing = explode( $separator, $terms );
	foreach ( $thing as $i => $str ) {
		if ( strstr( $str, ">$current<" ) ) {
			unset( $thing[$i] );
			break;
		}
	}
	if ( empty( $thing ) )
		return false;

	return trim( join( $glue, $thing ) );
}

/**
 * evolve_get Gets template files
 *
 * @since 0.2.3
 * @needsdoc
 * @action evolve_get
 * @todo test this on child themes
 */
function evolve_get( $file = NULL ) {
	do_action( 'evolve_get' ); // Available action: evolve_get
	$error = "Sorry, but <code>{$file}</code> does <em>not</em> seem to exist. Please make sure this file exist in <strong>" . get_stylesheet_directory() . "</strong>\n";
	$error = apply_filters( 'evolve_get_error', (string) $error ); // Available filter: evolve_get_error
	if ( isset( $file ) && file_exists( get_stylesheet_directory() . "/{$file}.php" ) )
		locate_template( get_stylesheet_directory() . "/{$file}.php" );
	else
        echo $error;
}

/**
 * evolve_include_all() A function to include all files from a directory path
 *
 * @since 0.2.3
 * @credits k2
 */
function evolve_include_all( $path, $ignore = false ) {

	/* Open the directory */
	$dir = @dir( $path ) or die( 'Could not open required directory ' . $path );
	
	/* Get all the files from the directory */
	while ( ( $file = $dir->read() ) !== false ) {
		/* Check the file is a file, and is a PHP file */
		if ( is_file( $path . $file ) and ( !$ignore or !in_array( $file, $ignore ) ) and preg_match( '/\.php$/i', $file ) ) {
			require_once( $path . $file );
		}
	}		
	$dir->close(); // Close the directory, we're done.
}


/**
 * Gets the profile URI for the document being displayed.
 * @link http://microformats.org/wiki/profile-uris Profile URIs
 *
 * @since 0.2.4
 * @param integer $echo 0|1
 * @return string profile uris seperatd by spaces
 **/
function evolve_get_profile_uri( $echo = 1 ) {
	// hAtom profile
	$profile[] = 'http://purl.org/uF/hAtom/0.1/';
	
	// hCard, hCalendar, rel-tag, rel-license, rel-nofollow, VoteLinks, XFN, XOXO profile
	$profile[] = 'http://purl.org/uF/2008/03/';
	
	$profile = join( ' ', apply_filters( 'profile_uri',  $profile ) ); // Available filter: profile_uri
	
	if ( $echo ) echo $profile;
	else return $profile;
}
add_action( 'customize_controls_enqueue_scripts', 'my_add_scripts' );      
 
function my_add_scripts() {
    wp_enqueue_media();
    wp_enqueue_script('evolve-media-manager',EVOLVE_DIRECTORY.'js/evolve-media-manager.js', array( ), '1.0', true);
}

add_action( 'customize_controls_print_styles', 'my_customize_styles', 50);
function my_customize_styles() { ?>
    <style>
    .wp-full-overlay {
        z-index: 150000 !important;
    }
    </style>
<?php }

/**
 * reCaptcha Class
 *
 * @recaptcha 2
 * @since 3.2.5
 */
class evolve_GoogleRecaptcha 
{

    /* Google recaptcha API url */    
 
    public function VerifyCaptcha($response)
    {		

	$response = isset( $_POST['g-recaptcha-response'] ) ? esc_attr( $_POST['g-recaptcha-response'] ) : '';
    $remote_ip = $_SERVER["REMOTE_ADDR"];
	$secret = evolve_get_option('evl_recaptcha_private','');
	$request = wp_remote_get( 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $response . '&remoteip=' . $remote_ip );	
		
        $response_body = wp_remote_retrieve_body($request);  
        $res = json_decode($response_body, TRUE);
        if($res['success'] == 'true') 
            return TRUE;
        else
            return FALSE;
    } 
} 