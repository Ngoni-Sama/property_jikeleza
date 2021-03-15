<?php

function wpestate_add_welcome_widget(){
   
    $logo                     =   esc_html( wpresidence_get_option('wp_estate_logo_image','url') );
    print '<div class="dashboard_widget_exp">'.esc_html__('Your Current Logo','wpresidence').'</div>';
    if ($logo != '') {
        print '<img class="dashboard_widget_logo admin_widget_logo" src="'.esc_url($logo).'" class="img-responsive retina_ready"  alt="'.esc_html__('company logo','wpresidence').'"/>';
    } else {
        print '<img class="img-responsive admin_widget_logo retina_ready" src="' .esc_url(get_theme_file_uri('/img/logo.png')).'" alt="'.esc_html__('company logo','wpresidence').'"/>';
    }
    print '<a class="wpestate_admin_button reverse_but logo_wid_upload" href="'.esc_url( home_url('/') ).'wp-admin/admin.php?page='. str_replace(' ','',wp_get_theme()).'&tab=5"  style="float:right;">'.esc_html__('Upload New Logo','wpresidence').'</a>';
    
    
    
    print '<div class=" widget_content_wrapper" >';
        print '<div class="dashboard_widget_exp" style="margin-top:32px;">'.esc_html__('Your Current Colors','wpresidence').'</div>';
        
        $main_color                     =   esc_html( wpresidence_get_option('wp_estate_main_color','') );
        $background_color               =   esc_html( wpresidence_get_option('wp_estate_background_color', '') );
        $font_color                     =   esc_html( wpresidence_get_option('wp_estate_font_color', '') );
        $footer_color                   =   esc_html( wpresidence_get_option('wp_estate_footer_back_color', '') ); 
        if($main_color==''){
            $main_color='#1CA8DD';
        }
        if($background_color==''){
            $background_color='#ffffff';
        }
        
        if($font_color==''){
            $font_color='#8593a9';
        }
        if($footer_color==''){
            $footer_color='#333333';
        }
        
        
        print '<div class="dasboard_widget_color_wrapper">';
        print '<div class="dasboard_widget_color" style="background-color:'.$main_color.'"></div>';
        print '<div class="dasboard_widget_color" style="background-color:'.$background_color.'"></div>';
        print '<div class="dasboard_widget_color" style="background-color:'.$font_color.'"></div>';
        print '<div class="dasboard_widget_color" style="background-color:'.$footer_color.'"></div>';
        print '<div class="dasboard_widget_color" style="background-color:'.$main_color.'"></div>';
        print '<div class="more_colors" style="background-color:#fff">...</div>';
        print '</div>' ;                   
        
        print '<a class="wpestate_admin_button reverse_but"  href="'.esc_url( home_url('/') ).'wp-admin/admin.php?page='. str_replace(' ','',wp_get_theme()).'&tab=30">'.esc_html__('Change Colors','wpresidence').'</a>';
    print '</div>'; 
}

//////////////////////////////////////////
//Add New Page dashboard admin widget
//////////////////////////////////////////
function wpestate_add_new_page_widget(){
    
    $current_pages      =   wpestate_how_many_pages();
    
    print'<div class="dashboard_widget_exp">';
        printf(esc_html__('You have  %1$d pages published.','wpresidence'),$current_pages);
    print '</div>';
    
    $pages_list = wpestate_get_all_page_templates();

    //////////////////////////////////////////////////////////////// initial showing
    $select_list    =   '';
    $example_list   =   '';
    
    foreach($pages_list as $key=>$page){
        $select_list    .=  '<option value="'.$page['wp_template'].'">'.$page['name'].'</value>';
    }
    

    print '<form action = "" method="post">';
       
        print ' <div class="add_form_wrapper">
                    <label class="new_page_title" for="new_page_title">'.esc_html__('Page Title','wpresidence').'</label>
                    <input type="text" id="new_page_title" name="new_page_title" class="form-input-tip ">
                </div>';
   
        print ' <div class="add_form_wrapper">
                    <label class="new_page_title" for="new_page_title">'.esc_html__('Page Template','wpresidence').'</label>
                    <select class="" id="widget_new_page_template" name="new_page_template">
                    '.$select_list.'
                    </select>
                </div>';
        print '<div class="see_pages_dash"><a href="'.esc_url(home_url('/')).'wp-admin/edit.php?post_type=page">'.esc_html__('See All Your Pages','wpresidence').'</a></div>';
        print ' <div class="">
                    <input type="submit" id="submit_new_page"  class="wpestate_admin_button reverse_but" Value="'.esc_html__('Add New Page','wpresidence').'">
                </div>';
           wp_nonce_field( 'wpestate_widget_page', 'wpestate_widget_page_nonce' );
    print '</form>';
      
}


