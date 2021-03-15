<?php
// Template Name: Blog list page
// Wp Estate Pack
get_header();
$wpestate_options            =   wpestate_page_details($post->ID);
$blog_unit                   =   esc_html ( wpresidence_get_option('wp_estate_blog_unit','') ); 
$wpestate_no_listins_per_row =   intval( wpresidence_get_option('wp_estate_blog_listings_per_row', '') );
?>
<div class="row">
    <?php get_template_part('templates/breadcrumbs'); ?>
    <div class=" <?php print esc_html($wpestate_options['content_class']);?> ">
        <?php get_template_part('templates/ajax_container'); ?>
        <?php while (have_posts()) : the_post(); ?>
        <?php if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) == 'yes') { ?>
              <h1 class="entry-title title_prop"><?php the_title(); ?></h1>
        <?php } ?>
        <div class="single-content"><?php the_content();?></div>   
        <?php endwhile; // end of the loop.  ?>  

              
        <div class="blog_list_wrapper">    
        <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 0;
            $args = array(
                'post_type' => 'post',
                'paged'     => $paged,
                'status'    =>'published'
            );

            $blog_selection = new WP_Query($args);
            
            while ($blog_selection->have_posts()): $blog_selection->the_post();
                if($blog_unit=='list'){
                     include( locate_template('templates/blog_unit.php') ) ;
                }else{
                     include( locate_template('templates/blog_unit2.php') ) ;
                }              
            endwhile;
            wp_reset_query();
        ?>
        
           
        </div>
        <?php wpestate_pagination($blog_selection->max_num_pages, $range = 2); ?>    
    </div><!-- end 9col container-->
    
<?php  include get_theme_file_path('sidebar.php'); ?>
</div>   

<?php get_footer(); ?>