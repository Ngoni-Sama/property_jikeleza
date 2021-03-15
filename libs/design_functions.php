<?php
if(!function_exists('wpestate_generate_user_menu')):
    function wpestate_generate_user_menu($place=''){
        $current_user           =   wp_get_current_user();
        $userID                 =   $current_user->ID;
        $user_login             =   $current_user->user_login;  
        $user_agent_id          =   intval( get_user_meta($userID,'user_agent_id',true));
        $add_link               =   wpestate_get_template_link('user_dashboard_add.php');
        $add_agent              =   wpestate_get_template_link('user_dashboard_add_agent.php');
        $dash_profile           =   wpestate_get_template_link('user_dashboard_profile.php');
        $dash_favorite          =   wpestate_get_template_link('user_dashboard_favorite.php');
        $dash_link              =   wpestate_get_template_link('user_dashboard.php');
        $agent_list_link        =   wpestate_get_template_link('user_dashboard_agent_list.php');
        $dash_searches          =   wpestate_get_template_link('user_dashboard_searches.php');
        $dash_showing           =   wpestate_get_template_link('user_dashboard_showing.php');
        $activeprofile          =   '';
        $activedash             =   '';
        $activeadd              =   '';
        $activefav              =   '';
        $activesearch           =   '';
        $activeinvoices         =   '';
        $user_pack              =   get_the_author_meta( 'package_id' , $userID );    
        $clientId               =   esc_html( wpresidence_get_option('wp_estate_paypal_client_id','') );
        $clientSecret           =   esc_html( wpresidence_get_option('wp_estate_paypal_client_secret','') );  
        $user_registered        =   get_the_author_meta( 'user_registered' , $userID );
        $user_package_activation=   get_the_author_meta( 'package_activation' , $userID );
        $home_url               =   esc_url(home_url('/'));
        $dash_invoices          =   wpestate_get_template_link('user_dashboard_invoices.php');
        $dash_inbox             =   wpestate_get_template_link('user_dashboard_inbox.php');
        $activeinbox            =   '';
        $activeshowing          =   '';
        $activeaddagent         =   '';
        $activeagentlist        =   '';
        if ( basename( get_page_template() ) == 'user_dashboard.php' ){
            $activedash  =   'user_tab_active';    
        }else if ( basename( get_page_template() ) == 'user_dashboard_add.php' ){
            $activeadd   =   'user_tab_active';
        }else if ( basename( get_page_template() ) == 'user_dashboard_profile.php' ){
            $activeprofile   =   'user_tab_active';
        }else if ( basename( get_page_template() ) == 'user_dashboard_favorite.php' ){
            $activefav   =   'user_tab_active';
        }else if( basename( get_page_template() ) == 'user_dashboard_searches.php' ){
            $activesearch  =   'user_tab_active';
        }else if( basename( get_page_template() ) == 'user_dashboard_invoices.php' ){
            $activeinvoices  =   'user_tab_active';
        }else if( basename( get_page_template() ) == 'user_dashboard_add_agent.php' ){
            $activeaddagent =   'user_tab_active';
        }else if( basename( get_page_template() ) == 'user_dashboard_agent_list.php' ){
            $activeagentlist =   'user_tab_active';
        }else if( basename( get_page_template() ) == 'user_dashboard_inbox.php' ){
            $activeinbox =   'user_tab_active';
        }else if( basename( get_page_template() ) == 'user_dashboard_showing.php' ){
            $activeshowing =   'user_tab_active';
        } 
    
        $no_unread  =   intval(get_user_meta($userID,'unread_mess',true));   
        $user_role  =   get_user_meta( $current_user->ID, 'user_estate_role', true) ;
        
        if( $dash_profile!=$home_url && $dash_profile!='' ){ ?>
            <li role="presentation">
                <a href="<?php print esc_url($dash_profile);?>" class="<?php print esc_attr($activeprofile); ?>">
                    <i class="fas fa-cog"></i> <?php  esc_html_e('My Profile','wpresidence');?>
                </a>
            </li>
        <?php } ?>
        
        <?php 
        if( $dash_link!=$home_url && $dash_link!='' && wpestate_check_user_permission_on_dashboard( 'user_dashboard' ) ){
            if($user_agent_id==0 || ( $user_agent_id!=0 && get_post_status($user_agent_id)!='pending' && get_post_status($user_agent_id)!='disabled') ){?>
                <li role="presentation">
                    <a href="<?php print esc_url($dash_link);?>"     class="<?php print esc_attr($activedash); ?>">
                       <i class="fas fa-map-marker-alt"></i> <?php esc_html_e('My Properties List','wpresidence');?>
                    </a>
                </li>
        <?php } 
        }?>
            
            
        <?php if( $add_link!=$home_url && $add_link!='' && wpestate_check_user_permission_on_dashboard( 'user_dashboard_add' ) ){
            if($user_agent_id==0 || ( $user_agent_id!=0 && get_post_status($user_agent_id)!='pending' && get_post_status($user_agent_id)!='disabled') ){?>
                <li role="presentation">
                    <a href="<?php print esc_url ($add_link);?>"      class="<?php print esc_attr($activeadd); ?>">
                        <i class="fas fa-plus"></i><?php esc_html_e('Add New Property','wpresidence');?>
                    </a>
                </li>
        <?php }
        } 
      
        
        
        if($user_role==3 || $user_role ==4){
            if( $user_agent_id!=0 && get_post_status($user_agent_id)!='pending'){
            ?>
            <li role="presentation">
                <a href="<?php print esc_url ($add_agent);?>" class="<?php print esc_attr($activeaddagent); ?>">
                    <i class="fas fa-user-plus"></i><?php esc_html_e('Add New Agent','wpresidence');?>
                </a>
            </li> 
            
            <li role="presentation">
                <a href="<?php print esc_url ($agent_list_link);?>" class="<?php print esc_attr($activeagentlist); ?>">
                    <i class="fas fa-user"></i><?php esc_html_e('Agent list','wpresidence');?>
                </a>
            </li>
            
        <?php
            }
        }
        ?>
            
            
            
        <?php if( $dash_favorite!=$home_url && $dash_favorite!=''  && wpestate_check_user_permission_on_dashboard( 'user_dashboard_favorite' ) ){ ?>
            <li role="presentation">
                <a href="<?php print esc_url($dash_favorite);?>" class="<?php print esc_attr($activefav); ?>">
                    <i class="fas fa-heart"></i> <?php esc_html_e('Favorites','wpresidence');?>
                </a>
            </li>
        <?php } ?>
            
            
            
        <?php if( $dash_searches!=$home_url && $dash_searches!=''  && wpestate_check_user_permission_on_dashboard( 'user_dashboard_searches' ) ){ ?>
            <li role="presentation">
                <a href="<?php print esc_url($dash_searches);?>" class="<?php print esc_attr($activesearch); ?>">
                    <i class="fas fa-search"></i> <?php esc_html_e('Saved Searches','wpresidence');?>
                </a>
            </li>
        <?php } 
        
        
        
        if( $dash_invoices!=$home_url && $dash_invoices!=''  && wpestate_check_user_permission_on_dashboard( 'user_dashboard_invoices' ) ){ ?>
            <li role="presentation">
                <a href="<?php print esc_url($dash_invoices);?>" class="<?php print esc_attr($activeinvoices); ?>">
                    <i class="far fa-file-alt"></i><?php esc_html_e('My Invoices','wpresidence');?>
                </a>
            </li>
        <?php } 
        
        
        
        if($dash_inbox!=$home_url && $dash_inbox!='' && wpestate_check_user_permission_on_dashboard( 'user_dashboard_inbox' ) ){ ?>
            <li role="presentation">
                <a href="<?php print esc_url($dash_inbox);?>" class="<?php print esc_attr($activeinbox); ?>"><i class="far fa-envelope"></i> 
                    <?php esc_html_e('Inbox','wpresidence'); 
                        if  ($no_unread>0){
                            echo '<div class="unread_mess">'.intval($no_unread).'</div>';
                        }
                    ?>
                </a>
            </li>
        <?php } ?>
     
            
        
        <?php if($place=='top'){ ?>   
               <li role="presentation" class="divider"></li>
        <?php }?>     
             
        <li role="presentation"><a href="<?php echo wp_logout_url( esc_url(home_url('/') ) );?>" title="Logout"><i class="fas fa-power-off"></i> <?php esc_html_e('Log Out','wpresidence');?></a></li>
        
        <?php
        
    }
endif;




