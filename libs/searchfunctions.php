<?php


if(!function_exists('wpestate_show_advanced_search_tabs')):
function wpestate_show_advanced_search_tabs($adv_submit,$position=''){
        $return='';
        $adv_search_type            =   wpresidence_get_option('wp_estate_adv_search_type','');
        $adv6_taxonomy                  =   wpresidence_get_option('wp_estate_adv6_taxonomy');
        $adv6_taxonomy_terms            =   wpresidence_get_option('wp_estate_adv6_taxonomy_terms');     
        $adv_search_what                =   wpresidence_get_option('wp_estate_adv_search_what','');
        $custom_advanced_search         =   wpresidence_get_option('wp_estate_custom_advanced_search','');
        $adv_search_fields_no_per_row   =   floatval( wpresidence_get_option('wp_estate_search_fields_no_per_row') );
        $extended_search                =   wpresidence_get_option('wp_estate_show_adv_search_extended','');
        $args                       =   wpestate_get_select_arguments();
        $action_select_list         =   wpestate_get_action_select_list($args);
        $categ_select_list          =   wpestate_get_category_select_list($args);
        $select_city_list           =   wpestate_get_city_select_list($args); 
        $select_area_list           =   wpestate_get_area_select_list($args);
        $select_county_state_list   =   wpestate_get_county_state_select_list($args);

        global $post;
        if( isset($post->ID) ){
            $post_id =$post->ID;
         }

                
        $return.= '<div role="tabpanel" class="adv_search_tab '.wpestate_search_tab_align().'" id="tab_prpg_adv6">';
                    
            $tab_items      =   '';
            $tab_content    =   '';
            $active         =   'active';
            if(isset($_GET['adv6_search_tab']) && $_GET['adv6_search_tab']!=''){
                $active         =   '';
            }
                        
          
            $term_counter=0;
            $adv_search_fields_no               =   floatval( wpresidence_get_option('wp_estate_adv_search_fields_no') );

                if(is_array($adv6_taxonomy_terms)):
                    foreach ($adv6_taxonomy_terms as $term_id){
                        $term               =   get_term( $term_id, $adv6_taxonomy);
                        $use_name           =   sanitize_title($term->name);
                        $use_title_name     =   $term->name;
                        
                        

                        if(isset($_GET['adv6_search_tab']) && $_GET['adv6_search_tab']==$use_name){
                            $active         =   'active';
                        }
                        $tab_items.= '<div class="adv_search_tab_item '.esc_attr($active).' '.esc_attr($use_name).'" data-term="'.esc_attr($use_name).'" data-termid="'.esc_attr($term_id).'" data-tax="'.esc_attr($adv6_taxonomy).'">
                        <a href="#'.urldecode($use_name.$position).'" aria-controls="'.urldecode($use_name.$position).'" role="tab" class="adv6_tab_head" data-toggle="tab">'.urldecode (str_replace("-"," ",$use_title_name)).'</a>
                        </div>';

                        $tab_class='';
                        if(isset($_GET['adv6_search_tab'])){
                            $tab_class=esc_html($_GET['adv6_search_tab']);
                        }
                        

                        $tab_content.='<div role="tabpanel" class="tab-pane '.esc_attr($tab_class).' '.esc_attr($active).'" id="'.urldecode($use_name.$position).'">';
                            if( !wpestate_half_map_conditions ($post_id)){
                                $tab_content.='<form serch5 role="search" method="get" action="'.esc_url($adv_submit).'" >';
                            }
                                    if($adv6_taxonomy=='property_category'){
                                        $tab_content.='<input type="hidden" name="filter_search_type[]" value="'.esc_html($use_name).'" >';
                                    }else if($adv6_taxonomy=='property_action_category'){
                                        $tab_content.='<input type="hidden" name="filter_search_action[]" value="'.esc_html($use_name).'" >';
                                    }else if($adv6_taxonomy=='property_city'){
                                        $tab_content.='<input type="hidden" name="advanced_city" value="'.esc_html($use_name).'" >';
                                    }else if($adv6_taxonomy=='property_area'){
                                        $tab_content.='<input type="hidden" name="advanced_area" value="'.esc_html($use_name).'" >';
                                    }else if($adv6_taxonomy=='property_county_state'){
                                        $tab_content.='<input type="hidden" name="advanced_contystate" value="'.esc_html($use_name).'" >';
                                    }


                                    $tab_content.='<input type="hidden" name="adv6_search_tab" value="'.esc_html($use_name).'">
                                    <input type="hidden" name="term_id" class="term_id_class" value="'.esc_html($term_id).'">
                                    <input type="hidden" name="term_counter" class="term_counter" value="'.intval($term_counter).'">

                                    '.wpestate_show_adv6_form($active,$position,$adv_search_what,$adv_search_fields_no_per_row,$action_select_list,$categ_select_list,$select_city_list,$select_area_list,$select_county_state_list,$use_name,$term_id,$adv_search_fields_no,$term_counter);
                                    if($extended_search=='yes'){
                                        ob_start();
                                    if($position==''){$position='adv';}
                                        show_extended_search($position,$use_name);
                                        $tab_content.=ob_get_contents();
                                        ob_end_clean();
                                    }    
                            if( !wpestate_half_map_conditions ($post_id)){
                                $tab_content.='</form>';
                            }
                        $tab_content.='</div>  ';
                        $active='';
                        $term_counter++;
                    }
                    endif;


                $return.=  '<div class="nav nav-tabs" role="tablist">'.$tab_items.'</div>';   //escaped above 
                $return.=  '<div class="tab-content">'.$tab_content.'</div>';//escaped above                 
                $return.= '</div>';
                     
                
        
        
        return  $return;
}
endif;







if(!function_exists('wpestate_show_location_field')):
function wpestate_show_location_field($position,$term_counter=''){
    
    
    $return_string='  
            <input type="text" id="'.$position.'adv_location_'.$term_counter.'" class="form-control adv_locations_search" name="adv_location"  placeholder="'. esc_html__('Enter an address, state, city, area or zip code','wpresidence').'" value="';
                    if(isset($_GET['adv_location'])){
                        $return_string.= esc_attr(stripslashes($_GET['adv_location']) );
                    }
               $return_string.='">';
               
               
   $availableTags= wpestate_request_transient_cache('wpestate_search_location_tags');            
      
    if($availableTags==false){
        $availableTags='';
        $args = array(
            'orderby' => 'count',
            'hide_empty' => 0,
        ); 

        $terms = get_terms( 'property_city', $args );
        foreach ( $terms as $term ) {
           $availableTags.= '"'.esc_html($term->name).'",';
        }

        $terms = get_terms( 'property_area', $args );

        foreach ( $terms as $term ) {
           $availableTags.= '"'.esc_html($term->name).'",';
        }

        $terms = get_terms( 'property_county_state', $args );
        foreach ( $terms as $term ) {
           $availableTags.= '"'.esc_html($term->name).'",';
        }           
        
        wpestate_set_transient_cache('wpestate_search_location_tags',$availableTags,60*60*24);
    }
    
    $return_string.= '<script type="text/javascript">
                       //<![CDATA[
                       jQuery(document).ready(function(){
                            var availableTags = ['.$availableTags.'];
                            jQuery(".adv_locations_search").autocomplete({
                                source: availableTags,
                                change: function() {
                                    wpestate_show_pins();
                                }
                            });
                       });
                       //]]>
                       </script>';
               
    return $return_string;
    
}
endif;






if(!function_exists('wpestate_search_tab_align')):
function wpestate_search_tab_align(){
    
    $wp_estate_search_tab_align = wpresidence_get_option('wp_estate_search_tab_align','');
    if($wp_estate_search_tab_align=='center'){
        return 'wpestate_search_tab_align_center';
    }
}
endif;


if(!function_exists('wpestate_geo_search_filter_function')):
function wpestate_geo_search_filter_function($args,$center_lat,$center_long,$radius){
    global $wpdb;
    $radius_measure = wpresidence_get_option('wp_estate_geo_radius_measure','');
    $earth         = 3959;
    if( $radius_measure == 'km' ) {
       $earth = 6371;
    }


    $wpdb_query = $wpdb->prepare( "SELECT $wpdb->posts.ID,
            ( %s * acos(
                    cos( radians(%s) ) *
                    cos( radians( latitude.meta_value ) ) *
                    cos( radians( longitude.meta_value ) - radians(%s) ) +
                    sin( radians(%s) ) *
                    sin( radians( latitude.meta_value ) )
            ) )
            AS distance, latitude.meta_value AS latitude, longitude.meta_value AS longitude
            FROM $wpdb->posts
            INNER JOIN $wpdb->postmeta
                    AS latitude
                    ON $wpdb->posts.ID = latitude.post_id
            INNER JOIN $wpdb->postmeta
                    AS longitude
                    ON $wpdb->posts.ID = longitude.post_id
            WHERE 1=1

                    AND latitude.meta_key='property_latitude'
                    AND longitude.meta_key='property_longitude'
            HAVING distance < %s
            ORDER BY $wpdb->posts.menu_order ASC, distance ASC",
            $earth,
            $center_lat,
            $center_long,
            $center_lat,
            $radius
        );
        $listing_ids = $wpdb->get_results( $wpdb_query, OBJECT_K );
      
        if ( $listing_ids=='') {
            $listing_ids = array();
        }
        // return post ids for main wp_query
        
        $new_ids        =   array_keys(  $listing_ids );
        $original_ids   =   $args[ 'post__in' ];
        


        if ( !empty($new_ids) ){
            if( empty(  $args[ 'post__in' ] ) ){
                $args[ 'post__in' ] = $new_ids;
            }else if( $args[ 'post__in' ][0]==0 ){// no items on coustom
                $args[ 'post__in' ]=array(0);
            }else{
                $intersect   =   array_intersect ( $new_ids , $original_ids );
                if( empty($intersect) ){
                    $intersect=array(0);
                }
                    
                $args[ 'post__in' ] =$intersect;
         
             
                
            }
        }else{
            $args[ 'post__in' ]=array(0);
        }
        return $args;
    
}
endif;










