<?php
global $prop_selection;
global $wpestate_options;
global $num;
global $args;
global $custom_advanced_search;
global $adv_search_what;
global $adv_search_how;
global $adv_search_label;
global $prop_unit_class;
global $show_compare_only;
global $wpestate_property_unit_slider;
global $custom_post_type;
global $col_class;
global $wpestate_custom_unit_structure;
global $wpestate_no_listins_per_row;
global $wpestate_uset_unit;
global $wpestate_included_ids;
global $wpestate_prop_unit;
$wpestate_uset_unit         =   intval ( wpresidence_get_option('wpestate_uset_unit','') );
$wpestate_no_listins_per_row=   intval( wpresidence_get_option('wp_estate_listings_per_row', '') );
$wpestate_custom_unit_structure      =   wpresidence_get_option('wpestate_property_unit_structure');
$taxonmy                    =   get_query_var('taxonomy');
$term                       =   get_query_var( 'term' );
$wpestate_property_unit_slider       =   wpresidence_get_option('wp_estate_prop_list_slider','');
$property_card_type         =   intval(wpresidence_get_option('wp_estate_unit_card_type'));
$property_card_type_string  =   '';
if($property_card_type==0){
    $property_card_type_string='';
}else{
    $property_card_type_string='_type'.$property_card_type;
}

if( is_tax() && $custom_post_type=='estate_agent'){
global $wpestate_no_listins_per_row;
$wpestate_no_listins_per_row       =   intval( wpresidence_get_option('wp_estate_agent_listings_per_row', '') );

$col_class=4;
if($wpestate_options['content_class']=='col-md-12'){
    $col_class=3;
}

if($wpestate_no_listins_per_row==3){
    $col_class  =   '6';
    $col_org    =   6;
    if($wpestate_options['content_class']=='col-md-12'){
        $col_class  =   '4';
        $col_org    =   4;
    }
}else{   
    $col_class  =   '4';
    $col_org    =   4;
    if($wpestate_options['content_class']=='col-md-12'){
        $col_class  =   '3';
        $col_org    =   3;
    }
}

}
   


$selected_order         =   esc_html__('Sort by','wpresidence');
$listing_filter         =   '';
$listings_list          =   '';
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
    

$args = wpestate_get_select_arguments();


foreach($listing_filter_array as $key=>$value){
    $listings_list.= '<li role="presentation" data-value="'.$key.'">'.$value.'</li>';//escaped above

    if($key==$listing_filter){
        $selected_order     =   $value;
        $selected_order_num =   $key;
    }
}   
      

$order_class='';

?>

