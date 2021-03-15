<?php
global $current_adv_filter_search_label;
global $current_adv_filter_category_label;
global $current_adv_filter_city_label;
global $current_adv_filter_area_label;
global $current_adv_filter_county_label;
global $wpestate_prop_unit;
$listing_filter         =   '';
$current_name      =    '';
$current_slug      =    '';
$listings_list     =    '';
$show_filter_area  =    '';
$current_adv_filter_search_meta     = 'Types';
$current_adv_filter_category_meta   = 'Categories';
$current_adv_filter_city_meta       = 'Cities';
$current_adv_filter_area_meta       = 'Areas';
$current_adv_filter_county_meta     = 'States';

if(isset($is_shortcode)){
    $show_filter_area='yes';
   
    
    
    $current_adv_filter_category_label  =   $filter_data['category']['label'];
    $current_adv_filter_category_meta   =   $filter_data['category']['meta'];
    $current_adv_filter_search_label    =   $filter_data['types']['label'];
    $current_adv_filter_search_meta     =   $filter_data['types']['meta'];        
    $current_adv_filter_county_label    =   $filter_data['county']['label'];
    $current_adv_filter_county_meta     =   $filter_data['county']['meta'];            
    $current_adv_filter_city_label      =   $filter_data['city']['label'];
    $current_adv_filter_city_meta       =   $filter_data['city']['meta'];
    $current_adv_filter_area_label      =   $filter_data['area']['label'];
    $current_adv_filter_area_meta       =   $filter_data['area']['meta'];
    
    $listing_filter                     =   $filter_data['listing_filter'];
}



if( isset($post->ID) ){
    $show_filter_area  =   get_post_meta($post->ID, 'show_filter_area', true);
}


        
if( is_tax() ){
    $show_filter_area = 'yes';
    $current_adv_filter_search_label    =esc_html__('Types','wpresidence');
    $current_adv_filter_category_label  =esc_html__('Categories','wpresidence');
    $current_adv_filter_city_label      =esc_html__('Cities','wpresidence');
    $current_adv_filter_area_label      =esc_html__('Areas','wpresidence');
    $current_adv_filter_county_label    =esc_html__('States','wpresidence');

    
    $taxonmy                            = get_query_var('taxonomy');
    $term                               = single_cat_title('',false);
    
    
    
    if ($taxonmy == 'property_city'){
        $current_adv_filter_city_label  =   ucwords( str_replace('-',' ',$term) );
        $current_adv_filter_city_meta   =   sanitize_title($term);
    }
    if ($taxonmy == 'property_area'){
        $current_adv_filter_area_label  =   ucwords( str_replace('-',' ',$term) );
        $current_adv_filter_area_meta   =   sanitize_title($term);
    }
    if ($taxonmy == 'property_category'){
        $current_adv_filter_category_label  =   ucwords( str_replace('-',' ',$term) );
        $current_adv_filter_category_meta   =   sanitize_title($term);
    }
    if ($taxonmy == 'property_action_category'){
        $current_adv_filter_search_label    =   ucwords( str_replace('-',' ',$term) );
        $current_adv_filter_search_meta     =   sanitize_title($term);
    }
    if ($taxonmy == 'property_county_state'){
        $current_adv_filter_county_label    =   ucwords( str_replace('-',' ',$term) );
        $current_adv_filter_county_meta     =   sanitize_title($term);
    }
    
}


