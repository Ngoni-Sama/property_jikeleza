/*global  jQuery, document ,ajaxcalls_vars,Modernizr,google,map,control_vars,dashboard_vars*/
// front property submit page-template-front_property_submit
jQuery(document).ready(function ($){
    "use strict";
    jQuery('#loginpop').val('3');
    jQuery('.page-template-front_property_submit #submit_property').on('click',function(event){
            event.preventDefault();

            if (parseInt(ajaxcalls_vars.userid, 10) === 0 ) {
                jQuery('.login-links').hide();
                jQuery("#modal_login_wrapper").show(); 
            }else{
                $('#front_submit_form').submit();
            }
    });
        
        
        
        
        $('#front_end_submit_register').on('click', function(){ 
 
            var post_id, securitypass, ajaxurl;
            securitypass    =  jQuery('#security-pass').val();
            ajaxurl         =  ajaxcalls_vars.admin_url + 'admin-ajax.php';

            if (parseInt(ajaxcalls_vars.userid, 10) === 0 ) {



                if (!Modernizr.mq('only all and (max-width: 768px)')) {
                    jQuery('#modal_login_wrapper').show(); 
                    jQuery('#loginpop').val('2');
                }else{
                    jQuery('.mobile-trigger-user').trigger('click');
                }


            } 
              jQuery('#loginpop').val('2');
        });
        
        
	// inner navigation processing
	$('.inner_navigation').on('click', function(e){ 
		e.preventDefault();
		var current_step = parseInt( $('.page-template-front_property_submit #current_step').val() );	
		$('.page-template-front_property_submit .step_'+current_step).hide();
		
		var id = parseInt( $(this).attr('data-id') );
	 
          
         
		$('.page-template-front_property_submit .step_'+id).fadeIn();
		$('.page-template-front_property_submit .inner_navigation').removeClass('active');
		$(this).addClass('active');
		$('.page-template-front_property_submit #current_step').val( id );
	
		if( id < 7 ){
                    
			$('#front_submit_prev_step').show();
			$('#front_submit_next_step').show();
                        if(mapfunctions_vars.geolocation_type==1){
                            google.maps.event.trigger(map, 'resize');
                        }else{
                       
                            setTimeout(function(){       map.invalidateSize(); }, 600);   
                        }
			$('.page-template-front_property_submit #submit_property').hide();
		}
		if( id == 5 ){
                  
			$('#front_submit_next_step').hide();
			$('.page-template-front_property_submit #submit_property').show();
		}
		if( id == 1 ){
                    
			$('#front_submit_prev_step').hide();
			$('#front_submit_next_step').show();
			$('.page-template-front_property_submit #submit_property').hide();
		}
	});
	
	// process next step action
	$('#front_submit_next_step').on('click', function(e){ 
		var current_step = parseInt( $('.page-template-front_property_submit #current_step').val() );	
               
		if( current_step < 5 ){
			$('.page-template-front_property_submit .step_'+current_step).hide();
			current_step++;
			
			// innner navigaton
			$('.page-template-front_property_submit .inner_navigation').removeClass('active');
			$('.page-template-front_property_submit .navigation_'+current_step).addClass('active');
			
			$('.page-template-front_property_submit #current_step').val( current_step );
			$('.page-template-front_property_submit .step_'+current_step).show();
			$('#front_submit_prev_step').show();
			if(wp_estate_kind_of_map===1){
                            google.maps.event.trigger(map, "resize");
                        }else if(wp_estate_kind_of_map===2){
                             map.invalidateSize();
                        }
                        $('.page-template-front_property_submit #submit_property').hide();
		}
		if( current_step == 5 ){
			$('#front_submit_next_step').hide();
			$('.page-template-front_property_submit #submit_property').show();

            }
	});
	
	// process prev step action
	$('#front_submit_prev_step').on('click', function(e){ 
		var current_step = parseInt( $('.page-template-front_property_submit #current_step').val() );
         
		if( current_step <= 5 ){
			$('.page-template-front_property_submit .step_'+current_step).hide();
			current_step--;
			
			// innner navigaton
			$('.page-template-front_property_submit .inner_navigation').removeClass('active');
			$('.page-template-front_property_submit .navigation_'+current_step).addClass('active');
			$('.page-template-front_property_submit #current_step').val( current_step );
			$('.page-template-front_property_submit .step_'+current_step).show();
			$('#front_submit_next_step').show();
			google.maps.event.trigger(map, 'resize');
                        $('.page-template-front_property_submit #submit_property').hide();
		}
		if( current_step == 1 ){
			$('#front_submit_prev_step').hide();
			$('#front_submit_next_step').show();
			$('.page-template-front_property_submit #submit_property').hide();
		}
	});
	
	// login link / register link swap fn
	$('#register_link').on('click', function(e){ 
		e.preventDefault();
		$('.page-template-front_property_submit #register_link').hide();
		$('.page-template-front_property_submit #login_link').show();
		
		$('.page-template-front_property_submit .register_row').show();
		$('.page-template-front_property_submit .login_row').hide();
		$('#submit_type').val('register');
	});
	$('#login_link').on('click', function(e){ 
		e.preventDefault();
		$('.page-template-front_property_submit #register_link').show();
		$('.page-template-front_property_submit #login_link').hide();
		
		$('.page-template-front_property_submit .register_row').hide();
		$('.page-template-front_property_submit .login_row').show();
		$('#submit_type').val('login');
	});
		
});