<?php
if(function_exists('wpestate_update_hiddent_address')):
function wpestate_update_hiddent_address(){
    wp_suspend_cache_addition(true);    
    $args = array(
             'post_type'                 =>    'estate_property',
             'post_status'               =>    'publish',
             'posts_per_page'            =>    -1,
             'cache_results'             =>    false,
             'update_post_meta_cache'    =>    false,
             'update_post_term_cache'    =>    false,
            );	

    $prop_selection =   new WP_Query( $args);
    $hidden_address='';

    // address,zip city, state,city, area

    while ( $prop_selection->have_posts() ): 
        $prop_selection->the_post();

        $edit_id            =   get_the_ID();
        $hidden_address     =   '';


        $property_address               =   esc_html( get_post_meta($edit_id, 'property_address', true) );
        $hidden_address.= $property_address.', ';

        $property_zip                   =   esc_html( get_post_meta($edit_id, 'property_zip', true) );
        $hidden_address.= $property_zip.', ';


        $property_area_array            =   get_the_terms($edit_id, 'property_area');
        if(isset($property_area_array [0])){
            $property_area                  =   $property_area_array [0]->name;
        }
        $hidden_address .=$property_area.', ';  

        $property_city_array            =   get_the_terms($edit_id, 'property_city');
        if(isset($property_city_array [0])){
            $property_city                  =   $property_city_array [0]->name;
        }
        $hidden_address .=$property_city.', ';



        $property_county_state_array            =   get_the_terms($edit_id, 'property_county_state');
        if(isset($property_county_state_array [0])){
            $property_county_state                 =   $property_county_state_array [0]->name;
        }
        $hidden_address .=$property_county_state.', ';

        echo ' </br>'.$edit_id.' '.$hidden_address;

        update_post_meta($edit_id, 'hidden_address', $hidden_address);


    endwhile;

    wp_reset_query();
    wp_reset_postdata();
    wp_suspend_cache_addition(false);



}
endif;



if(!function_exists('wpestate_update_hiddent_address_single')):
function wpestate_update_hiddent_address_single($edit_id){
        $edit_id= intval($edit_id);
        $hidden_address     =   '';

        $property_area='';
        $property_city='';
        $property_county_state ='';
        
        $property_address               =   esc_html( get_post_meta($edit_id, 'property_address', true) );
        $hidden_address.= $property_address.', ';

        $property_zip                   =   esc_html( get_post_meta($edit_id, 'property_zip', true) );
        $hidden_address.= $property_zip.', ';


        $property_area_array            =   get_the_terms($edit_id, 'property_area');
        if(is_array($property_area_array)){
            foreach ($property_area_array as $item) {
              $hidden_address .=$item->name.', ';
            }
        }
      
        
        $property_city_array            =   get_the_terms($edit_id, 'property_city');    
        if(is_array($property_city_array)){
            foreach ($property_city_array as $item) {
              $hidden_address .=$item->name.', ';
            }
        }



        $property_county_state_array            =   get_the_terms($edit_id, 'property_county_state');      
        if(is_array($property_county_state_array)){
            foreach ($property_county_state_array as $item) {
              $hidden_address .=$item->name.', ';
            }
        }
     

        update_post_meta($edit_id, 'hidden_address', $hidden_address);




}
endif;