if(is_page_template('property_list.php')){
    
    $current_adv_filter_search_action   =   get_post_meta ( $post->ID, 'adv_filter_search_action', true);
    if($current_adv_filter_search_action[0]=='all'){
        $current_adv_filter_search_label    =esc_html__('Types','wpresidence');
        $current_adv_filter_search_meta     = 'Types';
    }else{
        $current_adv_filter_search_label    =   ucwords( str_replace('-',' ',$current_adv_filter_search_action[0]) );
        $current_adv_filter_search_meta     =   sanitize_title($current_adv_filter_search_action[0]);
    }
   

    $current_adv_filter_search_category =   get_post_meta ( $post->ID, 'adv_filter_search_category', true);    
    if($current_adv_filter_search_category[0]=='all'){
        $current_adv_filter_category_label  =esc_html__('Categories','wpresidence');
        $current_adv_filter_category_meta   = 'Categories';
    }else{
        $current_adv_filter_category_label  =   ucwords( str_replace('-',' ',$current_adv_filter_search_category[0]) );
        $current_adv_filter_category_meta   =   sanitize_title($current_adv_filter_search_category[0]);
    }
     
   // county / state fielter
    $current_adv_filter_county        =   get_post_meta ( $post->ID, 'current_adv_filter_county', true);
    if(isset($current_adv_filter_county[0])){
        if($current_adv_filter_county[0]=='all'){
            $current_adv_filter_county_label      =esc_html__('States','wpresidence');
            $current_adv_filter_county_meta       = 'States';
        }else{
            $current_adv_filter_county_label  =   ucwords( str_replace('-',' ',$current_adv_filter_county[0]) );
            $current_adv_filter_county_meta   =   sanitize_title($current_adv_filter_county[0]);
        }
    }
   
   
    $current_adv_filter_area        =   get_post_meta ( $post->ID, 'current_adv_filter_area', true);
    if($current_adv_filter_area[0]=='all'){
        $current_adv_filter_area_label      =esc_html__('Areas','wpresidence');
        $current_adv_filter_area_meta       = 'Areas';
    }else{
        $current_adv_filter_area_label  =   ucwords( str_replace('-',' ',$current_adv_filter_area[0]) );
        $current_adv_filter_area_meta   =   sanitize_title($current_adv_filter_area[0]);
    }
    
    
    $current_adv_filter_city        =   get_post_meta ( $post->ID, 'current_adv_filter_city', true);
    if($current_adv_filter_city[0]=='all'){
        $current_adv_filter_city_label      =esc_html__('Cities','wpresidence');
        $current_adv_filter_city_meta       = 'Cities';
    }else{
        $current_adv_filter_city_label  =   ucwords( str_replace('-',' ',$current_adv_filter_city[0]) );
        $current_adv_filter_city_meta   =   sanitize_title($current_adv_filter_city[0]);
    }
}




$selected_order         = esc_html__('Sort by','wpresidence');

if( isset($post->ID) ){
    $listing_filter         = get_post_meta($post->ID, 'listing_filter',true );
}
$listing_filter_array   = array(
                            "1"=>esc_html__('Price High to Low','wpresidence'),
                            "2"=>esc_html__('Price Low to High','wpresidence'),
                            "3"=>esc_html__('Newest first','wpresidence'),
                            "4"=>esc_html__('Oldest first','wpresidence'),
                            "5"=>esc_html__('Bedrooms High to Low','wpresidence'),
                            "6"=>esc_html__('Bedrooms Low to high','wpresidence'),
                            "7"=>esc_html__('Bathrooms High to Low','wpresidence'),
                            "8"=>esc_html__('Bathrooms Low to high','wpresidence'),
                            "0"=>esc_html__('Default','wpresidence')
                        );
    

$args_local = wpestate_get_select_arguments();

foreach($listing_filter_array as $key=>$value){
    $listings_list.= '<li role="presentation" data-value="'.esc_html($key).'">'.esc_html($value).'</li>';//escaped above
    if($key==$listing_filter){
        $selected_order     =   $value;
        $selected_order_num =   $key;
    }
}   
      

$order_class='';
if( $show_filter_area != 'yes' ){
    $order_class=' order_filter_single ';  
}
        
if( $show_filter_area=='yes' ){

        if ( is_tax() ){
            $curent_term    =   get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
            $current_slug   =   $curent_term->slug;
            $current_name   =   $curent_term->name;
            $current_tax    =   $curent_term->taxonomy; 
        }


    $action_select_list =   wpestate_get_action_select_list($args_local);
    $categ_select_list  =   wpestate_get_category_select_list($args_local);
    $select_county_list =   wpestate_get_county_state_select_list($args_local);
    $select_city_list   =   wpestate_get_city_select_list($args_local); 
    $select_area_list   =   wpestate_get_area_select_list($args_local);
    
         
}// end if show filter


