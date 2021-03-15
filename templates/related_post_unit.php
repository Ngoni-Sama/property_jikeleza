<?php
global $wpestate_options;
$thumb_id   =   get_post_thumbnail_id($post->ID);
$link       =   esc_url( get_permalink() );
$title      =   get_the_title();
$col_class  =   4;

if($wpestate_options['content_class']=='col-md-12'){
    $col_class=3;
}
?>

<div class=" col-md-<?php print esc_attr($col_class);?> related-unit "> 
        <?php  
        $preview = wp_get_attachment_image_src($thumb_id, 'blog_thumb');    
        $unit_class="";
        if ($preview[0]!='') {
            $unit_class="has_thumb"; ?>
            <div class="related_blog_unit_image" data-related-link="<?php print esc_attr($link);?>">
                <a href="<?php print esc_url($link);?>"><img src="<?php print esc_url($preview[0]);?>" class=" lazyload img-responsive" ></a>
                    <?php print '<div class="prop_new_details_back"></div>
                    <a href="'.esc_url($link).'" class="related_post_link">'.esc_html($title).'</a>';
                    ?>
            </div>                              
        <?php    
        }
        ?>
   
</div>