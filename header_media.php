<?php 
$show_adv_search_status     =   wpresidence_get_option('wp_estate_show_adv_search','');
$global_header_type         =   wpresidence_get_option('wp_estate_header_type','');
$global_header              =   wpresidence_get_option('wp_estate_global_header','url');
$global_revolution_slider   =   wpresidence_get_option('wp_estate_global_revolution_slider','');
$adv_search_type            =   wpresidence_get_option('wp_estate_adv_search_type','');
$search_on_start            =   wpresidence_get_option('wp_estate_search_on_start','');
$post_id                    =   '';
if(isset($post->ID)){
    $post_id=$post->ID;
}

if($search_on_start=='yes' && !is_page_template( 'splash_page.php' ) ){

    wpestate_show_advanced_search($post_id);
}

?>

<div class="header_media with_search_<?php echo esc_html($adv_search_type);?>">
<?php
    if ( is_404() || is_category() || is_tax() || is_archive() || is_search() ){
        $header_type=0;
        if( is_category() || is_tax() || is_archive() ){
            $global_header_type         =   wpresidence_get_option('wp_estate_header_type_taxonomy','');
            
            if($global_header_type==3){
                $global_revolution_slider   =  wpresidence_get_option('wp_estate_header_taxonomy_revolution_slider','');
            }else if($global_header_type==1){
                $global_header= wpresidence_get_option('wp_estate_header_taxonomy_image','url');
    
                if($global_header==''){
                    if( wpestate_check_google_map_tax()){
                        $header_type=7;
                    }
                }
            }
            
            

        }
    }else{
        $header_type                =   get_post_meta ( $post->ID, 'header_type', true);
    }
    
    if(is_singular('estate_agency')){
        $header_type=21;
    }
    if(is_singular('estate_developer')){
        $header_type=22;
    }
    

    if( isset($post->ID) && !wpestate_half_map_conditions ($post->ID) ){
        $custom_image               =   esc_html( esc_html(get_post_meta($post->ID, 'page_custom_image', true)) );  
        $rev_slider                 =   esc_html( esc_html(get_post_meta($post->ID, 'rev_slider', true)) ); 

        ////////////////////////////////////////////////////////////////////////////
        // if property page
        ////////////////////////////////////////////////////////////////////////////


        if(is_singular('estate_property')){
            
            $header_type                =   get_post_meta ( $post->ID, 'header_type', true);
            if($header_type==0){ // global
                $header_type_property_page= esc_html ( wpresidence_get_option('wp_estate_header_type_property_page','') );

                if($header_type_property_page==0){
                    $header_type=1; //none
                }else if($header_type_property_page==1){
                    $header_type=2; //image
                    $custom_image =  wpresidence_get_option('wp_estate_header_property_page_image','url');
                }else if($header_type_property_page==2){
                    $header_type=3; //theme slider
                }else if($header_type_property_page==3){
                      $header_type=4; //rev slider
                      $rev_slider = wpresidence_get_option('wp_estate_header_property_page_revolution_slider','');
                }else if($header_type_property_page==4){
                        $header_type=5; //google maps
                }
            }
             
            $prpg_slider_type_status= esc_html ( wpresidence_get_option('wp_estate_global_prpg_slider_type','') );
            $local_pgpr_slider_type_status=  get_post_meta($post->ID, 'local_pgpr_slider_type', true);

            if($local_pgpr_slider_type_status=='global' && $prpg_slider_type_status === 'full width header'){
                $header_type=8;
            }
            if($local_pgpr_slider_type_status=='full width header'){
                $header_type=8;
            }
            if($local_pgpr_slider_type_status=='global' && $prpg_slider_type_status === 'multi image slider'){
                $header_type=9;
            }
            if($local_pgpr_slider_type_status=='multi image slider'){
                $header_type=9;
            }
            
            if($local_pgpr_slider_type_status=='animation slider'){
                $header_type = 'animation slider';
            }
            
            if($local_pgpr_slider_type_status=='global' && $prpg_slider_type_status === 'header masonry gallery'){
                $header_type=12;
            }
            if($local_pgpr_slider_type_status=='header masonry gallery'){
                $header_type=12;
            }
             
        }

        if( is_page_template( 'splash_page.php' ) ){
            $header_type=20;
        }

    }
    
    
  
    
    
    if( is_page_template( 'property_list_half.php' ) ){
        $header_type=5;
    }
    
    if( is_tax() &&  intval(wpresidence_get_option('wp_estate_property_list_type','') )==2 ){
        $header_type=5;
    }
    
    
    if(is_page_template( 'advanced_search_results.php' ) &&  intval(wpresidence_get_option('wp_estate_property_list_type_adv','') )==2  ){
        $header_type=5;
    }
    
   

    
        if (!$header_type==0){  // is not global settings
            switch ($header_type) {
                case 1://none
                    break;
                case 2://image
                    wpestate_header_image($custom_image);
                    break;
                case 3://theme slider
                    wpestate_present_theme_slider();
                    break;
                case 4://revolutin slider
                    if(function_exists('putRevSlider')){
                        putRevSlider($rev_slider);
                    }
                    break;
                case 5://google maps
                    if( isset($post->ID) && !wpestate_half_map_conditions ($post->ID) ){
                        include( locate_template('templates/google_maps_base.php' ) ); 
                    }
                    break;
                case 6:
                    wpestate_video_header();
                    break;
                case 7://google maps
                    include( locate_template('templates/header_taxonomy.php') ); 
                    break;
                case 8:
                    wpestate_listing_full_width_slider($post->ID);
                    break;
                case 9:
                    wpestate_multi_image_slider($post->ID);
                    break;
                 case 12:
                    wpestate_header_masonry_gallery($post->ID);
                    break;
                case 20:
                    wpestate_splash_page_header();
                    break;
                case 21;
                    include( locate_template ('templates/header_agency.php') ); 
                    break;
                case 22;
                    include( locate_template ('templates/header_developer.php') ); 
                    break;
                    
                case 'animation slider';
                    include( locate_template ('templates/property_animation_slider.php') ); 
                    break;
                case 11;
                    include( locate_template ('templates/property_slider_tour.php') ); 
                    break;
               
            }
        }else{    // we don't have particular settings - applt global header
            switch ($global_header_type) {
                case 0://image
                    break;
                case 1://image
                  
                    wpestate_header_image($global_header);
                    break;
                case 2://theme slider
                    wpestate_present_theme_slider();
                    break;
                case 3://revolutin slider
                  
                    if(function_exists('putRevSlider')){
                        putRevSlider($global_revolution_slider);
                    }
                    break;
                case 4://google maps
                    include( locate_template('templates/google_maps_base.php') ); 
                    break;
                case 8:
                    wpestate_listing_full_width_slider($post->ID);
                    break;
            }

        } // end if header
    
  
  
    $global_header_type         =   wpresidence_get_option('wp_estate_header_type','');
    $show_adv_search_slider     =   wpresidence_get_option('wp_estate_show_adv_search_slider','');
    $show_mobile                =   0;  

    if ( is_404() || is_category() || is_tax() || is_archive() || is_search() ){
        $header_type=0;
    }else{
        $header_type                =   get_post_meta ( $post->ID, 'header_type', true);
    }

    if( wpestate_float_search_placement_new($post_id) ||  is_page_template( 'splash_page.php' )  ){
        if($header_type==1 || ( $global_header_type==0 && $header_type==0) ){
            //nothing
        }else{
           include( locate_template( 'templates/advanced_search.php') );
        }
    }
    
    if( is_page_template( 'splash_page.php' ) ){
        if( wp_is_mobile() ){
            include( locate_template( 'templates/adv_search_mobile.php') );
        }
    }
