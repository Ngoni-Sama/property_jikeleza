<?php



if( !function_exists('wpestate_theme_slider_contact') ):
function wpestate_theme_slider_contact($propid){
            ob_start();
          
            $slider_property_id=$propid;
           
            $realtor_details = wpestate_return_agent_details($propid);
        
            print '<div class="theme_slider_contact_wrapper">';
            
                    if($realtor_details['link']!=''){
                        print '<a href="'.esc_url($realtor_details['link']).'"><div class="theme_slider_agent" style="background-image:url('.esc_url($realtor_details['realtor_image']).');"></div></a>';
                    }else{
                        print '<div class="theme_slider_agent" style="background-image:url('.esc_url($realtor_details['realtor_image']).');"></div>';
                    }
                    
                    print '<div class="theme_slider_agent_name" >';
                    if($realtor_details['link']!=''){
                        print '<a href="'.esc_url($realtor_details['link']).'">'.esc_html($realtor_details['realtor_name']).'</a>';
                    }else{
                        print esc_html($realtor_details['realtor_name']);
                    }
                    
                print '</div>
                    <div class="wpestate_theme_slider_contact_agent">'.esc_html('Contact Agent','wpesidence').'</div>
                </div>';
            
            
            
            print '<div class="theme_slider_contact_form_wrapper">
                <div class="theme_slider_details_modal_close">
                    <svg enable-background="new 0 0 413.348 413.348" viewBox="0 0 413.348 413.348" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m413.348 24.354-24.354-24.354-182.32 182.32-182.32-182.32-24.354 24.354 182.32 182.32-182.32 182.32 24.354 24.354 182.32-182.32 182.32 182.32 24.354-24.354-182.32-182.32z"/></svg>
                </div>';
            
            include( locate_template( 'templates/agent_contact.php') );  
            print '</div>';
            $contact_forms = ob_get_contents();
    ob_end_clean();
    
    return $contact_forms;
}
endif;