if(!function_exists('wpestate_custom_fonts_elements')):
    function wpestate_custom_fonts_elements(){
        $style='';
        $h1_fontfamily =     ( esc_html( wpresidence_get_option('h1_typo','font-family') ));
        $h1_fontfamily =    wp_specialchars_decode  ( $h1_fontfamily,ENT_QUOTES ); 
        $h1_fontfamily =    str_replace('+', ' ', $h1_fontfamily);
        $h1_fontsubset =    esc_html( wpresidence_get_option('h1_typo','subsets') );
        $h1_fontsize   =    esc_html( wpresidence_get_option('h1_typo','font-size') );
        $h1_lineheight =    esc_html( wpresidence_get_option('h1_typo','line-height') );
        $h1_fontweight =    esc_html( wpresidence_get_option('h1_typo','font-weight') );

       
        if ($h1_fontfamily != '') {
            $style.= 'h1,h1 a{font-family:' . $h1_fontfamily .';}';
        }     
        if ($h1_fontsize != '') { 
            $style.= 'h1,h1 a{font-size:' . $h1_fontsize .';}';
        }
        if ($h1_lineheight != '') {  
            $style.= 'h1,h1 a{line-height:' . $h1_lineheight .';}';
        }
        if ($h1_fontweight != '') {  
            $style.=  'h1,h1 a,.entry-title{font-weight:' . $h1_fontweight .';}';
        }
     
        
        $h2_fontfamily =   (  esc_html( wpresidence_get_option('h2_typo','font-family') ) );
      
       
        $h2_fontfamily =    wp_specialchars_decode  ( $h2_fontfamily,ENT_QUOTES ); 
        $h2_fontfamily =    str_replace('+', ' ', $h2_fontfamily);
        $h2_fontsize   =    esc_html( wpresidence_get_option('h2_typo','font-size'));
        $h2_lineheight =    esc_html( wpresidence_get_option('h2_typo','line-height') );
        $h2_fontweight =    esc_html( wpresidence_get_option('h2_typo','font-weight') );


     
        if ($h2_fontfamily != '') {
            $style.=  'h2,h2 a{font-family:' . $h2_fontfamily .';}';
        }     
        if ($h2_fontsize != '') { 
            $style.=  'h2,h2 a{font-size:' . $h2_fontsize .';}';
        }
        if ($h2_lineheight != '') {  
            $style.=  'h2,h2 a{line-height:' . $h2_lineheight .';}';
        }
        if ($h2_fontweight != '') {  
            $style.=  'h2,h2 a{font-weight:' . $h2_fontweight .';}';
        }
          
 
        $h3_fontfamily =    esc_html(  wpresidence_get_option('h3_typo','font-family') );
        $h3_fontfamily =    wp_specialchars_decode  ( $h3_fontfamily,ENT_QUOTES ); 
        $h3_fontfamily =    str_replace('+', ' ', $h3_fontfamily);
        $h3_fontsize   =    esc_html( wpresidence_get_option('h3_typo','font-size'));
        $h3_lineheight =    esc_html( wpresidence_get_option('h3_typo','line-height') );
        $h3_fontweight =    esc_html( wpresidence_get_option('h3_typo','font-weight') );
     
        if ($h3_fontfamily != '') {
            $style.=  'h3,h3 a{font-family:' . $h3_fontfamily .';}';
        }     
        if ($h3_fontsize != '') { 
            $style.=  'h3,h3 a{font-size:' . $h3_fontsize .';}';
        }if ($h3_lineheight != '') {  
            $style.=  'h3,h3 a{line-height:' . $h3_lineheight .';}';
        }
        if ($h3_fontweight != '') {  
            $style.=  'h3,h3 a{font-weight:' . $h3_fontweight .';}';
        }

        
        $h4_fontfamily =    esc_html( wpresidence_get_option('h4_typo','font-family') );
        $h4_fontfamily =    wp_specialchars_decode  ( $h4_fontfamily,ENT_QUOTES ); 
        $h4_fontfamily =    str_replace('+', ' ', $h4_fontfamily);
        $h4_fontsize   =    esc_html( wpresidence_get_option('h4_typo','font-size') );
        $h4_lineheight =    esc_html( wpresidence_get_option('h4_typo','line-height') );
        $h4_fontweight =    esc_html( wpresidence_get_option('h4_typo','font-weight') );
        
        if ($h4_fontfamily != '') {
             $style.=  'h4,h4 a{font-family:' . $h4_fontfamily .';}';
        }     
        if ($h4_fontsize != '') { 
            $style.=  'h4,h4 a{font-size:' . $h4_fontsize .';}';
        }
        if ($h4_lineheight != '') {  
            $style.=  'h4,h4 a{line-height:' . $h4_lineheight .';}';
        }
        if ($h4_fontweight != '') {  
            $style.=  'h4,h4 a{font-weight:' . $h4_fontweight .';}';
        }
         
        
        $h5_fontfamily =    esc_html( wpresidence_get_option('h5_typo','font-family') );
        $h5_fontfamily =    wp_specialchars_decode  ( $h5_fontfamily,ENT_QUOTES ); 
        $h5_fontfamily =    str_replace('+', ' ', $h5_fontfamily);
        $h5_fontsize   =    esc_html( wpresidence_get_option('h5_typo','font-size') );
        $h5_lineheight =    esc_html( wpresidence_get_option('h5_typo','line-height') );
        $h5_fontweight =    esc_html( wpresidence_get_option('h5_typo','font-weight') );

        if ($h5_fontfamily != '') {
            $style.= 'h5,h5 a{font-family:' . $h5_fontfamily .';}';
        }     
        if ($h5_fontsize != '') { 
            $style.= 'h5,h5 a{font-size:' . $h5_fontsize .';}';
        }
        if ($h5_lineheight != '') {  
            $style.= 'h5,h5 a{line-height:' . $h5_lineheight .';}';
        }
        if ($h5_fontweight != '') {  
            $style.= 'h5,h5 a{font-weight:' . $h5_fontweight .';}';
        }
          
        $h6_fontfamily =    esc_html( wpresidence_get_option('h6_typo','font-family') );
        $h6_fontfamily =    wp_specialchars_decode  ( $h6_fontfamily,ENT_QUOTES );
        $h6_fontfamily =    str_replace('+', ' ', $h6_fontfamily);
        $h6_fontsize   =    esc_html( wpresidence_get_option('h6_typo','font-size') );
        $h6_lineheight =    esc_html( wpresidence_get_option('h6_typo','line-height') );
        $h6_fontweight =    esc_html( wpresidence_get_option('h6_typo','font-weight') );

        if ($h6_fontfamily != '') {
            $style.=  'h6,h6 a{font-family:' . $h6_fontfamily .';}';
        }     
        if ($h6_fontsize != '') { 
           $style.=  'h6,h6 a{font-size:' . $h6_fontsize .';}';
        }if ($h6_lineheight != '') {  
           $style.=  'h6,h6 a{line-height:' . $h6_lineheight .';}';
        }
        if ($h6_fontweight != '') {  
           $style.=  'h6,h6 a{font-weight:' . $h6_fontweight .';}';
        }

      
        $p_fontfamily = esc_html( wpresidence_get_option('paragraph_typo','font-family') );
        $p_fontfamily =    wp_specialchars_decode  ( $p_fontfamily,ENT_QUOTES );
        $p_fontfamily = str_replace('+', ' ', $p_fontfamily);
        $p_fontsize   = esc_html( wpresidence_get_option('paragraph_typo','font-size') );
        $p_lineheight = esc_html( wpresidence_get_option('paragraph_typo','line-height') );
        $p_fontweight = esc_html( wpresidence_get_option('paragraph_typo','font-weight') );

        if ($p_fontfamily != '') {
            $style.=  'body,p{font-family:' . $p_fontfamily .';}';
        }     
        if ($p_fontsize != '') { 
            $style.=  '.single-content,p,.single-estate_property .listing_detail .price_label{font-size:' . $p_fontsize .';}';
        }
        if ($p_lineheight != '') {  
            $style.=  'p{line-height:' . $p_lineheight .';}';
        }
        if ($p_fontweight != '') {  
            $style.=  'p{font-weight:' . $p_fontweight .';}';
        }
          
        $menu_fontfamily =  esc_html( wpresidence_get_option('menu_typo','font-family') );
        $menu_fontfamily =    wp_specialchars_decode  ( $menu_fontfamily,ENT_QUOTES );
        $menu_fontfamily =  str_replace('+', ' ', $menu_fontfamily);
        $menu_fontsize   =  esc_html( wpresidence_get_option('menu_typo','font-size') );
        $menu_lineheight =  esc_html( wpresidence_get_option('menu_typo','line-height') );
        $menu_fontweight =  esc_html( wpresidence_get_option('menu_typo','font-weight') );

       
        if ($menu_fontfamily != '') {
             $style.= '#access a,#access ul ul a,#user_menu_u{font-family:"' . $menu_fontfamily .'";}';
        }     
        if ($menu_fontsize != '') { 
            $style.= '#access a,#user_menu_u{font-size:' . $menu_fontsize .';}';
        }
        
        if ($menu_fontweight != '') {  
            $style.= '#access a,#user_menu_u{font-weight:' . $menu_fontweight .';}';
        }
      
   
        
        if($style!=''){
            print trim($style); 
        }
    }
endif;


