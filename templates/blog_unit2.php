<?php
$col_class  =   'col-md-4';
if(isset($wpestate_options) && $wpestate_options['content_class']=='col-md-12' ){
    $col_class  =   'col-md-3';
    $col_org    =   3;
}

if(isset($wpestate_no_listins_per_row) && $wpestate_no_listins_per_row==3){
    $col_class  =   'col-md-6';
    $col_org    =   6;
    if(isset($wpestate_options) && $wpestate_options['content_class']=='col-md-12'){
        $col_class  =   'col-md-4';
        $col_org    =   4;
    }
    
}else{   
    $col_class  =   'col-md-4';
    $col_org    =   4;
    if( isset($wpestate_options) && $wpestate_options['content_class']=='col-md-12'){
        $col_class  =   'col-md-3';
        $col_org    =   3;
    }
}

// if template is vertical
if(isset($align) && $align=='col-md-12'){
    $col_class  =  'col-md-12';
    $col_org    =  12;
}

$preview        =   array();
$preview[0]     =   '';
$words          =   55;
$link           =   esc_url ( get_permalink());
$title          =   get_the_title();

if (mb_strlen ($title)>90 ){
    $title          =   mb_substr($title,0,90).'...';
}

if(isset($is_shortcode) && $is_shortcode==1 ){
    $col_class='col-md-'.$row_number_col.' shortcode-col';
}

?>  

<div  class="<?php echo esc_html($col_class);?>  listing_wrapper blog2v"> 
    <div class="property_listing_blog" data-link="<?php echo esc_attr($link); ?>">
        <?php
        if (has_post_thumbnail()):
       
            $pinterest  =   wp_get_attachment_image_src(get_post_thumbnail_id(),'property_full_map');
            $preview    =   wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_listings');
            $compare    =   wp_get_attachment_image_src(get_post_thumbnail_id(), 'slider_thumb');
            $extra= array(
                'data-original'=>$preview[0],
                'class'	=> 'lazyload img-responsive',    
            );
         
            $thumb_prop = get_the_post_thumbnail( $post->ID, 'property_listings',$extra );    
            if($thumb_prop ==''){
                $thumb_prop_default =  get_theme_file_uri('/img/defaults/default_property_listings.jpg');
                $thumb_prop         =  '<img src="'.esc_url($thumb_prop_default).'" class="b-lazy img-responsive wp-post-image  lazy-hidden" alt="'.esc_html__('user image','wpresidence').'" />';   
            }
            $featured   = intval  ( get_post_meta( $post->ID, 'prop_featured', true ) );
        
            
            if( $thumb_prop!='' ){
                print '<div class="blog_unit_image">';
                print  trim($thumb_prop);
                print '</div>'; 
            }
           
        endif;
        ?>

           <h4>
               <a href="<?php the_permalink(); ?>" class="blog_unit_title"><?php 
                    $title=get_the_title();
                    echo mb_substr( $title,0,44); 
                    if(mb_strlen($title)>44){
                        echo '...';   
                    } 
                ?></a> 
           </h4>
        
           <div class="blog_unit_meta">
            <?php print get_the_date('M d, Y');?>
            
           </div>
           
            <div class="listing_details the_grid_view">
                <?php   
               
                if( has_post_thumbnail() ){
                   //echo wpestate_strip_words( get_the_excerpt(),18).' ...';
                   echo  wpestate_strip_excerpt_by_char(get_the_excerpt(),115,$post->ID,'...');
                } else{
                    // echo wpestate_strip_words( get_the_excerpt(),40).' ...';
                    echo  wpestate_strip_excerpt_by_char(get_the_excerpt(),200,$post->ID,'...');
                } ?>
            </div>

            <a class="read_more" href="<?php the_permalink(); ?>"> <?php esc_html_e('Continue reading','wpresidence'); ?><i class="fas fa-angle-right"></i> </a>

        </div>          
    </div>      