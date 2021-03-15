<?php
global $wpestate_options;
$tags           = wp_get_post_tags($post->ID);
$col_class  =   4;
$no_rows    =   3;
if($wpestate_options['content_class']=='col-md-12'){
    $col_class  =   3;
    $no_rows    =   4;
}


if ($tags) {
        $tag_array=array();
        foreach($tags as $tag){
            $tag_array[]=$tag->term_id;
        }
    
        $args = array(
            'tag__in'       => $tag_array,
            'post__not_in'  => array($post->ID),
            'showposts'     => $no_rows,
            'meta_query'    => array(
                                    array(
                                        'key' => '_thumbnail_id',
                                        'compare' => 'EXISTS'
                                    ),
                                )
        );
        

        wp_reset_query();
        $my_query = new WP_Query($args);
        
        
        if ( $my_query->have_posts() ) { ?>	

          <div class="related_posts"> 
                <h3><?php esc_html_e('Related Posts', 'wpresidence'); ?></h3>   
              
                    <?php
                    $wpestate_no_listins_per_row=3;
                    while ($my_query->have_posts()) {
                        $my_query->the_post();
                        if(has_post_thumbnail() ){
                                 include( locate_template('templates/blog_unit2.php') ) ;
                        }
                       
                    } //end while
                    ?>
                
          </div>		
        <?php } //endif have post
}// end if tags
wp_reset_query();
?> 