<?php
require_once get_theme_file_path('/libs/plugins/class-tgm-plugin-activation.php');

///////////////////////////////////////////////////////////////////////////////////////////
/////// Required Plugins
///////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_required_plugins') ):
function wpestate_required_plugins() {
    
  
	$plugins = array(
                array(
                    'name'     			=> 'WpResidence Core functionality', 
                    'slug'     			=> 'wpresidence-core', 
                    'source'   			=> get_theme_file_uri ('/libs/plugins/wpresidence-core.zip'),
                    'required' 			=> true,
                    'version' 			=> '3.3',
                    'force_activation' 		=> false, 
                    'force_deactivation' 	=> false,
                    'external_url' 		=> '',
		),
                array(
                    'name'     			=> 'WpResidence Gutenberg Blocks functionality', 
                    'slug'     			=> 'residence-gutenberg', 
                    'source'   			=> get_theme_file_uri ('/libs/plugins/residence-gutenberg.zip'),
                    'required' 			=> true,
                    'version' 			=> '1.50.1',
                    'force_activation' 		=> false, 
                    'force_deactivation' 	=> false,
                    'external_url' 		=> '',
		),
            
                array(
                    'name'     			=> 'WpResidence Elementor Addon', 
                    'slug'     			=> 'residence-elementor', 
                    'source'   			=> get_theme_file_uri ('/libs/plugins/residence-elementor.zip'),
                    'required' 			=> true,
                    'version' 			=> '3.3',
                    'force_activation' 		=> false, 
                    'force_deactivation' 	=> false,
                    'external_url' 		=> '',
		), 
                array(
                    'name'     			=> 'WpEstate CRM', 
                    'slug'     			=> 'wpestate-crm', 
                    'source'   			=> get_theme_file_uri ('/libs/plugins/wpestate-crm.zip'),
                    'required' 			=> true,
                    'version' 			=> '1.0',
                    'force_activation' 		=> false, 
                    'force_deactivation' 	=> false,
                    'external_url' 		=> '',
		),
		array(
                    'name'     			=> 'Revolution Slider', 
                    'slug'     			=> 'revslider', 
                    'source'   			=> get_theme_file_uri ('/libs/plugins/revslider.zip'),
                    'required' 			=> false,
                    'version' 			=> '6.2.15',
                    'force_activation' 		=> false, 
                    'force_deactivation' 	=> false,
                    'external_url' 		=> '',
		),
                array(
                    'name'     			=> 'WPBakery Visual Composer', 
                    'slug'     			=> 'js_composer', 
                    'source'   			=> get_theme_file_uri ('/libs/plugins/js_composer.zip'),
                    'required' 			=> false,
                    'version' 			=> '6.2.0',
                    'force_activation' 		=> false, 
                    'force_deactivation' 	=> false,
                    'external_url' 		=> '',
		),
                array(
                    'name'     			=> 'Ultimate Addons for Visual Composer', 
                    'slug'     			=> 'Ultimate_VC_Addons', 
                    'source'   			=> get_theme_file_uri ('/libs/plugins/Ultimate_VC_Addons.zip'),
                    'required' 			=> false,
                    'version' 			=> '3.19.5',
                    'force_activation' 		=> false, 
                    'force_deactivation' 	=> false,
                    'external_url' 		=> '',
		), 
                array(
                    'name'     			=> 'Elementor', 
                    'slug'     			=> 'elementor', 
                    'source'   			=> 'https://downloads.wordpress.org/plugin/elementor.2.9.8.zip',
                    'required' 			=> false,
                    'version' 			=> '2.9.8',
                    'force_activation' 		=> false, 
                    'force_deactivation' 	=> false,
                    'external_url' 		=> '',
		),
                array(
                    'name'     			=> 'One Click Demo Import', 
                    'slug'     			=> 'one-click-demo-import', 
                    'source'   			=> get_theme_file_uri ('/libs/plugins/one-click-demo-import.zip'),
                    'required' 			=> false,
                    'version' 			=> '2.5.2',
                    'force_activation' 		=> false, 
                    'force_deactivation' 	=> false,
                    'external_url' 		=> '',
		),
                array(
                    'name'     			=> 'Envato Market', 
                    'slug'     			=> 'envato-market', 
                    'source'   			=> 'https://goo.gl/pkJS33',
                    'required' 			=> false,
                    'version' 			=> '2.0.1',
                    'force_activation' 		=> false, 
                    'force_deactivation' 	=> false,
                    'external_url' 		=> '',
		)
           
	);

	
	
		$config = array(
		'domain'       		=> 'wpresidence',         	
		'default_path' 		=> '',                         	
		'parent_slug'           => 'themes.php', 				
		'menu'         		=> 'install-required-plugins', 	
		'has_notices'      	=> true,                       
		'is_automatic'    	=> false,					   
		'message' 			=> '',								
		'strings'      		=> array(
			'page_title'                       			=> esc_html__( 'Install Required Plugins', 'wpresidence' ),
			'menu_title'                       			=> esc_html__( 'Install Plugins' , 'wpresidence' ),
			'installing'                       			=> esc_html__( 'Installing Plugin: %s', 'wpresidence' ), 
			'oops'                             			=> esc_html__( 'Something went wrong with the plugin API.', 'wpresidence' ),
			'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'wpresidence'  ), // %1$s = plugin name(s)
			'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'wpresidence'  ), // %1$s = plugin name(s)
			'notice_cannot_install'  				=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'wpresidence'  ), // %1$s = plugin name(s)
			'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' , 'wpresidence' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' , 'wpresidence' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 				=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' , 'wpresidence' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 					=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'wpresidence'  ), // %1$s = plugin name(s)
			'notice_cannot_update' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' , 'wpresidence' ), // %1$s = plugin name(s)
			'install_link' 					 	=> _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'wpresidence'  ),
			'activate_link' 				  	=> _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'wpresidence'  ),
			'return'                           			=> esc_html__( 'Return to Required Plugins Installer', 'wpresidence' ),
			'plugin_activated'                 			=> esc_html__( 'Plugin activated successfully.', 'wpresidence' ),
			'complete' 						=> esc_html__( 'All plugins installed and activated successfully. %s', 'wpresidence' ), 
			'nag_type'						=> 'updated'
		)
	);
tgmpa($plugins, $config);
}
endif; // end   wpestate_required_plugins  
?>