if( !function_exists('wpestate_general_design_elements') ):
    function wpestate_general_design_elements(){
        global $post;
        $style='';   
      
        $wp_estate_logo_max_height                            =   esc_html ( wpresidence_get_option('wp_estate_logo_max_height','') );
        if($wp_estate_logo_max_height!=''){
            $style.='.logo img{
                max-height: '.$wp_estate_logo_max_height.'px;
            }';
                      
        }
        
        
      
        $float_form_top                             =   esc_html ( wpresidence_get_option('wp_estate_float_form_top','') );
        $float_search_form                          =   esc_html ( wpresidence_get_option('wp_estate_use_float_search_form','') );
       
        if( is_tax() || is_category() || is_archive() ){
      
         $float_form_top                          =   esc_html ( wpresidence_get_option('wp_estate_float_form_top_tax','') );
        }else{
            
            if ( isset($post->ID)){  
                 
                $float_form_top_local = esc_html ( get_post_meta ( $post->ID, 'use_float_search_form_local', true) );
                if($float_form_top_local!=0){
                    $float_form_top=$float_form_top_local;
                }
            }
        }
        
        if(isset( $post->ID)){
            $post_id = $post->ID;
        }else{
            $post_id = '';
        }

        if( wpestate_float_search_placement($post_id) ){
            $style='
            #search_wrapper {
                top: '.$float_form_top.';
            }';       
        }

        $adv_back_color                 =  esc_html ( wpresidence_get_option('wp_estate_adv_back_color','') );
        $adv_font_color                 =  esc_html ( wpresidence_get_option('wp_estate_adv_font_color','') );
        $adv_back_color_opacity         =  esc_html ( wpresidence_get_option('wp_estate_adv_back_color_opacity','') );
        if( $adv_back_color  !=''){ 
            $style.='
                #search_wrapper.with_search_form_float #search_wrapper_color{
                background-color: '.$adv_back_color.';
            }
            #search_wrapper {
                background:transparent;
            }';
        }
        
        if( $adv_font_color  !=''){ 
            $style.='
            #search_wrapper.with_search_form_float,
            #search_wrapper.with_search_form_float #amount,
            #search_wrapper.with_search_form_float .adv_extended_options_text i,
            #search_wrapper.with_search_form_float .adv_extended_options_text,
            #search_wrapper.with_search_form_float .extended_search_checker label,
            #search_wrapper.with_search_form_float .adv_search_slider label,
            #search_wrapper.with_search_form_float .adv_extended_options_text{
                color: '.$adv_font_color.';
            }
            
            #search_wrapper.with_search_form_float #search_wrapper #amount,
            #search_wrapper.with_search_form_float .adv_search_slider #amount,
            #search_wrapper.with_search_form_float .adv6-holder .adv_search_slider p label, 
            #search_wrapper.with_search_form_float .adv6-holder .adv_search_slider p span,
            #search_wrapper.with_search_form_float #amount_wd {
                color: '.$adv_font_color.'!important;
            }';
        }

        if($adv_back_color_opacity!=''){
            $style.='
                #search_wrapper.with_search_form_float #search_wrapper_color{
                opacity: '.floatval($adv_back_color_opacity).';
            }';
        }
        
        $main_grid_content_width                    =   esc_html ( wpresidence_get_option('wp_estate_main_grid_content_width','') );
        $main_content_width                         =   esc_html ( wpresidence_get_option('wp_estate_main_content_width','') );
        $header_height                              =   esc_html ( wpresidence_get_option('wp_estate_header_height','') );   
        $sticky_header_height                       =   esc_html ( wpresidence_get_option('wp_estate_sticky_header_height','') );
        $border_radius_corner                       =   wpresidence_get_option('wp_estate_border_radius_corner','');
        $cssbox_shadow                              =   wpresidence_get_option('wp_estate_cssbox_shadow','');
        $prop_unit_min_height                       =   wpresidence_get_option('wp_estate_prop_unit_min_height','');
        $border_bottom_header                       =   esc_html ( wpresidence_get_option('wp_estate_border_bottom_header','') );
        $sticky_border_bottom_header                =   esc_html ( wpresidence_get_option('wp_estate_sticky_border_bottom_header','') );
        $border_bottom_header_sticky_color          =   esc_html ( wpresidence_get_option('wp_estate_border_bottom_header_sticky_color','') );
        $border_bottom_header_color                 =   esc_html ( wpresidence_get_option('wp_estate_border_bottom_header_color','') );
        $cssbox_shadow_value                        =   esc_html ( wpresidence_get_option('wp_estate_cssbox_shadow','') ); 
        $property_unit_color                        =   esc_html ( wpresidence_get_option('wp_estate_property_unit_color','') );
        $propertyunit_internal_padding_top          =   wpresidence_get_option('wp_estate_propertyunit_internal_padding_top','');
        $propertyunit_internal_padding_left         =   wpresidence_get_option('wp_estate_propertyunit_internal_padding_left','');
        $propertyunit_internal_padding_bottom       =   wpresidence_get_option('wp_estate_propertyunit_internal_padding_bottom','');
        $propertyunit_internal_padding_right        =   wpresidence_get_option('wp_estate_propertyunit_internal_padding_right',''); 
        $wp_estate_content_area_back_color                   = esc_html ( wpresidence_get_option('wp_estate_content_area_back_color','') );
        $wp_estate_contentarea_internal_padding_top          = wpresidence_get_option('wp_estate_contentarea_internal_padding_top','');
        $wp_estate_contentarea_internal_padding_left         = wpresidence_get_option('wp_estate_contentarea_internal_padding_left','');
        $wp_estate_contentarea_internal_padding_bottom       = wpresidence_get_option('wp_estate_contentarea_internal_padding_bottom','');
        $wp_estate_contentarea_internal_padding_right        = wpresidence_get_option('wp_estate_contentarea_internal_padding_right','');       
        $blog_unit_min_height       = wpresidence_get_option('wp_estate_blog_unit_min_height','');
        $agent_unit_min_height      = wpresidence_get_option('wp_estate_agent_unit_min_height','');        
        $unit_border_color          =  esc_html ( wpresidence_get_option('wp_estate_unit_border_color','') );
        $unit_border_size           = wpresidence_get_option('wp_estate_unit_border_size','');       
        $wp_estate_widget_sidebar_border_size   = wpresidence_get_option('wp_estate_widget_sidebar_border_size','');
        $widget_sidebar_border_color            =  esc_html ( wpresidence_get_option('wp_estate_widget_sidebar_border_color','') );       
        $map_controls_back                      =  esc_html ( wpresidence_get_option('wp_estate_map_controls_back','') );
        $map_controls_font_color                =  esc_html ( wpresidence_get_option('wp_estate_map_controls_font_color','') );
        $sidebarwidget_internal_padding_top         = esc_html ( wpresidence_get_option('wp_estate_sidebarwidget_internal_padding_top','') );
        $sidebarwidget_internal_padding_left        = esc_html ( wpresidence_get_option('wp_estate_sidebarwidget_internal_padding_left','') ) ;
        $sidebarwidget_internal_padding_bottom      = esc_html ( wpresidence_get_option('wp_estate_sidebarwidget_internal_padding_bottom','') );
        $sidebarwidget_internal_padding_right       = esc_html ( wpresidence_get_option('wp_estate_sidebarwidget_internal_padding_right','') ) ;
        $sidebar_heading_background_color           = esc_html ( wpresidence_get_option('wp_estate_sidebar_heading_background_color','') );
        $sidebar_widget_color                       = esc_html ( wpresidence_get_option('wp_estate_sidebar_widget_color', '') );
        $sidebar_heading_boxed_color                = esc_html ( wpresidence_get_option('wp_estate_sidebar_heading_boxed_color','') );
       
            $widgett_area_classes= "#primary .widget-container,#primary .agent_contanct_form,#primary .widget-container.latest_listings .widget-title-sidebar";   
        
            if ( $sidebarwidget_internal_padding_top!='' ){
                $style.='
                .agent_contanct_form_sidebar #show_contact{
                    margin: 0px 0px 10px 0px;
                    padding: 7px 0px 7px 0px;
                    font-size: 16px;
                    line-height: 26px;
                    width:auto;
                }';
                 
                $style.=$widgett_area_classes.'{
                    padding-top:'.$sidebarwidget_internal_padding_top.'px;
                }
                
                #primary .widget-container.latest_listings .widget-title-sidebar,
                .directory_sidebar_wrapper{
                    padding-top:'.$sidebarwidget_internal_padding_top.'px;
                }

                .widget-container.boxed_widget .wd_user_menu,
                #primary .login_form, 
                .widget-container.boxed_widget form{
                    padding: 0px 0px 0px 0px;
                }';
            }
        
        
            if ( $sidebarwidget_internal_padding_left!='' ){
                $style.=$widgett_area_classes.'{
                    padding-left:'.$sidebarwidget_internal_padding_left.'px;
                }
                #primary .latest_listings.list_type,
                #primary .widget-container.latest_listings .widget-title-sidebar,
                .directory_sidebar_wrapper{
                    padding-left:'.$sidebarwidget_internal_padding_left.'px;
                }

                ';
            } 
        
            if ( $sidebarwidget_internal_padding_bottom!='' ){
                $style.=$widgett_area_classes.'{
                    padding-bottom:'.$sidebarwidget_internal_padding_bottom.'px;
                }
                #primary .latest_listings.list_type,
                .directory_sidebar_wrapper{
                    padding-bottom:'.$sidebarwidget_internal_padding_bottom.'px;
                }
                
                ';
            }
        
            if ( $sidebarwidget_internal_padding_right!='' ){
                $style.=$widgett_area_classes.'{
                    padding-right:'.$sidebarwidget_internal_padding_right.'px;
                } 
                #input_formula{
                    padding:0px;
                }
                primary .latest_listings.list_type,
                #primary .widget-container.latest_listings .widget-title-sidebar,
                .directory_sidebar_wrapper{
                    padding-right:'.$sidebarwidget_internal_padding_right.'px;
                }
                #adv_extended_close_widget{
                    right: '.$sidebarwidget_internal_padding_right.'px;
                }       
               
                ';
            }
        
            $style.='#primary .widget-container.featured_sidebar{
                padding:0px;
            }';
            
            if ( $widget_sidebar_border_color!='' ){
                $style.=$widgett_area_classes.'
                     {
                    border-color:'.$widget_sidebar_border_color.';
                    border-style: solid;
                }
                .advanced_search_sidebar .widget-title-footer, .advanced_search_sidebar .widget-title-sidebar,
                #primary .latest_listings,
                .directory_sidebar_wrapper {
                    border-color:'.$widget_sidebar_border_color.'!important;
                    border-style: solid;
                }
                #primary .widget-container.latest_listings .widget-title-sidebar{
                    border-bottom:0px!important;
                }
                #primary .latest_listings{
                    border-top:0px!important;
                }
                ';
            }
            
            if ( $wp_estate_widget_sidebar_border_size!='' ){
                $style.=$widgett_area_classes.'
                    {
                    border-width:'.$wp_estate_widget_sidebar_border_size.'px;
                }
                #primary .latest_listings,
                .directory_sidebar_wrapper {
                    border-width:'.$wp_estate_widget_sidebar_border_size.'px!important;
                }
                ';
            }
             
            if($sidebar_heading_background_color!=''){
                $style.='
                    .widget-title-sidebar,.boxed_widget .widget-title-sidebar,
                    .agent_contanct_form_sidebar #show_contact,
                    #primary .widget-container.latest_listings .widget-title-sidebar{
                        background-color:'.$sidebar_heading_background_color.'!important;
                        
                    }';
                if($sidebarwidget_internal_padding_right!= '' && $sidebarwidget_internal_padding_top!='' && $sidebarwidget_internal_padding_bottom!='' && $sidebarwidget_internal_padding_left!=''  ){
                    $style.='
                    .widget-title-sidebar, .boxed_widget .widget-title-sidebar,
                    .agent_contanct_form_sidebar #show_contact{
                        margin-top: '.(-1 * $sidebarwidget_internal_padding_top).'px;
                        margin-right: '.(-1 * $sidebarwidget_internal_padding_right).'px;
                        margin-bottom: '.$sidebarwidget_internal_padding_bottom.'px;
                        margin-left: '.(-1 * $sidebarwidget_internal_padding_left).'px;
                    }
                     .widget-title-sidebar, .boxed_widget .widget-title-sidebar,
                     .agent_contanct_form_sidebar #show_contact{
                        padding-top: '.$sidebarwidget_internal_padding_top.'px;
                        padding-right: '.$sidebarwidget_internal_padding_right.'px;
                        padding-bottom: '.$sidebarwidget_internal_padding_bottom.'px;
                        padding-left: '.$sidebarwidget_internal_padding_left.'px;
                    }
                     #primary .widget-container.latest_listings .widget-title-sidebar{
                        margin:0px;
                  
                    }
                    #primary .latest_listings.list_type {
                        padding-top: '.$sidebarwidget_internal_padding_top.'px;
                    }';                    
           
            }else{
                 $style.='
                    .widget-title-sidebar, .boxed_widget .widget-title-sidebar,
                    .agent_contanct_form_sidebar #show_contact{
                        margin-top: -30px;
                        margin-right: -30px;
                        margin-bottom: 30px;
                        margin-left: -30px;
                    }
                     .widget-title-sidebar, .boxed_widget .widget-title-sidebar,
                     .agent_contanct_form_sidebar #show_contact{
                        padding-top: 15px;
                        padding-right: 30px;
                        padding-bottom: 15px;
                        padding-left: 30px;
                    }
                     #primary .widget-container.latest_listings .widget-title-sidebar{
                        margin:0px;
                        padding-top: 15px;
                    }
                    #primary .latest_listings.list_type {
                        padding-top: 30px;
                    }';
                               
            }
            }
            //widget-container
            if ($sidebar_widget_color != '') {
            $style.='
                #primary .agent_contanct_form,
                #primary .widget-container,
                #primary .widget-container.latest_listings .widget-title-sidebar,
                #primary .latest_listings.list_type,
                .directory_sidebar_wrapper{
                    background-color: '.$sidebar_widget_color.';
                }';
            } 
            
            if($sidebar_heading_boxed_color!=''){
                $style.= '.boxed_widget .widget-title-sidebar,
                    .widget-title-sidebar,
                    .agent_contanct_form_sidebar #show_contact{
                    color: '.$sidebar_heading_boxed_color.';
                }';
            }

            $sidebar_boxed_font_color            =  esc_html ( wpresidence_get_option('wp_estate_sidebar_boxed_font_color','') );
            if ($sidebar_boxed_font_color != '') {
                $style.= '
                #primary,#primary a,#primary label,
                #primary .boxed_widget,#primary .boxed_widget a,#primary  .boxed_widget label,
                #primary .agent_unit .agent_detail,
                #primary .agent_unit .agent_detail i,
                .directory_sidebar label{
                    color: '.$sidebar_boxed_font_color.';
                }'; 
            } 
            
        
        if($map_controls_back!=''){
            $style.='#gmap-control span.spanselected,#gmap-control span,#gmap-control,
                #gmapzoomplus, #gmapzoomminus,#openmap,#street-view{
                background-color:'.$map_controls_back.';
            }';
        }

        if($map_controls_font_color!=''){
            $style.='#gmap-control span.spanselected,#gmap-control span,
                #gmap-control,#gmapzoomplus, #gmapzoomminus,#openmap,#street-view{
                color:'.$map_controls_font_color.';
            }
            #gmap-control span:hover,
            #street-view:hover{
                color: #fff;
            }
            ';
        }
        
        if ( $unit_border_color!='' ){
            $style.='.property_listing,
                .related_blog_unit_image,
                .property_listing:hover,
                .featured_property,
                .featured_article,
                .agent_unit,
                .user_role_unit,
                .agency_unit
                {
                border-color:'.$unit_border_color.'
            }
            ';
        }
        if ( $unit_border_size!='' ){
            $style.='.property_listing,
                .related_blog_unit_image,
                .property_listing:hover,
                .featured_property,
                .featured_article,
                .agent_unit,
                .user_role_unit,
                .agency_unit,
                .user_role_unit,
                .agency_unit:hover
                {
                border-width:'.$unit_border_size.'px;
            }
            ';
        }

        
        if($blog_unit_min_height!=''){
            $style.='.blog2v .property_listing{
                min-height: '.$blog_unit_min_height.'px;
            }';
        }
        
        if($agent_unit_min_height!=''){
            $style.='.article_container .agent_unit, .category .agent_unit, .page-template-agents_list .agent_unit{
                min-height: '.$agent_unit_min_height.'px;
            }';
        }
             
        $content_area_classes_color='.notice_area,
            .wpestate_property_description,
            .property-panel .panel-body,
            .wpestate_agent_details_wrapper,
            .agent_contanct_form,
            .page_template_loader .vc_row,
            #tab_prpg .tab-pane,
            .agency_content_wrapper,
            .single-blog,
            .single_width_blog #comments,
            .contact-wrapper,
            .contact-content,
            .invoice_unit:nth-of-type(odd)
            ';
        
        $content_area_classes='.wpestate_property_description,
            .property-panel .panel-body,
            .property-panel .panel-heading,
            .wpestate_agent_details_wrapper,
            .agent_contanct_form,
            .page_template_loader .vc_row,
            #tab_prpg .tab-pane,
            .agency_content_wrapper,
            .single-blog,
            .single_width_blog #comments,
            .contact-wrapper,
            .contact-content
            ';
        
        
        if($wp_estate_content_area_back_color!=''){
            $style.=$content_area_classes_color.'{
                background-color:'.$wp_estate_content_area_back_color.';  
            }
            
            .property-panel .panel-heading,
            .single-estate_property .listing-content .agent_contanct_form,
            .property_reviews_wrapper,
            .multi_units_wrapper,
            .single-estate_agent .agent_content,
            .agency_contact_wrapper,
            .developer_contact_wrapper{
                background-color:'.$wp_estate_content_area_back_color.'; 
            }
            .wpestate_property_description p{
                margin-bottom:0px;
            }
            
            .page_template_loader .vc_row{
                margin-bottom:13px;
            }
            .page_template_loader .vc_row{
                margin-left: 0px;
                margin-right: 0px;
            }
            .agent_contanct_form {
                margin-top:26px;
            }
            .contact-content .agent_contanct_form,
            .agent_content.col-md-12,
            .single-agent .wpestate_agent_details_wrapper{
                padding:0px;
            }
         
            .contact_page_company_picture,
            .agentpic-wrapper{
                padding-left:0px;
            }
            
            .profile-onprofile,
            .contact-wrapper{
                margin:0px;
            }
            .contact_page_company_details{
                padding-right:0px;
            }
            .lightbox_property_sidebar .agent_contanct_form{
                background-color: #fff;
            }

            ';
        }
        
        
        if ( $wp_estate_contentarea_internal_padding_top!='' ){
            $style.=$content_area_classes.'{
                padding-top:'.$wp_estate_contentarea_internal_padding_top.'px;
            }
            .single-estate_property .listing-content .agent_contanct_form, 
            .property_reviews_wrapper,
            .multi_units_wrapper,
            .developer_contact_wrapper,
            .single-estate_agent .wpestate_agent_details_wrapper{
                padding-top:'.$wp_estate_contentarea_internal_padding_top.'px;
            }
            .property-panel .panel-body,
            .developer_contact_wrapper .col-md-6,
            .single-estate_developer .agent_contanct_form,
            .single-estate_agent .agent_content{
                padding-top:0px;
            }
            ';
        }
        
        
        if ( $wp_estate_contentarea_internal_padding_left!='' ){
            $style.=$content_area_classes.'{
                padding-left:'.$wp_estate_contentarea_internal_padding_left.'px;
            }
            .single-estate_property .listing-content .agent_contanct_form, 
            .property_reviews_wrapper,
            .multi_units_wrapper,
            .notice_area,
             .developer_contact_wrapper,
             .single-estate_agent .wpestate_agent_details_wrapper,
             .single-estate_agent .agent_content{
                padding-left:'.$wp_estate_contentarea_internal_padding_left.'px;            
            }
            .developer_contact_wrapper .col-md-6,
            .single-estate_developer .agent_contanct_form{
                padding-left:0px;
            }
            ';
        }
        
        
        if ( $wp_estate_contentarea_internal_padding_bottom!='' ){
            $style.=$content_area_classes.'{
                padding-bottom:'.$wp_estate_contentarea_internal_padding_bottom.'px;
            }
            .single-estate_property .listing-content .agent_contanct_form, 
            .property_reviews_wrapper,
            .multi_units_wrapper,
             .developer_contact_wrapper,
             .single-estate_agent .wpestate_agent_details_wrapper,
             .single-estate_agent .agent_content{
                padding-bottom:'.$wp_estate_contentarea_internal_padding_bottom.'px;
            }
            .property-panel .panel-heading,
            .developer_contact_wrapper .col-md-6,
            .single-estate_developer .agent_contanct_form{
                padding-bottom: 0px;
            }
            .property_reviews_wrapper .wpresidence_button {
                margin-bottom: 0px;
            }
            ';
        }
        
        if ( $wp_estate_contentarea_internal_padding_right!='' ){
            $style.=$content_area_classes.'{
                padding-right:'.$wp_estate_contentarea_internal_padding_right.'px;
            }
            .single-estate_property .listing-content .agent_contanct_form, 
            .property_reviews_wrapper,
            .multi_units_wrapper,
            .notice_area,
            .developer_contact_wrapper,
            .single-estate_agent .wpestate_agent_details_wrapper,
            .single-estate_agent .agent_content{
                padding-right:'.$wp_estate_contentarea_internal_padding_right.'px;
            }
            .property-panel h4:after{
                margin-right:0px;
            }
            .developer_contact_wrapper .col-md-6{
               padding-right:0px;
            }
            .single-estate_developer .agent_contanct_form{
                padding-right:20px;
            }

            #add_favorites,
            .prop_social{
                right:'.$wp_estate_contentarea_internal_padding_right.'px;
            }
            ';
        }

        if ( $property_unit_color!='' ){
            $style.='.property_listing,
                .property_listing:hover,
                .featured_property,
                .featured_article,
                .agent_unit,
                .user_role_unit,
                .agency_unit{
                    background-color:'.$property_unit_color.'
            }
            ';
        }
        
        
        if ( $propertyunit_internal_padding_top!='' ){
            $style.='.property_listing,
                .related_blog_unit_image,
                .agent_unit,
                .featured_property,
                .featured_article{
                padding-top:'.$propertyunit_internal_padding_top.'px;
            }';
        }
        if ( $propertyunit_internal_padding_left!='' ){
            $style.='.property_listing,
                .related_blog_unit_image,
                .agent_unit,
                .featured_property,
                .featured_article{
                padding-left:'.$propertyunit_internal_padding_left.'px;
            }';
        }
        if ( $propertyunit_internal_padding_bottom!='' ){
            $style.='.property_listing,
                .related_blog_unit_image,
                .agent_unit,
                .featured_property,
                .featured_article,
                .listing_wrapper.col-md-12 > .property_listing{
                padding-bottom:'.$propertyunit_internal_padding_bottom.'px;
            }';
        }
        if ( $propertyunit_internal_padding_right!='' ){
            $style.='.property_listing,
                .related_blog_unit_image,
                .agent_unit,
                .featured_property,
                .featured_article{
                padding-right:'.$propertyunit_internal_padding_right.'px;
            }';
        }
         
        if($border_bottom_header_color!=''){
            $style.='.master_header{
                border-color:'.$border_bottom_header_color.';
            }';
        } 
        if($border_bottom_header_sticky_color!=''){
            $style.='.master_header.master_header_sticky{
                border-color:'.$border_bottom_header_sticky_color.';
            }';
        }
        
        if($border_bottom_header!=''){
            $style.='.master_header{
               border-width:'.$border_bottom_header.'px;
                border-bottom-style:solid;
            }';
        }
        
        if($sticky_border_bottom_header!=''){
            $style.='
                .master_header_sticky,
                .master_header.header_transparent.master_header_sticky{
                    border-width:'.$sticky_border_bottom_header.'px;
                    border-bottom-style:solid;
            }';
        }
        
          
        if($prop_unit_min_height!=''){
            $style.='.property_listing{
                min-height:'.$prop_unit_min_height.'px;
            }';
             $style.='#google_map_prop_list_sidebar .property_listing,.col-md-6.has_prop_slider.listing_wrapper .property_listing{
                min-height:'.($prop_unit_min_height+30).'px;
            }';
        }
         
         
        if($cssbox_shadow!=''){
            if( $cssbox_shadow=='none'){
                $cssbox_shadow_value='-webkit-box-shadow:none;
                box-shadow:none;';
            }else{
                $cssbox_shadow_value='-webkit-box-shadow:'.$cssbox_shadow.';
                box-shadow:'.$cssbox_shadow.';';
            }
            
            $style.='
            .wpb_btn-info,
            #primary .widget-container.twitter_wrapper,
            .wpcf7-form-control,
            #access ul ul,
            .form-control.open,
            .btn,
            .customnav,
            #user_menu_open,
            .filter_menu,
            .pagination > li > a, 
            .pagination > li > span,
            .property_listing,
            .agent_unit,
            .blog_unit,
            .related_blog_unit .blog_unit_image img,
            #tab_prpg .tab-pane,
            .agent_unit_social_single,
            .agent_contanct_form_sidebar .agent_contanct_form,
            #footer-contact-form input[type=text], 
            #footer-contact-form input[type=password],
            #footer-contact-form input[type=email], 
            #footer-contact-form input[type=url], 
            #footer-contact-form input[type=number],
            #footer-contact-form textarea,
            #comments input[type=text], 
            #comments input[type=password],
            #comments input[type=email], 
            #comments input[type=url], 
            #comments input[type=number],
            #comments textarea,
            .agent_contanct_form input[type=text], 
            .agent_contanct_form input[type=password],
            .agent_contanct_form input[type=email], 
            .agent_contanct_form input[type=url], 
            .agent_contanct_form input[type=number],
            .agent_contanct_form textarea,
            .zillow_widget,
            .advanced_search_shortcode,
            .advanced_search_sidebar,
            .mortgage_calculator_div,
            .footer-contact-form,
            .contactformwrapper,
            .info_details,
            .info_idx,
            .loginwd_sidebar,
            blockquote,
            .featured_article,
            .featured_property,
            .customlist2 ul,
            .featured_agent,
            .testimonial-text,
            .wpb_alert-info.vc_alert_3d.wpestate_message,
            .wpb_alert-success.vc_alert_3d.wpestate_message,
            .wpb_alert-error.vc_alert_3d.wpestate_message,
            .wpb_alert-danger.vc_alert_3d.wpestate_message,
            .wpb_call_to_action.wpestate_cta_button,
            .vc_call_to_action.wpestate_cta_button2,
            .saved_search_wrapper,
            .search_unit_wrapper,.mortgage_calculator_li,
            .adv_listing_filters_head, .listing_filters_head, .listing_filters,
            .adv-search-3, .page-template-front_property_submit .navigation_container, 
            .advanced_search_shortcode, 
            .membership_package_product, .contact-wrapper, .developer_contact_wrapper, 
            .agency_contact_wrapper, 
            .property_reviews_wrapper, .agency_contact_container_wrapper, 
            .agency_content_wrapper, .submit_property_front_wrapper, 
            .directory_sidebar_wrapper, .places_wrapper_type_2, 
            .featured_property, .agency_unit, #comments, 
            .single-blog, #content_container .container_agent, 
            .listing_wrapper .property_listing, 
            .listing_wrapper .agent_unit, .tab-pane, 
            .agent_contanct_form, .agent_content, 
            .wpestate_agent_details_wrapper, 
            .wpestate_property_description, 
            .multi_units_wrapper, .property-panel, 
            #primary .widget-container, .user_role_unit, 
            .testimonial-slider-container .testimonial-container.type_class_3, 
            .estate_places_slider.slick-initialized.slick-slider, 
            .google_map_shortcode_wrapper, 
            .testimonial-container.type_class_1 .testimonial-text, 
            .blog_unit, .agent_unit_featured, 
            .featured_article,
            .slider_container .listing_wrapper .property_listing{
              '.$cssbox_shadow_value.'
            }
           

            .agent_contanct_form input[type="submit"], 
            .single-content input[type="submit"]{
                border:none!important;
            }
            
            #facebooklogin, 
            #facebookloginsidebar_mobile, 
            #facebookloginsidebar_topbar, 
            #facebookloginsidebar,
            #googlelogin, 
            #googleloginsidebar_mobile, 
            #googleloginsidebar_topbar, 
            #googleloginsidebar,
            #yahoologin, 
            #twitterloginsidebar_mobile, 
            #twitterloginsidebar_topbar, 
            #twitterloginsidebar{
                border-bottom:0px;
            }

            #primary .widget-container.twitter_wrapper,
            .agentpict,
            .agent_unit img,
            .property_listing img{
                border:none;
            }';
           
            
        }
        
        if($border_radius_corner!=''){
            $style.='
            #advanced_submit_2,
            .adv_handler, 
            #search_wrapper, 
            #search_wrapper_color, 
            .blog_unit_image, 
            .comment-form #submit, 
            .wpresidence_button, 
            .adv_search_tab_item, 
            #search_wrapper, 
            .property_unit_type5 .item, 
            .property_unit_type5 .featured_gradient, 
            .property_unit_type5, 
            .adv_search_tab_item, 
            .property_reviews_wrapper, 
            .listing_wrapper, 
            .term_bar_item, .agentpict, 
            .schedule_meeting, 
            .form-control, 
            .subunit_wrapper, 
            .related_blog_unit_image img, 
            .widget_latest_listing_image img, 
            .agent-unit-img-wrapper img, 
            .featured_widget_image img, 
            .front_plan_row, 
            .acc_google_maps, 
            .wpresidence_button, 
            .sidebar_filter_menu,    
            .places_wrapper_type_2,
            .places_wrapper_type_2 .places_cover,
            .mortgage_calculator_li,
            input[type=text], 
            input[type=password], 
            input[type=email], 
            input[type=url], 
            input[type=number], 
            textarea,
            .wpcf7-form-control,
            #mobile_display,
            .form-control, 
            .adv-search-1 input[type=text], 
            .property_listing,
            .listing-cover-plus,
            .share_unit,
            .items_compare img,
            .ribbon-wrapper-default, 
            .featured_div,
            .agent_unit,
            .blog_unit,
            .related_blog_unit,
            .related_blog_unit_image,
            .related_blog_unit_image img,
            .related_blog_unit_image .listing-cover,
            .listing-cover-plus-related,
            .gallery img,
            .post-carusel,
            .property-panel .panel-heading,
            .isnotfavorite,
            #add_favorites.isfavorite:hover,
            #add_favorites:hover,
            #add_favorites.isfavorite,
            #slider_enable_map,
            #slider_enable_street,
            #slider_enable_slider,
            .mydetails,
            .agent_contanct_form_sidebar .agent_contanct_form,
            .comment .blog_author_image,
            #agent_submit,
            .comment-reply-link,
            .comment-form #submit,
            #colophon .social_sidebar_internal a,
            #primary .social_sidebar_internal a,
            .zillow_widget,
            .twitter_wrapper,
            #calendar_wrap,
            .widget_latest_internal img,
            .widget_latest_internal .listing-cover,
            .widget_latest_internal .listing-cover-plus,
            .featured_sidebar,
            .featured_widget_image img,
            .advanced_search_shortcode,
            .advanced_search_sidebar,
            .mortgage_calculator_div,
            .flickr_widget_internal img,
            .Widget_Flickr .listing-cover,
            #gmap-loading,
            #gmap-noresult,
            #street-view,
            .contact-comapany-logo,
            #gmap-control,
            #google_map_prop_list_sidebar #advanced_submit_2,
            #results,
            .adv-search-1 input[type=text],
            .adv-search-3,
            .adv-search-3 #results,
            #advanced_submit_22,
            .adv_results_wrapper #advanced_submit_2,
            .compare_item_head img,
            .backtop, 
            .contact-box,
            .footer-contact-form,
            .contactformwrapper,
            .info_details,
            .info_idx,
            .user_dashboard_links,
            #stripe_cancel,
            .pack_description,
            .pack-unit,
            .perpack,
            #direct_pay,
            #send_direct_bill,
            #profile-image,
            .dasboard-prop-listing,
            .info-container i,
            #form_submit_1,
            .loginwd_sidebar,
            .login_form,
            .alert-message,
            .login-alert,
            .agent_contanct_form input[type="submit"],
            .single-content input[type="submit"],
            table,
            blockquote,
            .featured_article,
            .blog_author_image,
            .featured_property,
            .agent_face,
            .agent_face img,
            .agent_face_details img,
            .google_map_sh,
            .customlist2 ul,
            .featured_agent,
            .iconcol img,
            .testimonial-image,
            .testimonial-text,
            .wpestate_posts_grid.wpb_teaser_grid .categories_filter li, 
            .wpestate_posts_grid.wpb_categories_filter li,
            .wpestate_posts_grid img,
            .wpestate_progress_bar.vc_progress_bar .vc_single_bar,
            .wpestate_cta_button,
            .wpestate_cta_button2,
            button.wpb_btn-large, span.wpb_btn-large,
            select.dsidx-resp-select,
            .dsidx-resp-area input[type="text"], .dsidx-resp-area select,
            .sidebar .dsidx-resp-area-submit input[type="submit"], .dsidx-resp-vertical .dsidx-resp-area-submit input[type="submit"], 
            .saved_search_wrapper,
            .search_unit_wrapper,
            .front_plan_row,
            .front_plan_row_image,
            #floor_submit,
            .manage_floor,
            #search_form_submit_1,
            .dropdown-menu,
            .wpcf7-form input[type="submit"],
            .panel-group .panel,
            .label,
            .featured_title,
            .featured_second_line,
            .transparent-wrapper,
            .wpresidence_button,
            .tooltip-inner,
            .listing_wrapper.col-md-12 .property_listing>img,
            #facebooklogin, 
            #facebookloginsidebar_mobile, 
            #facebookloginsidebar_topbar, 
            #facebookloginsidebar,
            #googlelogin, 
            #googleloginsidebar_mobile, 
            #googleloginsidebar_topbar, 
            #googleloginsidebar,
            #yahoologin, 
            #twitterloginsidebar_mobile, 
            #twitterloginsidebar_topbar, 
            #twitterloginsidebar,
            #new_post select,
            button.slick-prev.slick-arrow,
            button.slick-next.slick-arrow,
            #pick_pack,
            .single-estate_property .listing-content .agent_contanct_form,
            .property_reviews_wrapper,
            .notice_area,
            .multi_units_wrapper,
            .subunit_wrapper,
            .subunit_thumb img,
            .single-content.single-agent,
            .container_agent .agent_contanct_form,
            .agency_contact_wrapper,
            .single-estate_agency .property_reviews_wrapper,
            .agency_content_wrapper,
            .developer_contact_wrapper,
            .agency_contact_wrapper,
            .single-content.single-blog,
            .single_width_blog #comments,
             #primary .widget-container,
             .widget_latest_listing_image,
             .directory_sidebar_wrapper,
             .full_width_header .header_type1.header_left #access ul li.with-megamenu>ul.sub-menu, 
             .full_width_header .header_type1.header_left #access ul li.with-megamenu:hover>ul.sub-menu,
             .action_tag_wrapper,
             .ribbon-inside,
             .unit_type3_details,
             .submit_listing,
             .submit_action,
             .agency_unit,
             .modal_login_container,
             .page_template_loader .vc_row,
             .listing_wrapper .property_listing,
             .adv-search-3, .page-template-front_property_submit .navigation_container, .advanced_search_shortcode, 
             .membership_package_product, .contact-wrapper, .developer_contact_wrapper, 
             .agency_contact_wrapper, .property_reviews_wrapper, 
             .agency_contact_container_wrapper, 
             .agency_content_wrapper, 
             .submit_property_front_wrapper, 
             .directory_sidebar_wrapper, 
             .places_wrapper_type_2, 
             .featured_property, 
             .agency_unit, #comments, 
             .single-blog, 
             #content_container .container_agent, 
             .listing_wrapper .property_listing, 
             .listing_wrapper .agent_unit, 
             .tab-pane, .agent_contanct_form, 
             .agent_content, 
             .wpestate_agent_details_wrapper, 
             .wpestate_property_description, 
             .multi_units_wrapper, .property-panel, 
             #primary .widget-container, 
             .user_role_unit, 
             .testimonial-slider-container .testimonial-container.type_class_3, 
             .estate_places_slider.slick-initialized.slick-slider, 
             .google_map_shortcode_wrapper, 
             .testimonial-container.type_class_1 .testimonial-text, 
             .blog_unit, 
             .agent_unit_featured, 
             .featured_article{
                border-radius: '.intval($border_radius_corner).'px;
            }
            
            .wpestate_tabs .ui-widget-content,
            .agent_contanct_form input[type="submit"], 
            .single-content input[type="submit"],
            button.wpb_btn-large, span.wpb_btn-large{
                border-radius: '.intval($border_radius_corner).'px!important;
            }
            
            .carousel-control-theme-prev,
            .carousel-control-theme-next,
            .icon-fav-on-remove,
            #tab_prpg .tab-pane,
            .nav-prev-wrapper,
            #advanced_submit_2:hover,
            .pagination > li:first-child > a, 
            .pagination > li:first-child > span,
            .pagination .roundright a, 
            .pagination .roundright span,
            #user_menu_open,
            #access ul ul,
            .adv-search-1,
            #openmap,
            .slider-content,
            #access ul li.with-megamenu>ul.sub-menu,
            #access ul li.with-megamenu:hover>ul.sub-menu,
            .wpb_toggle.wpestate_toggle,
            .featured_property.featured_property_type2 img,
            .featured_property_type2 .places_cover,
            .info_details img,
             #adv-search-header-3,
            #adv-search-header-1,
            .page-template-advanced_search_results .with_search_2 #openmap,
            .agentpict,
            #tab_prpg li:first-of-type,
            #tab_prpg ul,
            .slider-property-status,
            .nav-next-wrapper,
            .agent_unit img,
            .listing-cover,
            .pagination .roundleft a, 
            .pagination .roundleft span,
            .slider-content,
            .property_listing img,
            .agent_unit_social_single,
            .wpestate_agent_details_wrapper,
            .wpestate_property_description,
            .single-estate_property .listing-content .agent_contanct_form,
            .property_reviews_wrapper,
            .schedule_meeting,
            .agent_unit_button,
            .control_tax_sh,
            .adv_handler,
            .featured_property.featured_property_type3{
                border-top-left-radius: '.intval($border_radius_corner).'px;
                border-top-right-radius: '.intval($border_radius_corner).'px;
                border-bottom-left-radius: '.intval($border_radius_corner).'px;
                border-bottom-right-radius: '.intval($border_radius_corner).'px;
            }
            .featured_property.featured_property_type3 .featured_img,
            .featured_property_type3 .item,
            .single-estate_agency .agent_contanct_form{
                border-top-left-radius: '.intval($border_radius_corner).'px;
                border-bottom-left-radius: '.intval($border_radius_corner).'px;
            }
            .featured_property.featured_property_type3 .featured_secondline{
                border-top-right-radius: '.intval($border_radius_corner).'px;
                border-bottom-right-radius: '.intval($border_radius_corner).'px;
            }

            .pack-unit h4,
            .user_dashboard_links a:first-of-type,
            .featured_property.featured_property_type1 .featured_img,
            .featured_property.featured_property_type1 .carousel-inner,
            #primary .widget-container.latest_listings .widget-title-sidebar,
            .sub-menu li:hover:first-of-type,
            #user_menu_open > li:first-of-type > a:hover,
            #forgot-div-title-topbar, 
            #register-div-title-topbar, 
            #login-div-title-topbar{
                border-top-left-radius: '.intval($border_radius_corner).'px;
                border-top-right-radius: '.intval($border_radius_corner).'px;
            }
            .listing-unit-img-wrapper {
                border-top-left-radius: '.intval($border_radius_corner).'px;
                border-top-right-radius: '.intval($border_radius_corner).'px;
            }


            .featured_secondline,
            .featured_property_type3 .item,
            #primary .latest_listings,
            #primary .latest_listings .owl-carousel .owl-wrapper-outer,
            .sub-menu li:hover:last-of-type,
            #user_menu_open > li:last-of-type > a:hover,
            .login_modal_control{
                border-bottom-left-radius: '.intval($border_radius_corner).'px;
                border-bottom-right-radius: '.intval($border_radius_corner).'px;
            }
            #infocloser{
                border-top-right-radius:0px;
            }
            
            .property-panel .panel-heading{
                border-bottom-left-radius: 0px;
                border-bottom-right-radius: 0px;
            }
            .property-panel .panel-body{
                border-bottom-left-radius: '.intval($border_radius_corner).'px!important;
                border-bottom-right-radius: '.intval($border_radius_corner).'px!important;
            }
            
            .agency_unit,
            .modal_login_container{
                overflow: hidden;
            }
            
            .listing_wrapper.col-md-12 .listing-unit-img-wrapper,
            .listing_wrapper.col-md-12 > .property_listing .carousel-inner{
                border-top-left-radius: '.intval($border_radius_corner).'px;
                border-top-right-radius: 0px;
                border-bottom-left-radius: '.intval($border_radius_corner).'px;
                border-bottom-right-radius: 0px;            
            }

            ';
        
        }
        
        
        if ($main_grid_content_width!='' && $main_grid_content_width!='1200'){
            $style.='
            .is_boxed.container,
            .content_wrapper,
            .master_header,
            .wide .top_bar,
            .header_type2 .header_wrapper_inside,
            .header_type1 .header_wrapper_inside,
            .slider-content-wrapper,
            #colophon.boxed_footer, 
            #colophon.sticky_footer.boxed_footer,
            .main_wrapper.is_boxed #search_wrapper.with_search_form_float.sticky_adv{
                width:'.$main_grid_content_width.'px;
            }

            #footer-widget-area{
                max-width:'.($main_grid_content_width).'px;
            }
             
            .blog_listing_image{
                width:25%;
            }
            
            .prop-info{
                width:75%;
            }
            
            .adv4-holder,
            .main_wrapper.is_boxed #search_wrapper,
            .perpack, #direct_pay{
                width: 100%;
            }
            #results {
              width:'.($main_grid_content_width-234-90).'px;
            }
            
            .adv-search-1,
            #search_wrapper.search_wr_10 .adv-search-1{
                width:'.($main_grid_content_width-90).'px;
                max-width:'.($main_grid_content_width-90).'px!important;
            }
            
            .main_wrapper.is_boxed  .adv-search-1{
                width:'.($main_grid_content_width-20).'px;
                max-width:'.($main_grid_content_width-20).'px!important;
            }
            
            .main_wrapper.is_boxed #search_wrapper.with_search_form_float,
            #search_wrapper.with_search_form_float{
                width:'.($main_grid_content_width-90).'px;
            }

            .transparent-wrapper{  
                width:'.($main_grid_content_width-90).'px;
            }
            .adv1-holder,
            .with_search_on_start.without_search_form_float .adv1-holder, 
            .with_search_on_end.without_search_form_float .adv1-holder
            {
               width:'.($main_grid_content_width-13-274).'px;
            }
            
            #google_map_prop_list_sidebar .adv-search-1 .filter_menu{
                width:100%;min-width:100%;
            }
            
          
                      
            .search_wr_3#search_wrapper{
              width:'.($main_grid_content_width-90).'px;
            }
            
            
            .header_wrapper_inside,
            .sub_footer_content,
            .gmap-controls,
            #carousel-property-page-header .carousel-indicators{
                max-width:'.$main_grid_content_width.'px;
            }
            
            .gmap-controls{
                margin-left:-'.intval($main_grid_content_width/2).'px;
            }
            .shortcode_slider_list li {
                max-width: 25%;
            }
            
            @media only screen and (max-width: '.$main_grid_content_width.'px){
                
                .content_wrapper, 
                .master_header, 
                .wide .top_bar, 
                .header_wrapper_inside, 
                .slider-content-wrapper,
                .wide .top_bar, .top_bar,
                .adv-search-1{
                    width: 100%;
                    max-width:100%;
                }
            }
            ';
        }
        
        
        if($main_content_width!=''){
            $sidebar_width = intval(100-$main_content_width);
            $style.='
            .col-md-9.rightmargin,
            .col-md-9.rightmargin.single_width_blog,
            .col-md-9.col-md-push-3.rightmargin.single_width_blog,
            .full_width_prop{
                width:'.$main_content_width.'%;
            }
            
            .col-md-12.full_width_prop,
            .col-md-12.single_width_blog{
                width: 100%;
            }
            
            .col-md-push-3.rightmargin,
            .single_width_blog.col-md-push-3,
            .full_width_prop.col-md-push-3{
                left:'.$sidebar_width.'%;
            }
            
            #primary{
               width:'.$sidebar_width.'%;
            }
            
            #primary.col-md-pull-9{
                right:'.$main_content_width.'%;
            }
            ';
        
            
        }
        
        
        if($header_height!=''){
            $style.='.header_wrapper,.header5_top_row,.header_wrapper.header_type5{
                height:'.$header_height.'px;
            }
            #access ul li.with-megamenu>ul.sub-menu, 
            #access ul li.with-megamenu:hover>ul.sub-menu,
            #access ul li:hover > ul {
                top:'.$header_height.'px;
            }
            .menu > li{
                height:'.$header_height.'px;
                line-height:'.$header_height.'px;
            }
            #access .menu>li>a i{
                line-height:'.$header_height.'px;
            }

            #access ul ul{
                top:'.($header_height+50).'px;
            }
           
            .has_header_type5 .header_media,
            .has_header_type2 .header_media,
            .has_header_type3 .header_media,
            .has_header_type4 .header_media,
            .has_header_type1 .header_media{
                padding-top: '.($header_height).'px;
            }

            .has_top_bar .has_header_type5 .header_media,
            .has_top_bar .has_header_type2 .header_media,
            .has_top_bar .has_header_type3 .header_media,
            .has_top_bar .has_header_type4 .header_media,
            .has_top_bar .has_header_type1 .header_media{
                padding-top: '.($header_height-90+130).'px;
            }
            
            .admin-bar .has_header_type5 .header_media,
            .admin-bar .has_header_type2 .header_media,
            .admin-bar .has_header_type3 .header_media,
            .admin-bar .has_header_type4 .header_media,
            .admin-bar .has_header_type1 .header_media{
                padding-top: '.($header_height-90+89).'px;
            }
            
            .admin-bar .has_header_type4 .header_media,
            .has_header_type4 .header_media{
                padding-top: 0px;
            }
            .admin-bar.has_top_bar .has_header_type4 .header_media,
            .has_top_bar .has_header_type4 .header_media{
                padding-top: 40px;
            }
            

            .admin-bar.has_top_bar .has_header_type5 .header_media,
            .admin-bar.has_top_bar .has_header_type2 .header_media,
            .admin-bar.has_top_bar .has_header_type3 .header_media,
            .admin-bar.has_top_bar .has_header_type4 .header_media,
            .admin-bar.has_top_bar .has_header_type1 .header_media{
                padding-top: '.($header_height-90+131).'px;
            }
            
            .admin-bar.has_top_bar .has_header_type2 #google_map_prop_list_wrapper, 
            .admin-bar.has_top_bar .has_header_type2 #google_map_prop_list_sidebar{
                top: '.($header_height+73).'px;
                margin-top: 0px;
            }
            
            .has_top_bar .has_header_type2 #google_map_prop_list_wrapper, 
            .has_top_bar .has_header_type2 #google_map_prop_list_sidebar{
                top: '.($header_height+40).'px;
                margin-top: 0px;
            }

            #google_map_prop_list_sidebar,
            #google_map_prop_list_wrapper{
                top: '.($header_height+41).'px;
            }
            #google_map_prop_list_wrapper.half_no_top_bar.half_type3, 
            #google_map_prop_list_sidebar.half_no_top_bar.half_type3,
            #google_map_prop_list_wrapper.half_no_top_bar.half_type2, 
            #google_map_prop_list_sidebar.half_no_top_bar.half_type2,
            #google_map_prop_list_wrapper.half_no_top_bar, 
            #google_map_prop_list_sidebar.half_no_top_bar{
                top: '.($header_height).'px;
            }
            
            .admin-bar.has_top_bar #google_map_prop_list_sidebar.half_type3,
            .admin-bar.has_top_bar #google_map_prop_list_wrapper.half_type3{
                top: '.($header_height+73).'px;
                margin-top: 0px;
            }

            .admin-bar #google_map_prop_list_sidebar.half_type3, 
            .admin-bar #google_map_prop_list_sidebar.half_type2, 
            .admin-bar #google_map_prop_list_wrapper.half_type2, 
            .admin-bar #google_map_prop_list_wrapper.half_type3,
            #google_map_prop_list_sidebar.half_type2, 
            #google_map_prop_list_sidebar.half_type3, 
            #google_map_prop_list_wrapper.half_type2, 
            #google_map_prop_list_wrapper.half_type3{
                top: '.($header_height+33).'px;
                margin-top: 0px;
            }
            
            .admin-bar.has_top_bar .has_header_type1 .dashboard-margin{    
                top: '.($header_height-8).'px;
            }
            .has_top_bar .has_header_type1 .dashboard-margin{
                top: '.($header_height-40).'px;
            }
            .has_header_type1 .dashboard-margin{
                top: '.($header_height).'px;
            }
            .admin-bar .has_header_type1 .dashboard-margin{
                top: '.($header_height+32).'px;
            }
            .admin-bar .has_header_type1 .col-md-3.user_menu_wrapper {
                padding-top: '.($header_height).'px;
            }
            .has_header_type1 .col-md-3.user_menu_wrapper {
                padding-top: '.($header_height-32).'px;
            }
            ';
        }
        if($sticky_header_height!=''){
            $style.='.header_wrapper.customnav,.customnav.header_wrapper.header_type5{
                height:'.$sticky_header_height.'px;
            } 
            .customnav.header_type2 .logo img{
                bottom: 10px;
                top: auto;
                transform: none;
            }
      

            .customnav .menu > li{
                height:'.$sticky_header_height.'px;
                line-height:'.$sticky_header_height.'px;
            }
            .customnav.header_type5 .menu > li, .customnav.header_type5.hover_type_4  .menu > li{
               line-height:'.$sticky_header_height.'px!important;
            }
            .customnav #access .menu>li>a i{
                line-height:'.$sticky_header_height.'px;
            }
            .customnav #access ul li.with-megamenu>ul.sub-menu, 
            .customnav #access ul li.with-megamenu:hover>ul.sub-menu,
            .customnav #access ul li:hover> ul{
              top:'.$sticky_header_height.'px;
            }
            .header_type5.customnav #access ul li.with-megamenu>ul.sub-menu, 
            .header_type5.customnav #access ul li.with-megamenu:hover>ul.sub-menu, 
            .header_type5.customnav #access ul li:hover> ul,
            .full_width_header .header_type1.header_left.customnav #access ul li.with-megamenu>ul.sub-menu, 
            .full_width_header .header_type1.header_left.customnav #access ul li.with-megamenu:hover>ul.sub-menu{
                top:'.$sticky_header_height.'px;
            }
            ';
        }
         
        $wpestate_uset_unit       =   intval ( wpresidence_get_option('wpestate_uset_unit','') );
        $wpestate_custom_unit_structure = wpresidence_get_option('wpestate_property_unit_structure');
        if($wpestate_uset_unit==1 && $wpestate_custom_unit_structure!=''){
            foreach($wpestate_custom_unit_structure as $rows){
                foreach($rows as $columns){
                    foreach($columns as $elements){
                        if($elements['class_name']!='' && $elements['class_content']!=''){
                            $style.= ".".$elements['class_name']."{".$elements['class_content']."}";
                            if($elements['font']!=''){
                                $style.= ".".$elements['class_name']." a{font-size:".$elements['font']."px;color:".$elements['color']."}";
                                $style.= ".".$elements['class_name']." span:before{font-size:".$elements['font']."px;color:".$elements['color']."}";
                            }

                        }
                    }
                   
                }
            }
        
        }
        
        
        if($style!=''){
            print trim($style);  
        }

    }