function wpestate_get_all_page_templates(){
    $pages_list = array();
    
    $pages_list[]=array(
        'name'          =>  'Advanced Search Results',
        'wp_template'   =>  'advanced_search_results.php',
    );
    
    $pages_list[]=array(
        'name'          =>  'Agency list',
        'wp_template'   =>  'agency_list.php',
    );
    
    $pages_list[]=array(
        'name'          =>  'Agents Agencies Developers Search Results',
        'wp_template'   =>  'aag_search_results.php',
    );
    
    $pages_list[]=array(
        'name'          =>  'Agents list',
        'wp_template'   =>  'agents_list.php',
    );
    
    $pages_list[]=array(
        'name'          =>  'Blog list page',
        'wp_template'   =>  'blog_list.php',
    );
    
    $pages_list[]=array(
        'name'          =>  'Compare Listings',
        'wp_template'   =>  'compare_listings.php',
    );
    
    $pages_list[]=array(
        'name'          =>  'Contact Page',
        'wp_template'   =>  'contact_page.php',
    );
    
    $pages_list[]=array(
        'name'          =>  'Developer list',
        'wp_template'   =>  'developers_list.php',
    );
    
    $pages_list[]=array(
        'name'          =>  'Front Property Submit',
        'wp_template'   =>  'front_property_submit.php',
    );
    
    $pages_list[]=array(
        'name'          =>  'GDPR Terms',
        'wp_template'   =>  'gdpr_terms.php',
    );
    
    $pages_list[]=array(
        'name'          =>  'Idx Page',
        'wp_template'   =>  'single-idx.php',
    );
    
    $pages_list[]=array(
        'name'          =>  'Paypal Processor',
        'wp_template'   =>  'processor.php',
    );
    
    $pages_list[]=array(
        'name'          =>  'Properties list',
        'wp_template'   =>  'property_list.php',
    );
    
    $pages_list[]=array(
        'name'          =>  'Properties list directory',
        'wp_template'   =>  'property_list_directory.php',
    );
    
    $pages_list[]=array(
        'name'          =>  'Properties list half',
        'wp_template'   =>  'property_list_half.php',
    );
    
    $pages_list[]=array(
        'name'          =>  'Property page template',
        'wp_template'   =>  'page_property_design.php',
    );
    
    $pages_list[]=array(
        'name'          =>  'Splash Page',
        'wp_template'   =>  'splash_page.php',
    );
    
    $pages_list[]=array(
        'name'          =>  'Stripe Charge Page',
        'wp_template'   =>  'stripecharge.php',
    );
    
    $pages_list[]=array(
        'name'          =>  'Terms and Conditions',
        'wp_template'   =>  'terms_conditions.php',
    );
    
    $pages_list[]=array(
        'name'          =>  'User Dashboard',
        'wp_template'   =>  'user_dashboard.php',
    );
    
    $pages_list[]=array(
        'name'          =>  'User Dashboard  Saved Searches',
        'wp_template'   =>  'user_dashboard_searches.php',
    );
    
    $pages_list[]=array(
        'name'          =>  'User Dashboard Add agent',
        'wp_template'   =>  'user_dashboard_add_agent.php',
    );
    
    $pages_list[]=array(
        'name'          =>  'User Dashboard Agent List',
        'wp_template'   =>  'user_dashboard_agent_list.php',
    );
    
    $pages_list[]=array(
        'name'          =>  'User Dashboard Favorite',
        'wp_template'   =>  'user_dashboard_favorite.php',
    );
     
    $pages_list[]=array(
        'name'          =>  'User Dashboard Floor Plans',
        'wp_template'   =>  'user_dashboard_floor.php',
    );
      
    $pages_list[]=array(
        'name'          =>  'User Dashboard Inbox',
        'wp_template'   =>  'user_dashboard_inbox.php',
    );
       
    $pages_list[]=array(
        'name'          =>  'User Dashboard Invoices',
        'wp_template'   =>  'user_dashboard_invoices.php',
    );
        
    $pages_list[]=array(
        'name'          =>  'User Dashboard Profile Page',
        'wp_template'   =>  'user_dashboard_profile.php',
    );
         
    $pages_list[]=array(
        'name'          =>  'User Dashboard Search Results',
        'wp_template'   =>  'user_dashboard_search_result.php',
    );
          
    $pages_list[]=array(
        'name'          =>  'User Dashboard Submit',
        'wp_template'   =>  'user_dashboard_add.php',
    );
           
    $pages_list[]=array(
        'name'          =>  'Zillow Estimate',
        'wp_template'   =>  'zillow_estimate_page.php',
    );
      
    return $pages_list; 
       
}

