<!-- GET AGENT LISTINGS-->
<?php
global $wpestate_property_unit_slider;
global $wpestate_no_listins_per_row;
global $wpestate_uset_unit;
global $wpestate_custom_unit_structure;
global $align_class;
global $prop_unit_class;
global $wpestate_prop_unit;
global $post;
$wpestate_prop_unit         =   esc_html ( wpresidence_get_option('wp_estate_prop_unit','') );
$prop_no                    =   intval( wpresidence_get_option('wp_estate_prop_no', '') );
$prop_unit_class            =   '';
if($wpestate_prop_unit=='list'){
    $prop_unit_class="ajax12";
    $align_class=   'the_list_view';
}

$agent_id    =   get_post_meta($post->ID,'user_meda_id',true);

if( !$agent_id ){
    $agent_id = -1;
}
 

$wpestate_property_unit_slider       =   wpresidence_get_option('wp_estate_prop_list_slider','');
if(isset($_GET['pagelist'])){
    $paged = intval( $_GET['pagelist'] );
}else{
    $paged = 1;
}


$wpestate_custom_unit_structure     =   wpresidence_get_option('wpestate_property_unit_structure');
$wpestate_uset_unit                 =   intval ( wpresidence_get_option('wpestate_uset_unit','') );
$wpestate_no_listins_per_row        =   intval( wpresidence_get_option('wp_estate_listings_per_row', '') );
$property_card_type                 =   intval(wpresidence_get_option('wp_estate_unit_card_type'));
if($property_card_type==0){
    $property_card_type_string='';
}else{
    $property_card_type_string='_type'.intval($property_card_type);
}


$terms          =   array();
$selected_term  =   '';
 

if( $agent_id === -1 ){
	// try to query by agent post type id
	$args = array(
        'post_type'         =>  'estate_property',		
        'paged'             =>  $paged,
        'posts_per_page'    =>  $prop_no,
        'post_status'       => 'publish',
        'meta_key'          => 'prop_featured',
        'orderby'           => 'meta_value',
        'order'             => 'DESC',
		'meta_query' => array(
			array(
				'key'     => 'property_agent',
				'value'   => $post->ID,
			),
		),
        );
        $mapargs = array(
            'post_type'         => 'estate_property',
            'post_status'       => 'publish',
            'posts_per_page'    => -1,
            'meta_query'        => array(
                                        array(
                                            'key'   => 'property_agent',
                                            'value' => $post->ID,
                                        )
                                )
                    );
        
}else{
	$args = array(
            'post_type'         =>  'estate_property',
            'author'            =>  $agent_id,
            'paged'             =>  $paged,
            'posts_per_page'    =>  $prop_no,
            'post_status'       => 'publish',
            'meta_key'          => 'prop_featured',
            'orderby'           => 'meta_value',
            'order'             => 'DESC',
        );
        $mapargs = array(
            'post_type'         =>  'estate_property',
            'author'            =>  $agent_id,
            'paged'             =>  $paged,
            'posts_per_page'    =>  '-1',
            'post_status'       => 'publish',
        );
        
}
 
$prop_selection = wpestate_return_filtered_by_order($args);
$tab_terms      = array();

$terms = get_terms( 'property_category', array(
    'hide_empty' => false,
) );