if(!function_exists('wpestate_show_search_field_10')):
function wpestate_show_search_field_10($action_select_list){
    $allowed_html               =   array();
    $appendix='half-';
    $return_string='  <div class="col-md-9">
            <input type="text" id="adv_location" class="form-control" name="adv_location"  placeholder="'. esc_html__('Type address, state, city or area','wpresidence').'" value="';
                    if(isset($_GET['adv_location'])){
                        $return_string.= esc_attr( wp_kses($_GET['adv_location'], $allowed_html) );
                    }
               $return_string.='">      
        </div>';
    

        if(isset($_GET['filter_search_action'][0]) && $_GET['filter_search_action'][0]!='' && $_GET['filter_search_action'][0]!='all'){
                $full_name          =   get_term_by('slug', ( ( $_GET['filter_search_action'][0] ) ),'property_action_category');
                $adv_actions_value  =   $adv_actions_value1 = $full_name->name;
            }else{
                $adv_actions_value  =   esc_html__('Types','wpresidence');
                $adv_actions_value1 =   'all';
            } 

            $return_string  .=  wpestate_build_dropdown_adv($appendix,'actionslist','adv_actions',$adv_actions_value,$adv_actions_value1,'filter_search_action',$action_select_list);

            
            
     
     
      
    $return_string.='<input type="hidden" name="is10" value="10">';
    return $return_string;
}
endif;


if(!function_exists('wpestate_show_search_field_11')):
function wpestate_show_search_field_11($action_select_list,$categ_select_list){
    $allowed_html   =   array();
    $appendix       =   'half-';
    $return_string  =   ' <div class="col-md-6">
            <input type="text" id="keyword_search" class="form-control" name="keyword_search"  placeholder="'.esc_html__('Type Keyword','wpresidence').'" value="';
            
            if(isset($_GET['keyword_search'])){
                $return_string.= esc_attr( wp_kses($_GET['keyword_search'], $allowed_html) );
            }
            $return_string.='"></div>';
    

        if(isset($_GET['filter_search_action'][0]) && $_GET['filter_search_action'][0]!='' && $_GET['filter_search_action'][0]!='all'){
                $full_name          =   get_term_by('slug', ( ( $_GET['filter_search_action'][0] ) ),'property_action_category');
                $adv_actions_value  =   $adv_actions_value1 = $full_name->name;
            }else{
                $adv_actions_value  =   esc_html__('Types','wpresidence');
                $adv_actions_value1 =   'all';
            } 

            $return_string  .=  wpestate_build_dropdown_adv($appendix,'actionslist','adv_actions',$adv_actions_value,$adv_actions_value1,'filter_search_action',$action_select_list);

            
            
     
       if( isset($_GET['filter_search_type'][0]) && $_GET['filter_search_type'][0]!=''  && $_GET['filter_search_type'][0]!='all' ){
                $full_name = get_term_by('slug', esc_html( wp_kses($_GET['filter_search_type'][0], $allowed_html) ),'property_category');
                $adv_categ_value    =   $adv_categ_value1   =   $full_name->name;
            }else{
                $adv_categ_value    =   esc_html__('Categories','wpresidence');
                $adv_categ_value1   =   'all';
            }
        $return_string.=wpestate_build_dropdown_adv($appendix,'categlist','adv_categ',$adv_categ_value,$adv_categ_value1,'filter_search_type',$categ_select_list);

     
      
    $return_string.='<input type="hidden" name="is11" value="11">';
    return $return_string;
}
endif;




if(!function_exists('wpestated_advanced_search_tip11')):
function wpestated_advanced_search_tip11($args){
  
    $allowed_html       =   array();
    $taxcateg_include   =   array();  
    $categ_array        =   array();
    $action_array       =   array();
    $type_name          =   'filter_search_type';
    $type_name_value    =   wp_kses( $_REQUEST[$type_name][0] ,$allowed_html );
    $taxcateg_include   =   sanitize_title ( wp_kses( $type_name_value ,$allowed_html ) );
         
    
    if (isset($_GET['filter_search_type']) && $_GET['filter_search_type'][0]!='all' && trim($_GET['filter_search_type'][0])!='' ){
        $taxcateg_include   =   array();

        foreach($_GET['filter_search_type'] as $key=>$value){
            $taxcateg_include[]= sanitize_title (  esc_html( wp_kses($value, $allowed_html ) ) );
        }

        $categ_array=array(
            'taxonomy'     => 'property_category',
            'field'        => 'slug',
            'terms'        => $taxcateg_include
        );
    }

    if ( ( isset($_GET['filter_search_action']) && $_GET['filter_search_action'][0]!='all' && trim($_GET['filter_search_action'][0])!='') ){
        $taxaction_include   =   array();   

        foreach( $_GET['filter_search_action'] as $key=>$value){
            $taxaction_include[]    = sanitize_title ( esc_html (  wp_kses($value, $allowed_html ) ) );
        }

        $action_array=array(
             'taxonomy'     => 'property_action_category',
             'field'        => 'slug',
             'terms'        => $taxaction_include
        );
    }
    $args['tax_query']      =   wpestate_clear_tax(   $args['tax_query'] );
    if( !empty($categ_array) ){
        $args['tax_query'][]    =   $categ_array;
    }
    if( !empty($action_array) ){
        $args['tax_query'][]    =   $action_array;
    }
    
    
    return ($args);
 
}
endif;

if(!function_exists('wpestated_advanced_search_tip11_ajax')):
function  wpestated_advanced_search_tip11_ajax($args,$keyword_search,$filter_search_action11,$filter_search_categ11) {
  
    $allowed_html       =   array();
    $taxcateg_include   =   array();  
    $categ_array        =   array();
    $action_array       =   array();
   
    $filter_search_categ11  =   strtolower($filter_search_categ11);
    $filter_search_action11 =   strtolower($filter_search_action11);
            
            
    if (isset($filter_search_categ11) && $filter_search_categ11!='all' && trim($filter_search_categ11)!='' ){
        $taxcateg_include   =   array();
        $taxcateg_include[] =   sanitize_title (  esc_html( wp_kses($filter_search_categ11, $allowed_html ) ) );
        
        $categ_array=array(
            'taxonomy'     => 'property_category',
            'field'        => 'slug',
            'terms'        => $taxcateg_include
        );
    }

    if ( ( isset($filter_search_action11) && $filter_search_action11!='all' && trim($filter_search_action11)!='') ){
        $taxaction_include      =   array();   
        $taxaction_include[]    =   sanitize_title ( esc_html (  wp_kses($filter_search_action11, $allowed_html ) ) );
     
        $action_array=array(
            'taxonomy'     => 'property_action_category',
            'field'        => 'slug',
            'terms'        => $taxaction_include
        );
    }
    
    $args['tax_query']      =   wpestate_clear_tax(   $args['tax_query'] );
    if( !empty($categ_array) ){
        $args['tax_query'][]    =   $categ_array;
    }
    if( !empty($action_array) ){
        $args['tax_query'][]    =   $action_array;
    }
    
    
    return ($args);
 
}
endif;




if(!function_exists('wpestated_advanced_search_tip10')):
function wpestated_advanced_search_tip10($args){
    $args['tax_query']  =   wpestate_clear_tax(   $args['tax_query'] );
    $allowed_html       =   array();
    $action_array       =   array();
    $location_array     =   array();
    
    
   
    

    if ( ( isset($_GET['filter_search_action']) && $_GET['filter_search_action'][0]!='all' && $_GET['filter_search_action'][0]!='All' && trim($_GET['filter_search_action'][0])!='') ){
        $taxaction_include   =   array();   

        foreach( $_GET['filter_search_action'] as $key=>$value){
            $taxaction_include[]    = sanitize_title ( esc_html (  wp_kses($value, $allowed_html ) ) );
        }

        $action_array=array(
            'taxonomy'     => 'property_action_category',
            'field'        => 'slug',
            'terms'        => $taxaction_include
        );
    }




    if ( isset($_GET['adv_location']) && $_GET['adv_location']!='') {

        $location_array = array(
                        'key'     => 'hidden_address',
                        'value'   =>  sanitize_text_field( $_GET['adv_location'] ),
                        'compare' => 'LIKE',
                        'type'    => 'string',
                );

    }

    
   
    
    if( !empty($action_array) ){
        if(gettype(  $args['tax_query']) =='string' ){
            $args['tax_query']=array();
        }
        $args['tax_query'][]=$action_array;
    }
 
    if(!empty($location_array)){
        
        if(gettype(  $args['meta_query']) =='string' ){
            $args['meta_query']=array();
        }
        $args['meta_query'][]=$location_array;
    }

  
    
    return ($args);
 
}
endif;