endif;


if(!function_exists('wpestate_build_unit_custom_structure')):
function wpestate_build_unit_custom_structure($wpestate_custom_unit_structure,$propID,$wpestate_property_unit_slider){
   
    $row_no=0;
    $wpestate_custom_unit_structure      =   wpresidence_get_option('wpestate_property_unit_structure');
   
    if(is_array($wpestate_custom_unit_structure)){
        foreach($wpestate_custom_unit_structure as $rows){
       
        $row_class=count ($rows);
        $col_md=12;
        if($row_class==2){
            $col_md=6;
        }else if($row_class==3){
            $col_md=4;
        }else if($row_class==4){
            $col_md=3;
        }
        
        $row_no++;
        foreach($rows as $columns){
            print '<div class="property_unit_custom row_no_'.$row_no.' col-md-'.$col_md.'  ">';
                foreach($columns as $elements){
                    print '<div class="property_unit_custom_element '.$elements['element_name'].' '.$elements['class_name'].' '.$elements['extra_class'];
                    if($elements['element_name']=='custom_div') {
                        print ' '. $elements['text'].' ';
                    }
                    print '"';
                    if($elements['text-align']!='' ) {
                        if( $col_md==12 || $elements['text-align']=='center'){
                            print ' style=" width:100%; " ';
                        } else{
                            print ' style=" float:'.$elements['text-align'].'; " ';
                        }
                        
                    }
                    
                    print '>';
                    wpestate_build_unit_show_detail($elements['element_name'],$propID,$wpestate_property_unit_slider,$elements['text'],$elements['icon']);
                    print '</div>';
                }
            print'</div>';
        }
        
        
    }
    } 
}
endif;


