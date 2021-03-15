<?php
// Template Name:Stripe Charge Page
// Wp Estate Pack


$endpoint_secret   =   esc_html ( wpresidence_get_option('wp_estate_stripe_webhook','') ); 
$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
$event = null;

try {
    $event = \Stripe\Webhook::constructEvent(
        $payload, $sig_header, $endpoint_secret
    );
} catch(\UnexpectedValueException $e) {
    // Invalid payload
    http_response_code(400); // PHP 5.4 or greater
    exit('');
} catch(\Stripe\Error\SignatureVerification $e) {
    // Invalid signature
    http_response_code(400); // PHP 5.4 or greater
    exit();
}
   
    

if ($event->type == "payment_intent.succeeded") {
        $intent = $event->data->object;
  
        $pay_type       =   intval($event->data->object->charges->data[0]->metadata->pay_type);
        $userId         =   intval($event->data->object->charges->data[0]->metadata->user_id);  
        $depozit        =   intval($intent->amount);
       
            
        if($pay_type==2){
            
            $listing_id     =   intval($event->data->object->charges->data[0]->metadata->listing_id);
            $is_featured    =   intval($event->data->object->charges->data[0]->metadata->featured_pay);
            $is_upgrade     =   intval($event->data->object->charges->data[0]->metadata->is_upgrade);

            $time = time(); 
            $date = date('Y-m-d H:i:s',$time);

            if($is_upgrade==1){
                
                update_post_meta($listing_id, 'prop_featured', 1);
                $invoice_id=wpestate_insert_invoice('Upgrade to Featured','One Time',$listing_id,$date,$current_user->ID,0,1,'' );
                wpestate_email_to_admin(1);
                update_post_meta($invoice_id, 'pay_status', 1); 
                
                
            }else{
                
                update_post_meta($listing_id, 'pay_status', 'paid');
                
                // if admin does not need to approve - make post status as publish
                $admin_submission_status = esc_html ( wpresidence_get_option('wp_estate_admin_submission','') );
                $paid_submission_status  = esc_html ( wpresidence_get_option('wp_estate_paid_submission','') );
              
                if($admin_submission_status=='no'  && $paid_submission_status=='per listing' ){
                      
                    $post = array(
                        'ID'            => $listing_id,
                        'post_status'   => 'publish'
                        );
                     $post_id =  wp_update_post($post ); 
                }
                // end make post publish

                if($is_featured==1){
                    update_post_meta($listing_id, 'prop_featured', 1);
                    $invoice_id = wpestate_insert_invoice('Publish Listing with Featured','One Time',$listing_id,$date,$current_user->ID,1,0,'' );
                }else{
                    $invoice_id = wpestate_insert_invoice('Listing','One Time',$listing_id,$date,$current_user->ID,0,0,'' );
                }
                update_post_meta($invoice_id, 'pay_status', 1); 
                wpestate_email_to_admin(0);
            }
        
            $redirect = wpestate_get_template_link('user_dashboard.php');
            http_response_code(200);
            wp_redirect($redirect);exit();
        }
    
    

    
    
    
    
    
}elseif ($event->type == "invoice.payment_succeeded") {
            $customer_stripe_id =$event->data->object->customer;
       
            $args=array('meta_key'      => 'stripe', 
                        'meta_value'    => $customer_stripe_id
            );
            
            $update_user_id =   0;
            $customers=get_users( $args ); 
            foreach ( $customers as $user ) {
                $update_user_id = $user->ID;
            } 
            $pack_id = intval (get_user_meta($update_user_id, 'package_id',true));
           
            if($update_user_id!=0 && $pack_id!=0){
                if( wpestate_check_downgrade_situation($update_user_id,$pack_id) ){
                    wpestate_downgrade_to_pack( $update_user_id, $pack_id );
                    wpestate_upgrade_user_membership($update_user_id,$pack_id,2,'');
                }else{
                    wpestate_upgrade_user_membership($update_user_id,$pack_id,2,'');
                }     
            }
           
    
            http_response_code(200);
            exit();
    
            
    
}elseif ($event->type == "invoice.payment_failed") {
    
        $customer_stripe_id =$event->data->object->customer;
        $args   =   array(  'meta_key'      => 'stripe', 
                            'meta_value'    => $customer_stripe_id
                            );

        $customers  =   get_users( $args ); 
        foreach ( $customers as $user ) {
            update_user_meta( $user->ID, 'stripe', '' );
            downgrade_to_free($user->ID);
        }      
        http_response_code(200);
        exit();
    
    
}elseif ($event->type == "payment_intent.payment_failed") {
        $intent = $event->data->object;
        $error_message = $intent->last_payment_error ? $intent->last_payment_error->message : "";
        printf("Failed: %s, %s", $intent->id, $error_message);
        http_response_code(200);
        exit();
}else{
    http_response_code(200);
    exit();
}
