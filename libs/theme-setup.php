<?php


if ( ! function_exists( 'wpestate_convert_redux_wp_estate_multi_curr' ) ):
function wpestate_convert_redux_wp_estate_multi_curr(){
    $custom_fields = get_option( 'wp_estate_multi_curr', true);  
    $cur_code=array();
    $cur_label=array();
    $cur_value=array();
    $cur_positin=array();
    $redux_currency=array();
    
    if(is_array($custom_fields)){
        foreach($custom_fields as $field){
            $cur_code[]=$field[0];
            $cur_label[]=$field[1];
            $cur_value[]=$field[2];
            $cur_positin[]=$field[3];
        }
    }
    
    $redux_currency['add_curr_name']=$cur_code;
    $redux_currency['add_curr_label']=$cur_label;
    $redux_currency['add_curr_value']=$cur_value;  
    $redux_currency['add_curr_order']=$cur_positin;
   
    return $redux_currency;
}
endif;


if ( ! function_exists( 'wpestate_reverse_convert_redux_wp_estate_multi_curr' ) ):
function wpestate_reverse_convert_redux_wp_estate_multi_curr(){
    global $wpresidence_admin;
    $final_array = array();
    if(isset($wpresidence_admin['wpestate_currency']['add_curr_name'])){
        foreach ( $wpresidence_admin['wpestate_currency']['add_curr_name'] as $key=>$value ){
            $temp_array=array();
            $temp_array[0]= $wpresidence_admin['wpestate_currency']['add_curr_name'][$key];
            $temp_array[1]= $wpresidence_admin['wpestate_currency']['add_curr_label'][$key];
            $temp_array[2]= $wpresidence_admin['wpestate_currency']['add_curr_value'][$key];
            $temp_array[3]= $wpresidence_admin['wpestate_currency']['add_curr_order'][$key];

            $final_array[]=$temp_array;
        }
    }
    return $final_array;


}
endif;

if ( ! function_exists( 'wpestate_convert_redux_wp_estate_custom_fields' ) ):
function wpestate_convert_redux_wp_estate_custom_fields(){
    $custom_fields      =   get_option( 'wp_estate_custom_fields', true);  
    $add_field_name     =   array();
    $add_field_label    =   array();
    $add_field_order    =   array();
    $add_field_type     =   array();
    $add_dropdown_order =   array();
      
    $redux_custom_fields=array();
    if(is_array($custom_fields)){
        foreach($custom_fields as $key=>$field){
            $add_field_name[]=$field[0];
            $add_field_label[]=$field[1];
            $add_field_type[]=$field[2];
            $add_field_order[]=$field[3];
            if(isset($field[4])){
            $add_dropdown_order[]=$field[4];
            }
        }
    }
    $redux_custom_fields['add_field_name']=$add_field_name;
    $redux_custom_fields['add_field_label']=$add_field_label;
    $redux_custom_fields['add_field_order']=$add_field_order;  
    $redux_custom_fields['add_field_type']=$add_field_type;
    $redux_custom_fields['add_dropdown_order']=$add_dropdown_order;
    update_option( 'wpestate_custom_fields_list', $redux_custom_fields);  
    return $redux_custom_fields;   
    
}
endif;


if ( ! function_exists( 'wpestate_reverse_convert_redux_wp_estate_custom_fields' ) ):
function wpestate_reverse_convert_redux_wp_estate_custom_fields(){
    global $wpresidence_admin;
    $final_array=array();
   
    if(isset($wpresidence_admin['wpestate_custom_fields_list']['add_field_name'])){
        foreach( $wpresidence_admin['wpestate_custom_fields_list']['add_field_name'] as $key=>$value){
            $temp_array=array();
            $temp_array[0]= $wpresidence_admin['wpestate_custom_fields_list']['add_field_name'][$key];
            $temp_array[1]= $wpresidence_admin['wpestate_custom_fields_list']['add_field_label'][$key];
            $temp_array[3]= $wpresidence_admin['wpestate_custom_fields_list']['add_field_order'][$key];
            $temp_array[2]= $wpresidence_admin['wpestate_custom_fields_list']['add_field_type'][$key];
            if( isset(  $wpresidence_admin['wpestate_custom_fields_list']['add_dropdown_order'][$key] ) ){
                $temp_array[4]= $wpresidence_admin['wpestate_custom_fields_list']['add_dropdown_order'][$key];
            }
            $final_array[]=$temp_array;
        }
    }
    
    usort($final_array,"wpestate_sorting_function");
    
    return $final_array;
}

