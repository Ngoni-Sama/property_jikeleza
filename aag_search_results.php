<?php
// Template Name: Agents Agencies Developers Search Results
// Wp Estate Pack

if(!function_exists('wpestate_residence_functionality')){
    esc_html_e('This page will not work without WpResidence Core Plugin, Please activate it from the plugins menu!','wpresidence');
    exit();
}

get_header();
wp_suspend_cache_addition(true);
$wpestate_options=wpestate_page_details($post->ID);
global $wpestate_no_listins_per_row;
$wpestate_no_listins_per_row      =   intval( wpresidence_get_option('wp_estate_agent_listings_per_row', '') );

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
        
        <div id="listing_ajax_container_agent" class=" <?php echo sanitize_text_field( $_GET['_search_post_type']); ?>"> 
        <?php
		$all_out_tax = array();
		
		$_search_post_type = null;
		
		if( isset( $_GET['_search_post_type'] ) ){
			$_search_post_type = sanitize_text_field( $_GET['_search_post_type'] );
		}
		
        $args = array(
                'cache_results'     => false,
                'paged'             => $paged,
                'posts_per_page'    => 10 );

		// if is set post type
		if( isset( $_search_post_type ) ){
			$args['post_type'] = $_search_post_type;
			
			
			// if post type set - define taxonomies
			switch( $_search_post_type ){
				case "estate_agent":
					$all_input_taxonomies = array( '_property_city_agent', '_property_area_agent', '_property_category_agent', '_property_action_category_agent' );
					
					foreach( $all_input_taxonomies as $single_tax ){
						if( $_GET[$single_tax] && $_GET[$single_tax] != 'all' ){
							$all_out_tax[] = array(
								'taxonomy' => ltrim( $single_tax, '_'),
								'field'    => 'slug',
								'terms'    => sanitize_text_field( $_GET[$single_tax] ),
							);
						}
					}
				break;
				case "estate_agency":
					$all_input_taxonomies = array( '_city_agency', '_area_agency', '_category_agency', '_action_category_agency' );
					
					foreach( $all_input_taxonomies as $single_tax ){
						if( $_GET[$single_tax] && $_GET[$single_tax] != 'all' ){
							$all_out_tax[] = array(
								'taxonomy' => ltrim( $single_tax, '_'),
								'field'    => 'slug',
								'terms'    => sanitize_text_field( $_GET[$single_tax] ),
							);
						}
					}
				break;
				case "estate_developer":
					$all_input_taxonomies = array( '_property_city_developer', '_property_area_developer', '_property_category_developer', '_property_action_developer' );
					
					foreach( $all_input_taxonomies as $single_tax ){
						if( $_GET[$single_tax] && $_GET[$single_tax] != 'all' ){
							$all_out_tax[] = array(
								'taxonomy' => ltrim( $single_tax, '_'),
								'field'    => 'slug',
								'terms'    => sanitize_text_field( $_GET[$single_tax] ),
							);
						}
					}
				break;
			}
			
		}
		
		// if taxonomies set add to query
		if(  count( $all_out_tax ) > 0 ){
			$args['tax_query'] = $all_out_tax;
		}
		
		// if is set search text
		if( isset( $_GET['_keyword_search'] ) ){
			$args['s'] = sanitize_text_field( $_GET['_keyword_search'] );
		}
	 	 
		 
		// if empty page
		if( !isset( $_GET['_search_post_type'] ) ){
			$args  = array();
		}
		 
	 
        $agent_selection = new WP_Query($args);

        $per_row_class='';
        $agent_listings_per_row = wpresidence_get_option('wp_estate_agent_listings_per_row');
        if( $agent_listings_per_row==4){
            $per_row_class =' agents_4per_row ';
        }
       
        if( $agent_selection->have_posts() ):
		        
        while ($agent_selection->have_posts()): $agent_selection->the_post();
     
		if( $_search_post_type == 'estate_agent' ){
			print '<div class="col-md-'.esc_attr($col_org.$per_row_class).' listing_wrapper">';	    
		}
        
			
                // if post type set - define taxonomies
                switch( $_search_post_type ){
                        case "estate_agent":
                                get_template_part('templates/agent_unit'); 
                        break;
                        case "estate_agency":
                                get_template_part('templates/agency_unit'); 
                        break;
                        case "estate_developer":
                                get_template_part('templates/agency_unit'); 
                        break;
                }
			
		if( $_search_post_type == 'estate_agent' ){	
			print '</div>';	
        }     
        endwhile;
			
		else:
                print '<span class="no_results">'. esc_html__("We didn't find any results. Please try again with different search parameters.", "wpresidence").'</>';
			
		endif;
		
		?> 
        </div>
        <?php wpestate_pagination($agent_selection->max_num_pages, $range = 2); ?>         
       
    </div><!-- end 9col container-->
    
<?php   include get_theme_file_path('sidebar.php');
wp_suspend_cache_addition(false);?>
</div>   
<?php get_footer(); ?>