?>
    <?php if( $show_filter_area=='yes' ){  
        ?>
    <div class="listing_filters_head"> 
        <input type="hidden" id="page_idx" value="<?php 
                if ( !is_tax() && !is_category() ) { 
                    global $post;
                   print intval($post->ID);
                }?>">
      
         
                <div class="dropdown listing_filter_select filter_action_category" >
                  <div data-toggle="dropdown" id="a_filter_action" class="filter_menu_trigger" data-value="<?php print esc_attr($current_adv_filter_search_meta);?>"> <?php print esc_html($current_adv_filter_search_label);?> <span class="caret caret_filter"></span> </div>           
                  <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="a_filter_action">
                      <?php print trim($action_select_list);?>
                  </ul>        
                </div>

                <div class="dropdown listing_filter_select filter_category" >
                  <div data-toggle="dropdown" id="a_filter_categ" class="filter_menu_trigger" data-value="<?php print esc_attr($current_adv_filter_category_meta);?>"> <?php print esc_html($current_adv_filter_category_label);?> <span class="caret caret_filter"></span> </div>           
                  <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="a_filter_categ">
                      <?php print trim($categ_select_list);?>
                  </ul>        
                </div>                           
          

                <div class="dropdown listing_filter_select filter_county" >
                  <div data-toggle="dropdown" id="a_filter_county" class="filter_menu_trigger" data-value="<?php print esc_attr($current_adv_filter_county_meta);?>"> <?php print esc_html($current_adv_filter_county_label);?> <span class="caret caret_filter"></span> </div>           
                  <ul id="filter_county" class="dropdown-menu filter_menu" role="menu" aria-labelledby="a_filter_county">
                      <?php print trim($select_county_list);?>
                  </ul>        
                </div> 
	 
        
                <div class="dropdown listing_filter_select filter_city" >
                  <div data-toggle="dropdown" id="a_filter_cities" class="filter_menu_trigger" data-value="<?php print esc_attr($current_adv_filter_city_meta);?>"> <?php print esc_html($current_adv_filter_city_label);?> <span class="caret caret_filter"></span> </div>           
                  <ul id="filter_city" class="dropdown-menu filter_menu" role="menu" aria-labelledby="a_filter_cities">
                      <?php print trim($select_city_list);?>
                  </ul>        
                </div>  
       
                
                <div class="dropdown listing_filter_select filter_area" >
                  <div data-toggle="dropdown" id="a_filter_areas" class="filter_menu_trigger" data-value="<?php print esc_attr($current_adv_filter_area_meta);?>"><?php print esc_html($current_adv_filter_area_label);?><span class="caret caret_filter"></span> </div>           
                  <ul id="filter_area" class="dropdown-menu filter_menu" role="menu" aria-labelledby="a_filter_areas">
                      <?php print trim($select_area_list);?>
                  </ul>        
                </div> 
       
       
        
        <div class="dropdown listing_filter_select order_filter <?php print esc_attr($order_class);?>">
            <div data-toggle="dropdown" id="a_filter_order" class="filter_menu_trigger" data-value="<?php echo esc_html($selected_order_num);?>"> <?php echo esc_html($selected_order); ?> <span class="caret caret_filter"></span> </div>           
             <ul id="filter_order" class="dropdown-menu filter_menu" role="menu" aria-labelledby="a_filter_order">
                 <?php print trim($listings_list); ?>                   
             </ul>        
        </div> 


        <?php
        $prop_unit_list_class    =   '';
        $prop_unit_grid_class    =   'icon_selected';
        if($wpestate_prop_unit=='list'){
            $prop_unit_grid_class="";
            $prop_unit_list_class="icon_selected";
        }

        ?>    
        
        <div class="listing_filter_select listing_filter_views grid_filter_wiew">
            <div id="grid_view" class="<?php echo esc_html($prop_unit_grid_class); ?>"> 
                <i class="fas fa-th"></i>
            </div>
        </div>

        <div class="listing_filter_select listing_filter_views list_filter_wiew">
             <div id="list_view" class="<?php echo esc_html($prop_unit_list_class); ?>">
                <i class="fas fa-bars"></i>                  
             </div>
        </div>
          <div data-toggle="dropdown" id="a_filter_county" class="" data-value="<?php print esc_attr($current_adv_filter_county_meta);?>"></div> 
    </div> 
    <?php }else{
    ?>
        <div data-toggle="dropdown" id="a_filter_action" class="" data-value="<?php print esc_attr($current_adv_filter_search_meta);?>"></div>           
        <div data-toggle="dropdown" id="a_filter_categ" class="" data-value="<?php print esc_attr($current_adv_filter_category_meta);?>"></div>           
        <div data-toggle="dropdown" id="a_filter_cities" class="" data-value="<?php print esc_attr($current_adv_filter_city_meta);?>"></div>           
        <div data-toggle="dropdown" id="a_filter_areas" class="" data-value="<?php print esc_attr($current_adv_filter_area_meta);?>"></div>           
        <div data-toggle="dropdown" id="a_filter_county" class="" data-value="<?php print esc_attr($current_adv_filter_county_meta);?>"></div>           
              
    <?php
    } 
?>      