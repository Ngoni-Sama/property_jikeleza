<!-- begin sidebar -->
<div class="clearfix visible-xs"></div>
<?php 
global $wpestate_options;
global $current_adv_filter_search_action;
global $current_adv_filter_search_category;
global $current_adv_filter_area;
global $current_adv_filter_city;
global $current_adv_filter_county;


$sidebar_name               =   $wpestate_options['sidebar_name'];
$sidebar_class              =   $wpestate_options['sidebar_class'];
$args                       =   wpestate_get_select_arguments();
$action_select_list         =   wpestate_get_action_select_list($args);
$categ_select_list          =   wpestate_get_category_select_list($args);
$select_city_list           =   wpestate_get_city_select_list($args); 
$select_area_list           =   wpestate_get_area_select_list($args);
$select_county_state_list   =   wpestate_get_county_state_select_list($args);
$allowed_html               =   array();

if(isset($current_adv_filter_search_action[0]) && $current_adv_filter_search_action[0]!='' && $current_adv_filter_search_action[0]!='all'){
    $get_var_filter_search_type=  esc_html( wp_kses( $current_adv_filter_search_action[0], $allowed_html) );
    $full_name = get_term_by('slug',$get_var_filter_search_type,'property_action_category');
    $adv_actions_value=$adv_actions_value1= $full_name->name;
    $adv_actions_value1 = mb_strtolower ( str_replace(' ', '-', $adv_actions_value1) );
}else{
    $adv_actions_value=esc_html__('Types','wpresidence');
    $adv_actions_value1='all';
}


if(isset($current_adv_filter_search_category[0]) && $current_adv_filter_search_category[0]!='' && $current_adv_filter_search_category[0]!='all'){
    $get_var_filter_search_type=  esc_html( wp_kses( $current_adv_filter_search_category[0], $allowed_html) );
    $full_name = get_term_by('slug',$get_var_filter_search_type,'property_category');
    $adv_categ_value=$adv_categ_value1= $full_name->name;
    $adv_categ_value1 = mb_strtolower ( str_replace(' ', '-', $adv_categ_value1) );
}else{
    $adv_categ_value=esc_html__('Categories','wpresidence');
    $adv_categ_value1='all';
}

if(isset($current_adv_filter_city[0]) && $current_adv_filter_city[0]!='' && $current_adv_filter_city[0]!='all'){
    $get_var_filter_search_type=  esc_html( wp_kses( $current_adv_filter_city[0], $allowed_html) );
    $full_name = get_term_by('slug',$get_var_filter_search_type,'property_city');
    $advanced_city_value=$advanced_city_value1= $full_name->name;
    $advanced_city_value1 = mb_strtolower ( str_replace(' ', '-', $advanced_city_value1) );
}else{
    $advanced_city_value=esc_html__('Cities','wpresidence');
    $advanced_city_value1='all';
}

if(isset($current_adv_filter_area[0]) && $current_adv_filter_area[0]!='' && $current_adv_filter_area[0]!='all'){
    $get_var_filter_search_type=  esc_html( wp_kses( $current_adv_filter_area[0], $allowed_html) );
    $full_name = get_term_by('slug',$get_var_filter_search_type,'property_area');
    $advanced_area_value=$advanced_area_value1= $full_name->name;
    $advanced_area_value1 = mb_strtolower ( str_replace(' ', '-', $advanced_area_value1) );
}else{
    $advanced_area_value=esc_html__('Areas','wpresidence');
    $advanced_area_value1='all';
}

if(isset($current_adv_filter_county[0]) && $current_adv_filter_county[0]!='' && $current_adv_filter_county[0]!='all'){
    $get_var_filter_search_type=  esc_html( wp_kses( $current_adv_filter_county[0], $allowed_html) );
    $full_name = get_term_by('slug',$get_var_filter_search_type,'property_county_state');
    $advanced_county_value=$advanced_county_value1= $full_name->name;
    $advanced_county_value1 = mb_strtolower ( str_replace(' ', '-', $advanced_county_value) );
}else{
    $advanced_county_value=esc_html__('States','wpresidence');
    $advanced_county_value1='all';
}
 

?>