?>   
    
    
    <?php 
        if(is_page_template( 'splash_page.php' ) ){
            print '<div class="splash_page_widgets_wrapper">';
                if ( is_active_sidebar( 'splash-page_bottom-left-widget-area' ) ) {
                    print ' <div class="splash-left-widet">
                        <ul class="xoxo">';
                            dynamic_sidebar('splash-page_bottom-left-widget-area');
                        print'</ul>    
                    </div> '; 
                }

                if ( is_active_sidebar( 'splash-page_bottom-right-widget-area' ) ) {
                    print'
                    <div class="splash-right-widet">
                        <ul class="xoxo">';
                           dynamic_sidebar('splash-page_bottom-right-widget-area');
                        print'</ul>
                    </div>';
                }
            print '</div>';
        }
    
    ?>
</div>

<?php 
if($search_on_start=='no'  && !is_page_template( 'splash_page.php' )){
    if( ( is_category() || is_tax() || is_archive() ) &&  wpresidence_get_option('wp_estate_use_float_search_form','')=='yes' ){
        
    }else{ 
    
        wpestate_show_advanced_search($post_id);
    }
}

if( !wpestate_half_map_conditions('') && !wpestate_is_user_dashboard() && !is_page_template( 'splash_page.php' ) ){
    if( wp_is_mobile() ){
        include( locate_template( 'templates/adv_search_mobile.php' ) );
    }
}?>