function wpestate_create_new_page($title,$slug){
   
    $my_post = array(
        'post_title'    => $title,
        'post_type'     => 'page',
        'post_status'   => 'publish',
    );

   
    $new_id = wp_insert_post($my_post);
    if($slug!=''){
        update_post_meta($new_id, '_wp_page_template',$slug);
    }
    
    update_post_meta($new_id, 'sidebar_option','none');
    update_post_meta($new_id, 'page_show_title','no'); 
      
    return $new_id;
   
}




add_action ('wp_loaded', 'wpestate_newpage_create_and_redirect');
function wpestate_newpage_create_and_redirect(){
    $pages_list = wpestate_get_all_page_templates();
    
   
    if( isset($_POST) && isset($_POST['new_page_title']) && $_POST['new_page_title']!='' ) {
        if (    ! isset( $_POST['wpestate_widget_page_nonce'] )  || ! wp_verify_nonce( $_POST['wpestate_widget_page_nonce'], 'wpestate_widget_page' ) ) {
            esc_html_e('Sorry, your nonce did not verify.','wpresidence');
            exit();
        }
        $title          =   sanitize_text_field($_POST['new_page_title']);
        $slug           =   sanitize_text_field($_POST['new_page_template']);
     

        $new_page_id    =   wpestate_create_new_page($title,$slug);
       
      
        wp_redirect(  get_edit_post_link($new_page_id,'x') );
        exit();
    }
}

//////////////////////////////////////////
//Add New Property dashboard admin widget
//////////////////////////////////////////
function wpestate_add_new_property_widget(){
    $current_user = wp_get_current_user();
    $userID                 =   $current_user->ID;
  //  $levels                 =   wpestate_world_return_levels();
    $current_listings       =   wpestate_how_many_lisitings();
    $add_link               =   wpestate_get_template_link('user_dashboard_add.php');
    
    print'<div class="dashboard_widget_exp">';
    printf(esc_html__('You have  %1$d listings published:','wpresidence'),$current_listings);
    print '</div>';
    
    $listings = wpestate_my_lisitings();
    print '<ul class="dashboard-widget-list">';
    foreach($listings as $listing){
        print '<li><a href="'.esc_url($listing['url']).'" target="_blank">'.$listing['title'].'</a></li>';
    }
    print '<li>...</li>';
    print '</ul>';
   
    print '<a class="wpestate_admin_button reverse_but"  href="'.$add_link.'">'.esc_html__('Add New Property','wpresidence').'</a>';
 
 
}
function wpestate_how_many_lisitings(){
    $args = array(
        'post_type'         => 'estate_property',
        'post_status'       => 'any',
        'paged'             => -1,
    );
    
    $query = new WP_Query($args);
    
    $current_listed= $query->found_posts;
    wp_reset_postdata();
    wp_reset_query();
    return $current_listed;
    
}


