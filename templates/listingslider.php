<?php
// this is the slider for the blog post
// embed_video_id embed_video_type
global $slider_size;
$arguments      = array(
                    'numberposts' => -1,
                    'post_type' => 'attachment',
                    'post_mime_type' => 'image',
                    'post_parent' => $post->ID,
                    'post_status' => null,
                    'exclude' => get_post_thumbnail_id(),
                    'orderby' => 'menu_order',
                    'order' => 'ASC'
                );

$post_attachments       = get_posts($arguments);

$wp_estate_kind_of_map  = esc_html ( wpresidence_get_option('wp_estate_kind_of_map','') );     
if($wp_estate_kind_of_map==2){
    $wp_estate_kind_of_map='open_street';
}    


if ($post_attachments || has_post_thumbnail() || get_post_meta($post->ID, 'embed_video_id', true)) {  ?>   
    <div id="carousel-listing" class=" slide post-carusel <?php echo esc_attr($wp_estate_kind_of_map.'_carousel');?>" data-interval="false">
 
    <?php 
    print wpestate_return_property_status($post->ID,'horizontalstatus'); 
    $slider_components          =   wpestate_slider_slide_generation($slider_size);
    $header_type                =   get_post_meta ( $post->ID, 'header_type', true);
    $global_header_type         =   esc_html ( wpresidence_get_option('wp_estate_header_type_property_page','') );
    
    print wpestate_slider_enable_maps($header_type,$global_header_type);
    ?>    

    <!-- Wrapper for slides -->
    <div class="carousel-inner owl-carousel owl-theme" id="property_slider_carousel">
      <?php print trim($slider_components['slides']);?>
    </div>

    <!-- Indicators -->    
    <div class="carusel-back"></div>  
    <ol class="carousel-indicators">
      <?php print trim($slider_components['indicators']); ?>
    </ol>

    <ol class="carousel-round-indicators">
        <?php print trim($slider_components['round_indicators']);?>
    </ol> 

    <div class="caption-wrapper">   
      <?php  print trim($slider_components['captions']);?>
        <div class="caption_control"></div>
    </div>  

    </div>

    <script type="text/javascript">
        //<![CDATA[
        jQuery(document).ready(function(){
           wpestate_property_slider(); 
        });
        //]]>
    </script>

<?php
} // end if post_attachments
?>