if(!function_exists('wpestated_advanced_search_tip10_ajax')):
function wpestated_advanced_search_tip10_ajax($args,$filter_search_action10,$adv_location10){
    $args['tax_query']      = (array)  wpestate_clear_tax(   $args['tax_query'] );
    $allowed_html       =   array();
    $action_array       =   array();
    $location_array     =   array();
    
    $filter_search_action10 = strtolower($filter_search_action10);
  
    if (  isset($filter_search_action10) && $filter_search_action10!='all' && $filter_search_action10!='' ){
        $taxaction_include   =   array();   


        $taxaction_include[]    = sanitize_title ( esc_html (  wp_kses($filter_search_action10, $allowed_html ) ) );

        $action_array=array(
            'taxonomy'     => 'property_action_category',
            'field'        => 'slug',
            'terms'        => $taxaction_include
        );
    }




    if ( isset($adv_location10) && $adv_location10!='') {

        $location_array = array(
                        'key'     => 'hidden_address',
                        'value'   =>  sanitize_text_field($adv_location10 ),
                        'compare' => 'LIKE',
                        'type'    => 'string',
                );

    }

    
    
    
    if( !empty($action_array) ){
        if(!is_array( $args['tax_query'] )){
            $args['tax_query']=array();
        }
        
        $args['tax_query'][]=$action_array;
    }
 
    if(!empty($location_array)){
        if(!is_array( $args['meta_query'] )){
            $args['meta_query']=array();
        }
        
        $args['meta_query'][]=$location_array;
    }

  
  
    return ($args);
 
}
endif;


if(!function_exists('wpestate_clear_tax')):
function wpestate_clear_tax($tax_array){
    
  
    if( !is_array($tax_array[0] ) ){
        unset( $tax_array[0] );
    }else{
        if(empty($tax_array[0])){
            unset( $tax_array[0] ); 
        }
    }
    
    foreach($tax_array as $key=>$tax_ar){
        if( $key != 'relation' ){
            if( !is_array($tax_ar) ){
                unset( $tax_array[$key] );
            }else{
                if(empty($tax_ar)){
                    unset( $tax_array[$key] ); 
                }
            }
        }     
    }
    
    return $tax_array;
    
}
endif;




if (!function_exists('wpestate_search_results_custom')):
function wpestate_search_results_custom($tip=''){
    global $wpestate_included_ids;
    global $amm_features;
    $real_custom_fields     =   wpresidence_get_option( 'wp_estate_custom_fields', ''); 
    $adv_search_what        =   wpresidence_get_option('wp_estate_adv_search_what','');
    $adv_search_how         =   wpresidence_get_option('wp_estate_adv_search_how','');
    $adv_search_label       =   wpresidence_get_option('wp_estate_adv_search_label','');                    
    $adv_search_type        =   wpresidence_get_option('wp_estate_adv_search_type','');
    $adv_search_fields_no   =   floatval( wpresidence_get_option('wp_estate_adv_search_fields_no') );
    
    $term_counter=0;
    if( isset( $_REQUEST['term_counter']) ) {
        $term_counter=intval($_REQUEST['term_counter']);
    }
    
            
        $adv_search_what    = array_slice($adv_search_what, ($term_counter*$adv_search_fields_no),$adv_search_fields_no);
        $adv_search_label   = array_slice($adv_search_label, ($term_counter*$adv_search_fields_no),$adv_search_fields_no);
        $adv_search_how     = array_slice($adv_search_how, ($term_counter*$adv_search_fields_no),$adv_search_fields_no);

    
    $wpestate_keyword                =   '';
    $area_array             =   ''; 
    $city_array             =   '';  
    $action_array           =   '';
    $categ_array            =   '';
    $meta_query             =   '';
    $wpestate_included_ids           =   array();
    $id_array               =   '';
    $countystate_array      =   '';
    $allowed_html           =   array();
    $new_key                =   0;
    $features               =   array(); 
    $status_array           =   '';
    
    if($adv_search_type==6 || $adv_search_type==7 || $adv_search_type==8 || $adv_search_type==9){
        $adv6_taxonomy          =   wpresidence_get_option('wp_estate_adv6_taxonomy');
        if($adv6_taxonomy=='property_category'){
            $adv_search_what[]='categories';
            
        }else if($adv6_taxonomy=='property_action_category'){
            $adv_search_what[]='types';
        }else if($adv6_taxonomy=='property_city'){
            $adv_search_what[]='cities';
        }else if($adv6_taxonomy=='property_area'){
            $adv_search_what[]='areas';
        }else if($adv6_taxonomy=='property_county_state'){
            $adv_search_what[]='county / state';
        }
        $adv_search_how[]='like';
        $adv_search_label[]='';
    }
   
    
   $term_location_value='';
    
    foreach($adv_search_what as $key=>$term ){
        $new_key        =   $key+1;  
        $new_key        =   'val'.$new_key; 
        
        
        if($term === 'none' || $term === 'keyword' || $term === 'property id'){
            // do nothng
            
            
        }else if( $term === 'wpestate location' ){
                if( $tip === 'ajax' ){
                    $term_location_value=  wp_kses($_POST['val_holder'][$key],$allowed_html);
                }
        }else if( $term === 'property status' ) {
            
               if( $tip === 'ajax' ){
                    $input_name         =    'property_status';
                    $input_value        =    wp_kses($_POST['val_holder'][$key],$allowed_html);
                }else{
                    $input_name         =   'property_status';
                    $input_value        =   '';
                    if(isset( $_REQUEST['property_status'])){
                        $input_value        =    wp_kses( $_REQUEST['property_status'],$allowed_html);
                    }
                }
                
            
                if ( (isset($_REQUEST[$input_name]) || isset($_POST['val_holder'][$key]) )   && strtolower ($input_value)!='all' && $input_value!='' ){
                    $taxcity   =   array();   
                    $taxcity[] = wp_kses($input_value,$allowed_html);
                    $status_array = array(
                        'taxonomy'  => 'property_status',
                        'field'     => 'slug',
                        'terms'     => $taxcity
                    );
                }
        
        }else if( $term === 'categories' ) {
            
                
                if( $tip === 'ajax' ){
                    $input_name         =   'filter_search_type';
                    $input_value        =    wp_kses($_POST['val_holder'][$key],$allowed_html);
                }else{
                    $input_name         =   'filter_search_type';
                    if(isset($_REQUEST['filter_search_type'][0])){
                        $input_value        =  wp_kses( $_REQUEST['filter_search_type'][0],$allowed_html);
                    }
                }

         
                if ( (isset($_REQUEST[$input_name]) || isset($_POST['val_holder'][$key]) )  && strtolower ($input_value)!='all' && $input_value!='' ){
                    $taxcateg_include   =   array();
                    $taxcateg_include[] =   wp_kses($input_value,$allowed_html);
  
                    $categ_array=array(
                        'taxonomy'  => 'property_category',
                        'field'     => 'slug',
                        'terms'     => $taxcateg_include
                    );
                } 
        } 
       
        else if($term === 'types'){ 
                if( $tip === 'ajax' ){
                    $input_name         =   'filter_search_action';
                    $input_value        =   wp_kses($_POST['val_holder'][$key],$allowed_html);
                }else{
                    $input_name         =   'filter_search_action';
                    if(isset($_REQUEST['filter_search_action'][0])){
                        $input_value        =   wp_kses( $_REQUEST['filter_search_action'][0],$allowed_html);
                    }
                }
         
                
                if ( (isset($_REQUEST[$input_name]) || isset($_POST['val_holder'][$key]) )    && strtolower ($input_value)!='all' && $input_value!='' ){
                    $taxaction_include   =   array();   

                    $taxaction_include[] = wp_kses($input_value,$allowed_html);

                    $action_array=array(
                        'taxonomy'  => 'property_action_category',
                        'field'     => 'slug',
                        'terms'     => $taxaction_include
                    );
                }
        }

        else if($term === 'cities'){
                if( $tip === 'ajax' ){
                    $input_name         =    'advanced_city';
                    $input_value        =    wp_kses($_POST['val_holder'][$key],$allowed_html);
                }else{
                    $input_name         =   'advanced_city';
                    $input_value        =   '';
                    if(isset( $_REQUEST['advanced_city'])){
                        $input_value        =    wp_kses( $_REQUEST['advanced_city'],$allowed_html);
                    }
                }
                
            
                if ( (isset($_REQUEST[$input_name]) || isset($_POST['val_holder'][$key]) )   && strtolower ($input_value)!='all' && $input_value!='' ){
                    $taxcity   =   array();   
                    $taxcity[] = wp_kses($input_value,$allowed_html);
                    $city_array = array(
                        'taxonomy'  => 'property_city',
                        'field'     => 'slug',
                        'terms'     => $taxcity
                    );
                }
        }

        else if($term === 'areas'){
                
                if( $tip === 'ajax' ){
                    $input_name         =   'advanced_area';
                    $input_value        =    wp_kses($_POST['val_holder'][$key],$allowed_html);
                }else{
                    $input_name         =   'advanced_area';
                    $input_value        =   '';  
                    if(isset($_REQUEST['advanced_area'])){
                        $input_value        =   wp_kses( $_REQUEST['advanced_area'],$allowed_html);
                    }
                }
                
                if ( (isset($_REQUEST[$input_name]) || isset($_POST['val_holder'][$key]) )    && strtolower ($input_value)!='all' && $input_value!='' ){
                    $taxarea   =   array();   
                    $taxarea[] = wp_kses($input_value,$allowed_html);
                    $area_array = array(
                        'taxonomy'  => 'property_area',
                        'field'     => 'slug',
                        'terms'     => $taxarea
                    );
                }
        }
        
        else if($term === 'county / state'){
           
     
                if( $tip === 'ajax' ){
                    $input_name         =   'advanced_contystate';
                    $input_value        =    wp_kses($_POST['val_holder'][$key],$allowed_html);
                     
                }else{
                    $input_name         =   'advanced_contystate';
                    $input_value        =   wp_kses( $_REQUEST['advanced_contystate'],$allowed_html);
                              
                }
                                     
             
                if ( (isset($_REQUEST[$input_name]) || isset($_POST['val_holder'][$key]) )   && strtolower ($input_value)!='all' && $input_value!='' ){
                    $taxcountystate   =     array();   
                    $taxcountystate[] =     wp_kses($input_value,$allowed_html);
           
                    $countystate_array = array(
                        'taxonomy'  => 'property_county_state',
                        'field'     => 'slug',
                        'terms'     => $taxcountystate
                    );
                }
             
        } 
        else{ 
          
            $term         =   str_replace(' ', '_', $term);
            $slug         =   wpestate_limit45(sanitize_title( $term )); 
            
            $slug         =   sanitize_key($slug);             
            $string       =   wpestate_limit45 ( sanitize_title ($adv_search_label[$key]) );   
            $slug_name    =   sanitize_key($string);
            
            $compare_array      =   array();
            $show_slider_price  =   wpresidence_get_option('wp_estate_show_slider_price','');
            
          
            if ( $adv_search_what[$key] === 'property country'){
                
                if( $tip === 'ajax' ){
                    $term_value=  wp_kses($_POST['val_holder'][$key],$allowed_html);
                }else{
                    if(isset($_GET['advanced_country'])){
                        $term_value=  esc_html( wp_kses( $_GET['advanced_country'], $allowed_html) );
                    }
                }
                
                if( $term_value!='' && $term_value!='all' && $term_value!='all' &&  $term_value != $adv_search_label[$key]){
                    $compare_array['key']        = 'property_country';
                    $compare_array['value']      =  wp_kses($term_value,$allowed_html);
                    $compare_array['type']       = 'CHAR';
                    $compare_array['compare']    = 'LIKE';
                    //$meta_query[]                = $compare_array;
                    $wpestate_included_ids[] = $compare_array;
                }
                
                
                //&& ( isset($_REQUEST['slider_min']) && isset($_REQUEST['slider_max']) )
                
            }else if ( $adv_search_what[$key] === 'property price' && $show_slider_price ==='yes'  ){
                
                $compare_array['key']        = 'property_price';
                
                if( $tip === 'ajax' ){                   
                    $price_low  = floatval($_POST['slider_min']);
                    $price_max  = floatval($_POST['slider_max']);
                }else{
                    if( isset($_GET['term_id']) && isset($_GET['term_id'])!='' ){
                        $term_id    = intval($_GET['term_id']);
                        $price_low  = floatval( $_GET['price_low_'.$term_id] );
                        $price_max  = floatval( $_GET['price_max_'.$term_id] );
              
                    }else{
                        $price_low  = floatval( $_GET['price_low'] );
                        $price_max  = floatval( $_GET['price_max'] );
              
                    }
                    
                }

                $custom_fields = wpresidence_get_option( 'wp_estate_multi_curr', '');
                if( !empty($custom_fields) && isset($_COOKIE['my_custom_curr']) &&  isset($_COOKIE['my_custom_curr_pos']) &&  isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos']!=-1){
                    $i=intval($_COOKIE['my_custom_curr_pos']);
                    $price_max       =   $price_max / $custom_fields[$i][2];
                    $price_low       =   $price_low / $custom_fields[$i][2];
                }
                
                
                if($price_max>0){
                    $compare_array['key']        = 'property_price';
                    $compare_array['value']      = array($price_low, $price_max);
                    $compare_array['type']       = 'numeric';
                    $compare_array['compare']    = 'BETWEEN';
                    $wpestate_included_ids[]= $compare_array;
                    //$meta_query[]                = $compare_array;
                }
            }else{
                if( $tip === 'ajax' ){
                    $term_value= wp_kses($_POST['val_holder'][$key],$allowed_html);
                }else{
                    $term_value='';
                    
                 //   print '$slug_name '.$slug_name.'</br>';
                    if(isset($_GET[$slug_name])){
                        $term_value =  (esc_html( wp_kses($_GET[$slug_name], $allowed_html) ));
                    }
                }
                
                if( $adv_search_label[$key] != $term_value && $term_value != '' && strtolower($term_value) != 'all'){ // if diffrent than the default values
                    $compare        =   '';
                    $search_type    =   ''; 
                    $allowed_html   =   array();
                    $compare        =   $adv_search_how[$key];

                    if($compare === 'equal'){
                       $compare         =   '='; 
                       $search_type     =   'numeric';
                       $term_value      =   floatval ($term_value );

                    }else if($compare === 'greater'){
                        $compare        = '>='; 
                        $search_type    = 'numeric';
                        $term_value     =  floatval ( $term_value );

                    }else if($compare === 'smaller'){
                        $compare        ='<='; 
                        $search_type    ='numeric';
                        $term_value     = floatval ( $term_value );

                    }else if($compare === 'like'){
                        $compare        = 'LIKE'; 
                        $search_type    = 'CHAR';
                        $term_value     = (wp_kses( $term_value ,$allowed_html));
                     //   $term_value     = str_replace(' ','%',$term_value);
                        
                    }else if($compare === 'date bigger'){
                        $compare        ='>=';  
                        $search_type    ='DATE';
                        $term_value     =  str_replace(' ', '-', $term_value);
                        $term_value     = wp_kses( $term_value,$allowed_html );

                    }else if($compare === 'date smaller'){
                        $compare        = '<='; 
                        $search_type    = 'DATE';
                        $term_value     =  str_replace(' ', '-', $term_value);
                        $term_value     = wp_kses( $term_value,$allowed_html );
                    }

                    $compare_array['key']        = $slug;
                    $compare_array['value']      = $term_value;
                    $compare_array['type']       = $search_type;
                    $compare_array['compare']    = $compare;
                    $wpestate_included_ids[]= $compare_array;
                    //$meta_query[]                = $compare_array;

                }// end if diffrent
            } 
        }////////////////// end last else
    } ///////////////////////////////////////////// end for each adv search term
   

    
    
    if($tip === 'search'){
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    }
    
    if($tip === 'ajax'){
        $paged      =   intval($_POST['newpage']);
        $prop_no    =   intval( wpresidence_get_option('wp_estate_prop_no', '') );
    }
    
    if($tip === 'ajax'){
        $features_array = wpestate_add_feature_to_search('ajax');
    }else{
        $features_array = wpestate_add_feature_to_search();
    }
    
    $args = array(
        'cache_results'             =>  false,
        'update_post_meta_cache'    =>  false,
        'update_post_term_cache'    =>  false,
        
        'post_type'       => 'estate_property',
        'post_status'     => 'publish',
        'paged'           => $paged,
        'posts_per_page'  => 30,
        'meta_key'        => 'prop_featured',
        'orderby'         => 'meta_value',
        'order'           => 'DESC',
        'meta_query'      => $meta_query,
        'tax_query'       => array(
                                'relation' => 'AND',
                                $categ_array,
                               $action_array,
                                $city_array,
                                $area_array,
                                $countystate_array,
                                $features_array,
                                $status_array
                            )
    );  
    


    $meta_ids=array();
    if(!empty($wpestate_included_ids)){
        $meta_ids = wpestate_add_meta_post_to_search($wpestate_included_ids);
         $args['post__in']=$meta_ids;
    }
   
 
   
    if(!empty($features)){
       
    }
    
    if($adv_search_type==10 && $tip === 'ajax'){
        $args    =   wpestated_advanced_search_tip10_ajax($args,$_POST['filter_search_action10'],$_POST['adv_location10']);
    }
    
    
    if($adv_search_type==11 && $tip === 'ajax'){
        $args    =   wpestated_advanced_search_tip11_ajax($args,$_POST['keyword_search'],$_POST['filter_search_action11'],$_POST['filter_search_categ11']);
    }
    
    
    
    if( in_array('wpestate location', $adv_search_what)){
       $args = wpestate_filter_for_location($args);
    }
    
    //$term_location_value
    if( in_array('wpestate location', $adv_search_what) && $tip === 'ajax' ){
       $args = wpestate_filter_for_location_ajax($args,$term_location_value);
    }

    return $args;
      
}
endif;

















