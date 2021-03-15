<?php
global $wpestate_property_unit_slider;
global $wpestate_no_listins_per_row;
global $wpestate_uset_unit;
global $wpestate_custom_unit_structure;
global $align_class;
global $prop_unit_class;
global $wpestate_prop_unit;
$wpestate_property_unit_slider       =   wpresidence_get_option('wp_estate_prop_list_slider','');
$wpestate_prop_unit                  =   esc_html ( wpresidence_get_option('wp_estate_prop_unit','') );
$prop_unit_class            =   '';
if($wpestate_prop_unit=='list'){
    $prop_unit_class="ajax12";
    $align_class=   'the_list_view';
}

$user_agency    =   get_post_meta($post->ID,'user_meda_id',true);
$agent_list     =   (array)get_user_meta($user_agency,'current_agent_list',true);
$agent_list[]   =   $user_agency;
$prop_no        =   intval( wpresidence_get_option('wp_estate_prop_no', '') );
$paged = (get_query_var('page')) ? get_query_var('page') : 1;

if(isset($_GET['pagelist'])){
    $paged = intval( $_GET['pagelist'] );
}else{
    $paged = 1;
}

$wpestate_custom_unit_structure      =   wpresidence_get_option('wpestate_property_unit_structure');
$wpestate_uset_unit         =   intval ( wpresidence_get_option('wpestate_uset_unit','') );
$wpestate_no_listins_per_row         =   intval( wpresidence_get_option('wp_estate_listings_per_row', '') );
$property_card_type         =   intval(wpresidence_get_option('wp_estate_unit_card_type'));
$property_card_type_string  =   '';
if($property_card_type==0){
    $property_card_type_string='';
}else{
    $property_card_type_string='_type'.intval($property_card_type);
}


$terms=array();
$selected_term='';



if( count($agent_list) == 0 || $user_agency==0 ){

$args = array(
        'post_type'         =>  'estate_property',
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

}else{
  $args = array(
        'post_type'         =>  'estate_property',
        'author__in'        =>  $agent_list,
        //'paged'             =>  $paged,
        'posts_per_page'    =>  $prop_no,
        'post_status'       => 'publish',
        'meta_key'          => 'prop_featured',
        'orderby'           => 'meta_value',
        'order'             => 'DESC',
        );

}




$prop_selection = wpestate_return_filtered_by_order($args);
$tab_terms      = array();
$terms          = get_terms( 'property_action_category', array(
                    'hide_empty' => false,
                ) );

 

foreach( $terms as $single_term ){


  if( count($agent_list) == 0 ){
    $args = array(
        'post_type'         =>  'estate_property',
            
        'posts_per_page'    =>  -1,
        'post_status'       => 'publish',
        'meta_key'          => 'prop_featured',
        'orderby'           => 'meta_value',
        'order'             => 'DESC',
    		'tax_query' => array(
    			array(
    				'taxonomy' => 'property_action_category',
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
    $args = array(
        'post_type'         =>  'estate_property',
        'author__in'        =>  $agent_list,      
        'posts_per_page'    =>  -1,
        'post_status'       => 'publish',
        'meta_key'          => 'prop_featured',
        'orderby'           => 'meta_value',
        'order'             => 'DESC',
    		'tax_query' => array(
    			array(
    				'taxonomy' => 'property_action_category',
    				'field'    => 'term_id',
    				'terms'    => $single_term->term_id,
    			),
    		),
    		'fields' => 'ids'
           );
  }

	
  
  
	   $all_posts = get_posts( $args );
	   
	   if( count( $all_posts ) > 0 )
	   $tab_terms[ $single_term->term_id ] = array( 'name' => $single_term->name, 'slug' => $single_term->slug, 'count' => count( $all_posts ) );
}



$term_bar='<div class="term_bar_item active_term" data-term_id="0" data-term_name="all">'.esc_html__('All','wpresidence').' ('.esc_html($prop_selection->found_posts).')</div>';

	foreach($tab_terms as $key=>$value){
        $term_bar .= '<div class="term_bar_item"   data-term_id="'.esc_attr($key).'" data-term_name="'.esc_attr($value['slug']).'" >'. esc_html($value['name']).' ('. esc_html($value['count']).')</div>';
    } 
 

        $ajax_nonce = wp_create_nonce( "wpestate_developer_listing_nonce" );
        print'<input type="hidden" id="wpestate_developer_listing_nonce" value="'.esc_html($ajax_nonce).'" />    ';
	
	
        if($prop_selection->have_posts()):
            echo '<div class="mylistings developer_listing agency_listings_title single_listing_block">';
            echo '<div class="term_bar_wrapper" data-agency_id="'.esc_attr($user_agency).'" data-post_id="'.intval($post->ID).'" >'.($term_bar).'</div>'; //escaper abover
            echo '<div class="agency_listings_wrapper">';
            
            while ($prop_selection->have_posts()): $prop_selection->the_post();   
                $property_category     =   get_the_terms($post->ID, 'property_category') ;
                include( locate_template('templates/property_unit'.esc_html($property_card_type_string).'.php') );

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