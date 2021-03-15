<?php
// Archive Page
// Wp Estate Pack
get_header();
$wpestate_options    =   wpestate_page_details('');
$blog_unit  =   esc_html ( wpresidence_get_option('wp_estate_blog_unit','') ); 
global $wpestate_no_listins_per_row;
$wpestate_no_listins_per_row =   intval( wpresidence_get_option('wp_estate_blog_listings_per_row', '') );

if ( 'wpestate_message' == get_post_type() || 'wpestate_invoice' == get_post_type()  ){
    exit();
}
?>

<div class="row"> 
    <?php get_template_part('templates/breadcrumbs'); ?>
    <div class=" <?php print esc_html($wpestate_options['content_class']);?> ">
          <?php get_template_part('templates/ajax_container'); ?>
          <h1 class="entry-title">
             <?php 
             if (is_category() ) {
                    printf(esc_html__('Category Archives: %s', 'wpresidence'), '<span>' . single_cat_title('', false) . '</span>');
             }else if (is_day()) {
                    printf(esc_html__('Daily Archives: %s', 'wpresidence'), '<span>' . get_the_date() . '</span>'); 
             } elseif (is_month()) {
                    printf(esc_html__('Monthly Archives: %s', 'wpresidence'), '<span>' . get_the_date(_x('F Y', 'monthly archives date format', 'wpresidence')) . '</span>'); 
             } elseif (is_year()) {
                    printf(esc_html__('Yearly Archives: %s', 'wpresidence'), '<span>' . get_the_date(_x('Y', 'yearly archives date format', 'wpresidence')) . '</span>');
             } else {
                esc_html_e('Blog Archives', 'wpresidence'); 
             }
            
             ?>
          </h1>
          <div class="blog_list_wrapper">
          <?php   
           while (have_posts()) : the_post();
                if($blog_unit=='list'){
                    include( locate_template('templates/blog_unit.php') ) ;
                }else{
                    include( locate_template('templates/blog_unit2.php') ) ;
                }       
           endwhile;
           wp_reset_query();
           ?>
           </div>
        <?php wpestate_pagination('', $range = 2); ?>    

    </div>
       
<?php include get_theme_file_path('sidebar.php'); ?>
</div>   
<?php get_footer(); ?>