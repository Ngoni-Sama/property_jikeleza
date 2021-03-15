<div class="property_media">
                    
    <?php
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
    if( get_post_meta($post->ID, 'embed_video_id', true)!='' ){
        print '<i class="fas fa-video"></i>';
    }?>
                
   <i class="fas fa-camera"></i><?php echo ' '.esc_html($image_counter); ?>
</div>