if(!function_exists('wpestate_search_results_default')):
function wpestate_search_results_default($tip=''){
    
    $area_array         =   ''; 
    $city_array         =   '';  
    $action_array       =   '';
    $categ_array        =   '';
    $id_array           =   '';
    $countystate_array  =   '';
    $allowed_html       =   array();
    
    if($tip === 'ajax'){
        $type_name      =   'category_values';
        $type_name_value=   wp_kses( $_REQUEST[$type_name] ,$allowed_html );
        $action_name    =   'action_values';
        $action_name_value  = wp_kses( $_REQUEST[$action_name] ,$allowed_html );
        $city_name      =   'city';
        $area_name      =   'area';
        $rooms_name     =   'advanced_rooms';
        $bath_name      =   'advanced_bath';
        $price_low_name =   'price_low';
        $price_max_name =   'price_max';
    }else{
        $type_name          =   'filter_search_type';
        
        $type_name_value    =   '';
        if(isset($_REQUEST[$type_name][0])){
            $type_name_value    =   wp_kses( $_REQUEST[$type_name][0] ,$allowed_html );
        }
        $action_name        =   'filter_search_action';
        $action_name_value  =   '';
        if(isset( $_REQUEST[$action_name][0])){
            $action_name_value  =    wp_kses( $_REQUEST[$action_name][0],$allowed_html );
        }
        
        $city_name      =   'advanced_city';
        $area_name      =   'advanced_area';
        $rooms_name     =   'advanced_rooms';
        $bath_name      =   'advanced_bath';
        $price_low_name =   'price_low';
        $price_max_name =   'price_max';
    }

    if ( $type_name_value!='all' && $type_name_value!='' ){
        $taxcateg_include   =   array();     
        $taxcateg_include   =   sanitize_title ( wp_kses( $type_name_value ,$allowed_html ) );
           
        $categ_array=array(
            'taxonomy'     => 'property_category',
            'field'        => 'slug',
            'terms'        => $taxcateg_include
        );
    }

    if ( $action_name_value !='all' && $action_name_value !='') {
        $taxaction_include   =   array();   
        $taxaction_include   =   sanitize_title ( wp_kses( $action_name_value ,$allowed_html) );   
        
        $action_array=array(
             'taxonomy'     => 'property_action_category',
             'field'        => 'slug',
             'terms'        => $taxaction_include
        );
     }


    
    if (isset($_REQUEST[$city_name]) and $_REQUEST[$city_name] != 'all' && $_REQUEST[$city_name] != '') {
        $taxcity[] = sanitize_title ( wp_kses ( $_REQUEST[$city_name],$allowed_html ) );
        $city_array = array(
            'taxonomy'     => 'property_city',
            'field'        => 'slug',
            'terms'        => $taxcity
         );
     }

 
    if (isset($_REQUEST[$area_name]) and $_REQUEST[$area_name] != 'all' && $_REQUEST[$area_name] != '') {
        $taxarea[] = sanitize_title ( wp_kses ($_REQUEST[$area_name],$allowed_html) );
        $area_array = array(
            'taxonomy'     => 'property_area',
            'field'        => 'slug',
            'terms'        => $taxarea
        );
     }

   
    
    $meta_query = $rooms = $baths = $price = array();
    if (isset($_REQUEST[$rooms_name]) && is_numeric($_REQUEST[$rooms_name])) {
        $rooms['key'] = 'property_bedrooms';
        $rooms['compare'] = '=';
        $rooms['value'] = floatval ($_REQUEST[$rooms_name]);
        $meta_query[] = $rooms;
    }

    if (isset($_REQUEST[$bath_name]) && is_numeric($_REQUEST[$bath_name])) {
        $baths['key'] = 'property_bathrooms';
        $baths['compare'] = '=';
        $baths['value'] = floatval ($_REQUEST[$bath_name]);
        $meta_query[] = $baths;
    }


    //////////////////////////////////////////////////////////////////////////////////////
    ///// price filters 
    //////////////////////////////////////////////////////////////////////////////////////
    $price_low ='';
    if( isset($_REQUEST[$price_low_name])){
        $price_low = floatval($_REQUEST[$price_low_name]);
    }

    $price_max='';
    $custom_fields = wpresidence_get_option( 'wp_estate_multi_curr', '');
              
      
    if( isset($_REQUEST[$price_max_name])  && $_REQUEST[$price_max_name] && floatval($_REQUEST[$price_max_name])>0 ){
            $price_max          = floatval($_REQUEST[$price_max_name]);
            
            if( !empty($custom_fields) && isset($_COOKIE['my_custom_curr']) &&  isset($_COOKIE['my_custom_curr_pos']) &&  isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos']!=-1){
                $i=intval($_COOKIE['my_custom_curr_pos']);
                $price_max       =   $price_max / $custom_fields[$i][2];
                $price_low       =   $price_low / $custom_fields[$i][2];
            }
            
            
            $price['key']       = 'property_price';
            $price['value']     = array($price_low, $price_max);
            $price['type']      = 'numeric';
            $price['compare']   = 'BETWEEN';
            $meta_query[]       = $price;
    }else {
            
            if( !empty($custom_fields) && isset($_COOKIE['my_custom_curr']) &&  isset($_COOKIE['my_custom_curr_pos']) &&  isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos']!=-1){
                $i=intval($_COOKIE['my_custom_curr_pos']);
                $price_low       =   $price_low / $custom_fields[$i][2];
            }
            
      
            $price['key']       = 'property_price';
            $price['value']     =  $price_low;
            $price['type']      = 'numeric';
            $price['compare']   = '>=';
            $meta_query[]       = $price;
    }


 
   
    if($tip === 'ajax'){
      
        $features             = array();
        $features = wpestate_add_feature_to_search_ajax();
        if(!empty($features)){
            $args['post__in']=$features;
        }
    }
    
    
    $meta_order         =   'prop_featured';
    $meta_directions    =   'DESC';   
    $order_by           =   'meta_value';
    
        if(isset($_POST['order'])) {
            $order=  wp_kses( $_POST['order'],$allowed_html );
            switch ($order){
                case 1:
                    $meta_order='property_price';
                    $meta_directions='DESC';
                    $order_by='meta_value_num';
                    break;
                case 2:
                    $meta_order='property_price';
                    $meta_directions='ASC';
                    $order_by='meta_value_num';
                    break;
                case 3:
                    $meta_order='';
                    $meta_directions='DESC';
                    $order_by='ID';
                    break;
                case 4:
                    $meta_order='';
                    $meta_directions='ASC';
                    $order_by='ID';
                    break;
                case 5:
                    $meta_order='property_bedrooms';
                    $meta_directions='DESC';
                    $order_by='meta_value_num';
                    break;
                case 6:
                    $meta_order='property_bedrooms';
                    $meta_directions='ASC';
                    $order_by='meta_value_num';
                    break;
                case 7:
                    $meta_order='property_bathrooms';
                    $meta_directions='DESC';
                    $order_by='meta_value_num';
                    break;
                case 8:
                    $meta_order='property_bedrooms';
                    $meta_directions='ASC';
                    $order_by='meta_value_num';
                    break;
            }
        }

    
    
    
    
    if($tip === 'search'){
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    }
    
    if($tip === 'ajax'){
        $paged      =   intval($_POST['newpage']);
    }
    
    $prop_no    =   intval( wpresidence_get_option('wp_estate_prop_no', '') );
    
    if($tip === 'ajax'){
        $features_array = wpestate_add_feature_to_search('ajax');
    }else{
        $features_array = wpestate_add_feature_to_search();
    }
    
    $args = array(
        'cache_results'             =>  false,
        'update_post_meta_cache'    =>  false,
        'update_post_term_cache'    =>  false,
        
        'post_type'       => 'estate_property',
        'post_status'     => 'publish',
        'paged'           => $paged,
        'posts_per_page'  => $prop_no,
        'meta_key'        => $meta_order,
        'orderby'         => $order_by,
        'order'           => $meta_directions,
        'meta_query'      => $meta_query,
        'tax_query'       => array(
                                'relation' => 'AND',
                                    $categ_array,
                                    $action_array,
                                    $city_array,
                                    $area_array,
                                    $features_array, 
                              
                            )
    );      
    if(!empty($features)){
        $args['post__in']=$features;
    }
   
    
    if( isset($_POST['geo_lat']) && wpresidence_get_option('wp_estate_use_geo_location','')=='yes' && $_POST['geo_lat']!='' && $_POST['geo_long']!='' ){
            $geo_lat    = $_POST['geo_lat'];
            $geo_long   = $_POST['geo_long'];
            $geo_rad    = $_POST['geo_rad'];
            $args       = wpestate_geo_search_filter_function( $args, $geo_lat, $geo_long, $geo_rad);
    }

  
    return $args;
    
}
endif;