if(!function_exists('wpestate_build_unit_show_detail')):
function wpestate_build_unit_show_detail($element,$propID,$wpestate_property_unit_slider,$text,$icon){
    $element = strtolower($element);
    
    
    switch ($element) {
        case 'share':
            $link=  esc_url (  get_permalink($propID) );
            if ( has_post_thumbnail() ){
                $pinterest = wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_full_map');
            }
            $protocol = is_ssl() ? 'https' : 'http';
            
            print wpestate_share_unit_desing($propID);
            
            if($text==''){
                if($icon!=''){
                    if ( strpos($icon, 'fa-') !== false){
                        print '<span class="share_list text_share"  data-original-title="'.esc_attr__('share','wpresidence').'" ><i class="fa '.esc_attr($icon).'" aria-hidden="true"></i></span>';
                    }else{
                        print '<span class="share_list text_share"  data-original-title="'.esc_attr__('share','wpresidence').'" ><img src="'.esc_url($icon).'" alt="'.esc_html__('share','wpresidence').'"></span>';
                    }
                }else{
                    print '<span class="share_list"  data-original-title="'.esc_attr__('share','wpresidence').'" ></span>';
                }
                
            }else{
               print '<span class="share_list text_share"  data-original-title="'.esc_attr__('share','wpresidence').'" >'.$text.'</span>';
            }       
               
        break;
        
        
        case 'link_to_page':
         
            $link=  esc_url ( get_permalink($propID));        
            if($text==''){
                if ( strpos($icon, 'fa-') !== false){
                    print '<a href="'.esc_url($link).'" target="'.esc_attr(wpresidence_get_option('wp_estate_unit_card_new_page','')).'" ><i class="fa '.esc_attr($icon).'" aria-hidden="true"></i></a>';
                }else{
                    print '<a href="'.esc_url($link).'" target="'.esc_attr(wpresidence_get_option('wp_estate_unit_card_new_page','')).'" ><img src="'.esc_url($icon).'" alt="'.esc_html__('details','wpresidence').'"></a>';
                }
            }else{
               print '<a href="'.esc_url($link).'" target="'.esc_attr(wpresidence_get_option('wp_estate_unit_card_new_page','')).'" >'.str_replace('_',' ',$text).'</a>';
               
            }       
               
        break;
       
        case 'favorite':
            $current_user   =   wp_get_current_user();
            $userID         =   $current_user->ID;
            $user_option    =   'favorites'.$userID;
            $favorite_class =   'icon-fav-off';
            $fav_mes        =   esc_html__('add to favorites','wpresidence');
            $user_option    =   'favorites'.$userID;
            $curent_fav     =   get_option($user_option);
            if($curent_fav){
                if ( in_array ($propID,$curent_fav) ){
                    $favorite_class =   'icon-fav-on';   
                    $fav_mes        =   esc_html__('remove from favorites','wpresidence');
                } 
            }
        print '<span class="icon-fav custom_fav '.esc_attr($favorite_class).'" data-original-title="'.esc_attr($fav_mes).'" data-postid="'.intval($propID).'"></span>';
        
        break;
        
               
        case 'compare':
         
          //    
            $compare   = wp_get_attachment_image_src(get_post_thumbnail_id(), 'slider_thumb');           
            if($text==''){
              
                if($icon!=''){
                    if ( strpos($icon, 'fa-') !== false){
                        print '<span class="compare-action text_compare" data-original-title="'.esc_attr__('compare','wpresidence').'" data-pimage="';
                        if( isset($compare[0])){print esc_html($compare[0]);} 
                        print '" data-pid="'.intval($propID).'"><i class="fa '.esc_attr($icon).'" aria-hidden="true"></i></span>';
                       
                    }else{
                        print '<span class="compare-action text_compare" data-original-title="'.esc_attr__('compare','wpresidence').'" data-pimage="';
                        if( isset($compare[0])){print esc_html($compare[0]);} 
                        print '" data-pid="'.intval($propID).'"><img src="'.esc_url($icon).'" alt="'.esc_html__('featured icon','wpresidence').'"></span>';
                    }
                }else{
                    print '<span class="compare-action" data-original-title="'.esc_attr__('compare','wpresidence').'" data-pimage="';
                    if( isset($compare[0])){print esc_html($compare[0]);} 
                    print '" data-pid="'.intval($propID).'"></span>';
                }
                
            }else{
               print '<span class="compare-action text_compare" data-original-title="'.esc_attr__('compare','wpresidence').'" data-pimage="';
               if( isset($compare[0])){print esc_html($compare[0]);} 
               print '" data-pid="'.intval($propID).'">'.$text.'</span>';
               
            }       
               
        break;
        
        
         case 'property_status':
            $prop_stat              =    get_the_terms( $propID, 'property_status');
             
            if(is_array($prop_stat)){ 
                foreach ($prop_stat as $key=>$term){
                    if($term->slug!='normal'){
                        print stripslashes($term->name) ;
                    }
                }
            }
        break;
        
        
    
            
        case 'icon':
            if ( strpos($icon, 'fa-') !== false){
                print '<i class="fa '.$icon.'" aria-hidden="true"></i>';
            }else{
                print '<img src="'.esc_url($icon).'" alt="'.esc_html__('featured icon','wpresidence').'">';
            }
        break;
        
        
        
        case 'featured_icon':
            if(intval  ( get_post_meta($propID, 'prop_featured', true) )==1){
                
                if($text!=''){
                    print esc_html($text);
                }else{
                    if ( strpos($icon, 'fa-') !== false){
                        print '<i class="fa '.$icon.'" aria-hidden="true"></i>';
                    }else{
                        print '<img src="'.esc_url($icon).'" alt="'.esc_html__('featured icon','wpresidence').'">';
                    }
                }
                
               
            }
        break;
        
        case 'text':
            if (function_exists('icl_translate') ){
                print stripslashes(str_replace('_',' ',$text));
            }else{
                $meta_value =stripslashes(str_replace('_',' ',$text));
                $meta_value = apply_filters( 'wpml_translate_single_string', $meta_value, 'wpestate', 'wp_estate_custom_unit_'.$meta_value );
                print esc_html($meta_value);
            }
        break;
        
        case 'image':
            wpestate_build_unit_show_detail_image($propID,$wpestate_property_unit_slider);
        break;
    
        case 'description':
            print wpestate_strip_excerpt_by_char(get_the_excerpt(),115,$propID);
        break;
    
        case 'title':
            print '<h4><a href="'.esc_url( get_permalink($propID) ).'" target="'.esc_attr(wpresidence_get_option('wp_estate_unit_card_new_page','')).'" >'.get_the_title($propID).'</a></h4>';
        break;
    
        case 'property_price':
            $wpestate_currency                   =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
            $where_currency             =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
            wpestate_show_price($propID,$wpestate_currency,$where_currency);
        break;
    
        case 'property_category';
            print get_the_term_list($propID, 'property_category', '', ', ', '') ;
        break;
    
        case 'property_action_category';
            print get_the_term_list($propID, 'property_action_category', '', ', ', '') ;
        break;
        
        case 'property_city';
            print get_the_term_list($propID, 'property_city', '', ', ', '') ;
        break;
        
        case 'property_area';
            print get_the_term_list($propID, 'property_area', '', ', ', '') ;
        break;
        
        case 'property_county_state';
            print  get_the_term_list($propID, 'property_county_state', '', ', ', '') ;
        break;
        
        case 'property_agent';
            $agent_id   = intval( get_post_meta($propID, 'property_agent', true) );
            print '<a href="'.esc_url ( get_permalink($agent_id) ).'">'.get_the_title($agent_id).'</a>';
        break;
        
        case 'property_agent_picture';
            $agent_id   = intval( get_post_meta($propID, 'property_agent', true) );
            $preview            = wp_get_attachment_image_src(get_post_thumbnail_id($agent_id), 'agent_picture_thumb');
            $preview_img         = $preview[0];
            print '<a href="'.esc_url( get_permalink($agent_id)).'" class="property_unit_custom_agent_face" style="background-image:url('.esc_url($preview_img).')"></a>';
        break;
        
        case 'custom_div';
            print '';
        break;
        case 'property_size';
            print wpestate_get_converted_measure( $propID, 'property_size' ); 
        break;
        default:
           
            if (function_exists('icl_translate') ){
                print  get_post_meta($propID, $element, true);
            }else{
                $meta_value = get_post_meta($propID, $element, true);;
                $meta_value = apply_filters( 'wpml_translate_single_string', $meta_value, 'wpestate', 'wp_estate_custom_unit_'.$meta_value );
                print esc_html($meta_value);
            }
    }
    
  
}
endif;