if( !function_exists('wpestate_present_theme_slider') ):
    function wpestate_present_theme_slider(){
    
        
        $theme_slider   =   wpresidence_get_option( 'wp_estate_theme_slider_type'); 
    
        if($theme_slider=='type2'){
            wpestate_present_theme_slider_type2();
            return;
        }
        
        if($theme_slider=='type3'){
            wpestate_present_theme_slider_type3();
            return;
        }
        
        $attr=array(
            'class'	=>'img-responsive'
        );

        $theme_slider   =   wpresidence_get_option( 'wp_estate_theme_slider', ''); 

        if(empty($theme_slider)){
            return; // no listings in slider - just return
        }
        $wpestate_currency       =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
        $where_currency =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );

        $counter    =   0;
        $slides     =   '';
        $indicators =   '';
        $args = array(  
                    'post_type'        =>   'estate_property',
                    'post_status'      =>   'publish',
                    'post__in'         =>   $theme_slider,
                    'posts_per_page'   =>   -1
                  );
       
        $recent_posts = new WP_Query($args);
        $slider_cycle   =   wpresidence_get_option( 'wp_estate_slider_cycle', ''); 
        if($slider_cycle == 0){
            $slider_cycle = false;
        }
        
        $extended_search    =   wpresidence_get_option('wp_estate_show_adv_search_extended','');
        $extended_class     =   '';

        if ( $extended_search =='yes' ){
            $extended_class='theme_slider_extended';
        }
        $theme_slider_height   =   wpresidence_get_option( 'wp_estate_theme_slider_height', '');
        
        if($theme_slider_height==0){
            $theme_slider_height=900;
            $extended_class .= " full_screen_yes ";
        }
        
        print '<div class="theme_slider_wrapper '.$extended_class.' carousel  slide" data-ride="carousel" data-interval="'.esc_attr($slider_cycle).'" id="estate-carousel"  style="height:'.$theme_slider_height.'px;">';

        while ($recent_posts->have_posts()): $recent_posts->the_post();
               $theid=get_the_ID();
             

                $preview        =   wp_get_attachment_image_src(get_post_thumbnail_id($theid), 'property_full_map');
                if($preview[0]==''){
                    $preview[0]= get_theme_file_uri('/img/defaults/default_property_featured.jpg');
                }

               if($counter==0){
                    $active=" active ";
                }else{
                    $active=" ";
                }
                $measure_sys    =   wpresidence_get_option('wp_estate_measure_sys','');
                $price          =   floatval( get_post_meta($theid, 'property_price', true) );
                $price_label    =   '<span class="">'.esc_html ( get_post_meta($theid, 'property_label', true) ).'</span>';
                $price_label_before   =   '<span class="">'.esc_html ( get_post_meta($theid, 'property_label_before', true) ).'</span>';
                $beds           =   floatval( get_post_meta($theid, 'property_bedrooms', true) );
                $baths          =   floatval( get_post_meta($theid, 'property_bathrooms', true) );
                $size           =   wpestate_get_converted_measure( $theid, 'property_size' );
                
                if ($price != 0) {
                   $price  = wpestate_show_price($theid,$wpestate_currency,$where_currency,1);  
                }else{
                    $price=$price_label_before.''.$price_label;
                }


               $slides.= '
               <div class="item theme_slider_classic '.$active.'" data-href="'.esc_url( get_permalink()).'" style="background-image:url('.esc_url($preview[0]).');height:'.$theme_slider_height.'px;">
                  
                    
   
                <div class="featured_gradient"></div>
                

                <div class="slider-content-wrapper">
                    <div class="slider-content">
                        <h3><a href="'. esc_url( get_permalink() ).'">';
                            $title = get_the_title();

                            $slides.= mb_substr( $title,0,28); 
                            if(mb_strlen($title)>28){
                                $slides.= '...';   
                            }         
                            $slides.='</a> </h3>
                                <span> '. wpestate_strip_words( get_the_excerpt(),20).'...';
                             
                            $slides.=wpestate_theme_slider_contact($theid); 
                 $slides.='   <div class="theme-slider-price">
                            '.$price.'  
                            <div class="listing-details">';
                            if($beds!=0){
                                $slides.= '<span class="inforoom"><svg viewBox="0 0 90 50" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M16 18C16 13.6 19.6 10 24 10C28.4 10 32 13.6 32 18C32 22.4 28.4 26 24 26C19.6 26 16 22.4 16 18ZM88 30H12V2C12 0.9 11.1 0 10 0H2C0.9 0 0 0.9 0 2V50H12V42H78V50H80H82H86H88H90V32C90 30.9 89.1 30 88 30ZM74 12H38C36.9 12 36 12.9 36 14V26H88C88 18.3 81.7 12 74 12Z" fill="black"/>
</svg>'.$beds.'</span>';
                            }
                            if($baths!=0){
                                $slides.= '<span class="infobath">  <svg  viewBox="0 0 56 59" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M2 37C2.00973 43.673 5.92011 49.724 12 52.4742V58C12.0016 58.5516 12.4484 58.9984 13 59H15C15.5516 58.9984 15.9984 58.5516 16 58V53.7186C16.9897 53.9011 17.9936 53.9953 19 54H37C38.0064 53.9953 39.0103 53.9011 40 53.7186V58C40.0016 58.5516 40.4484 58.9984 41 59H43C43.5516 58.9984 43.9984 58.5516 44 58V52.4742C50.0799 49.724 53.9903 43.673 54 37V31H2V37Z" fill="black"/>
<path d="M55 27H1C0.447715 27 0 27.4477 0 28C0 28.5523 0.447715 29 1 29H55C55.5523 29 56 28.5523 56 28C56 27.4477 55.5523 27 55 27Z" fill="black"/>
<path d="M5 21H7V22C7 22.5523 7.44772 23 8 23C8.55228 23 9 22.5523 9 22V18C9 17.4477 8.55228 17 8 17C7.44772 17 7 17.4477 7 18V19H5V7C5 4.23858 7.23858 2 10 2C12.7614 2 15 4.23858 15 7V7.09021C12.116 7.57866 10.004 10.0749 10 13C10.0016 13.5516 10.4484 13.9984 11 14H21C21.5516 13.9984 21.9984 13.5516 22 13C21.996 10.0749 19.884 7.57866 17 7.09021V7C17 3.13401 13.866 0 10 0C6.13401 0 3 3.13401 3 7V25.5H5V21Z" fill="black"/>
</svg>'.$baths.'</span>';
                            }
                            if($size!=0){
                                $slides.= '<span class="infosize"><svg  viewBox="0 0 42 32" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M41 0H13C12.45 0 12 0.45 12 1V10H1C0.45 10 0 10.45 0 11V31C0 31.55 0.45 32 1 32H29C29.55 32 30 31.55 30 31V22H41C41.55 22 42 21.55 42 21V1C42 0.45 41.55 0 41 0ZM28 30H2V12H28V30ZM40 20H30V11C30 10.45 29.55 10 29 10H14V2H40V20Z" fill="black"/>
</svg>'.$size.'</span>';
                            }
                            
                            $slides.= '    
                            </div>
                         </div>

                         <a class="carousel-control-theme-next" href="#estate-carousel" data-slide="next"><i class="fa demo-icon icon-right-open-big"></i></a>
                         <a class="carousel-control-theme-prev" href="#estate-carousel" data-slide="prev"><i class="fa demo-icon icon-left-open-big"></i></a>
                    </div> 
                    </div>
                </div>';

               $indicators.= '
               <li data-target="#estate-carousel" data-slide-to="'.esc_attr($counter).'" class="'.esc_attr($active).'">

               </li>';

               $counter++;
        endwhile;
        wp_reset_query();
        print '<div class="carousel-inner" role="listbox">
                  '.$slides.'
               </div>

               <ol class="carousel-indicators">
                    '.$indicators.'
               </ol>

               </div>';
    } 