if(!function_exists('wpestate_add_feature_to_search_ajax')):
function wpestate_add_feature_to_search_ajax(){
    global $table_prefix;
    global $wpdb;
    $searched=0;
   
    $feature_list_array =   array();
    $allowed_html       =   array();
    
    
    
    $all_checkers=explode(",", wp_kses($_POST['all_checkers'],$allowed_html) );
    
     $potential_ids=array();
    
    foreach($all_checkers as $checker => $value){
        if($value!=''){
            $searched       =   1;
        }
        $post_var_name  =   str_replace(' ','_', trim($value) );
        $input_name     =   wpestate_limit45(sanitize_title( $post_var_name ));
        $input_name     =   sanitize_key($input_name);
        if(trim($input_name)!=''){
          
            
            $potential_ids[$checker]=
                wpestate_get_ids_by_query(
                    $wpdb->prepare("
                        SELECT post_id
                        FROM ".$table_prefix."postmeta
                        WHERE meta_key = %s
                        AND CAST(meta_value AS UNSIGNED) = %f
                    ",$input_name,'1' )
            );
            
        }
        
    }
    
    $ids=[];
    foreach($potential_ids as $key=>$temp_ids){
        if(count($ids)==0){
            $ids=$temp_ids;
        }else{
            $ids=array_intersect($ids,$temp_ids);
        }
    }
    
      
    if(empty($ids) && $searched==1 ){
        $ids[]=0;
    }
    return $ids;
    
    
}
endif;






if(!function_exists('wpestate_add_feature_to_search')):
function wpestate_add_feature_to_search($tip=''){
    $features       =   array();
    $allowed_html   =   array();   
    $terms = get_terms( array(
        'taxonomy' => 'property_features',
        'hide_empty' => false,
    ) );
 
    if($tip=='ajax'){
        $all_checkers=explode(",", wp_kses($_POST['all_checkers'],$allowed_html) );
        foreach($all_checkers as $item_name){
            if($item_name!=''){
               $features[]=$item_name;
            }
        }
        
    }else{
        
        foreach($terms as $key => $term){
            $input_name     =   $term->slug;
            $input_name     =     str_replace('%','', $input_name);
            if ( isset( $_REQUEST[$input_name] ) && $_REQUEST[$input_name]==1 ){
               $features[]=$term->name;
            }
        }
    }
    
 
    
    if( !empty($features)){
        $features_array=array();
        $features_array['relation']='AND';
        
        foreach ($features as $term):
            $features_array[]=array(
                'taxonomy' => 'property_features',
                'field'    => 'name',
                'terms'    => $term,
            );
        endforeach;
        return $features_array;
    }
}
endif;



if(!function_exists('get_ids_by_query')):
function wpestate_get_ids_by_query($query){
    global $wpdb;

    $data=$wpdb->get_results($query,'ARRAY_A');
    $results=[];
    foreach($data as $entry){
        $results[]=$entry['post_id'];
    }
    return $results;
}
endif;










if(!function_exists('wpestated_advanced_search_tip2')):
function wpestated_advanced_search_tip2(){
    $categ_array        =   '';
    $action_array       =   '';
    $area_array         =  ''; 
    $city_array         =  ''; 
    $countystate_array  =  '';
    $location_array     =  '';
    $meta_query         =   array();
    $allowed_html       =   array();
    
    if (isset($_GET['filter_search_type']) && $_GET['filter_search_type'][0]!='all' && trim($_GET['filter_search_type'][0])!='' ){
        $taxcateg_include   =   array();

        foreach($_GET['filter_search_type'] as $key=>$value){
            $taxcateg_include[]= sanitize_title (  esc_html( wp_kses($value, $allowed_html ) ) );
        }

        $categ_array=array(
            'taxonomy'     => 'property_category',
            'field'        => 'slug',
            'terms'        => $taxcateg_include
        );
    }

    if ( ( isset($_GET['filter_search_action']) && $_GET['filter_search_action'][0]!='all' && trim($_GET['filter_search_action'][0])!='') ){
        $taxaction_include   =   array();   

        foreach( $_GET['filter_search_action'] as $key=>$value){
            $taxaction_include[]    = sanitize_title ( esc_html (  wp_kses($value, $allowed_html ) ) );
        }

        $action_array=array(
             'taxonomy'     => 'property_action_category',
             'field'        => 'slug',
             'terms'        => $taxaction_include
        );
    }
     
    if ( isset($_GET['adv_location']) && $_GET['adv_location']!='') {
        $taxlocation[] = sanitize_title (  esc_html( wp_kses($_GET['adv_location'], $allowed_html) ) );
        $area_array = array(
            'taxonomy'     => 'property_area',
            'field'        => 'slug',
            'terms'        => $taxlocation
        );

        $city_array = array(
            'taxonomy'     => 'property_city',
            'field'        => 'slug',
            'terms'        => $taxlocation
        );
        
        $countystate_array = array(
            'taxonomy'      => 'property_county_state',
            'field'         => 'slug',
            'terms'         => $taxlocation
        );
        $location_array     = array( 
                                    'relation' => 'OR',
                                    $city_array,
                                    $area_array,
                                    $countystate_array
                                );
        }
     
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
  
        
        
    $args = array(
        'cache_results'             =>  false,
        'update_post_meta_cache'    =>  false,
        'update_post_term_cache'    =>  false,
        
        'post_type'       => 'estate_property',
        'post_status'     => 'publish',
        'paged'           => $paged,
        'posts_per_page'  => 30,
        'meta_key'        => 'prop_featured',
        'orderby'         => 'meta_value',
        'order'           => 'DESC',
        'meta_query'      => $meta_query,
        'tax_query'       => array(
                                    'relation' => 'AND',
                                    $categ_array,
                                    $action_array,
                                    $location_array
                               )
    );
    
    return ($args);
 
}
endif;





if(!function_exists('wpestated_advanced_search_tip2_ajax')):
function wpestated_advanced_search_tip2_ajax(){
    $categ_array        =   '';
    $action_array       =   '';
    $area_array         =  ''; 
    $city_array         =  ''; 
    $countystate_array  =  '';
    $location_array     =  '';
    $meta_query         =   array();
    $allowed_html       =   array();
    
    if ( isset($_POST['category_values']) && $_POST['category_values']!='' && $_POST['category_values']!='all' ){
        $taxcateg_include   =   array();
        $taxcateg_include[]= sanitize_title (  esc_html( wp_kses($_POST['category_values'], $allowed_html ) ) );
      
        $categ_array=array(
            'taxonomy'     => 'property_category',
            'field'        => 'slug',
            'terms'        => $taxcateg_include
        );
    }

    if ( isset($_POST['action_values'] ) && $_POST['action_values']!='' && $_POST['action_values']!='all' ) {
        $taxaction_include   =   array();   
        $taxaction_include[]    = sanitize_title ( esc_html (  wp_kses($_POST['action_values'] , $allowed_html ) ) );
      
        $action_array=array(
             'taxonomy'     => 'property_action_category',
             'field'        => 'slug',
             'terms'        => $taxaction_include
        );
    }
     
    
    
    if ( isset($_POST['location']) && $_POST['location']!='' ) {
        $taxlocation[] = sanitize_title (  esc_html( wp_kses($_POST['location'], $allowed_html) ) );
        $area_array = array(
            'taxonomy'     => 'property_area',
            'field'        => 'slug',
            'terms'        => $taxlocation
        );

        $city_array = array(
            'taxonomy'     => 'property_city',
            'field'        => 'slug',
            'terms'        => $taxlocation
        );
        
        $countystate_array = array(
            'taxonomy'      => 'property_county_state',
            'field'         => 'slug',
            'terms'         => $taxlocation
        );
        $location_array     = array( 
                                    'relation' => 'OR',
                                    $city_array,
                                    $area_array,
                                    $countystate_array
                                );
        }
     
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
  
        
        
    $args = array(
        'cache_results'             =>  false,
        'update_post_meta_cache'    =>  false,
        'update_post_term_cache'    =>  false,
        
        'post_type'       => 'estate_property',
        'post_status'     => 'publish',
        'paged'           => $paged,
        'posts_per_page'  => -1,
        'meta_key'        => 'prop_featured',
        'orderby'         => 'meta_value',
        'order'           => 'DESC',
        'meta_query'      => $meta_query,
        'tax_query'       => array(
                                    'relation' => 'AND',
                                    $categ_array,
                                    $action_array,
                                    $location_array
                               )
    );
    
    return ($args);
 
}
endif;








if(!function_exists('wpestated_advanced_search_tip2_ajax_tabs')):
function wpestated_advanced_search_tip2_ajax_tabs(){
    $categ_array        =   '';
    $action_array       =   '';
    $area_array         =  ''; 
    $city_array         =  ''; 
    $countystate_array  =  '';
    $location_array     =  '';
    $meta_query         =   array();
    $allowed_html       =   array();
    
    if ( isset($_POST['category_values']) && $_POST['category_values']!='' && $_POST['category_values']!='all' ){
        $taxcateg_include   =   array();
        $taxcateg_include[]= sanitize_title (  esc_html( wp_kses($_POST['category_values'], $allowed_html ) ) );
      
        $categ_array=array(
            'taxonomy'     => 'property_category',
            'field'        => 'slug',
            'terms'        => $taxcateg_include
        );
    }

    if ( isset($_POST['action_values'] ) && $_POST['action_values']!='' && $_POST['action_values']!='all' ) {
        $taxaction_include   =   array();   
        $taxaction_include[]    = sanitize_title ( esc_html (  wp_kses($_POST['action_values'] , $allowed_html ) ) );
      
        $action_array=array(
             'taxonomy'     => 'property_action_category',
             'field'        => 'slug',
             'terms'        => $taxaction_include
        );
    }
     
    
    
    if ( isset($_POST['location']) && $_POST['location']!='' ) {
        $taxlocation[] = sanitize_title (  esc_html( wp_kses($_POST['location'], $allowed_html) ) );
        $area_array = array(
            'taxonomy'     => 'property_area',
            'field'        => 'slug',
            'terms'        => $taxlocation
        );

        $city_array = array(
            'taxonomy'     => 'property_city',
            'field'        => 'slug',
            'terms'        => $taxlocation
        );
        
        $countystate_array = array(
            'taxonomy'      => 'property_county_state',
            'field'         => 'slug',
            'terms'         => $taxlocation
        );
        $location_array     = array( 
                                    'relation' => 'OR',
                                    $city_array,
                                    $area_array,
                                    $countystate_array
                                );
        }
     
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
  
        
        
    $adv6_taxonomy          =   wpresidence_get_option('wp_estate_adv6_taxonomy');
    if ( isset($_POST['picked_tax'] ) && $_POST['picked_tax']!='' && $_POST['picked_tax']!='all' ) {
        $taxaction_picked_tax  =   array();   
        $taxaction_picked_tax[]    = sanitize_title ( esc_html (  wp_kses($_POST['picked_tax'] , $allowed_html ) ) );
      
        $taxaction_picked_tax=array(
             'taxonomy'     => $adv6_taxonomy,
             'field'        => 'slug',
             'terms'        => $taxaction_picked_tax
        );
    }
    
  
    $features_array = wpestate_add_feature_to_search('ajax');
    
    $args = array(
        'cache_results'             =>  false,
        'update_post_meta_cache'    =>  false,
        'update_post_term_cache'    =>  false,
        
        'post_type'       => 'estate_property',
        'post_status'     => 'publish',
        'paged'           => $paged,
        'posts_per_page'  => -1,
        'meta_key'        => 'prop_featured',
        'orderby'         => 'meta_value',
        'order'           => 'DESC',
        'tax_query'       => array(
                                    'relation' => 'AND',
                                    $categ_array,
                                    $action_array,
                                    $taxaction_picked_tax,
                                    $location_array,
                                    $features_array
                               )
    );
    
    
    $features             = array();
    $features = wpestate_add_feature_to_search_ajax();
    if(!empty($features)){
        $args['post__in']=$features;
    }
        
    if(!empty($features)){
        $args['post__in']=$features;
    }
    return ($args);
 
}
endif;


if(!function_exists('wpestate_show_search_params_new')):
function wpestate_show_search_params_new($wpestate_included_ids,$args,$custom_advanced_search, $adv_search_what,$adv_search_how,$adv_search_label){

    global $amm_features;
    


  
 
    if( isset($args['tax_query'] )){
           
        foreach($args['tax_query'] as $key=>$query ){

       

            if( isset($query['relation'] ) && $query['relation']==='OR' ){
                $value=$query[0]['terms'][0];
                $value=  ucwords(str_replace('-', ' ', $value));
                print '<strong>'.esc_html__('County, City or Area is ','wpresidence').':</strong> '.rawurldecode($value);    
            }
            
            
          
            
          // had  $query['terms'][0] 
            if ( isset($query['taxonomy']) && isset( $query['terms']) && $query['taxonomy'] == 'property_category'){
                
                if( is_array( $query['terms'] ) ){
                    $term = $query['terms'][0];
                }else{
                    $term=$query['terms'];
                }
            
                $page = get_term_by( 'slug',$term ,'property_category');
                if(isset($page->name)){
                    print '<strong>'.esc_html__('Category','wpresidence').':</strong> '. $page->name .', ';  
                }
            }

            if ( isset($query['taxonomy']) && isset( $query['terms'] ) && $query['taxonomy']=='property_action_category' ){
                
                if( is_array( $query['terms'] ) ){
                   $term = $query['terms'][0];
                }else{
                    $term=$query['terms'];
                }
           
                
                $page = get_term_by( 'slug',$term,'property_action_category');
                
                if(isset($page->name)){
                    print '<strong>'.esc_html__('For','wpresidence').':</strong> '.$page->name.', ';  
                }
            }

            if ( isset($query['taxonomy']) && isset($query['terms']) && $query['taxonomy']=='property_city'){
                $page = get_term_by( 'slug',$query['terms'][0] ,'property_city');
                if(isset($page->name)){
                    print '<strong>'.esc_html__('City','wpresidence').':</strong> '.$page->name.', ';  
                }
            }

            if ( isset($query['taxonomy']) && isset($query['terms']) && $query['taxonomy']=='property_area'){
                $page = get_term_by( 'slug',$query['terms'][0] ,'property_area');
                if(isset($page->name)){
                    print '<strong>'.esc_html__('Area','wpresidence').':</strong> '.$page->name.', ';  
                }
            }
            if ( isset($query['taxonomy']) && isset($query['terms']) && $query['taxonomy']=='property_county_state'){
                $page = get_term_by( 'slug',$query['terms'][0] ,'property_county_state');
                if(isset($page->name)){
                    print '<strong>'.esc_html__('County / State','wpresidence').':</strong> '.$page->name.', ';  
                }
            }
         
        }
    }
   
    if(is_array($args['meta_query'])){
        wpestate_show_search_params_for_meta($args['meta_query'],$custom_advanced_search, $adv_search_what,$adv_search_how,$adv_search_label);
    }
    
    if(is_array($wpestate_included_ids)){
        wpestate_show_search_params_for_meta($wpestate_included_ids,$custom_advanced_search, $adv_search_what,$adv_search_how,$adv_search_label);
    }
    // on custom search
    // 
    // 
    // features and ammenities as tax
    if( isset($query['relation'] ) && $query['relation']==='AND' ){
        $features_array=$query;
        unset($features_array['relation']);
        print '<strong>'.esc_html__('Has','wpresidence').'</strong>: ';  
        foreach($features_array as $term){
            print trim($term['terms']).',';
        }
    }
            
}
endif;


if( !function_exists('wpestate_show_currency_save_search') ):
function wpestate_show_currency_save_search(){
    $custom_fields  = wpresidence_get_option( 'wp_estate_multi_curr', '');
      
    if( !empty($custom_fields) && isset($_COOKIE['my_custom_curr']) &&  isset($_COOKIE['my_custom_curr_pos']) &&  isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos']!=-1){
        $i=intval($_COOKIE['my_custom_curr_pos']);
        $wpestate_currency   =   $custom_fields[$i][0];
    }else{
        $wpestate_currency   =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
    }
    
    return $wpestate_currency;
}
endif;


if(!function_exists('wpestate_show_search_params_for_meta')):
function wpestate_show_search_params_for_meta($wpestate_included_ids,$custom_advanced_search, $adv_search_what,$adv_search_how,$adv_search_label){
    $admin_submission_array=array(
        'types'             =>esc_html__('types','wpresidence'),
        'categories'        =>esc_html__('categories','wpresidence'),
        'cities'            =>esc_html__('cities','wpresidence'),
        'areas'             =>esc_html__('areas','wpresidence'),
        'property price'    =>esc_html__('property price','wpresidence'),
        'property size'     =>esc_html__('property size','wpresidence'),
        'property lot size' =>esc_html__('property lot size','wpresidence'),
        'property rooms'    =>esc_html__('property rooms','wpresidence'),
        'property bedrooms' =>esc_html__('property bedrooms','wpresidence'),
        'property bathrooms'=>esc_html__('property bathrooms','wpresidence'),
        'property address'  =>esc_html__('property address','wpresidence'),
        'property county'   =>esc_html__('property county','wpresidence'),
        'property state'    =>esc_html__('property state','wpresidence'),
        'property zip'      =>esc_html__('property zip','wpresidence'),
        'property country'  =>esc_html__('property country','wpresidence'),
        'property status'   =>esc_html__('property status','wpresidence')
    );
  
  
    if(is_array($wpestate_included_ids)){
        foreach($wpestate_included_ids as $search_parameter){
          $label=str_replace('_',' ',$search_parameter['key']);

            if(array_key_exists ($label, $admin_submission_array)){
               $label=$admin_submission_array[$label];
            }else{
                if($custom_advanced_search==='yes'){ 
                    $label = wpestate_get_custom_field_name($search_parameter['key'],$adv_search_what,$adv_search_label);
                }
            }

            if($label=='hidden_address'){
                $label=esc_html__('address','wpresidence');
            }
            print '<strong>'.$label.'</strong> ';

            $where_currency =   esc_html ( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
            if ( isset($search_parameter['compare']) ){
                        if ($search_parameter['compare']=='BETWEEN'){
                            if($search_parameter['key']=='property_price'){
                                $show_currency= ' '.wpestate_show_currency_save_search();
                                $factor=1;
                                if( isset($_COOKIE['my_custom_curr_coef'])&& $_COOKIE['my_custom_curr_coef']!=0 && isset($_COOKIE['my_custom_curr']) &&  isset($_COOKIE['my_custom_curr_pos']) &&  isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos']!=-1){
                                    $factor=$factor*$_COOKIE['my_custom_curr_coef'];
                                }
                                if ($where_currency == 'before') {
                                    print ' '.esc_html__('between ','wpresidence').' '.$show_currency.' '.$search_parameter['value'][0]*$factor.' '.esc_html__('and','wpresidence').' '.$show_currency.' '.$search_parameter['value'][1]*$factor;
                                } else {
                                    print ' '.esc_html__('between','wpresidence').' '.$search_parameter['value'][0]*$factor.' '.$show_currency.' '.esc_html__('and','wpresidence').' '.$search_parameter['value'][1]*$factor.$show_currency;
                                }
                       
                            }else{
                                print ' '.esc_html__('between','wpresidence').' '.$search_parameter['value'][0].' '.esc_html__('and','wpresidence').' '.$search_parameter['value'][1];
                            }
                            print', ';   
                        }else if ($search_parameter['compare']=='LIKE'){
                            print  esc_html__(' similar with ','wpresidence').' <strong>'.str_replace('_',' ',$search_parameter['value']).'</strong>, '; 
                        }else if ($search_parameter['compare']=='CHAR'){
                            print esc_html__(' has','wpresidence').' <strong>'.str_replace('_',' ',$custm_name).'</strong>, ';       
                        }else if ($search_parameter['compare']=='='){
                            print  esc_html__(' equal with ','wpresidence').' '.$search_parameter['value'].', ';    
                        }else if ( $search_parameter['compare'] == '<=' ){
                            print esc_html__('smaller than ','wpresidence').' '.$search_parameter['value'].', '; 
                        }else if ( $search_parameter['compare'] == '>=' ){
                            print  esc_html__('bigger than ','wpresidence').' '.$search_parameter['value'].', '; 
                        }



            }
        }
    }
    
}
endif;







if(!function_exists('wpestate_show_search_params')):
function wpestate_show_search_params($args,$custom_advanced_search, $adv_search_what,$adv_search_how,$adv_search_label){
  

    if( isset($args['tax_query'] )){
           
        foreach($args['tax_query'] as $key=>$query ){

       

            if( isset($query['relation'] ) && $query['relation']==='OR' ){
                $value=$query[0]['terms'][0];
                $value=  ucwords(str_replace('-', ' ', $value));
                print '<strong>'.esc_html__('County, City or Area is ','wpresidence').':</strong> '.rawurldecode($value);    
            }
            
          // had  $query['terms'][0] 
            if ( isset($query['taxonomy']) && isset( $query['terms']) && $query['taxonomy'] == 'property_category'){
                
                if( is_array( $query['terms'] ) ){
                    $term = $query['terms'][0];
                }else{
                    $term=$query['terms'];
                }
            
                $page = get_term_by( 'slug',$term ,'property_category');
                if(isset($page->name)){
                    print '<strong>'.esc_html__('Category','wpresidence').':</strong> '. $page->name .', ';  
                }
            }

            if ( isset($query['taxonomy']) && isset( $query['terms'] ) && $query['taxonomy']=='property_action_category' ){
                
                if( is_array( $query['terms'] ) ){
                   $term = $query['terms'][0];
                }else{
                    $term=$query['terms'];
                }
           
                
                $page = get_term_by( 'slug',$term,'property_action_category');
                
                if(isset($page->name)){
                    print '<strong>'.esc_html__('For','wpresidence').':</strong> '.$page->name.', ';  
                }
            }

            if ( isset($query['taxonomy']) && isset($query['terms']) && $query['taxonomy']=='property_city'){
                $page = get_term_by( 'slug',$query['terms'][0] ,'property_city');
                if(isset($page->name)){
                    print '<strong>'.esc_html__('City','wpresidence').':</strong> '.$page->name.', ';  
                }
            }

            if ( isset($query['taxonomy']) && isset($query['terms']) && $query['taxonomy']=='property_area'){
                $page = get_term_by( 'slug',$query['terms'][0] ,'property_area');
                if(isset($page->name)){
                    print '<strong>'.esc_html__('Area','wpresidence').':</strong> '.$page->name.', ';  
                }
            }
            if ( isset($query['taxonomy']) && isset($query['terms']) && $query['taxonomy']=='property_county_state'){
                $page = get_term_by( 'slug',$query['terms'][0] ,'property_county_state');
                if(isset($page->name)){
                    print '<strong>'.esc_html__('County / State','wpresidence').':</strong> '.$page->name.', ';  
                }
            }
         
        }
    }
    

    $wpestate_currency               =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
    $where_currency         =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );

    if( isset($args['meta_query'] ) && $args['meta_query']!='' ){
        foreach($args['meta_query'] as $key=>$query ){
            $admin_submission_array=array(
                        'types'             =>esc_html__('types','wpresidence'),
                        'categories'        =>esc_html__('categories','wpresidence'),
                        'cities'            =>esc_html__('cities','wpresidence'),
                        'areas'             =>esc_html__('areas','wpresidence'),
                        'property price'    =>esc_html__('property price','wpresidence'),
                        'property size'     =>esc_html__('property size','wpresidence'),
                        'property lot size' =>esc_html__('property lot size','wpresidence'),
                        'property rooms'    =>esc_html__('property rooms','wpresidence'),
                        'property bedrooms' =>esc_html__('property bedrooms','wpresidence'),
                        'property bathrooms'=>esc_html__('property bathrooms','wpresidence'),
                        'property address'  =>esc_html__('property address','wpresidence'),
                        'property county'   =>esc_html__('property county','wpresidence'),
                        'property state'    =>esc_html__('property state','wpresidence'),
                        'property zip'      =>esc_html__('property zip','wpresidence'),
                        'property country'  =>esc_html__('property country','wpresidence'),
                        'property status'   =>esc_html__('property status','wpresidence')
            );
            $label=str_replace('_',' ',$query['key']);

            if(array_key_exists ($label, $admin_submission_array)){
               $label=$admin_submission_array[$label];
            }
            
            if($custom_advanced_search==='yes'){
                $custm_name = wpestate_get_custom_field_name($query['key'],$adv_search_what,$adv_search_label);
            
                if ( isset($query['compare']) ){
                    if ($query['compare']=='BETWEEN'){
                  
                            if($query['key']=='property_price'){
                                if($query['value'][0]==0){
                                    $min_val=0;
                                }else{
                                     $min_val=wpestate_show_price_floor($query['value'][0],$wpestate_currency,$where_currency,1);
                                }
                                print '<strong>'.esc_html__('price range from: ','wpresidence').'</strong> '. $min_val.' '.esc_html__('to','wpresidence').' '.wpestate_show_price_floor($query['value'][1],$wpestate_currency,$where_currency,1);   
                            }else{
                                print '<strong>'.$custm_name.'</strong> '.esc_html__('bigger than','wpresidence').' '.$query['value'].', ';   
                            }
                        
                    }else if ($query['compare']=='LIKE'){
                        print esc_html($label). esc_html__(' similar with ','wpresidence').' <strong>'.str_replace('_',' ',$query['value']).'</strong>, '; 
                    
                        
                    }else if ($query['compare']=='CHAR'){
                        print esc_html__(' has','wpresidence').' <strong>'.str_replace('_',' ',$custm_name).'</strong>, ';       
                    
                        
                    }else if ($query['compare']=='='){
                        print '<strong>'.$custm_name.'</strong> '. esc_html__(' equal with ','wpresidence').' <strong>'.$query['value'].'</strong>, ';    
                        
                    }else if ( $query['compare'] == '<=' ){
                        if($query['key']=='property_price'){
                            if(isset($query['value'])){
                                print wpestate_show_price_floor($query['value'],$wpestate_currency,$where_currency,1); 
                            }
                        }else{
                            print '<strong>'.$custm_name.'</strong> '.esc_html__('smaller than ','wpresidence').' '.$query['value'].', '; 
                        }

                    }else{  
                        if(isset($query['value'])){
                            if($query['key']=='property_price'){
                                print '<strong>'.esc_html__('price range from ','wpresidence').'</strong> '. wpestate_show_price_floor($query['value'],$wpestate_currency,$where_currency,1).' '.esc_html__('to','wpresidence').' ';   
                            }else{
                                print '<strong>'.$custm_name.'</strong> '.esc_html__('bigger than','wpresidence').' '.$query['value'].', ';   
                            }
                        }
                    }                
                }else{
                    print '<strong>'.$custm_name.':</strong> '.$query['value'].', ';
                } //end elese query compare


            }else{
                if ( isset( $query['compare'] ) ){
                    $custm_name = wpestate_get_custom_field_name($query['key'],$adv_search_what,$adv_search_label);

                    if ( $query['compare'] == 'CHAR' ){
                        print esc_html__(' has','wpresidence').' <strong>'.str_replace('_',' ',$custm_name).'</strong>, ';     
                    }else if ( $query['compare'] == '<=' ){
                        if($query['key']=='property_price'){
                          
                            print wpestate_show_price_floor($query['value'],$wpestate_currency,$where_currency,1); 
                            
                        }else{
                            print '<strong>'.$custm_name.'</strong> '.esc_html__('smaller than ','wpresidence').' '. wpestate_show_price_floor($query['value'],$wpestate_currency,$where_currency,1) .', '; 
                        }          
                    } else{
                         if($query['key']=='property_price'){
                            if($query['value'][0]==0){
                                $min_val=0;
                            }else{
                                 $min_val=wpestate_show_price_floor($query['value'][0],$wpestate_currency,$where_currency,1);
                            }
                            print '<strong>'.esc_html__('price range from: ','wpresidence').'</strong> '. $min_val.' '.esc_html__('to','wpresidence').' '.wpestate_show_price_floor($query['value'][1],$wpestate_currency,$where_currency,1);   
                        }else{
                            print '<strong>'.$custm_name.'</strong> '.esc_html__('bigger than','wpresidence').' '.$query['value'].', ';   
                        }        
                    }

                }else{
                    print '<strong>'.$label.':</strong> '.$query['value'].', ';
                } //end elese query compare

            }//end else if custom adv search

        }
    }

}
endif;

if( !function_exists('wpestate_search_with_keyword')):
function wpestate_search_with_keyword($adv_search_what,$adv_search_label ){
    $wpestate_keyword        =   ''; 
    $return_custom  =   array();
    $id_array       =   '';
    $allowed_html   =   array();
    foreach($adv_search_what as $key=>$term ){
        if( $term === 'keyword' ){
           
            $term         =     str_replace(' ', '_', $term);
            $slug         =     wpestate_limit45(sanitize_title( $term )); 
            $slug         =     sanitize_key($slug); 
            $string       =     wpestate_limit45 ( sanitize_title ($adv_search_label[$key]) );              
            $slug_name    =     sanitize_key($string);
            $return_custom['keyword']      =    esc_attr(  wp_kses ( $_GET[$slug_name], $allowed_html) );
           
        }else if($term === 'property id' || $term === 'id'){
            
            $term         =     str_replace(' ', '_', $term);
            $slug         =     wpestate_limit45(sanitize_title( $term )); 
            $slug         =     sanitize_key($slug); 
            $string       =     wpestate_limit45 ( sanitize_title ($adv_search_label[$key]) );              
            $slug_name    =     sanitize_key($string);
            
            if(isset($_GET[$slug_name])){
                $id_array     =     intval ($_GET[$slug_name]);
            }
            $return_custom['id_array'] = $id_array;        
            
        }   
        
            
    }
    return $return_custom;
}
endif;

if( !function_exists('wpestate_search_with_keyword_ajax')):
function wpestate_search_with_keyword_ajax($adv_search_what,$adv_search_label ){
    $wpestate_keyword        =   ''; 
    $return_custom  =   '';
    $id_array       =   '';
    $allowed_html   =   array();
    foreach($adv_search_what as $key=>$term ){
        if( $term === 'keyword' ){
            $return_custom  =   array();
            $term         =     str_replace(' ', '_', $term);
            $slug         =     wpestate_limit45(sanitize_title( $term )); 
            $slug         =     sanitize_key($slug); 
            $string       =     wpestate_limit45 ( sanitize_title ($adv_search_label[$key]) );              
            $slug_name    =     sanitize_key($string);
            $return_custom['keyword']      =    esc_attr(    wp_kses($_POST['val_holder'][$key],$allowed_html) );
        
        }else if($term === 'property id' || $term === 'id' ){
            $return_custom  =   array();
            $term         =     str_replace(' ', '_', $term);
            $slug         =     wpestate_limit45(sanitize_title( $term )); 
            $slug         =     sanitize_key($slug); 
            $string       =     wpestate_limit45 ( sanitize_title ($adv_search_label[$key]) );              
            $slug_name    =     sanitize_key($string);
            
      
                $id_array     =     intval ($_POST['val_holder'][$key]);
        
            $return_custom['id_array'] = $id_array;        
            
        }   
        
            
    }
    return $return_custom;
}
endif;
if( !function_exists('wpestate_search_with_keyword_ajax2')):
function wpestate_search_with_keyword_ajax2($adv_search_what,$adv_search_label ){
    $wpestate_keyword=''; 
    $allowed_html   =   array();
    $new_key        =   0;
    foreach($adv_search_what as $key=>$term ){
        if( $term === 'keyword' ){
            $new_key    =   $key+1;  
            $new_key    =   'val'.$new_key;
            $wpestate_keyword= wp_kses( $_POST['val_holder'][$key],$allowed_html );
       }
    }
    return $wpestate_keyword;
}
endif;