<?php

if( !function_exists('wpestate_dropdowns_theme_admin_with_key') ):
    function wpestate_dropdowns_theme_admin_with_key($array_values,$option_name){
        
        $dropdown_return    =   '';
        $option_value       =   esc_html ( get_option('wp_estate_'.$option_name,'') );
        foreach($array_values as $key=>$value){
            $dropdown_return.='<option value="'.$key.'"';
              if ( $option_value == $key ){
                $dropdown_return.='selected="selected"';
            }
            $dropdown_return.='>'.$value.'</option>';
        }
        
        return $dropdown_return;
        
    }
endif;

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  General Settings
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   

if( !function_exists('wpestate_export_theme_options') ):
function wpestate_export_theme_options(){
    $export_options = array(    
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
        'wp_estate_splash_image',
        'wp_estate_splash_slider_gallery',
        'wp_estate_splash_slider_transition',
        'wp_estate_splash_video_mp4',
        'wp_estate_splash_video_webm',
        'wp_estate_splash_video_ogv',
        'wp_estate_splash_video_cover_img',
        'wp_estate_splash_overlay_image',
        'wp_estate_splash_overlay_color',
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
        'wp_estate_mobile_header_background_color',
        'wp_estate_mobile_header_icon_color',
        'wp_estate_mobile_menu_font_color',
        'wp_estate_mobile_menu_hover_font_color',
        'wp_estate_mobile_item_hover_back_color',
        'wp_estate_mobile_menu_backgound_color',
        'wp_estate_mobile_menu_border_color',
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
        'wp_estate_transparent_logo_image',
        'wp_estate_stikcy_logo_image',
        'wp_estate_logo_image',
        'wp_estate_sidebar_boxed_font_color',
        'wp_estate_sidebar_heading_background_color',
        'wp_estate_map_controls_font_color',
        'wp_estate_map_controls_back',
        'wp_estate_transparent_menu_hover_font_color',
        'wp_estate_transparent_menu_font_color',
        'top_menu_hover_back_font_color',
        'wp_estate_top_menu_hover_type',
        'wp_estate_top_menu_hover_font_color',
        'wp_estate_menu_item_back_color',
        'wp_estate_sticky_menu_font_color',
        'wp_estate_top_menu_font_size',
        'wp_estate_menu_item_font_size',
        'wpestate_uset_unit',
        'wp_estate_sidebarwidget_internal_padding_top',
        'wp_estate_sidebarwidget_internal_padding_left',
        'wp_estate_sidebarwidget_internal_padding_bottom',
        'wp_estate_sidebarwidget_internal_padding_right',
        'wp_estate_widget_sidebar_border_size',
        'wp_estate_widget_sidebar_border_color',
        'wp_estate_unit_border_color',
        'wp_estate_unit_border_size',
        'wp_estate_blog_unit_min_height',
        'wp_estate_agent_unit_min_height',
        'wp_estate_agent_listings_per_row',
        'wp_estate_blog_listings_per_row',
        'wp_estate_content_area_back_color',
        'wp_estate_contentarea_internal_padding_top',
        'wp_estate_contentarea_internal_padding_left',
        'wp_estate_contentarea_internal_padding_bottom',
        'wp_estate_contentarea_internal_padding_right',
        'wp_estate_property_unit_color',
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
        'wp_estate_prop_unit_min_height',
        'wp_estate_main_grid_content_width',
        'wp_estate_header_height',
        'wp_estate_sticky_header_height',
        'wp_estate_border_bottom_header_sticky_color',
        'wp_estate_border_bottom_header_color',
        'wp_estate_show_top_bar_user_login',
        'wp_estate_show_top_bar_user_menu',
        'wp_estate_currency_symbol',
        'wp_estate_where_currency_symbol',
        'wp_estate_measure_sys',
        'wp_estate_facebook_login',
        'wp_estate_google_login',
        'wp_estate_yahoo_login',
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
        'wp_estate_top_bar_back',
        'wp_estate_top_bar_font',
        'wp_estate_adv_search_back_color',
        'wp_estate_adv_search_font_color',
        'wp_estate_box_content_back_color',
        'wp_estate_box_content_border_color',
        'wp_estate_hover_button_color',
        'wp_estate_show_g_search',
        'wp_estate_show_adv_search_extended',
        'wp_estate_readsys',
        'wp_estate_map_max_pins',
        'wp_estate_ssl_map',
        'wp_estate_enable_stripe',    
        'wp_estate_enable_paypal',    
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
        'wp_estate_facebook_link',
        'wp_estate_twitter_link',
        'wp_estate_pinterest_link',
        'wp_estate_instagram_link',
        'wp_estate_linkedin_link',
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
        'wp_estate_wp_estate_adv_back_color',
        'wp_estate_adv_font_color',
        'wp_estate_show_no_features',
        'wp_estate_advanced_exteded',
        'wp_estate_adv_search_what',
        'wp_estate_adv_search_how',
        'wp_estate_adv_search_label',
        'wp_estate_adv_search_type',
        'wp_estate_property_adr_text',
        'wp_estate_property_features_text',
        'wp_estate_property_description_text',
        'wp_estate_property_details_text',
        'wp_estate_new_status',
        'wp_estate_status_list',
        'wp_estate_theme_slider',
        'wp_estate_slider_cycle',
        'wp_estate_use_mimify',
        'wp_estate_currency_label_main',
        'wp_estate_footer_background',
        'wp_estate_wide_footer',
        'wp_estate_show_footer',
    '   wp_estate_show_footer_copy',
        'wp_estate_footer_type',
        'wp_estate_logo_header_type',
        'wp_estate_wide_header',
        'wp_estate_logo_header_align',
        'wp_estate_text_header_align',
        'wp_estate_general_country',
        'wp_estate_show_submit'
        );
    
  
    
    $return_exported_data=array();
    // esc_html( get_option('wp_estate_where_currency_symbol') );
    foreach($export_options as $option){
        $real_option=get_option($option);
        
        if(is_array($real_option)){
            $return_exported_data[$option]= get_option($option) ;
        }else{
            $return_exported_data[$option]=esc_html( get_option($option) );
        }
     
    }
    
    if(function_exists('wpestate_return_imported_data_encoded')){
        return wpestate_return_imported_data_encoded($return_exported_data);
    }else{
        return '';
    }
    
}
endif;



