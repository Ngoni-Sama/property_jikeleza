<?php
// Single Agent
// Wp Estate Pack
get_header();
$wpestate_options           =   wpestate_page_details($post->ID);
$show_compare               =   1;
$wpestate_currency          =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
$where_currency             =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
?>

<div class="row">
    <?php get_template_part('templates/breadcrumbs'); ?>
    <div class=" <?php print esc_html($wpestate_options['content_class']);?> ">
        <?php   get_template_part('templates/ajax_container'); ?>
        <div id="content_container" > 
          
            <?php 
            while (have_posts()) : the_post(); 
                $agent_id           = get_the_ID();
                $realtor_details    = wpestate_return_agent_details('',$agent_id);
         
            ?>
          
            <div class="container_agent">
                <div class="single-content single-agent">

                    <?php  include( get_theme_file_path('templates/agentdetails.php')); ?>
                    <?php endwhile; // end of the loop.   ?>

                </div>

                <?php  include( locate_template('templates/agent_contact.php') );   ?>
            </div>    
            <?php  include( locate_template('templates/agent_listings.php'));  ?>
            <?php         
            $wp_estate_show_reviews     =    wpresidence_get_option('wp_estate_show_reviews_block','');         
            if(is_array($wp_estate_show_reviews) && in_array('agent', $wp_estate_show_reviews)){
               include( locate_template('templates/agent_reviews.php') );  
            }
            ?>
     
        </div>
    </div><!-- end 9col container-->    
<?php   include get_theme_file_path('sidebar.php'); ?>
</div>   
<?php
get_footer(); 
?>