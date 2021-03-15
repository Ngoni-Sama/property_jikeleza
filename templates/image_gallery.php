<?php
global $price;
global $price_label_before;
global $price_label;
wp_enqueue_script('owl_carousel');
$crop_images_lightbox       =   esc_html ( wpresidence_get_option('wp_estate_crop_images_lightbox','') );
$show_lightbox_contact      =   esc_html ( wpresidence_get_option('wp_estate_show_lightbox_contact','') );
$class_image_wrapper        =   'col-md-10';
$class_image_wrapper_global =   '';

if($show_lightbox_contact   ==  'no'){
    $class_image_wrapper        =   'col-md-12 lightbox_no_contact ';    
    $class_image_wrapper_global .=   ' lightbox_wrapped_no_contact ';
}

if($crop_images_lightbox=='no'){
      $class_image_wrapper_global .=   ' ligtbox_no_crop ';
}

?>

<div class="lightbox_property_wrapper"> 
    <div class="lightbox_property_wrapper_level2 <?php print esc_attr($class_image_wrapper_global); ?>">
        <div class="lightbox_property_content row">
            <div class="lightbox_property_slider <?php print esc_attr($class_image_wrapper); ?>">
                <div  id="owl-demo" class="owl-carousel owl-theme">
     
                    <?php
                    $counter=1;
                    $featured_id        =   get_post_thumbnail_id($post->ID);
                    $attachment_meta    =   wp_get_attachment($featured_id);
                   
                    if($crop_images_lightbox=='yes'){
                        $full_img           =   wp_get_attachment_image_src($featured_id, 'listing_full_slider_1');
                        echo '<div class="item" href="#'.$counter.'" style="background-image:url('.esc_attr($full_img[0]).')">';
                            if(trim($attachment_meta['caption'])!=''){
                               echo '<div class="owl_caption"> '. $attachment_meta['caption'].'</div>'; 
                            }
                         echo'</div>';
                    
                    }else{
                        $full_img           =   wp_get_attachment_image_src($featured_id, 'full');
                        echo '<div class="item" href="#'.$counter.'" >';
                            echo '<img src="'.esc_url($full_img[0]).'" alt="'.esc_html__('image','wpresidence').'" >';
                            if(trim($attachment_meta['caption'])!=''){
                               echo '<div class="owl_caption"> '. $attachment_meta['caption'].'</div>'; 
                            }
                         echo'</div>';
                    }
                
        
                    $arguments      = array(
                            'numberposts' => -1,
                            'post_type' => 'attachment',
                            'post_mime_type' => 'image',
                            'post_parent' => $post->ID,
                            'post_status' => null,
                            'exclude' => $featured_id,
                            'orderby' => 'menu_order',
                            'order' => 'ASC'
                        );

                    $post_attachments   = get_posts($arguments);
                    foreach ($post_attachments as $attachment) {
                       $counter++;
                        $full_img           = wp_get_attachment_image_src($attachment->ID, 'listing_full_slider_1');
                        $attachment_meta    = wp_get_attachment($attachment->ID);
                        if( $crop_images_lightbox=='yes'){
                            echo '<div class="item" href="#'.$counter.'"  style="background-image:url('.esc_attr($full_img[0]).')">';
                                if(trim($attachment_meta['caption'])!=''){
                                    echo '<div class="owl_caption"> '. $attachment_meta['caption'].'</div>'; 
                                }
                            echo'</div>';
                        }else{
                            $full_img           = wp_get_attachment_image_src($attachment->ID, 'full');
                            echo '<div class="item" href="#'.$counter.'" >';
                                echo '<img src="'.esc_url($full_img[0]).'" alt="'.esc_html__('image','wpresidence').'" >';
                                if(trim($attachment_meta['caption'])!=''){
                                   echo '<div class="owl_caption"> '. $attachment_meta['caption'].'</div>'; 
                                }
                             echo'</div>';
                        }
                    }
                    ?>
                </div>
            </div>

            <?php if($show_lightbox_contact=='yes'){ ?>
                <div class="lightbox_property_sidebar col-md-2">
                    <div class="lightbox_property_header">
                        <div class="entry-title entry-prop"><?php the_title(); ?></div>  
                    </div>
                    <h4 class="lightbox_enquire"><?php esc_html_e('Want to find out more?','wpresidence');?></h4>
                    <?php  include( locate_template ('/templates/agent_area.php') ); ?>
                </div>
            <?php } ?>

        </div>

        <div class="lighbox-image-close">
                <i class="fas fa-times" aria-hidden="true"></i>
        </div>
    </div>
    
    <div class="lighbox_overlay">
    </div>    
</div>


<script type="text/javascript">
    //<![CDATA[
    jQuery(document).ready(function(){
       estate_start_lightbox(); 
    });
    //]]>
</script>
