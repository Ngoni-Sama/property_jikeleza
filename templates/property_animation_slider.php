<?php
global $post;

$all_images =  get_post_meta( $post->ID, 'image_to_attach', true ) ;
$all_images = explode(',', $all_images);    
$all_images = array_filter($all_images);


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


print '<div class="theme_slider_wrapper '.esc_attr($extended_class).'  property_animation_slider carousel  slide" data-ride="carousel" data-interval="8000" id="property_animation_slider" >';		
    $counter        = 0;
    $slides         = '';
    $indicators     = '';
    $class_counter  = 1;

		
        if( count($all_images) > 0 ):
            foreach( $all_images as $single_image ){
                if( get_post_status( $single_image ) === false ){
                    continue;
                } 

                $theid=get_the_ID();
             
                $preview        =   wp_get_attachment_image_src( $single_image , 'property_full_map');
                
                if($preview[0]==''){
                    $preview[0]= get_theme_file_uri('/img/defaults/default_property_featured.jpg');
                }

                if($counter==0){
                    $active=" active ";
                }else{
                    $active=" ";
                }
				
                $caption        =   get_post( $single_image ) ;
                
                $description    =   '';
                if(isset($caption->post_content)){
                    $description    =   $caption->post_content;
                }
                
                $caption        =   $caption->post_excerpt;
               
                
                $slides.= '
                <div class="item  prop_animation_class_'.esc_attr($class_counter).' '.esc_attr($active).' " data-id="'.esc_attr($counter).'" style=" height:'.esc_attr($theme_slider_height).'px;" >
                    <div class="theme_slider_3_gradient"></div>
                      
                    <div class="image_div">
                        <img src="'.esc_url($preview[0]).'" alt="'.esc_html__('user image','wpresidence').'">
                    </div>
                    
                    <div class="slide_caption">
                        <h2>'.esc_html($caption).'</h2>
                        <div class="theme_slider_3_exp">'.esc_html($description).'</div>
                    </div>  
		</div>';

                $indicators.= '<li data-target="#property_animation_slider" data-slide-to="'.esc_attr($counter).'" class="'. esc_attr($active).'"></li>';

                $counter++;
			 
                $class_counter++;
                if( $class_counter > 3 ){
                    $class_counter = 1;
                }    
			   
        }
        endif;
        
        
        
        print '<div class="carousel-inner" role="listbox">
                  '.$slides.'
               </div>
			   
                <a id="carousel-control-theme-next" class="carousel-control-theme-next" href="#property_animation_slider" data-slide="next"><i class="fas fa-angle-right"></i></a>
                <a id="carousel-control-theme-prev" class="carousel-control-theme-prev" href="#property_animation_slider" data-slide="prev"><i class="fas fa-angle-left"></i></a>
               </div>';  