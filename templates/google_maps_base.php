<!-- Google Map -->
<?php
global $post;

$gmap_class="";

if( !is_tax() && !is_category() && isset($post->ID) ){
    $gmap_lat           =   esc_html( get_post_meta($post->ID, 'property_latitude', true));
    $gmap_long          =   esc_html( get_post_meta($post->ID, 'property_longitude', true));
    $property_add_on    =   ' data-post_id="'.esc_attr($post->ID).'" data-cur_lat="'.esc_attr($gmap_lat).'" data-cur_long="'.esc_attr($gmap_long).'" ';
    $closed_height      =   wpestate_get_current_map_height($post->ID);
    $open_height        =   wpestate_get_map_open_height($post->ID);
    $open_close_status  =   wpestate_get_map_open_close_status($post->ID);
}else{
    $gmap_lat           =   esc_html( wpresidence_get_option('wp_estate_general_latitude','') );
    $gmap_long          =   esc_html( wpresidence_get_option('wp_estate_general_longitude','') );
    $property_add_on    =   ' data-post_id="" data-cur_lat="'.esc_attr($gmap_lat).'" data-cur_long="'.esc_attr($gmap_long).'" ';
    $closed_height      =   intval (wpresidence_get_option('wp_estate_min_height',''));
    $open_height        =   wpresidence_get_option('wp_estate_max_height','');
    $open_close_status  =   esc_html( wpresidence_get_option('wp_estate_keep_min','' ) ); 
}

$keep_min_status    = esc_html( wpresidence_get_option('wp_estate_keep_max','') );
if($keep_min_status=='yes'){
    $gmap_class     =   " full_height_map ";
    $closed_height  =   "1000";
}
if( !is_tax() && !is_category() && isset($post->ID) ){
    $keep_min_status    = esc_html ( get_post_meta($post->ID, 'keep_max', true) );
    if($keep_min_status=='yes'){
        $gmap_class     =   " full_height_map ";
        $closed_height  =   "1000";
    }
}

$display_contact=0;
if(isset($map_height) && intval($map_height)!==0 ){
    $closed_height=$map_height;
    $gmap_class.=' wpestate_full_map_shortcode ';
    $display_map_controls=1;
}

if(is_page_template('contact_page.php') || 
        ( isset($map_shortcode_for) && $map_shortcode_for=='contact' && $map_shorcode_show_contact_form=='yes') ){
    $display_contact=1;
    $gmap_class.=" contact_map ";
    
}


?>



<div id="gmap_wrapper"  class="<?php print esc_attr($gmap_class); echo wpresidence_return_class_leaflet(); ?>" <?php print trim($property_add_on); ?> style="height:<?php print intval($closed_height);?>px"  >
    
    <?php
        if($display_contact==1){
            include(locate_template('templates/google-map-contact-details.php'));
        }
    
    ?>
    
    <div id="googleMap" class="<?php print esc_attr($gmap_class);?>" style="height:<?php print intval($closed_height);?>px">   
    </div>    

    <div class="tooltip"> <?php esc_html_e('click to enable zoom','wpresidence');?></div>

    <div id="gmap-loading"><?php esc_html_e('loading...','wpresidence');?> 
       <div class="new_prelader"></div>
    </div>


    <div id="gmap-noresult">
       <?php esc_html_e('We didn\'t find any results','wpresidence');?>
    </div>


    <div class="gmap-controls <?php echo wpresidence_return_class_leaflet(); ?> ">
    <?php
    // show or not the open close map button
    if( isset($post->ID) && !is_tax() && !is_category()){
        if (wpestate_get_map_open_close_status($post->ID) == 0 ){
            print ' <div id="openmap"><i class="fas fa-angle-down"></i>'.esc_html__('open map','wpresidence').'</div>';
        }
    }else{
        if( esc_html( wpresidence_get_option('wp_estate_keep_min','' ) )=='no'){
            print ' <div id="openmap"><i class="fas fa-angle-down"></i>'.esc_html__('open map','wpresidence').'</div>';
        }
    }
    ?>
    <div id="gmap-control">
        <span  id="map-view"><i class="far fa-image"></i><?php esc_html_e('View','wpresidence');?></span>
            <span id="map-view-roadmap"     class="map-type"><?php esc_html_e('Roadmap','wpresidence');?></span>
            <span id="map-view-satellite"   class="map-type"><?php esc_html_e('Satellite','wpresidence');?></span>
            <span id="map-view-hybrid"      class="map-type"><?php esc_html_e('Hybrid','wpresidence');?></span>
            <span id="map-view-terrain"     class="map-type"><?php esc_html_e('Terrain','wpresidence');?></span>
        <span  id="geolocation-button"><i class="fas fa-map-marker-alt"></i><?php esc_html_e('My Location','wpresidence');?></span>
        <span  id="gmap-full" ><i class="fas fa-arrows-alt"></i><?php esc_html_e('Fullscreen','wpresidence');?></span>
    <?php     
        if( !is_singular('estate_property') ){ ?>
            <span  id="gmap-prev"><i class="fas fa-chevron-left"></i><?php esc_html_e('Prev','wpresidence');?></span>
            <span  id="gmap-next" ><?php esc_html_e('Next','wpresidence');?><i class="fas fa-chevron-right"></i></span>

    <?php }
        $street_view_class=" ";?>
    </div>

    <?php 

        if(  wpresidence_get_option('wp_estate_show_g_search','') ==='yes' && intval( wpresidence_get_option('wp_estate_kind_of_map','')) === 1 ){
            $street_view_class=" lower_street ";
            echo '<input type="text" id="google-default-search" name="google-default-search" placeholder="'.esc_html__('Google Maps Search','wpresidence').'" value="" class="advanced_select  form-control"> '; 
        }
    ?>


    <div id="gmapzoomplus"><i class="fas fa-plus"></i> </div>
    <div id="gmapzoomminus"><i class="fas fa-minus"></i></div>

    <?php 
        if( is_singular('estate_property') ){
            if ( get_post_meta($post->ID, 'property_google_view', true) ==1){
                ?>
                <div id="street-view" class="<?php echo esc_html($street_view_class);echo wpresidence_return_class_leaflet(); ?>"><i class="fas fa-location-arrow"></i> <?php esc_html_e('Street View','wpresidence');?> </div>
                <?php   
            } 
        }
    ?>

    <?php echo wpestate_show_poi_onmap();?>
</div>
 

</div>    
<!-- END Google Map --> 