endif;




if( !function_exists('wpestate_present_theme_slider_type2') ):
    function wpestate_present_theme_slider_type2(){
        wp_enqueue_script('slick.min');
        $attr=array(
            'class'	=>'img-responsive'
        );

        $theme_slider   =   wpresidence_get_option( 'wp_estate_theme_slider', ''); 

        if(empty($theme_slider)){
            return; // no listings in slider - just return
        }
        $wpestate_currency       =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
        $where_currency =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );

        $counter    =   0;
        $slides     =   '';
        $indicators =   '';
        $args = array(  
                    'post_type'        =>   'estate_property',
                    'post_status'      =>   'publish',
                    'post__in'         =>   $theme_slider,
                    'posts_per_page'   =>   -1
                  );
       
        $recent_posts = new WP_Query($args);
        $slider_cycle   =   wpresidence_get_option( 'wp_estate_slider_cycle', ''); 
       
        $extended_search    =   wpresidence_get_option('wp_estate_show_adv_search_extended','');
        $extended_class     =   '';

        if ( $extended_search =='yes' ){
            $extended_class='theme_slider_extended';
        }
        
        
        $theme_slider_height   =   wpresidence_get_option( 'wp_estate_theme_slider_height', '');
        if($theme_slider_height==0){
            $theme_slider_height=900;
            $extended_class .= " full_screen_yes ";
        }
        
        print '<div class="theme_slider_wrapper theme_slider_2 '.esc_attr($extended_class).' " data-auto="'.esc_attr($slider_cycle).'" style="height:'.esc_attr($theme_slider_height).'px;">';

        while ($recent_posts->have_posts()): $recent_posts->the_post();
               $theid=get_the_ID();
           
                $preview        =   wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_full_map');
                if($preview[0]==''){
                    $preview[0]= get_theme_file_uri('/img/defaults/default_property_featured.jpg');
                }

               if($counter==0){
                    $active=" active ";
                }else{
                    $active=" ";
                }
              
                $price          =   floatval( get_post_meta($theid, 'property_price', true) );
                $price_label    =   '<span class="">'.esc_html ( get_post_meta($theid, 'property_label', true) ).'</span>';
                $price_label_before   =   '<span class="">'.esc_html ( get_post_meta($theid, 'property_label_before', true) ).'</span>';
             
                $property_city      =   get_the_term_list($theid, 'property_city', '', ', ', '') ;
                $property_area      =   get_the_term_list($theid, 'property_area', '', ', ', '');	
				
                if ($price != 0) {
                   $price  = wpestate_show_price($theid,$wpestate_currency,$where_currency,1);  
                }else{
                    $price=$price_label_before.''.$price_label;
                }

                $realtor_details = wpestate_return_agent_details($theid);
               $slides.= '
               <div class="item_type2 '.$active.'"  style="background-image:url('.esc_url($preview[0]).');height:'.$theme_slider_height.'px;">
                   
                

                        <div class="prop_new_details" data-href="'. esc_url( get_permalink() ).'">
                            <div class="prop_new_details_back"></div>
                            
                        

                            <div class="prop_new_detals_info">';
                              
                                if($realtor_details['link']!=''){
                                    $slides.= '<a href="'.$realtor_details['link'].'"><div class="theme_slider2_agent_picture" style="background-image:url('.wpestate_agent_picture($theid).');"></div></a>';
                                }else{
                                    $slides.= '<div class="theme_slider2_agent_picture" style="background-image:url('.wpestate_agent_picture($theid).');"></div>';
                                }
                                
                                
                                $slides.= '
                                <div class="theme-slider-price">
                                    '.$price.'  
                                </div>
                                
                                <h3><a href="'. esc_url( get_permalink() ).'">'.get_the_title().'</a> </h3>

                                <div class="theme-slider-location">';
                                    if($property_area!=''){
                                        $slides.= wp_kses_post($property_area).', ';
                                    }
                                    if($property_city!=''){
                                        $slides.= wp_kses_post($property_city);
                                    }
                                $slides.='</div>
                                    
                                '.wpestate_theme_slider_contact($theid).'
                                    
                        

                            </div>
                        </div>
                   
                </div>';

            
               $counter++;
        endwhile;
        wp_reset_query();
        print trim($slides).'</div>';
        print '<script type="text/javascript">
                //<![CDATA[
                jQuery(document).ready(function(){
                   wpestate_enable_slick_theme_slider(); 
                });
                //]]>
            </script>';
    } 
endif;