<div class="row">
    <?php get_template_part('templates/breadcrumbs'); ?>
    <div class=" <?php print esc_html($wpestate_options['content_class']);?> ">
        
        <div class="single-content" style="margin-bottom:20px;">
            <?php 
                if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) == 'yes') { ?>
                    <h1 class="entry-title title_prop"><?php the_title(); ?></h1>                
            <?php 
                } 
            ?>
            <div class="directory_content_wrapper">       
                <?php   
                    $page_object = get_page( $post->ID );
                    print wp_kses_post($page_object->post_content);
                ?>
            </div>     
        
        </div>

              
        <!--Filters starts here-->     
        <div class="listing_filters_head_directory"> 
            <input type="hidden" id="page_idx" value="<?php 
            if ( !is_tax() && !is_category() ) { 
               print intval($post->ID);
            }?>">

            <div class="dropdown listing_filter_select order_filter <?php print esc_attr($order_class);?>">
                <div data-toggle="dropdown" id="a_filter_order_directory" class="filter_menu_trigger" data-value="<?php echo esc_attr($selected_order_num);?>"> <?php echo esc_html($selected_order); ?> <span class="caret caret_filter"></span> </div>           
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
        
            <div class="listing_filter_select listing_filter_views">
                <div id="grid_view" class="<?php echo esc_html($prop_unit_grid_class); ?>"> 
                    <i class="fas fa-th"></i>
                </div>
            </div>

            <div class="listing_filter_select listing_filter_views">
                 <div id="list_view" class="<?php echo esc_html($prop_unit_list_class); ?>">
                     <i class="fas fa-bars"></i>                  
                 </div>
            </div>
           
    </div> 
        <!--Filters Ends here-->   
  
        
        <!-- Listings starts here -->                   
       
        
        <?php if( $custom_post_type=='estate_agent'){?>
            <div id=" listing_ajax_container_agent_tax" class="<?php echo esc_html($prop_unit_class);?>"></div> 
        <?php } ?> 
             
        <div id="listing_ajax_container" class="<?php echo esc_html($prop_unit_class);?>"> 
        
            <?php
            global $tax_categ_picked;
            global $tax_action_picked;
            global $tax_city_picked;
            global $taxa_area_picked;
            ?>
            
            <input type="hidden" id="tax_categ_picked" value="<?php print esc_html( $tax_categ_picked);?>">
            <input type="hidden" id="tax_action_picked" value="<?php print esc_html($tax_action_picked);?>">
            <input type="hidden" id="tax_city_picked" value="<?php print esc_html($tax_city_picked);?>">
            <input type="hidden" id="taxa_area_picked" value="<?php print esc_html($taxa_area_picked);?>">
            <?php
           

            $show_compare_only  =   'yes';
            $counter = 0;
            if( is_page_template('advanced_search_results.php') ) {
                $first=0;
                if ($prop_selection->have_posts()){    
                    while ($prop_selection->have_posts()): $prop_selection->the_post();
                        if( isset($_GET['is2']) && $_GET['is2']==1 && $first==0 ){
                            $gmap_lat    =   esc_html(get_post_meta($post->ID, 'property_latitude', true));
                            $gmap_long   =   esc_html(get_post_meta($post->ID, 'property_longitude', true));
                            if($gmap_lat!='' && $gmap_long!=''){
                                print '<span style="display:none" id="basepoint" data-lat="'.esc_attr($gmap_lat).'" data-long="'.esc_attr($gmap_long).'"></span>';
                                $first=1;
                            }
                        }

                        include( locate_template('templates/property_unit'.$property_card_type_string.'.php' ) );
                        
                        
                    endwhile;
                }else{   
                    print '<div class="bottom_sixty">';
                    esc_html_e('We didn\'t find any results. Please try again with different search parameters. ','wpresidence');
                    print '</div>';
                }  
            }else{
                if( $prop_selection->have_posts() ){
                    
                    while ($prop_selection->have_posts()): $prop_selection->the_post(); 
                        if($custom_post_type!='estate_agent'){
                            include( locate_template('templates/property_unit'.$property_card_type_string.'.php' ) );
                        }else{
                            print '<div class="col-md-'.$col_class.' listing_wrapper">';
                                get_template_part('templates/agent_unit'); 
                            print '</div>';
                        }
                       
                    endwhile;
                }else{
                    if($custom_post_type!='estate_agent'){
                        print '<h4 class="nothing">'.esc_html__('There are no properties listed on this page at this moment. Please try again later. ','wpresidence').'</h4>';
                    }else{
                        print '<h4 class="nothing">'.esc_html__('There are no agents listed on this page at this moment. Please try again later. ','wpresidence').'</h4>';
                    }
                }
            }

            wp_reset_query();               
        ?>
            
        </div>
        <?php  get_template_part('templates/spiner'); ?> 
            
        <?php   if( $prop_selection->have_posts() ){?> 
            <div id="directory_load_more" class="wpresidence_button"><?php esc_html_e('Load More Listings','wpresidence')?></div>  
        <?php } ?>
        <!-- Listings Ends  here --> 
        
        <?php   
            if (   !is_tax() ){
                print '   <div class="single-content">';
                $property_list_second_content = get_post_meta($post->ID, 'property_list_second_content', true);
                echo do_shortcode($property_list_second_content);
                print '</div>';
            }
          ?>
           
    <?php 
    if( wp_is_mobile() ){
    ?>
        <div class="col-xs-12 <?php print esc_html($wpestate_options['sidebar_class']);?> widget-area-sidebar" id="primary" >
           
            <?php  if ( is_active_sidebar( $wpestate_options['sidebar_name'] ) ) { ?>
                <ul class="xoxo">
                    <?php 
                        dynamic_sidebar( $wpestate_options['sidebar_name'] ); 
                    ?>
                </ul>
            <?php } ?>
        </div>

    <?php 
    } 
    ?>    
    </div><!-- end 9col container-->

<?php   include( locate_template('templates/directory_filters.php')); ?>
</div>   