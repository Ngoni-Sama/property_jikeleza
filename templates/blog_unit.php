<?php
// blog listing
$thumb_id   =   get_post_thumbnail_id($post->ID);
$preview    =   wp_get_attachment_image_src(get_post_thumbnail_id(), 'agent_picture_thumb');
$link       =   esc_url( get_permalink() );
?>

<div class="blog-unit-wrapper">
    <div class="blog_unit  col-md-12" data-link="<?php print esc_attr($link);?>"> 
    
        <?php 
        if( isset($wpestate_options) && $wpestate_options['content_class']=='col-md-12'){
            $preview = wp_get_attachment_image_src(get_post_thumbnail_id(), 'blog_unit');
        }else{
            $preview = wp_get_attachment_image_src(get_post_thumbnail_id(), 'blog_unit');
        }
        
        $extra= array(
            'data-original'=>$preview[0],
            'class'	=> 'lazyload img-responsive',    
        );
        
        $unit_class = "";
        $thumb_prop = get_the_post_thumbnail( $post->ID, 'blog_unit',$extra );
         
        if($thumb_prop ==''){
            $thumb_prop_default =  get_theme_file_uri('/img/defaults/default_blog_unit.jpg');
            $thumb_prop         =  '<img src="'.esc_url($thumb_prop_default).'" class="b-lazy img-responsive wp-post-image  lazy-hidden" alt="'.esc_html__('user image','wpresidence').'" />';   
        }
            
            
        if ( $thumb_prop != '' ) {
            $unit_class="has_thumb"; ?>
            <div class="blog_unit_image">
                <?php print trim($thumb_prop); ?>
            </div>      
        <?php } ?>        
                

    <div class="blog_unit_content <?php print esc_html($unit_class);?>">
        <div class="blog_unit_meta"></div>
        
        <h3>
            <a href="<?php the_permalink(); ?>"><?php 
                $title=get_the_title();
                echo mb_substr( $title,0,54); 
                if(mb_strlen($title)>54){
                    echo '...';   
                } 
            ?></a>
        </h3>
        
        <?php the_excerpt(); ?>
            
        <div class="blog_unit_meta widemeta">
            <span class="span_widemeta"><i class="far fa-copy"></i><?php the_category(', ');?></span>
            <span class="span_widemeta"><i class="far fa-calendar-alt"></i><?php print get_the_date('M d, Y');?></span>
            <span class="span_widemeta"><i class="far fa-comment"></i><?php comments_number( '0','1','%');?></span>
            <a class="read_more" href="<?php the_permalink(); ?>"><?php esc_html_e('Continue Reading','wpresidence'); ?><i class="fas fa-angle-right"></i></a>
        </div>
        
    </div>
</div>
</div>