<div class="directory_sidebar col-xs-12 <?php print esc_attr($wpestate_options['sidebar_class']);?> widget-area-sidebar" id="primary2" >
<div class="directory_sidebar_wrapper">

    
    <div class="dropdown form-control directory-adv_actions">
        <div data-toggle="dropdown" id="sidebar-adv_actions" class="sidebar_filter_menu" data-value="<?php print esc_attr($adv_actions_value1);?>"> 
            <?php print esc_html($adv_actions_value);?>
            <span class="caret caret_sidebar"></span> 
        </div>              
        <input type="hidden" name="filter_search_action[]" value="<?php if(isset($current_adv_filter_search_action[0])){print ( esc_attr( wp_kses( $current_adv_filter_search_action[0], $allowed_html) ) );}?>">
        <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="sidebar-adv_actions">
            <?php print trim($action_select_list);?>
        </ul>        
    </div>
  
    
    
    
    
    <div class="dropdown form-control directory-adv_category">
        <div data-toggle="dropdown" id="sidebar-adv_categ" class="sidebar_filter_menu" data-value="<?php print esc_attr($adv_categ_value1);?>">
            <?php print esc_html($adv_categ_value);?>    
            <span class="caret caret_sidebar"></span>
        </div>           
        
        <input type="hidden" name="filter_search_type[]" value="<?php if(isset($current_adv_filter_search_category[0])){print ( esc_attr( wp_kses( $current_adv_filter_search_category[0], $allowed_html) ) );}?>">
        <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="sidebar-adv_categ">
            <?php print trim($categ_select_list);?>
        </ul>
    </div> 
  
    
     <div class="dropdown form-control directory-adv_conty" >
        <div data-toggle="dropdown" id="sidebar-advanced_county" class="sidebar_filter_menu" data-value="<?php print esc_attr($advanced_county_value1);?>">
            <?php print esc_html($advanced_county_value);?>   
            <span class="caret caret_sidebar"></span> 
        </div>           
        
        <input type="hidden" name="advanced_county" value="">
        <ul class="dropdown-menu filter_menu" role="menu" id="adv-search-countystate"  aria-labelledby="sidebar-advanced_area">
            <?php print trim($select_county_state_list);?>
        </ul>
    </div>
    
    <div class="dropdown form-control directory-adv_city" >
        <div data-toggle="dropdown" id="sidebar-advanced_city" class="sidebar_filter_menu" data-value="<?php print esc_attr($advanced_city_value1);?>">
            <?php print esc_html($advanced_city_value);?>    
            <span class="caret caret_sidebar"></span> 
        </div>           
        
        <input type="hidden" name="advanced_city" value="<?php if(isset($current_adv_filter_city[0])){print ( esc_attr( wp_kses( $current_adv_filter_city[0], $allowed_html) ) );}?>">
        <ul  class="dropdown-menu filter_menu" role="menu"  id="adv-search-city" aria-labelledby="sidebar-advanced_city">
            <?php print trim($select_city_list);?>
        </ul>
    </div>  
    
    
    
    <div class="dropdown form-control directory-adv_area" >
        <div data-toggle="dropdown" id="sidebar-advanced_area" class="sidebar_filter_menu" data-value="<?php print esc_attr($advanced_area_value1);?>">
            <?php print esc_html($advanced_area_value);?> 
            <span class="caret caret_sidebar"></span> 
        </div>           
        
        <input type="hidden" name="advanced_area" value="<?php if(isset($current_adv_filter_area[0])){print ( esc_attr( wp_kses( $current_adv_filter_area[0], $allowed_html) ) );}?>">
        <ul class="dropdown-menu filter_menu" role="menu" id="adv-search-area"  aria-labelledby="sidebar-advanced_area">
            <?php print trim($select_area_list);?>
        </ul>
    </div>
    

    
    
    <?php
    $where_currency         =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
    $wpestate_currency               =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
    $min_price_slider       =   ( floatval(wpresidence_get_option('wp_estate_show_slider_min_price','')) );
    $max_price_slider       =   ( floatval(wpresidence_get_option('wp_estate_show_slider_max_price','')) );  
    $price_slider_label     =   wpestate_show_price_label_slider($min_price_slider,$max_price_slider,$wpestate_currency,$where_currency);
    

    print'<div class="adv_search_slider">
        <p>
            <label for="amount_wd">'.esc_html__('Price range:','wpresidence').'</label>
            <span id="amount_wd"  class="wpresidence_slider_price" >'.esc_html($price_slider_label).'</span>
        </p>
        <div id="slider_price_widget"></div>';
            $custom_fields = wpresidence_get_option( 'wp_estate_multi_curr', '');
            if( !empty($custom_fields) && isset($_COOKIE['my_custom_curr']) &&  isset($_COOKIE['my_custom_curr_pos']) &&  isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos']!=-1){
                $i=intval($_COOKIE['my_custom_curr_pos']);

                if( !isset($_GET['price_low']) && !isset($_GET['price_max'])  ){
                    $min_price_slider       =   $min_price_slider * $custom_fields[$i][2];
                    $max_price_slider       =   $max_price_slider * $custom_fields[$i][2];
                }
            }
            print'
            <input type="hidden" id="price_low_widget"  name="price_low"  value="'.$min_price_slider.'>" />
            <input type="hidden" id="price_max_widget"  name="price_max"  value="'.$max_price_slider.'>" />
    </div>';
            
            
            
            
            
    ?>
    
     <?php
    $measure_sys    =   wpestate_get_meaurement_unit_formated();
    $dir_min_size   =   wpestate_convert_measure( get_post_meta($post->ID,'dir_min_size',true) );
    $dir_max_size   =   wpestate_convert_measure( get_post_meta($post->ID,'dir_max_size',true) )
    ?>
    <div class="directory_slider property_size_slider">
        <p>
            <label for="property_size"><?php  print esc_html__('Size:','wpresidence').' '; ?></label>
            <span id="property_size"><?php   print trim($dir_min_size.' '.$measure_sys).' '.esc_html__('to','wpresidence').' '.trim($dir_max_size.' '.$measure_sys);?></span>
        </p>
        <div id="slider_property_size_widget"></div>
        <input type="hidden" id="property_size_low"  name="property_size_low"  value="<?php print get_post_meta($post->ID,'dir_min_size',true)?>" />
        <input type="hidden" id="property_size_max"  name="property_size_max"  value="<?php print get_post_meta($post->ID,'dir_max_size',true)?>" />
   
    </div>
    
    
    <?php
    $dir_min_lot_size   =   wpestate_convert_measure(  get_post_meta($post->ID,'dir_min_lot_size',true) );
    $dir_max_lot_size   =   wpestate_convert_measure(  get_post_meta($post->ID,'dir_max_lot_size',true) );
    ?>
    
    <div class="directory_slider property_lot_size_slider">
        <p>
            <label for="property_lot_size"><?php print esc_html__('Lot Size:','wpresidence').' ';?></label>
            <span id="property_lot_size"><?php print trim($dir_min_lot_size.' '.$measure_sys).' '.esc_html__('to','wpresidence').' '.trim($dir_max_lot_size.' '.$measure_sys);?></span>
        </p>
        <div id="slider_property_lot_size_widget"></div>
        <input type="hidden" id="property_lot_size_low"  name="property_lot_size_low"  value="<?php print get_post_meta($post->ID,'dir_min_lot_size',true)?>" />
        <input type="hidden" id="property_lot_size_max"  name="property_lot_size_max"  value="<?php print get_post_meta($post->ID,'dir_max_lot_size',true)?>" />
   
    </div>
    
       
   
    
    <?php
    $dir_rooms_min  = get_post_meta($post->ID,'dir_rooms_min',true);
    $dir_rooms_max   = get_post_meta($post->ID,'dir_rooms_max',true);
    ?>
           
    <div class="directory_slider property_rooms_slider">
        <p>
            <label for="property_rooms"><?php print esc_html__('Property Rooms:','wpresidence').' ';?></label>
            <span id="property_rooms"><?php print esc_html($dir_rooms_min).' '.esc_html__('to','wpresidence').' '.esc_html($dir_rooms_max);?></span>
        </p>
        <div id="slider_property_rooms_widget"></div>
        <input type="hidden" id="property_rooms_low"  name="property_rooms_low"  value="<?php print get_post_meta($post->ID,'dir_rooms_min',true)?>" />
        <input type="hidden" id="property_rooms_max"  name="property_rooms_max"  value="<?php print get_post_meta($post->ID,'dir_rooms_max',true)?>" />
   
    </div>
    
    
    
    
    <?php
    $dir_bedrooms_min  = get_post_meta($post->ID,'dir_bedrooms_min',true);
    $dir_bedrooms_max   = get_post_meta($post->ID,'dir_bedrooms_max',true);
    ?>
    
    <div class="directory_slider property_bedrooms_slider">
        <p>
            <label for="property_bedrooms"><?php  print esc_html__('Property Bedrooms:','wpresidence').' ';?></label>
            <span id="property_bedrooms"><?php print esc_html($dir_bedrooms_min).' '.esc_html__('to','wpresidence').' '.esc_html($dir_bedrooms_max);?></span>
        </p>
        <div id="slider_property_bedrooms_widget"></div>
        <input type="hidden" id="property_bedrooms_low"  name="property_bedrooms_low"  value="<?php print get_post_meta($post->ID,'dir_bedrooms_min',true)?>" />
        <input type="hidden" id="property_bedrooms_max"  name="property_bedrooms_max"  value="<?php print get_post_meta($post->ID,'dir_bedrooms_max',true)?>" />
   
    </div>
    
    
 
    
    <?php
    $dir_bathrooms_min  = get_post_meta($post->ID,'dir_bathrooms_min',true);
    $dir_bedrooms_max   = get_post_meta($post->ID,'dir_bathrooms_max',true);
    ?>
    
    <div class="directory_slider property_bathrooms_slider">
        <p>
            <label for="property_bathrooms"><?php print esc_html__('Property Bathrooms:','wpresidence').' ';?></label>
            <span id="property_bathrooms"><?php print esc_html($dir_bathrooms_min).' '.esc_html__('to','wpresidence').' '.esc_html($dir_bedrooms_max);?></span>
        </p>
        <div id="slider_property_bathrooms_widget"></div>
        <input type="hidden" id="property_bathrooms_low"  name="property_bathrooms_low"  value="<?php print esc_html($dir_bathrooms_min);?>" />
        <input type="hidden" id="property_bathrooms_max"  name="property_bathrooms_max"  value="<?php print esc_html($dir_bedrooms_max);?>" />
   
    </div>
    
    
    <?php
     
    $status_values          =   esc_html( wpresidence_get_option('wp_estate_status_list') );
    $status_values_array    =   explode(",",$status_values);
    
    $property_status_array          =   get_terms( array(
                                    'taxonomy' => 'property_status',
                                    'hide_empty' => false,
                                ));
    
    $property_status        =   '';

    if(is_array($property_status_array)){
        foreach ($property_status_array as $key=>$term) {
            $property_status.='<option value="' . $term->name. '"';
            $property_status.='>' . $term->name . '</option>';
        }
    }
    
    ?>
    
    <div class="property_status_wrapper">
        <label for="property_status"><?php esc_html_e('Property Status:','wpresidence');?></label><br />
        <select id="property_status"   class="form-control" name="property_status">
        <option value=""><?php esc_html_e('Property Status','wpresidence');?></option>
        <?php print trim($property_status) ;?>
        </select>
    </div>
    
    
    <div class="property_keyword_wrapper">
        <label for="property_keyword"><?php esc_html_e('Property Keyword:','wpresidence');?></label><br />
        <input type="text" id="property_keyword" class="form-control" placeholder="<?php esc_html_e('keyword','wpresidence');?>">
    </div>
    
    <div class="extended_search_check_wrapper_directory">
        <?php
        $advanced_exteded   =   wpresidence_get_option( 'wp_estate_advanced_exteded' ); 
   $featured_terms     =   wpresidence_redux_advanced_exteded();
        if(is_array($advanced_exteded)):
            foreach($advanced_exteded as $checker => $slug){
                    $input_name   =     str_replace('%','', $slug);
                    $item_title   =     $featured_terms[$slug];
                    

                   
                    if($input_name!='none'){
                        print'
                        <div class="extended_search_checker '.$input_name.'_directory">
                            <input type="checkbox" id="'.$input_name.'widget" name="'.$input_name.'" name-title="'.$item_title.'"  value="1">
                            <label class="directory_checkbox" for="'.esc_attr($input_name).'widget">'.esc_html($item_title).'</label>
                        </div>';
                    }
            }
        endif;
        ?>
    </div>
    <input type="hidden" id="property_dir_per_page" value="<?php print intval( wpresidence_get_option('wp_estate_prop_no', '') )?>">
    <input type="hidden" id="property_dir_pagination" value="1">
    <input type="hidden" id="property_dir_done" value="0">
    
    </div>


</div>   


<?php
 $align_class = $wpestate_options['sidebar_class'];
?>

  <div class="col-xs-12  <?php print esc_attr($align_class);?> widget-area-sidebar widget_directory_sidebar" id="primary" >
        <?php  if ( is_active_sidebar( $wpestate_options['sidebar_name'] ) ) { ?>
            <ul class="xoxo">
                <?php   dynamic_sidebar( $wpestate_options['sidebar_name'] ); ?>
            </ul>
        <?php } ?>
    </div>

