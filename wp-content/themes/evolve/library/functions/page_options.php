<div class='pyre_metabox'>
<h2 style="margin-top:0;"><?php _e( 'Post options', 'evolve' ); ?></h2>
<?php
$this->evolve_select(	
	'full_width',
	__( 'Full Width', 'evolve' ),
	array( 'no' => __( 'No', 'evolve' ), 'yes' => __( 'Yes', 'evolve' ) ),
	''
);
?>  
<h2 style="margin-top:0;"><?php _e( 'Slider Options', 'evolve' ); ?>:</h2>
<?php   
$this->evolve_select(	'slider_type',
	__( 'Slider Type', 'evolve' ),
	array( 
		'no' 		=> __( 'No Slider', 'evolve' ), 
		'parallax' 	=> __( 'Parallax Slider', 'evolve' ),
		'posts'		=> __( 'Posts Slider', 'evolve' ),
		'bootstrap' => __( 'Bootstrap Slider', 'evolve' )
	),
	''
);
?>
<h2 style="margin-top:0;"><?php _e( 'Widget Options', 'evolve' ); ?></h2>
<?php   
$this->evolve_select(	
	'widget_page',
	__( 'Enable Header Widgets', 'evolve' ),
	array( 'no' => __( 'No', 'evolve' ), 'yes' => __( 'Yes', 'evolve' ) ),
	''
);
?>
</div>
