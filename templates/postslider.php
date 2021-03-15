<?php
// this is the slider for the blog post
// embed_video_id embed_video_type
$video_id='';
$video_thumb='';
$video_alone = 0;
$full_img='';

if (esc_html( get_post_meta($post->ID, 'group_pictures', true) ) != 'no') {    
    $arguments = array(
          'numberposts' => -1,
          'post_type' => 'attachment',
          'post_parent' => $post->ID,
          'post_status' => null, 
          'orderby' => 'menu_order',
          'post_mime_type' => 'image',
          'order' => 'ASC'
    );
    $post_attachments   = get_posts($arguments);
 
    $video_id           = esc_html( get_post_meta($post->ID, 'embed_video_id', true) );
    $video_type         = esc_html( get_post_meta($post->ID, 'embed_video_type', true) );

        if ($post_attachments || has_post_thumbnail() || get_post_meta($post->ID, 'embed_video_id', true)) {   ?>   

            <div id="carousel-example-generic" class="carousel slide post-carusel" data-ride="carousel" data-interval="false">
              <!-- Indicators -->
              <ol class="carousel-indicators">
                 <?php  
                 $counter=0;
                 $has_video=0;
                 if($video_id!=''){
                    $has_video=1; 
                     $counter=1;
                 ?>
                 <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li> 
                 <?php   
                 }
                 
                
                foreach ($post_attachments as $attachment) {
                    //$preview = wp_get_attachment_image_src($attachment->ID, 'blog_thumb');
                    $counter++;
                    $active='';
                    if($counter==1 && $has_video!=1){
                        $active=" active ";
                    }else{
                         $active=" ";
                    }
                 ?>
                 <li data-target="#carousel-example-generic" data-slide-to="<?php print intval($counter-1);?>" class="<?php esc_attr($active);?>"></li>   
                 
                <?php
                }
                ?>

              </ol>

              <!-- Wrapper for slides -->
             <div class="carousel-inner">
                 <?php  
                 if($video_id!=''){
                 ?>
                 <div class="item active">
                    <?php
                    if($video_type=='vimeo'){
                       print wpestate_custom_vimdeo_video($video_id);
                    }else{
                       print wpestate_custom_youtube_video($video_id);
                    }
                    ?>
                  </div>
                 <?php
                 }
                 
                 $counter=0;
                 foreach ($post_attachments as $attachment) {
                   
                    $counter++;
                    $active='';
                    if($counter==1 && $has_video!=1){
                        $active=" active ";
                    }else{
                         $active=" ";
                    }
                    $full_img        = wp_get_attachment_image_src($attachment->ID, 'listing_full_slider');
                    $full_prty       = wp_get_attachment_image_src($attachment->ID, 'full');
                    $attachment_meta = wp_get_attachment($attachment->ID)
                    ?>
                 
                 <div class="item <?php print esc_attr($active);?>">
                        <a href="<?php print esc_url($full_prty[0]); ?>" rel="prettyPhoto" title="<?php print esc_attr($attachment_meta['caption']); ?>"   class="prettygalery" > 
                            <img  src="<?php print esc_url($full_img[0]);?>" alt="<?php print esc_attr($attachment_meta['alt']); ?>" class="img-responsive lightbox_trigger" />
                        </a>
                        <div class="carousel-caption">
                         <?php print esc_html($attachment_meta['caption']);?>
                        </div>
                  </div>
                 
                 <?php } //end foreach?>
                  
                  
                  
              </div>

                <!-- Controls -->
                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                    <i class="demo-icon icon-left-open-big"></i>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                    <i class="demo-icon icon-right-open-big"></i>
                </a>
            </div>

        <?php
        } // end if post_attachments
        ?>               
<?php
} //end grup pictures

?>