if( !function_exists('wpestate_general_country_list') ):
    function wpestate_general_country_list($selected){
        $countries = array(esc_html__("Afghanistan","wpresidence"),esc_html__("Albania","wpresidence"),esc_html__("Algeria","wpresidence"),esc_html__("American Samoa","wpresidence"),esc_html__("Andorra","wpresidence"),esc_html__("Angola","wpresidence"),esc_html__("Anguilla","wpresidence"),esc_html__("Antarctica","wpresidence"),esc_html__("Antigua and Barbuda","wpresidence"),esc_html__("Argentina","wpresidence"),esc_html__("Armenia","wpresidence"),esc_html__("Aruba","wpresidence"),esc_html__("Australia","wpresidence"),esc_html__("Austria","wpresidence"),esc_html__("Azerbaijan","wpresidence"),esc_html__("Bahamas","wpresidence"),esc_html__("Bahrain","wpresidence"),esc_html__("Bangladesh","wpresidence"),esc_html__("Barbados","wpresidence"),esc_html__("Belarus","wpresidence"),esc_html__("Belgium","wpresidence"),esc_html__("Belize","wpresidence"),esc_html__("Benin","wpresidence"),esc_html__("Bermuda","wpresidence"),esc_html__("Bhutan","wpresidence"),esc_html__("Bolivia","wpresidence"),esc_html__("Bosnia and Herzegowina","wpresidence"),esc_html__("Botswana","wpresidence"),esc_html__("Bouvet Island","wpresidence"),esc_html__("Brazil","wpresidence"),esc_html__("British Indian Ocean Territory","wpresidence"),esc_html__("Brunei Darussalam","wpresidence"),esc_html__("Bulgaria","wpresidence"),esc_html__("Burkina Faso","wpresidence"),esc_html__("Burundi","wpresidence"),esc_html__("Cambodia","wpresidence"),esc_html__("Cameroon","wpresidence"),esc_html__("Canada","wpresidence"),esc_html__("Cape Verde","wpresidence"),esc_html__("Cayman Islands","wpresidence"),esc_html__("Central African Republic","wpresidence"),esc_html__("Chad","wpresidence"),esc_html__("Chile","wpresidence"),esc_html__("China","wpresidence"),esc_html__("Christmas Island","wpresidence"),esc_html__("Cocos (Keeling) Islands","wpresidence"),esc_html__("Colombia","wpresidence"),esc_html__("Comoros","wpresidence"),esc_html__("Congo","wpresidence"),esc_html__("Congo, the Democratic Republic of the","wpresidence"),esc_html__("Cook Islands","wpresidence"),esc_html__("Costa Rica","wpresidence"),esc_html__("Cote d'Ivoire","wpresidence"),esc_html__("Croatia (Hrvatska)","wpresidence"),esc_html__("Cuba","wpresidence"),esc_html__('Curacao','wpresidence'),esc_html__("Cyprus","wpresidence"),esc_html__("Czech Republic","wpresidence"),esc_html__("Denmark","wpresidence"),esc_html__("Djibouti","wpresidence"),esc_html__("Dominica","wpresidence"),esc_html__("Dominican Republic","wpresidence"),esc_html__("East Timor","wpresidence"),esc_html__("Ecuador","wpresidence"),esc_html__("Egypt","wpresidence"),esc_html__("El Salvador","wpresidence"),esc_html__("Equatorial Guinea","wpresidence"),esc_html__("Eritrea","wpresidence"),esc_html__("Estonia","wpresidence"),esc_html__("Ethiopia","wpresidence"),esc_html__("Falkland Islands (Malvinas)","wpresidence"),esc_html__("Faroe Islands","wpresidence"),esc_html__("Fiji","wpresidence"),esc_html__("Finland","wpresidence"),esc_html__("France","wpresidence"),esc_html__("France Metropolitan","wpresidence"),esc_html__("French Guiana","wpresidence"),esc_html__("French Polynesia","wpresidence"),esc_html__("French Southern Territories","wpresidence"),esc_html__("Gabon","wpresidence"),esc_html__("Gambia","wpresidence"),esc_html__("Georgia","wpresidence"),esc_html__("Germany","wpresidence"),esc_html__("Ghana","wpresidence"),esc_html__("Gibraltar","wpresidence"),esc_html__("Greece","wpresidence"),esc_html__("Greenland","wpresidence"),esc_html__("Grenada","wpresidence"),esc_html__("Guadeloupe","wpresidence"),esc_html__("Guam","wpresidence"),esc_html__("Guatemala","wpresidence"),esc_html__("Guinea","wpresidence"),esc_html__("Guinea-Bissau","wpresidence"),esc_html__("Guyana","wpresidence"),esc_html__("Haiti","wpresidence"),esc_html__("Heard and Mc Donald Islands","wpresidence"),esc_html__("Holy See (Vatican City State)","wpresidence"),esc_html__("Honduras","wpresidence"),esc_html__("Hong Kong","wpresidence"),esc_html__("Hungary","wpresidence"),esc_html__("Iceland","wpresidence"),esc_html__("India","wpresidence"),esc_html__("Indonesia","wpresidence"),esc_html__("Iran (Islamic Republic of)","wpresidence"),esc_html__("Iraq","wpresidence"),esc_html__("Ireland","wpresidence"),esc_html__("Israel","wpresidence"),esc_html__("Italy","wpresidence"),esc_html__("Jamaica","wpresidence"),esc_html__("Japan","wpresidence"),esc_html__("Jordan","wpresidence"),esc_html__("Kazakhstan","wpresidence"),esc_html__("Kenya","wpresidence"),esc_html__("Kiribati","wpresidence"),esc_html__("Korea, Democratic People's Republic of","wpresidence"),esc_html__("Korea, Republic of","wpresidence"),esc_html__("Kuwait","wpresidence"),esc_html__("Kyrgyzstan","wpresidence"),esc_html__("Lao, People's Democratic Republic","wpresidence"),esc_html__("Latvia","wpresidence"),esc_html__("Lebanon","wpresidence"),esc_html__("Lesotho","wpresidence"),esc_html__("Liberia","wpresidence"),esc_html__("Libyan Arab Jamahiriya","wpresidence"),esc_html__("Liechtenstein","wpresidence"),esc_html__("Lithuania","wpresidence"),esc_html__("Luxembourg","wpresidence"),esc_html__("Macau","wpresidence"),esc_html__("Macedonia (FYROM)","wpresidence"),esc_html__("Madagascar","wpresidence"),esc_html__("Malawi","wpresidence"),esc_html__("Malaysia","wpresidence"),esc_html__("Maldives","wpresidence"),esc_html__("Mali","wpresidence"),esc_html__("Malta","wpresidence"),esc_html__("Marshall Islands","wpresidence"),esc_html__("Martinique","wpresidence"),esc_html__("Mauritania","wpresidence"),esc_html__("Mauritius","wpresidence"),esc_html__("Mayotte","wpresidence"),esc_html__("Mexico","wpresidence"),esc_html__("Micronesia, Federated States of","wpresidence"),esc_html__("Moldova, Republic of","wpresidence"),esc_html__("Monaco","wpresidence"),esc_html__("Mongolia","wpresidence"),esc_html__("Montserrat","wpresidence"),esc_html__("Morocco","wpresidence"),esc_html__("Mozambique","wpresidence"),esc_html__("Montenegro","wpresidence"),esc_html__("Myanmar","wpresidence"),esc_html__("Namibia","wpresidence"),esc_html__("Nauru","wpresidence"),esc_html__("Nepal","wpresidence"),esc_html__("Netherlands","wpresidence"),esc_html__("Netherlands Antilles","wpresidence"),esc_html__("New Caledonia","wpresidence"),esc_html__("New Zealand","wpresidence"),esc_html__("Nicaragua","wpresidence"),esc_html__("Niger","wpresidence"),esc_html__("Nigeria","wpresidence"),esc_html__("Niue","wpresidence"),esc_html__("Norfolk Island","wpresidence"),esc_html__("Northern Mariana Islands","wpresidence"),esc_html__("Norway","wpresidence"),esc_html__("Oman","wpresidence"),esc_html__("Pakistan","wpresidence"),esc_html__("Palau","wpresidence"),esc_html__("Panama","wpresidence"),esc_html__("Papua New Guinea","wpresidence"),esc_html__("Paraguay","wpresidence"),esc_html__("Peru","wpresidence"),esc_html__("Philippines","wpresidence"),esc_html__("Pitcairn","wpresidence"),esc_html__("Poland","wpresidence"),esc_html__("Portugal","wpresidence"),esc_html__("Puerto Rico","wpresidence"),esc_html__("Qatar","wpresidence"),esc_html__("Reunion","wpresidence"),esc_html__("Romania","wpresidence"),esc_html__("Russian Federation","wpresidence"),esc_html__("Rwanda","wpresidence"),esc_html__("Saint Kitts and Nevis","wpresidence"),esc_html__("Saint Martin","wpresidence"),esc_html__("Saint Lucia","wpresidence"),esc_html__("Saint Vincent and the Grenadines","wpresidence"),esc_html__("Samoa","wpresidence"),esc_html__("San Marino","wpresidence"),esc_html__("Sao Tome and Principe","wpresidence"),esc_html__("Saudi Arabia","wpresidence"),esc_html__("Senegal","wpresidence"),esc_html__("Seychelles","wpresidence"),esc_html__("Serbia","wpresidence"),esc_html__("Sierra Leone","wpresidence"),esc_html__("Singapore","wpresidence"),esc_html__("Slovakia (Slovak Republic)","wpresidence"),esc_html__("Slovenia","wpresidence"),esc_html__("Solomon Islands","wpresidence"),esc_html__("Somalia","wpresidence"),esc_html__("South Africa","wpresidence"),esc_html__("South Georgia and the South Sandwich Islands","wpresidence"),esc_html__("Spain","wpresidence"),esc_html__("Sri Lanka","wpresidence"),esc_html__("St. Helena","wpresidence"),esc_html__("St. Pierre and Miquelon","wpresidence"),esc_html__("Sudan","wpresidence"),esc_html__("Suriname","wpresidence"),esc_html__("Svalbard and Jan Mayen Islands","wpresidence"),esc_html__("Swaziland","wpresidence"),esc_html__("Sweden","wpresidence"),esc_html__("Switzerland","wpresidence"),esc_html__("Syrian Arab Republic","wpresidence"),esc_html__("Taiwan, Province of China","wpresidence"),esc_html__("Tajikistan","wpresidence"),esc_html__("Tanzania, United Republic of","wpresidence"),esc_html__("Thailand","wpresidence"),esc_html__("Togo","wpresidence"),esc_html__("Tokelau","wpresidence"),esc_html__("Tonga","wpresidence"),esc_html__("Trinidad and Tobago","wpresidence"),esc_html__("Tunisia","wpresidence"),esc_html__("Turkey","wpresidence"),esc_html__("Turkmenistan","wpresidence"),esc_html__("Turks and Caicos Islands","wpresidence"),esc_html__("Tuvalu","wpresidence"),esc_html__("Uganda","wpresidence"),esc_html__("Ukraine","wpresidence"),esc_html__("United Arab Emirates","wpresidence"),esc_html__("United Kingdom","wpresidence"),esc_html__("United States","wpresidence"),esc_html__("United States Minor Outlying Islands","wpresidence"),esc_html__("Uruguay","wpresidence"),esc_html__("Uzbekistan","wpresidence"),esc_html__("Vanuatu","wpresidence"),esc_html__("Venezuela","wpresidence"),esc_html__("Vietnam","wpresidence"),esc_html__("Virgin Islands (British)","wpresidence"),esc_html__("Virgin Islands (U.S.)","wpresidence"),esc_html__("Wallis and Futuna Islands","wpresidence"),esc_html__("Western Sahara","wpresidence"),esc_html__("Yemen","wpresidence"),esc_html__("Zambia","wpresidence"),esc_html__("Zimbabwe","wpresidence"));
        $country_select='<select id="general_country" style="width: 200px;" name="general_country">';

        foreach($countries as $country){
            $country_select.='<option value="'.$country.'"';  
            if($selected==$country){
                $country_select.='selected="selected"';
            }
            $country_select.='>'.$country.'</option>';
        }

        $country_select.='</select>';
        return $country_select;
    }
