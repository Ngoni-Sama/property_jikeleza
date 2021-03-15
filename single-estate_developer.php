<?php
// Single Agency
// Wp Estate Pack
get_header();
$wpestate_options           =   wpestate_page_details($post->ID);
$show_compare               =   1;
$wpestate_currency          =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
$where_currency             =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
$wpestate_options['content_class']='col-md-12';
?>

<div class="row">
    <?php get_template_part('templates/breadcrumbs'); ?>
    <div class=" <?php print esc_html($wpestate_options['content_class']);?> ">
        <div id="content_container"> 
        <?php 
        while (have_posts()) : the_post(); 
            $agency_id              = get_the_ID();
            $thumb_id               = get_post_thumbnail_id($post->ID);
            $preview                = wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_listings');
            $preview_img            = $preview[0];
            $agency_skype           = esc_html( get_post_meta($post->ID, 'developer_skype', true) );
            $agency_phone           = esc_html( get_post_meta($post->ID, 'developer_phone', true) );
            $agency_mobile          = esc_html( get_post_meta($post->ID, 'developer_mobile', true) );
            $agency_email           = is_email( get_post_meta($post->ID, 'developer_email', true) );
            $agency_posit           = esc_html( get_post_meta($post->ID, 'developer_position', true) );
            $agency_facebook        = esc_html( get_post_meta($post->ID, 'developer_facebook', true) );
            $agency_twitter         = esc_html( get_post_meta($post->ID, 'developer_twitter', true) );
            $agency_linkedin        = esc_html( get_post_meta($post->ID, 'developer_linkedin', true) );
            $agency_pinterest       = esc_html( get_post_meta($post->ID, 'developer_pinterest', true) );
            $agency_instagram       = esc_html( get_post_meta($post->ID, 'developer_instagram', true) );
            $agency_urlc            = esc_html( get_post_meta($post->ID, 'developer_website', true) );
            $agency_opening_hours   = esc_html( get_post_meta($post->ID, 'developer_opening_hours', true) );
            $name                   = get_the_title();
        ?>
        <?php endwhile; // end of the loop.    ?>
         
        <div class="single-content single-agent">    
           
            <?php  include( locate_template('templates/developer_listings.php') );  ?>
			
            <?php  include( locate_template('templates/agency_agents.php'));  ?>               
            <div class="developer_contact_wrapper">   
                <div class="col-md-6" id="agency_contact">              
                    <?php  include( locate_template('templates/agent_contact.php'));   ?>
                </div>

                <div class="col-md-6 developer_map">
                    <?php  include( locate_template('templates/agency_map.php'));  ?>
                </div>
            </div>	
            <?php       
            $wp_estate_show_reviews     =    wpresidence_get_option('wp_estate_show_reviews_block','');         
            if(is_array($wp_estate_show_reviews) && in_array('developer', $wp_estate_show_reviews)){
                include( locate_template('templates/developer_reviews.php'));  
            }
            ?>
            </div> 
        </div>  
        </div>
    </div><!-- end 9col container-->    
</div>   

<?php
get_footer(); 
?>