if (!function_exists('wpestate_build_unit_show_detail_image')):
function wpestate_build_unit_show_detail_image($propID,$wpestate_property_unit_slider){
    
    if ( has_post_thumbnail($propID) ){
        $link       =    esc_url ( get_permalink($propID));
        $title      =   get_the_title($propID);
        $pinterest  =   wp_get_attachment_image_src(get_post_thumbnail_id($propID), 'property_full_map');
        $preview    =   wp_get_attachment_image_src(get_post_thumbnail_id($propID), 'property_listings');
        $compare    =   wp_get_attachment_image_src(get_post_thumbnail_id($propID), 'slider_thumb');
        $extra= array(
            'data-original' =>  $preview[0],
            'class'         =>  'lazyload img-responsive',    
        );


        $thumb_prop             =   get_the_post_thumbnail($propID, 'property_listings',$extra);

        if($thumb_prop ==''){
            $thumb_prop_default =  get_theme_file_uri('/img/defaults/default_property_listings.jpg');
            $thumb_prop         =  '<img src="'.esc_url($thumb_prop_default).'" class="b-lazy img-responsive wp-post-image  lazy-hidden" alt="'.esc_html__('icon','wpresidence').'" />';   
        }

        print   '<div class="listing-unit-img-wrapper">';

            if(  $wpestate_property_unit_slider==1){
                    //slider
                $arguments      = array(
                                    'numberposts' => -1,
                                    'post_type' => 'attachment',
                                    'post_mime_type' => 'image',
                                    'post_parent' => $propID,
                                    'post_status' => null,
                                    'exclude' => get_post_thumbnail_id(),
                                    'orderby' => 'menu_order',
                                    'order' => 'ASC'
                                );
                $post_attachments   = get_posts($arguments);

                $slides='';

                $no_slides = 0;
                foreach ($post_attachments as $attachment) { 
                    $no_slides++;
                    $preview    =   wp_get_attachment_image_src($attachment->ID, 'property_listings');

                    $slides     .= '<div class="item lazy-load-item">
                                        <a href="'.esc_url($link).'"><img  data-lazy-load-src="'.esc_attr($preview[0]).'" alt="'.esc_attr($title).'" class="img-responsive" /></a>
                                    </div>';

                }// end foreach
                $unique_prop_id=uniqid();
                print '
                <div id="property_unit_carousel_'.esc_attr($unique_prop_id).'" class="carousel property_unit_carousel slide " data-ride="carousel" data-interval="false">
                    <div class="carousel-inner">         
                        <div class="item active">    
                            <a href="'.esc_url($link).'">'.$thumb_prop.'</a>     
                        </div>
                        '.$slides.'
                    </div>




                    <a href="'.esc_url($link).'"> </a>';

                    if( $no_slides>0){
                        print '<a class="left  carousel-control" href="#property_unit_carousel_'.$unique_prop_id.'" data-slide="prev">
                            <i class="fas fa-angle-left"></i>
                        </a>

                        <a class="right  carousel-control" href="#property_unit_carousel_'.$unique_prop_id.'" data-slide="next">
                            <i class="fas fa-angle-right"></i>
                        </a>';
                    }
                print'
                </div>';


            }else{
                print   '<a href="'.esc_url($link).'">'.$thumb_prop.'</a>';
                print   '<div class="listing-cover"></div><a href="'.esc_url($link).'"> <span class="listing-cover-plus">+</span></a>'; 
            }



            
            print   '</div>';
                

            }
}
endif;


