<?php 
global  $wp_estate_global_page_template; 
global  $wp_estate_local_page_template;
global  $wpestate_options;
global $propid;

 $page_to_load='';
            
if ($wp_estate_local_page_template!=0){
    $page_to=$wp_estate_local_page_template;
}else{
   $page_to= $wp_estate_global_page_template;
}

            
            
?>

<div class="row estate_property_first_row" data-prp-listingid="<?php print intval($post->ID);?>" >
    <?php get_template_part('templates/breadcrumbs'); ?>
    <div class="col-xs-12 <?php print esc_html($wpestate_options['content_class']);?> full_width_prop">
        
        <?php get_template_part('templates/ajax_container'); ?>
        
        <?php while (have_posts()) : the_post();
            $post_title = get_post_meta($page_to, 'page_show_title', true);
            if ($post_title != 'no') { ?>
                <h1 class="entry-title"><?php the_title(); ?></h1>
            <?php } ?>
         
            <div class="single-content page_template_loader">
            <?php 
            
           
            $the_query = new WP_Query( 'page_id='.$page_to );
                while ( $the_query->have_posts() ) :
                        $the_query->the_post();
                      the_content();
                endwhile;
                wp_reset_postdata();

            ?></div><!-- single content-->

        <?php endwhile; // end of the loop. ?>
    </div>
  
    
<?php     
 include get_theme_file_path('sidebar.php');?>
</div>   

<?php 
$mapargs = array(
        'post_type'         =>  'estate_property',
        'post_status'       =>  'publish',
        'p'                 =>  $post->ID,
        'fields'            =>    'ids');
  

$selected_pins  =  wpestate_listing_pins('blank_single',0,$mapargs,1);
wp_localize_script('googlecode_property', 'googlecode_property_vars2', 
            array('markers2'          =>  $selected_pins));

get_footer(); 
exit();
?>