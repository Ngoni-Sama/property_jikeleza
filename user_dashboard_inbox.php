<?php
// Template Name: User Dashboard Inbox
// Wp Estate Pack
wpestate_dashboard_header_permissions();

$current_user       = wp_get_current_user();
$dash_profile_link  = wpestate_get_template_link('user_dashboard_profile.php');

get_header();
$wpestate_options    =   wpestate_page_details($post->ID);
$user_role  =   get_user_meta( $current_user->ID, 'user_estate_role', true) ;
$userID     =   $current_user->ID;

?>

<div class="row row_user_dashboard">

    <?php  get_template_part('templates/dashboard-left-col');  ?>
    

    <div class="col-md-9 dashboard-margin">
        <?php get_template_part('templates/breadcrumbs'); ?>
        <?php  get_template_part('templates/user_memebership_profile');  ?>
        <?php get_template_part('templates/ajax_container'); ?>
        <?php while (have_posts()) : the_post(); ?>
            <?php if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) != 'no' ) { ?>
                <h3 class="entry-title"><?php the_title(); ?></h3>
            <?php }?>
         
            <div class="single-content"><?php the_content();?></div><!-- single content-->

        <?php endwhile; // end of the loop. ?>
            
            
        <div class="unread_mess_wrap">
            <?php
            $no_unread=  intval(get_user_meta($userID,'unread_mess',true));
            echo esc_html__('You have','wpresidence').' '.intval($no_unread).' '.esc_html__('unread messages','wpresidence');
            ?>
        </div>    
            
        <?php  
       
        $args = array(
                'post_type'         => 'wpestate_message',
                'post_status'       => 'publish',
                'paged'             => $paged,
                'posts_per_page'    => 80,
                'order'             => 'DESC',
              
                'meta_query' => array(
                                    'relation' => 'AND',
                                    array(
                                        'relation' => 'OR',
                                        array(
                                                'key'       => 'message_to_user',
                                                'value'     => $userID,
                                                'compare'   => '='
                                        ),
                                        array(
                                                'key'       => 'message_from_user',
                                                'value'     => $userID,
                                                'compare'   => '='
                                        ),
                                    ),
                                    array(
                                        'key'       => 'first_content',
                                        'value'     => 1,
                                        'compare'   => '='
                                    ),  
                                    array(
                                        'key'       => 'delete_destination'.$userID,
                                        'value'     => 1,
                                        'compare'   => '!='
                                    ),
                            )
            );
        
      
          
        $message_selection = new WP_Query($args);
        print '<div class="all_mess_wrapper">';
        while ($message_selection->have_posts()): $message_selection->the_post(); 
            include( locate_template('templates/message-listing-unit.php' ) ); 
        endwhile;
        print '</div>';
        wp_reset_query();
        ?>       
    </div>
</div>   

<?php
$ajax_nonce = wp_create_nonce( "wpestate_inbox_actions" );
print ' <input type="hidden" id="wpestate_inbox_actions" value="'.esc_html($ajax_nonce).'" />'; 

get_footer(); ?>