endif;


function wpestate_convert_to_redux_framework(){
    global $global_values;
    $all_options = array(
        'wp_estate_paypal_api',
        'wp_estate_use_optima',
        'wp_estate_yelp_dist_measure',
        'wp_estate_yelp_results_no',
        'wp_estate_yelp_categories',
        'wp_estate_yelp_client_api_key_2018',
        'wp_estate_yelp_client_id',
        'wp_estate_recaptha_secretkey',
        'wp_estate_recaptha_sitekey',
        'wp_estate_use_captcha',
        'wp_estate_walkscore_api',
        'wp_estate_generate_pins',
        'wp_estate_twitter_cache_time',
        'wp_estate_twitter_access_secret',
        'wp_estate_twitter_access_token',
        'wp_estate_twitter_consumer_secret',
        'wp_estate_twitter_consumer_key',
        'wp_estate_email_adr',
        'wp_estate_duplicate_email_adr',
        'wp_estate_show_sticky_footer',
        'wp_estate_global_header',
        'wp_estate_show_top_bar_user_menu_mobile',
        'wp_estate_google_analytics_code',
        'wp_estate_show_reviews_prop',
        'wp_estate_enable_direct_mess',
        'wp_estate_admin_approves_reviews',
        'wp_estate_header5_info_widget1_icon',
        'wp_estate_header5_info_widget1_text1',
        'wp_estate_header5_info_widget1_text2',
        'wp_estate_header5_info_widget2_icon',
        'wp_estate_header5_info_widget2_text1',
        'wp_estate_header5_info_widget2_text2',
        'wp_estate_header5_info_widget3_text2',
        'wp_estate_header5_info_widget3_text1',
        'wp_estate_header5_info_widget3_icon',
        'wp_estate_spash_header_type',
        'wp_estate_splash_slider_gallery',
        'wp_estate_splash_slider_transition',
        'wp_estate_splash_overlay_opacity',
        'wp_estate_splash_page_title',
        'wp_estate_splash_page_subtitle',
        'wp_estate_splash_page_logo_link',    
        'wp_estate_theme_slider_height',
        'wp_estate_sticky_search',
        'wp_estate_use_geo_location',
        'wp_estate_geo_radius_measure',
        'wp_estate_initial_radius',
        'wp_estate_min_geo_radius',
        'wp_estate_max_geo_radius',
        'wp_estate_paralax_header',
        'wp_estate_keep_max',
        'wp_estate_adv_back_color_opacity',
        'wp_estate_search_on_start',
        'wp_estate_use_float_search_form',
        'wp_estate_float_form_top',
        'wp_estate_float_form_top_tax',
        'wp_estate_use_price_pins',
        'wp_estate_use_price_pins_full_price',
        'wp_estate_use_single_image_pin',
        'wpestate_export_theme_options',
        'wp_estate_crop_images_lightbox',
        'wp_estate_show_lightbox_contact',
        'wp_estate_submission_page_fields',
        'wp_estate_mandatory_page_fields',
        'wp_estate_url_rewrites',
        'wp_estate_print_show_subunits',
        'wp_estate_print_show_agent',
        'wp_estate_print_show_description',
        'wp_estate_print_show_adress',
        'wp_estate_print_show_details',
        'wp_estate_print_show_features',
        'wp_estate_print_show_floor_plans',
        'wp_estate_print_show_images',
        'wp_estate_show_header_dashboard',
        'wp_estate_property_multi_text',                
        'wp_estate_property_multi_child_text', 
        'wp_estate_theme_slider_type',
        'wp_estate_adv6_taxonomy',
        'wp_estate_adv6_taxonomy_terms',   
        'wp_estate_adv6_max_price',     
        'wp_estate_adv6_min_price',
        'wp_estate_adv_search_fields_no',
        'wp_estate_search_fields_no_per_row',
        'wp_estate_property_sidebar',
        'wp_estate_property_sidebar_name',
        'wp_estate_show_breadcrumbs',
        'wp_estate_global_property_page_template',
        'wp_estate_p_fontfamily',
        'wp_estate_p_fontsize',
        'wp_estate_p_fontsubset',
        'wp_estate_p_lineheight',
        'wp_estate_p_fontweight',
        'wp_estate_h1_fontfamily',
        'wp_estate_h1_fontsize',
        'wp_estate_h1_fontsubset',
        'wp_estate_h1_lineheight',
        'wp_estate_h1_fontweight',
        'wp_estate_h2_fontfamily',
        'wp_estate_h2_fontsize',
        'wp_estate_h2_fontsubset',
        'wp_estate_h2_lineheight',
        'wp_estate_h2_fontweight',
        'wp_estate_h3_fontfamily',
        'wp_estate_h3_fontsize',
        'wp_estate_h3_fontsubset',
        'wp_estate_h3_lineheight',
        'wp_estate_h3_fontweight',
        'wp_estate_h4_fontfamily',
        'wp_estate_h4_fontsize',
        'wp_estate_h4_fontsubset',
        'wp_estate_h4_lineheight',
        'wp_estate_h4_fontweight',
        'wp_estate_h5_fontfamily',
        'wp_estate_h5_fontsize',
        'wp_estate_h5_fontsubset',
        'wp_estate_h5_lineheight',
        'wp_estate_h5_fontweight',
        'wp_estate_h6_fontfamily',
        'wp_estate_h6_fontsize',
        'wp_estate_h6_fontsubset',
        'wp_estate_h6_lineheight',
        'wp_estate_h6_fontweight',
        'wp_estate_menu_fontfamily',
        'wp_estate_menu_fontsize',
        'wp_estate_menu_fontsubset',
        'wp_estate_menu_lineheight',
        'wp_estate_menu_fontweight',
        'wp_estate_top_menu_hover_type',
        'wp_estate_map_controls_back',
        'wp_estate_top_menu_font_size',
        'wp_estate_menu_item_font_size',
        'wpestate_uset_unit',
        'wp_estate_sidebarwidget_internal_padding_top',
        'wp_estate_sidebarwidget_internal_padding_left',
        'wp_estate_sidebarwidget_internal_padding_bottom',
        'wp_estate_sidebarwidget_internal_padding_right',
        'wp_estate_widget_sidebar_border_size',
        'wp_estate_unit_border_size',
        'wp_estate_blog_unit_min_height',
        'wp_estate_agent_unit_min_height',
        'wp_estate_agent_listings_per_row',
        'wp_estate_blog_listings_per_row',
        'wp_estate_contentarea_internal_padding_top',
        'wp_estate_contentarea_internal_padding_left',
        'wp_estate_contentarea_internal_padding_bottom',
        'wp_estate_contentarea_internal_padding_right',
        'wp_estate_propertyunit_internal_padding_top',
        'wp_estate_propertyunit_internal_padding_left',
        'wp_estate_propertyunit_internal_padding_bottom',
        'wp_estate_propertyunit_internal_padding_right',       
        'wpestate_property_unit_structure',
        'wpestate_property_page_content',
        'wp_estate_main_grid_content_width',
        'wp_estate_main_content_width',
        'wp_estate_header_height',
        'wp_estate_sticky_header_height',
        'wp_estate_border_radius_corner',
        'wp_estate_cssbox_shadow',
        'wp_estate_prop_unit_min_height',
        'wp_estate_border_bottom_header',
        'wp_estate_sticky_border_bottom_header',
        'wp_estate_listings_per_row',
        'wp_estate_unit_card_type',
        'wp_estate_main_grid_content_width',
        'wp_estate_show_top_bar_user_login',
        'wp_estate_show_top_bar_user_menu',
        'wp_estate_currency_symbol',
        'wp_estate_where_currency_symbol',
        'wp_estate_measure_sys',
        'wp_estate_facebook_login',
        'wp_estate_facebook_api',
        'wp_estate_facebook_secret',
        'wp_estate_google_login',
        'wp_estate_google_oauth_api',
        'wp_estate_google_oauth_client_secret',
        'wp_estate_google_api_key',
        'wp_estate_yahoo_login',
        'wp_estate_use_gdpr',
        'wp_estate_show_adv_search_tax',
        'wp_estate_wide_status',
        'wp_estate_header_type',
        'wp_estate_prop_no',
        'wp_estate_prop_image_number',
        'wp_estate_show_empty_city',
        'wp_estate_blog_sidebar',
        'wp_estate_blog_sidebar_name',
        'wp_estate_blog_unit',
        'wp_estate_general_latitude',
        'wp_estate_general_longitude',
        'wp_estate_default_map_zoom',
        'wp_estate_cache',
        'wp_estate_show_adv_search_map_close',
        'wp_estate_pin_cluster',
        'wp_estate_zoom_cluster',
        'wp_estate_hq_latitude',
        'wp_estate_hq_longitude',
        'wp_estate_idx_enable',
        'wp_estate_geolocation_radius',
        'wp_estate_min_height',
        'wp_estate_max_height',
        'wp_estate_keep_min',
        'wp_estate_paid_submission',
        'wp_estate_admin_submission',
        'wp_estate_admin_submission_user_role',
        'wp_estate_price_submission',
        'wp_estate_price_featured_submission',
        'wp_estate_submission_curency',
        'wp_estate_free_mem_list',
        'wp_estate_free_feat_list',
        'wp_estate_free_feat_list_expiration',
        'wp_estate_free_pack_image_included',
        'wp_estate_custom_advanced_search',
        'wp_estate_adv_search_type',
        'wp_estate_show_adv_search',
        'wp_estate_show_adv_search_map_close',
        'wp_estate_cron_run',
        'wp_estate_show_no_features',
        'wp_estate_property_features_text',
        'wp_estate_property_description_text',
        'wp_estate_property_details_text',
        'wp_estate_status_list',
        'wp_estate_slider_cycle',
        'wp_estate_show_save_search',
        'wp_estate_search_alert',
        'wp_estate_adv_search_type',
        'wp_estate_color_scheme',
        'wp_estate_top_bar_back',
        'wp_estate_top_bar_font',      
        'wp_estate_show_g_search',
        'wp_estate_show_adv_search_extended',
        'wp_estate_readsys',
        'wp_estate_map_max_pins',
        'wp_estate_ssl_map',
        'wp_estate_api_key',
        'wp_estate_enable_stripe', 
        'wp_estate_stripe_secret_key',
        'wp_estate_stripe_publishable_key',
        'wp_estate_enable_paypal',
        'wp_estate_paypal_client_id',
        'wp_estate_paypal_client_secret',
        'wp_estate_paypal_rec_email',
        'wp_estate_enable_direct_pay',    
        'wp_estate_global_property_page_agent_sidebar',
        'wp_estate_global_prpg_slider_type',
        'wp_estate_global_prpg_content_type',
        'wp_estate_logo_margin',
        'wp_estate_header_transparent',
        'wp_estate_default_map_type',
        'wp_estate_prices_th_separator',
        'wp_estate_multi_curr',
        'wp_estate_date_lang',
        'wp_estate_blog_unit',
        'wp_estate_enable_autocomplete',
        'wp_estate_visible_user_role_dropdown',
        'wp_estate_visible_user_role',
        'wp_estate_show_reviews_block',
        'wp_estate_enable_user_pass',
        'wp_estate_auto_curency',
        'wp_estate_status_list',
        'wp_estate_custom_fields',
        'wp_estate_subject_password_reset_request',
        'wp_estate_password_reset_request',
        'wp_estate_subject_password_reseted',
        'wp_estate_password_reseted',
        'wp_estate_subject_purchase_activated',
        'wp_estate_purchase_activated',
        'wp_estate_subject_approved_listing',
        'wp_estate_approved_listing',
        'wp_estate_subject_new_wire_transfer',
        'wp_estate_new_wire_transfer',
        'wp_estate_subject_admin_new_wire_transfer',
        'wp_estate_admin_new_wire_transfer',
        'wp_estate_subject_admin_new_user',
        'wp_estate_admin_new_user',
        'wp_estate_subject_new_user',
        'wp_estate_new_user',
        'wp_estate_subject_admin_expired_listing',
        'wp_estate_admin_expired_listing',
        'wp_estate_subject_matching_submissions',
        'wp_estate_subject_paid_submissions',
        'wp_estate_paid_submissions',
        'wp_estate_subject_featured_submission',
        'wp_estate_featured_submission',
        'wp_estate_subject_account_downgraded',
        'wp_estate_account_downgraded',
        'wp_estate_subject_membership_cancelled',
        'wp_estate_membership_cancelled',
        'wp_estate_subject_downgrade_warning',
        'wp_estate_downgrade_warning',
        'wp_estate_subject_membership_activated',
        'wp_estate_membership_activated',
        'wp_estate_subject_free_listing_expired',
        'wp_estate_free_listing_expired',
        'wp_estate_subject_new_listing_submission',
        'wp_estate_new_listing_submission',
        'wp_estate_subject_listing_edit',
        'wp_estate_listing_edit',
        'wp_estate_subject_recurring_payment',
        'wp_estate_subject_recurring_payment',
        'wp_estate_custom_css',
        'wp_estate_company_name',
        'wp_estate_telephone_no',
        'wp_estate_mobile_no',
        'wp_estate_fax_ac',
        'wp_estate_skype_ac',
        'wp_estate_co_address',
        'wp_estate_google_link',
        'wp_estate_facebook_link',
        'wp_estate_twitter_link',
        'wp_estate_pinterest_link',
        'wp_estate_instagram_link',
        'wp_estate_linkedin_link',
        'wp_estate_zillow_api_key',
        'wp_estate_contact_form_7_agent',
        'wp_estate_contact_form_7_contact',
        'wp_estate_global_revolution_slider',
        'wp_estate_repeat_footer_back',
        'wp_estate_prop_list_slider',
        'wp_estate_agent_sidebar',
        'wp_estate_agent_sidebar_name',
        'wp_estate_property_list_type',
        'wp_estate_property_list_type_adv',
        'wp_estate_prop_unit',
        'wp_estate_general_font',
        'wp_estate_headings_font_subset',
        'wp_estate_copyright_message',
        'wp_estate_show_graph_prop_page',
        'wp_estate_map_style',
        'wp_estate_submission_curency_custom',
        'wp_estate_free_mem_list_unl',
        'wp_estate_adv_search_what',
        'wp_estate_adv_search_how',
        'wp_estate_adv_search_label',
        'wp_estate_show_save_search',
        'wp_estate_show_adv_search_slider',
        'wp_estate_show_adv_search_visible',
        'wp_estate_show_slider_price',
        'wp_estate_show_dropdowns',
        'wp_estate_show_slider_min_price',
        'wp_estate_show_slider_max_price', 
        'wp_estate_show_no_features',
        'wp_estate_advanced_exteded',
        'wp_estate_adv_search_what',
        'wp_estate_adv_search_how',
        'wp_estate_adv_search_label',
        'wp_estate_adv_search_type',
        'wp_estate_show_adv_search_general',
        'wp_estate_property_adr_text',
        'wp_estate_property_features_text',
        'wp_estate_property_description_text',
        'wp_estate_property_details_text',
        'wp_estate_new_status',
        'wp_estate_status_list',
        'wp_estate_theme_slider',
        'wp_estate_slider_cycle',
        'wp_estate_use_mimify',
        'wp_estate_no_id',
        'wp_estate_remove_script_version',
        'wp_estate_currency_label_main',
        'wp_estate_footer_background',
        'wp_estate_wide_footer',
        'wp_estate_show_footer',
        'wp_estate_show_footer_copy',
        'wp_estate_footer_type',
        'wp_estate_logo_header_type',
        'wp_estate_wide_header',
        'wp_estate_logo_header_align',
        'wp_estate_text_header_align',
        'wp_estate_general_country',
        'wp_estate_show_submit',
        'wp_estate_favicon_image',
        'wp_estate_logo_image',
        'wp_estate_stikcy_logo_image',
        'wp_estate_transparent_logo_image',
        'wp_estate_mobile_logo_image',
        'wp_estate_splash_image',
        'wp_estate_splash_video_mp4',
        'wp_estate_splash_video_webm',
        'wp_estate_splash_video_ogv',
        'wp_estate_splash_video_cover_img',
        'wp_estate_splash_overlay_image',
        'wp_estate_company_contact_image',
        'wp_estate_wp_estate_adv_back_color',
        'wp_estate_adv_font_color',
        'wp_estate_splash_overlay_color',
        'wp_estate_content_area_back_color',
        'wp_estate_main_color',
        'wp_estate_second_color',
        'wp_estate_background_color',
        'wp_estate_content_back_color',
        'wp_estate_header_color',
        'wp_estate_breadcrumbs_font_color',
        'wp_estate_font_color',
        'wp_estate_menu_items_color',
        'wp_estate_link_color',
        'wp_estate_headings_color',
        'wp_estate_sidebar_heading_boxed_color',
        'wp_estate_sidebar_widget_color',
        'wp_estate_footer_back_color',
        'wp_estate_footer_font_color',
        'wp_estate_footer_copy_color',
        'wp_estate_footer_copy_back_color',
        'wp_estate_menu_font_color',
        'wp_estate_menu_hover_back_color',
        'wp_estate_menu_hover_font_color',
        'wp_estate_menu_border_color',
        'wp_estate_adv_search_back_color',
        'wp_estate_adv_search_font_color',
        'wp_estate_box_content_back_color',
        'wp_estate_box_content_border_color',
        'wp_estate_hover_button_color',
        'wp_estate_sidebar_boxed_font_color',
        'wp_estate_sidebar_heading_background_color',
        'wp_estate_map_controls_font_color',
        'wp_estate_border_bottom_header_sticky_color',
        'wp_estate_border_bottom_header_color',
        'wp_estate_transparent_menu_hover_font_color',
        'wp_estate_transparent_menu_font_color',
        'top_menu_hover_back_font_color',
        'wp_estate_top_menu_hover_font_color',
        'wp_estate_menu_item_back_color',
        'wp_estate_sticky_menu_font_color',
        'wp_estate_active_menu_font_color',
        'wp_estate_top_menu_hover_back_font_color',
        'wp_estate_mobile_header_background_color',
        'wp_estate_mobile_header_icon_color',
        'wp_estate_mobile_menu_font_color',
        'wp_estate_mobile_menu_hover_font_color',
        'wp_estate_mobile_item_hover_back_color',
        'wp_estate_mobile_menu_backgound_color',
        'wp_estate_mobile_menu_border_color',
        'wp_estate_property_unit_color',
        'wp_estate_widget_sidebar_border_color',
        'wp_estate_unit_border_color',
        'wp_estate_user_dashboard_menu_color',
        'wp_estate_user_dashboard_menu_hover_color',
        'wp_estate_user_dashboard_menu_color_hover',
        'wp_estate_user_dashboard_menu_back',
        'wp_estate_user_dashboard_package_back',
        'wp_estate_user_dashboard_package_color',
        'wp_estate_user_dashboard_buy_package',
        'wp_estate_user_dashboard_package_select',
        'wp_estate_user_dashboard_content_back',
        'wp_estate_user_dashboard_content_button_back',
        'wp_estate_user_dashboard_content_color',
        'wp_estate_userpin',
        'wp_estate_idxpin',
        'wp_estate_direct_payment_details'
    );
    
    
    $images_array=array(
        'wp_estate_favicon_image',
        'wp_estate_logo_image',
        'wp_estate_stikcy_logo_image',
        'wp_estate_transparent_logo_image',
        'wp_estate_mobile_logo_image',
        'wp_estate_splash_image',
        'wp_estate_splash_video_mp4',
        'wp_estate_splash_video_webm',
        'wp_estate_splash_video_ogv',
        'wp_estate_splash_video_cover_img',
        'wp_estate_splash_overlay_image',
        'wp_estate_company_contact_image',
        'wp_estate_global_header',
        'wp_estate_footer_background',
        'wp_estate_userpin',
        'wp_estate_idxpin'
    );
    
    $color_array=array(
        'wp_estate_wp_estate_adv_back_color',
        'wp_estate_adv_font_color',
        'wp_estate_splash_overlay_color',
        'wp_estate_content_area_back_color',
        'wp_estate_main_color',
        'wp_estate_second_color',
        'wp_estate_background_color',
        'wp_estate_content_back_color',
        'wp_estate_header_color',
        'wp_estate_breadcrumbs_font_color',
        'wp_estate_font_color',
        'wp_estate_menu_items_color',
        'wp_estate_link_color',
        'wp_estate_headings_color',
        'wp_estate_sidebar_heading_boxed_color',
        'wp_estate_sidebar_widget_color',
        'wp_estate_footer_back_color',
        'wp_estate_footer_font_color',
        'wp_estate_footer_copy_color',
        'wp_estate_footer_copy_back_color',
        'wp_estate_menu_font_color',
        'wp_estate_menu_hover_back_color',
        'wp_estate_menu_hover_font_color',
        'wp_estate_menu_border_color',
        'wp_estate_adv_search_back_color',
        'wp_estate_adv_search_font_color',
        'wp_estate_box_content_back_color',
        'wp_estate_box_content_border_color',
        'wp_estate_hover_button_color',
        'wp_estate_sidebar_boxed_font_color',
        'wp_estate_sidebar_heading_background_color',
        'wp_estate_map_controls_font_color',
        'wp_estate_border_bottom_header_sticky_color',
        'wp_estate_border_bottom_header_color',
        'wp_estate_transparent_menu_hover_font_color',
        'wp_estate_transparent_menu_font_color',
        'top_menu_hover_back_font_color',
        'wp_estate_top_menu_hover_font_color',
        'wp_estate_menu_item_back_color',
        'wp_estate_sticky_menu_font_color',
        'wp_estate_active_menu_font_color',
        'wp_estate_top_menu_hover_back_font_color',
        'wp_estate_mobile_header_background_color',
        'wp_estate_mobile_header_icon_color',
        'wp_estate_mobile_menu_font_color',
        'wp_estate_mobile_menu_hover_font_color',
        'wp_estate_mobile_item_hover_back_color',
        'wp_estate_mobile_menu_backgound_color',
        'wp_estate_mobile_menu_border_color',
        'wp_estate_property_unit_color',
        'wp_estate_widget_sidebar_border_color',
        'wp_estate_unit_border_color',
        'wp_estate_user_dashboard_menu_color',
        'wp_estate_user_dashboard_menu_hover_color',
        'wp_estate_user_dashboard_menu_color_hover',
        'wp_estate_user_dashboard_menu_back',
        'wp_estate_user_dashboard_package_back',
        'wp_estate_user_dashboard_package_color',
        'wp_estate_user_dashboard_buy_package',
        'wp_estate_user_dashboard_package_select',
        'wp_estate_user_dashboard_content_back',
        'wp_estate_user_dashboard_content_button_back',
        'wp_estate_user_dashboard_content_color',
    );
    
    $mandatory_fields           =   ( get_option('wp_estate_mandatory_page_fields','') );
    Redux::setOption('wpresidence_admin','wp_estate_mandatory_page_fields', $mandatory_fields);
    
    foreach ($all_options as $option){
        $option_value = get_option( $option, '');
        
 
            
        if($option=='wp_estate_custom_fields'){
            $option_value = wpestate_convert_redux_wp_estate_custom_fields();
            Redux::setOption('wpresidence_admin','wpestate_custom_fields_list', $option_value);
        }else if($option=='wp_estate_multi_curr'){
            $option_value = wpestate_convert_redux_wp_estate_multi_curr();
            Redux::setOption('wpresidence_admin','wpestate_currency', $option_value);
        
        }else if(in_array($option, $images_array)){
            $option_value   =   get_option( $option, ''); 
            $option_array   =   array('url'=>$option_value);
            Redux::setOption('wpresidence_admin',$option, $option_array);
        }else if(in_array($option, $color_array)){
            $option_value=  get_option( $option, '');
            if($option_value!=''){
                $option_value   =   '#'.get_option( $option, ''); 
            }
            Redux::setOption('wpresidence_admin',$option, $option_value);
        }else if($option=='wp_estate_blog_sidebar_name'){
            $option_value   =   get_option( 'wp_estate_blog_sidebar_name', '');
            if(isset($GLOBALS['wp_registered_sidebars'][$option_value])){
                $sidebar_value  =   $GLOBALS['wp_registered_sidebars'][$option_value];
                Redux::setOption('wpresidence_admin','wp_estate_blog_sidebar_name', $sidebar_value); 
            }
        }else{
            Redux::setOption('wpresidence_admin',$option, $option_value);
        }
      
    }
    
    
    
    
    $adv_search_what    = get_option('wp_estate_adv_search_what','');
    $adv_search_how     = get_option('wp_estate_adv_search_how','');
    $adv_search_label   = get_option('wp_estate_adv_search_label','');
    $adv_search_icon    = get_option('wp_estate_search_field_label','');
    
    $wpestate_set_search_array=array();
    $wpestate_set_search_array['adv_search_what']=$adv_search_what;
    $wpestate_set_search_array['adv_search_how']=$adv_search_how;
    $wpestate_set_search_array['adv_search_label']=$adv_search_label;
    $wpestate_set_search_array['search_field_label']=$adv_search_icon;
    
    Redux::setOption('wpresidence_admin','wpestate_set_search', $wpestate_set_search_array);
    
    
    

    
    
    /// pins management 
    $taxonomy = 'property_action_category';
    $tax_terms = get_terms($taxonomy,'hide_empty=0');

    if(is_array($tax_terms)){
        foreach ($tax_terms as $tax_term) { 

            $name                    =  sanitize_key( wpestate_limit64('wp_estate_'.$tax_term->slug) );
            $limit54                 =  sanitize_key( wpestate_limit54($tax_term->slug));
            $option_value            =  get_option( $name, '');
            $option_array            =  array('url'=>$option_value);
            Redux::setOption('wpresidence_admin',$name, $option_array);
        }   
    }
    
    
    $taxonomy_cat = 'property_category';
    $categories = get_terms($taxonomy_cat,'hide_empty=0');
    if(is_array($categories)){
        foreach ($categories as $categ) {  
            $name                           =   sanitize_key ( wpestate_limit64('wp_estate_'.$categ->slug) );
            $limit54                        =   sanitize_key(wpestate_limit54($categ->slug));
            $option_value                   =   get_option( $name, '');
            $option_array                   =   array('url'=>$option_value);
            Redux::setOption('wpresidence_admin',$name, $option_array);

        }
    }
    if(is_array($tax_terms)){
        foreach ($tax_terms as $tax_term) {
            if(is_array($categories)){
                foreach ($categories as $categ) {
                    $limit54                    =   sanitize_key ( wpestate_limit27($categ->slug)).sanitize_key(wpestate_limit27($tax_term->slug) );
                    $name                       =   'wp_estate_'.$limit54;
                    $option_value            =  get_option( $name, '');
                    $option_array            =  array('url'=>$option_value);
                    Redux::setOption('wpresidence_admin',$name, $option_array);
               }
            }

        }
    }
    
    
    
    
    
    
    update_option('wpresidence_convert_to_redux2','yes');  
    
}

?>