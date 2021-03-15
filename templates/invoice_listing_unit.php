<?php
global $post;
global $userID;
global $where_currency;
global $wpestate_currency;
global $current_user;
?>

<div class="col-md-12 invoice_unit " data-booking-confirmed="<?php echo esc_attr(get_post_meta($post->ID, 'item_id', true));?>" data-invoice-confirmed="<?php echo intval($post->ID); ?>">
    <div class="col-md-2">
         <?php echo get_the_title(); ?> 
    </div>
    
    <div class="col-md-2">
        <?php echo get_the_date(); ?> 
    </div>
    
    <div class="col-md-2">
        <?php 
            $invoice_type= esc_html(get_post_meta($post->ID, 'invoice_type', true)); 
             //quick solution -  to be changed 
            if($invoice_type == 'Listing'){
                esc_html_e('Listing','wpresidence');
            }else if($invoice_type == 'Upgrade to Featured') {
                esc_html_e('Upgrade to Featured','wpresidence');
            } else if($invoice_type == 'Publish Listing with Featured'){
                esc_html_e('Publish Listing with Feature','wpresidence');
            }else if($invoice_type == 'Package'){
                esc_html_e('Package','wpresidence');
            }
        
        ?>
    </div>
    
    <div class="col-md-2">
        <?php 
            $bill_type = esc_html(get_post_meta($post->ID, 'biling_type', true));
            //quick solution -  to be changed 
            if($bill_type =='One Time' ){
                esc_html_e('One Time','wpresidence');
            }else if( $bill_type == 'Recurring'){
                esc_html_e('Recurring','wpresidence');
            }
        ?>
    </div>
    
    <div class="col-md-2">
        <?php 
        $status = esc_html(get_post_meta($post->ID, 'pay_status', true));
        if($status==0){
            esc_html_e('Not Paid','wpresidence');
        }else{
            esc_html_e('Paid','wpresidence');
        }   
        ?>      
    </div>
    
    <div class="col-md-2">
        <?php 
        $price = get_post_meta($post->ID, 'item_price', true);
       echo wpestate_show_price_booking_for_invoice($price,$wpestate_currency,$where_currency,0,1) ?>
    </div>
</div>