$transient_agent_id='';
foreach( $terms as $single_term ){
	
	// if agent field is not set - check select 
	if( $agent_id === -1 ){
            $transient_agent_id='meta_property_agent_'.$post->ID;
            $args = array(
                'post_type'         =>  'estate_property',      
                'posts_per_page'    =>  -1,
                'post_status'       => 'publish',
                'meta_key'          => 'prop_featured',
                'orderby'           => 'meta_value',
                'order'             => 'DESC',
                        'tax_query' => array(
                                array(
                                        'taxonomy' => 'property_category',
                                        'field'    => 'term_id',
                                        'terms'    => $single_term->term_id,
                                ),
                        ),
                        'fields' => 'ids',
                        'meta_query' => array(
                                array(
                                        'key'     => 'property_agent',
                                        'value'   => $post->ID,
                                ),
                        ),
               );
	}else{
              $transient_agent_id='custom_post_'.$agent_id;
		$args = array(
                    'post_type'         =>  'estate_property',
                    'author'        =>  $agent_id,        
                    'posts_per_page'    =>  -1,
                    'post_status'       => 'publish',
                    'meta_key'          => 'prop_featured',
                    'orderby'           => 'meta_value',
                    'order'             => 'DESC',
                            'tax_query' => array(
                                    array(
                                            'taxonomy' => 'property_category',
                                            'field'    => 'term_id',
                                            'terms'    => $single_term->term_id,
                                    ),
                            ),
                            'fields' => 'ids'
                   );
	}
	
	
        $all_posts = get_posts( $args );

        if( count( $all_posts ) > 0 )
        $tab_terms[ $single_term->term_id ] = array( 
                                            'name' => $single_term->name, 
                                            'slug' => $single_term->slug, 
                                            'count' => count( $all_posts ) 
                                            );
}


$term_bar='<div class="term_bar_item active_term" data-term_id="0" data-term_name="all">'.esc_html__('All','wpresidence').' ('.esc_html($prop_selection->found_posts).')</div>';
    if( count($tab_terms) > 0 ){
            foreach($tab_terms as $key=>$value){
                    $term_bar .= '<div class="term_bar_item "   data-term_id="'.esc_attr($key).'" data-term_name="'.esc_attr($value['slug']).'" >'. esc_html($value['name']).' ('. esc_html($value['count']).')</div>';
            }
    }

    if($prop_selection->have_posts()):
        echo '<div class="mylistings agent_listing agency_listings_title single_listing_block">';
            
            echo'<h3 class="agent_listings_title">'.esc_html__('My Listings','wpresidence').'</h3>';
            $ajax_nonce = wp_create_nonce( "wpestate_agent_listings_nonce" );
            print'<input type="hidden" id="wpestate_agent_listings_nonce" value="'.esc_html($ajax_nonce).'" />';
            
//            if($agent_id==-1){
//               $agent_id_no= $post->ID;
//            }else{
//                $agent_id_no=$agent_id;
//            }
            
            echo '<div class="term_bar_wrapper" data-agent_id="'.intval($agent_id).'" data-post_id="'.intval($post->ID).'" >'.($term_bar).'</div>'; //term bar expaed above
            
            echo '
                 <div class="agency_listings_wrapper">';
            while ($prop_selection->have_posts()): $prop_selection->the_post();   
                $property_category     =   get_the_terms($post->ID, 'property_category') ;

                include( locate_template('templates/property_unit'.esc_html($property_card_type_string).'.php' ) );

            endwhile; 
  
        echo '</div>';
		echo '<div class="spinner" id="listing_loader">
                    <div class="new_prelader"></div>
                </div>';
		echo '
			<div class="load_more_ajax_cont">
				<input type="button" class="wpresidence_button listing_load_more" value="'.esc_html__('Load More Properties','wpresidence').'">
				<!--
				<img  class="load_more_progress_bar" src="'.get_theme_file_uri('/img/ajax-loader-gmap.gif').'" /> -->
			</div>
		</div>';
    endif;



wp_reset_postdata();
wp_reset_query();



if (wp_script_is( 'googlecode_regular', 'enqueued' )) {
    
  
    $max_pins                   =   intval( wpresidence_get_option('wp_estate_map_max_pins') );
    $mapargs['posts_per_page']  =   $max_pins;
    $mapargs['offset']          =   ($paged-1)*9;
    $mapargs['fields']          =   'ids';
    
    $transient_appendix='_agent_listings_'.$transient_agent_id;
    $selected_pins  =   wpestate_listing_pins($transient_appendix,1,$mapargs,1);//call the new pins 
  
    wp_localize_script('googlecode_regular', 'googlecode_regular_vars2', 
                array('markers2'          =>  $selected_pins,
                      'agent_id'             =>  $agent_id ));

}


?>