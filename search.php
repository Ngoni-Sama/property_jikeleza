<?php
get_header();

if (    ! isset( $_GET['wpestate_default_search_nonce'] )  || ! wp_verify_nonce( $_GET['wpestate_default_search_nonce'], 'wpestate_default_search' ) ) {
   esc_html_e('Sorry, your nonce did not verify.','wpresidence');
   exit;
}
$postid='';
$wpestate_options            =   wpestate_page_details($postid);
$blog_unit          =   esc_html ( wpresidence_get_option('wp_estate_blog_unit','') ); 
?>

<div class="row">
    <?php get_template_part('templates/breadcrumbs'); ?>
    <div class=" <?php print esc_html($wpestate_options['content_class']);?> ">
        <?php get_template_part('templates/ajax_container'); ?>
        <div class="single-content">      
        <div class="blog_list_wrapper">    
        <?php
         
        if (have_posts()){
        print ' <h1 class="entry-title-search">'. esc_html__( 'Search Results for : ','wpresidence');print '"' . get_search_query() . '"'.'</h1>';
            while (have_posts()) : the_post(); 
                if($blog_unit=='list'){
                    include( locate_template('templates/blog_unit.php') ) ;
                }else{
                    include( locate_template('templates/blog_unit2.php') ) ;
                }  
            endwhile;
        }else{
        ?>
            <h2 class="entry-title-search"> <?php esc_html_e( 'We didn\'t find any results. Please try again with different search parameters. ', 'wpresidence' ); ?></h2>
            <form method="get" class="searchform" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <input type="text" class="field" name="s" id="s" value="<?php esc_attr_e( 'Search', 'wpresidence' ); ?>" />
                <input type="submit" id="submit-form" class="wpresidence_button" value="<?php esc_attr_e( 'Search', 'wpresidence' ); ?>">
                <?php wp_nonce_field( 'wpestate_default_search', 'wpestate_default_search_nonce' ); ?>
            </form>

        <?php
        }
        wp_reset_query();
        ?>
            
        </div>        
          
                  
        </div>
        <?php wpestate_pagination('', $range = 2); ?>       
  
    </div><!-- end 9col container-->
    
<?php   include get_theme_file_path('sidebar.php'); ?>
</div>   

<?php get_footer();?>