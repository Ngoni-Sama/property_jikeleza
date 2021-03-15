<?php
$title          =    get_the_title();
$link           =    esc_url( get_permalink() );
global          $wpestate_property_unit_slider;
global          $image_counter;
$arguments      = array(
    'numberposts'       => -1,
    'post_type'         => 'attachment',
    'post_mime_type'    => 'image',
    'post_parent'       => $post->ID,
    'post_status'       => null,
    'exclude'           => get_post_thumbnail_id(),
    'orderby'           => 'menu_order',
    'order'             => 'ASC'
);
$post_attachments   = get_posts($arguments);
$image_counter=count($post_attachments)+1;

$pinterest = wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_full_map');
$preview   = wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_listings');
$compare   = wp_get_attachment_image_src(get_post_thumbnail_id(), 'slider_thumb');
$extra= array(
    'data-original' =>  $preview[0],
    'class'         =>  'lazyload img-responsive',    
);

$main_image     =   wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'listing_full_slider');


if(  $wpestate_property_unit_slider==1){
              

    $slides='';

    $no_slides = 0;
    foreach ($post_attachments as $attachment) { 
        $no_slides++;
        $preview    =   wp_get_attachment_image_src($attachment->ID, 'listing_full_slider');

        $slides     .= '<div class="item lazy-load-item" style="background-image:url( '. esc_url($preview[0]).' )">
                           
                        </div>';

    }
    $unique_prop_id=uniqid();
    
    print '
    <div id="property_unit_carousel_'.esc_attr($unique_prop_id).'" class="carousel property_unit_carousel slide " data-ride="carousel" data-interval="false">
            <div class="carousel-inner">         
                <div class="item active" style="background-image:url( '. esc_url($main_image[0]).' )">    
                  
                </div>
                '.$slides.'
            </div>


            <a href="'.esc_url($link).'" target="'.esc_attr(wpresidence_get_option('wp_estate_unit_card_new_page','')).'"> </a>';// slides and thumb_prop escaped above

            if( $no_slides>0){
                print '<a class="left  carousel-control" href="#property_unit_carousel_'.esc_attr($unique_prop_id).'" data-slide="prev">
                    <i class="demo-icon icon-left-open-big"></i>
                </a>

                <a class="right  carousel-control" href="#property_unit_carousel_'.esc_attr($unique_prop_id).'" data-slide="next">
                    <i class="demo-icon icon-right-open-big"></i>
                </a>';
            }
    print'</div>';

}else{
    print '<div class="property_unit_type5_content" style="background-image:url( '. esc_url($main_image[0]).' )"></div>';//escaped above
}