if(!function_exists('wpestate_share_unit_desing')):
function wpestate_share_unit_desing($prop_id,$is_single=1){
    $protocol       =   is_ssl() ? 'https' : 'http';
    $pinterest      =   wp_get_attachment_image_src(get_post_thumbnail_id($prop_id), 'property_full_map');
    $link           =   esc_url ( get_permalink($prop_id) );
    $title          =   get_the_title($prop_id);
    $twiter_status  =   urlencode( $title.' '.$link);
    $email_link     =   'subject='.urlencode ( $title ) .'&body='. urlencode( esc_url($link));
    ob_start();
    
    ?>
        <div class="share_unit">
        <a href="<?php print esc_html($protocol);?>://www.facebook.com/sharer.php?u=<?php echo esc_url($link); ?>&amp;t=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="social_facebook"></a>
        <a href="<?php print esc_html($protocol);?>://twitter.com/intent/tweet?text=<?php echo esc_html($twiter_status); ?>" class="social_tweet" target="_blank"></a>
        <a href="<?php print esc_html($protocol);?>://pinterest.com/pin/create/button/?url=<?php echo esc_url($link); ?>&amp;media=<?php if (isset( $pinterest[0])){ echo esc_url($pinterest[0]); }?>&amp;description=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="social_pinterest"></a>
        <a href="<?php print esc_html($protocol);?>://api.whatsapp.com/send?text=<?php echo urlencode( get_the_title().' '. esc_url( $link )); ?>" class="social_whatsup" target="_blank"></a>   
           
        <a href="mailto:email@email.com?<?php echo trim(esc_html($email_link));?>" data-action="share email"  class="social_email"></a>

    </div>
    <?php
  
    $return = ob_get_contents();
    ob_end_clean();
    return   $return ;    
              
}
endif;