if( !function_exists('wpestate_present_theme_slider_type3') ):
    function wpestate_present_theme_slider_type3(){
        wp_enqueue_script('owl_carousel');
        $counter    =   0;
        $slides     =   '';
        $indicators =   '';
        $prices     =   '';
        $attr=array(
            'class'	=>'img-responsive'
        );

        $theme_slider   =   wpresidence_get_option( 'wp_estate_theme_slider'); 

        if(empty($theme_slider)){
            return; // no listings in slider - just return
        }

        $wpestate_currency  =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
        $where_currency     =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
    
        $args = array(  
                    'post_type'        =>   'estate_property',
                    'post_status'      =>   'publish',
                    'post__in'         =>   $theme_slider,
                    'posts_per_page'   =>   4
                  );
       
        
        $recent_posts   =   new WP_Query($args);
        $slider_cycle   =   wpresidence_get_option( 'wp_estate_slider_cycle', ''); 
        if($slider_cycle == 0){
            $slider_cycle = false;
        }
        
        $extended_search    =   wpresidence_get_option('wp_estate_show_adv_search_extended','');
        $extended_class     =   '';

        if ( $extended_search =='yes' ){
            $extended_class='theme_slider_extended';
        }
        $theme_slider_height   =   wpresidence_get_option( 'wp_estate_theme_slider_height', '');
        
        if($theme_slider_height==0){
            $theme_slider_height=900;
            $extended_class .= " full_screen_yes ";
        }
        
        print '<div class="theme_slider_wrapper owl-carousel owl-theme '.$extended_class.' theme_slider_3 slider_type_3  slide"  data-auto="'.esc_attr($slider_cycle).'" id="estate-carousel" >';
        
        $class_counter = 1;
        while ($recent_posts->have_posts()): $recent_posts->the_post();
				
                $theid=get_the_ID();
                $preview        =   wp_get_attachment_image_src(get_post_thumbnail_id($theid), 'property_full_map');
                if($preview[0]==''){
                    $preview[0]= get_theme_file_uri('/img/defaults/default_property_featured.jpg');
                }

               if($counter==0){
                    $active=" active ";
                }else{
                    $active=" ";
                }
                
                $property_size          =   wpestate_get_converted_measure( $theid, 'property_size' );
                $property_bedrooms      =   get_post_meta($theid,'property_bedrooms',true);
                $property_bathrooms     =   get_post_meta($theid,'property_bathrooms',true);
                $preview_indicator      =   wp_get_attachment_image_src(get_post_thumbnail_id($theid), 'agent_picture_thumb');
                $ex_cont                =   '<img src="'.$preview_indicator[0].'" alt="preview_indicator">';

                $slides.= '
                <div class="item   '.$active.' " data-hash="item'.esc_attr($counter).'" data-href="'. esc_url( get_permalink() ).'" style=" height:'.$theme_slider_height.'px;" >
                    <div class="theme_slider_3_gradient"></div>
                   
                    <div class="image_div">
                        <img src="'.esc_url($preview[0]).'" alt="'.esc_html__('slider','wpresidence').'">
                    </div>	 
                    <div class="slide_cont_block">
                        <div class="theme_slider_3_price">
                            '.wpestate_show_price($theid,$wpestate_currency,$where_currency,1).'
                        </div>                        
                        <a href="'.esc_url ( get_permalink($theid)).'" target="_blank"><h2>'.get_the_title().'</h2></a>
                        <div class="theme_slider_3_sec_row">';
                                if($property_bedrooms!=''){
                                    $slides.= '<div class="inforoom_unit_type5">'.esc_html($property_bedrooms).' '.esc_html__('BD','wpresidence').'</div>';
                                }

                                if($property_bathrooms!=''){
                                    $slides.= '<div class="inforoom_unit_type5">'.esc_html($property_bathrooms).' '.esc_html__('BA','wpresidence').'<span></span></div>';
                                }

                                if($property_size!=''){
                                    $slides.= '<div class="inforoom_unit_type5">'.trim($property_size).'</div>';//escaped above
                                }
                         $slides.=' </div>
                    </div>
                </div>';
           

                $indicators.= '
                <a data-target="#estate-carousel" href="#item'.esc_attr($counter).'" class="button secondary url '. esc_attr($active).'">
                    '.$ex_cont.'
                </a>';

                $counter++;
			   
                $class_counter++;
                if( $class_counter > 3 ){
                    $class_counter = 1;
                }
	   
        endwhile;
        wp_reset_query();
            
        print $slides;
	print '</div>';		 
        print '<ol class="theme_slider_3_carousel-indicators">'.$indicators.'</ol>';
        print '<script type="text/javascript">
                //<![CDATA[
                jQuery(document).ready(function(){
                   wpestate_theme_slider_3(); 
                });
                //]]>
        </script>';       
    }  
endif;

?>