endif; // end   wpestate_general_country_list  



if( !function_exists('wpestate_show_advanced_search_options') ):

function  wpestate_show_advanced_search_options($i,$adv_search_what){
    $return_string='';

    $curent_value='';
    if(isset($adv_search_what[$i])){
        $curent_value=$adv_search_what[$i];        
    }
    
   // $curent_value=$adv_search_what[$i];
    $admin_submission_array=array('types',
                                  'categories',
                                  'county / state',
                                  'cities',
                                  'areas',
                                  'wpestate location',
                                  'property price',
                                  'property size',
                                  'property lot size',
                                  'property rooms',
                                  'property bedrooms',
                                  'property bathrooms',
                                  'property address',                               
                                  'property zip',
                                  'property country',
                                  'property status',
                                  'property id',
                                  'keyword'
                                );
    
    foreach($admin_submission_array as $value){

        $return_string.='<option value="'.$value.'" '; 
        if($curent_value==$value){
             $return_string.= ' selected="selected" ';
        }
        $return_string.= '>'.$value.'</option>';    
    }
    
    $i=0;
    $custom_fields = wpresidence_get_option( 'wp_estate_custom_fields', '');
            
    if( !empty($custom_fields)){  
        while($i< count($custom_fields) ){          
            $name =   $custom_fields[$i][0];
            $type =   $custom_fields[$i][1];
            $slug =   str_replace(' ','-',$name);

            $return_string.='<option value="'.$slug.'" '; 
            if($curent_value==$slug){
               $return_string.= ' selected="selected" ';
            }
            $return_string.= '>'.$name.'</option>';    
            $i++;  
        }
    }  
    $slug='none';
    $name='none';
    $return_string.='<option value="'.$slug.'" '; 
    if($curent_value==$slug){
        $return_string.= ' selected="selected" ';
    }
    $return_string.= '>'.$name.'</option>';    

       
    return $return_string;
}
endif; // end   wpestate_show_advanced_search_options  

if( !function_exists('wpestate_show_advanced_search_how') ):
function  wpestate_show_advanced_search_how($i,$adv_search_how){
    $return_string='';
    $curent_value='';
    if (isset($adv_search_how[$i])){
         $curent_value=$adv_search_how[$i];
    }
   
    
    
    $admin_submission_how_array=array('equal',
                                      'greater',
                                      'smaller',
                                      'like',
                                      'date bigger',
                                      'date smaller');
    
    foreach($admin_submission_how_array as $value){
        $return_string.='<option value="'.$value.'" '; 
        if($curent_value==$value){
             $return_string.= ' selected="selected" ';
        }
        $return_string.= '>'.$value.'</option>';    
    }
    return $return_string;
}
endif; // end   wpestate_show_advanced_search_how  