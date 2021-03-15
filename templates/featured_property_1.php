<?php
$return_string  =   '';    
$thumb_id       =   get_post_thumbnail_id($prop_id);
$preview        =   wp_get_attachment_image_src(get_post_thumbnail_id(), 'listing_full_slider');
if($preview[0]==''){
    $preview[0]= get_theme_file_uri('/img/defaults/default_property_featured.jpg');
}
$link           =    esc_url( get_permalink() );
$title          =   get_the_title();
$price          =   floatval( get_post_meta($prop_id, 'property_price', true) );
$price_label    =   '<span class="price_label">'.esc_html ( get_post_meta($prop_id, 'property_label', true) ).'</span>';
$price_label_before =    get_post_meta($prop_id, 'property_label_before', true);
if($price_label_before!=''){
    $price_label_before    =   '<span class="price_label price_label_before">'.esc_html ( $price_label_before ).'</span>';
}

$wpestate_currency       =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
$where_currency =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
$content        =   wpestate_strip_words( get_the_excerpt(),30).' ...';
$gmap_lat       =   esc_html( get_post_meta($prop_id, 'property_latitude', true));
$gmap_long      =   esc_html( get_post_meta($prop_id, 'property_longitude', true));

$featured       =   intval  ( get_post_meta($prop_id, 'prop_featured', true) );



$realtor_details=   wpestate_return_agent_details($prop_id); 

$agent_id       =   $realtor_details['agent_id'];
$agent_face     =   $realtor_details['agent_face_img'];
$agent_posit    =   $realtor_details['realtor_position'];
$agent_permalink=   $realtor_details['link'];
$agent_phone    =   $realtor_details['realtor_phone'];
$agent_mobile   =   $realtor_details['realtor_mobile'];
$agent_email    =   $realtor_details['email'];


if ($price != 0) {
    $price = wpestate_show_price($prop_id,$wpestate_currency,$where_currency,1);  
}else{
    $price=$price_label_before.$price_label;
}

$return_string.= '
    <div class="featured_property featured_property_type1">     <div class="featured_prop_price">'.$price.' </div>';

            $return_string.= '<div class="featured_img">';
            $return_string .= '<div class="tag-wrapper">';
                if($featured==1){
                    $return_string .= '<div class="featured_div">'.esc_html__('Featured','wpresidence').'</div>';
                }
                $return_string .= wpestate_return_property_status($prop_id);
            $return_string .= '</div>';
            
            
                if(  $wpestate_property_unit_slider==1){

                    $arguments      = array(
                          'numberposts' => -1,
                          'post_type' => 'attachment',
                          'post_mime_type' => 'image',
                          'post_parent' => $prop_id,
                          'post_status' => null,
                          'exclude' => get_post_thumbnail_id($prop_id),
                          'orderby' => 'menu_order',
                          'order' => 'ASC'
                      );
                    $post_attachments   = get_posts($arguments);

                    $slides='';

                    $no_slides = 0;
                    foreach ($post_attachments as $attachment) { 
                        $no_slides++;
                        $preview_att    =   wp_get_attachment_image_src($attachment->ID, 'listing_full_slider');
                            if($preview_att[0]==''){
                                $preview_att[0]= get_theme_file_uri('/img/defaults/default_property_featured.jpg');
                            }

                        $slides     .= '<div class="item"><div class="featured_gradient"></div>
                                            <a href="'.esc_url($link).'"><img  src="'.esc_url($preview_att[0]).'" alt="'.esc_attr($title).'" class="img-responsive" /></a>
                                        </div>';

                    }// end foreach

                    $return_string .=  '
                    <div id="property_unit_featured_carousel_'.intval($prop_id).'" class="carousel slide  " data-ride="carousel" data-interval="false">
                        <div class="carousel-inner">         
                            <div class="item active">    
                                <a href="'.esc_url($link).'">
                                <div class="featured_gradient"></div>
                                <img src="' . esc_url($preview[0]) . '" data-original="' . esc_attr($preview[0]) . '" class="lazyload img-responsive" alt="'.esc_html__('image','wpresidence').'"/></a>     
                            </div>
                            '.$slides.'
                        </div>
                        <a href="'.esc_url($link).'"> </a>';
                  
                        if( $no_slides >= 1){
                            $return_string .=  '<a class="left  carousel-control" href="#property_unit_featured_carousel_'.intval($prop_id).'" data-slide="prev">
                                <i class="demo-icon icon-left-open-big"></i>
                            </a>

                            <a class="right  carousel-control" href="#property_unit_featured_carousel_'.intval($prop_id).'" data-slide="next">
                                <i class="demo-icon icon-right-open-big"></i>
                            </a>';
                        }
                    $return_string .= '
                    </div>';
                }else{
                    $return_string .=  '<a href="'. esc_url($link) .'">
                        <div class="featured_gradient"></div>
                        <img src="' . esc_url($preview[0]) . '" data-original="' . esc_attr($preview[0]) . '" class="lazyload img-responsive" alt="'.esc_html__('image','wpresidence').'"/>
                    </a>';
                }
            $return_string.= '</div>';
            $return_string.='';

            $return_string.= ' <div class="featured_secondline" data-link="'.esc_attr($link).'">';
            if ($agent_id!=''){
                $return_string.= '
                <div class="agent_face">

                    <img src="'.esc_url($agent_face).'" width="55" height="55" class="img-responsive" alt="'.esc_html__('user image','wpresidence').'">


                    <div class="agent_face_details">
                        <img src="'.esc_url($agent_face).'" width="120" height="120" class="img-responsive" alt="'.esc_html__('user image','wpresidence').'">
                        <h4><a href="'.esc_url($agent_permalink).'" >'.get_the_title($agent_id).'</a></h4>   
                        <div class="agent_position">'. $agent_posit .'</div> 
                        <a class="see_my_list" href="'.esc_url($agent_permalink).'" target="_blank">
                            <span class=" wpresidence_button   wpb_wpb_button ">'.esc_html__('My Listings','wpresidence').'</span>
                        </a>    
                    </div>
                </div>';
            }


          
            $return_string .= '<h2><a href="'.esc_url($link).'">';


            $return_string .= mb_substr( $title,0,37); 
            if(mb_strlen($title)>37){
                $return_string .= '...';   
            }

            $return_string.='</a></h2>
            <div class="sale_line">'.esc_html($sale_line).'</div>
     

     </div>'; // $pricee is escaped above

         $return_string .='
    </div>';

print trim($return_string);