function wpestate_my_lisitings(){
    $args = array(
        'post_type'         => 'estate_property',
        'post_status'       => 'any',
        'posts_per_page'    => 5,
    );
    
    $query      = new WP_Query($args);
    $my_posts   = array();
    
    while($query->have_posts()):
        $query->the_post();
    
        $temp_array['id']   =   get_the_ID();
        $temp_array['url']  =    esc_url( get_permalink() );
        $temp_array['title']=   get_the_title();
        $my_posts[]=$temp_array;
    endwhile;
    
    wp_reset_postdata();
    wp_reset_query();
    return $my_posts;
    
}

///////////////////////////////////////////
//Payments dashboard widget
//////////////////////////////////////////
function wpestate_add_payments_widget(){

    $paypal_status                  =   esc_html( wpresidence_get_option('wp_estate_paypal_api','') );
    print '<div class="dashboard_widget_exp">';
    if($paypal_status=='sandbox'){
        print esc_html__('Your Payment system is in SANDBOX mode.','wpresidence');
    }else{
        print esc_html__('Your Payment system is in LIVE mode.','wpresidence');
    }
    print '</div>';
            
    
    
    $submission_curency             =   esc_html( wpresidence_get_option('wp_estate_submission_curency','') );
    $currency_label_main            =   esc_html( wpresidence_get_option('wp_estate_currency_label_main','') );
   
    print '<div class="dashboard_widget_exp">';
    printf( esc_html__('Payments will be procesed in %1$s. Prices are displayed in %2$s','wpresidence'),'<strong>'.$submission_curency.'</strong>','<strong>'.$currency_label_main.'</strong>');
    print'</div>';
    
    $paypal_client_id               =   esc_html( wpresidence_get_option('wp_estate_paypal_client_id','') );
    $paypal_client_secret           =   esc_html( wpresidence_get_option('wp_estate_paypal_client_secret','') );
    $paypal_rec_email               =   esc_html( wpresidence_get_option('wp_estate_paypal_rec_email','') );
    
    if($paypal_client_id=='' || $paypal_client_secret=='' || $paypal_rec_email=='' ){
        print '<div class="dashboard_widget_exp">'.esc_html__('You did not add your Paypal Details. No Paypal payment will be processed','wpresidence').'</div>';
    }else{
        print '<div class="dashboard_widget_exp">'.esc_html__('Paypal Api Keys are added.Payments will be processed.','wpresidence').'</div>';
    }
    
    $stripe_secret_key              =   esc_html( wpresidence_get_option('wp_estate_stripe_secret_key','') );
    $stripe_publishable_key         =   esc_html( wpresidence_get_option('wp_estate_stripe_publishable_key','') );

    if($stripe_secret_key=='' || $stripe_publishable_key=='' ){
        print '<div class="dashboard_widget_exp">'.esc_html__('You did not add your Stripe Details. No Stripe payment will be processed','wpresidence').'</div>';
    }else{
        print '<div class="dashboard_widget_exp">'.esc_html__('Stripe Api Keys are added.Payments will be processed.','wpresidence').'</div>';
    }
    
    
    print '<a class="wpestate_admin_button reverse_but"  href="'.esc_url( home_url('/') ).'wp-admin/admin.php?page='. str_replace(' ','',wp_get_theme()).'&tab=47">'.esc_html__('Edit Payment Details','wpresidence').'</a>';
 
}

