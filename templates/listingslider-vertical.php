<?php
// this is the slider for the blog post
// embed_video_id embed_video_type
global $slider_size;
$video_id       =   '';
$video_thumb    =   '';
$video_alone    =   0;
$full_img       =   '';


$wp_estate_kind_of_map  = esc_html ( wpresidence_get_option('wp_estate_kind_of_map','') );     
if($wp_estate_kind_of_map==2){
    $wp_estate_kind_of_map='open_street';
}         
  ?>   


<div id="carousel-listing" class=" slide post-carusel carouselvertical  <?php echo esc_attr($wp_estate_kind_of_map.'_carousel');?>" data-touch="true" data-interval="false">
    
    <?php 
    print wpestate_return_property_status($post->ID,'verticalstatus');
    $slider_components          =   wpestate_slider_slide_generation($slider_size);
    $header_type                =   get_post_meta ( $post->ID, 'header_type', true);
    $global_header_type         =   esc_html ( wpresidence_get_option('wp_estate_header_type_property_page','') );
    print wpestate_slider_enable_maps($header_type,$global_header_type);
    
    ?>    

    <!-- Wrapper for slides -->
    <div class="carousel-inner owl-carousel owl-theme carouselvertical" id="property_slider_carousel">
     <?php print trim($slider_components['slides']);?>
    </div>

    <!-- Indicators -->    
    <ol  id="carousel-indicators-vertical" class="carousel-indicators-vertical">
       <?php print trim($slider_components['indicators']); ?>
    </ol>

  

    <div class="caption-wrapper vertical-wrapper">   
        <div class="vertical-wrapper-back"></div>  
        <?php  print trim($slider_components['captions']);?>
    </div>  

</div>

<script type="text/javascript">
    //<![CDATA[
    jQuery(document).ready(function(){
       wpestate_property_slider(); 
    });
    //]]>
</script>
