<?php
// Template Name: Agents list
// Wp Estate Pack
if(!function_exists('wpestate_residence_functionality')){
    esc_html_e('This page will not work without WpResidence Core Plugin, Please activate it from the plugins menu!','wpresidence');
    exit();
}

get_header();
wp_suspend_cache_addition(true);
$wpestate_options=wpestate_page_details($post->ID);
global $wpestate_no_listins_per_row;
$wpestate_no_listins_per_row       =   intval( wpresidence_get_option('wp_estate_agent_listings_per_row', '') );

$col_class=4;
if($wpestate_options['content_class']=='col-md-12'){
    $col_class=3;
}

if($wpestate_no_listins_per_row==3){
    $col_class  =   '6';
    $col_org    =   6;
    if($wpestate_options['content_class']=='col-md-12'){
        $col_class  =   '4';
        $col_org    =   4;
    }
}else{   
    $col_class  =   '4';
    $col_org    =   4;
    if($wpestate_options['content_class']=='col-md-12'){
        $col_class  =   '3';
        $col_org    =   3;
    }
}
?>

<div class="row">
    <?php get_template_part('templates/breadcrumbs'); ?>
    <div class=" <?php print esc_html($wpestate_options['content_class']);?> ">
        <?php get_template_part('templates/ajax_container'); ?>
        <?php 
        while (have_posts()) : the_post(); 
            if ( esc_html (get_post_meta($post->ID, 'page_show_title', true) ) != 'no') { ?>
            <h1 class="entry-title"><?php the_title(); ?></h1>
            <?php } ?>
            <div class="single-content"><?php the_content();?></div>
            <?php
        endwhile; 
        ?>                 
        
        <div id="listing_ajax_container_agent"> 
        <?php
        $args = array(
                'cache_results'     => false,
                'post_type'         => 'estate_agent',
                'paged'             => $paged,
                'posts_per_page'    => 10 );

        $agent_selection = new WP_Query($args);

        $per_row_class='';
        $agent_listings_per_row = wpresidence_get_option('wp_estate_agent_listings_per_row','');
        if( $agent_listings_per_row==4){
            $per_row_class =' agents_4per_row ';
        }
        
        
        while ($agent_selection->have_posts()): $agent_selection->the_post();
        print '<div class="col-md-'.esc_attr($col_org.$per_row_class).' listing_wrapper">';
            get_template_part('templates/agent_unit'); 
            print '</div>';
        endwhile;?> 
        </div>
        <?php wpestate_pagination($agent_selection->max_num_pages, $range = 2); ?>         
       
    </div><!-- end 9col container-->
    
<?php  
include get_theme_file_path('sidebar.php');
wp_suspend_cache_addition(false);?>
</div>   
<?php get_footer(); ?>