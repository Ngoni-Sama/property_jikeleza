<?php
global  $agency_skype;
global  $agency_phone;
global  $agency_mobile;
global  $agency_email;
global  $agency_opening_hours;
global  $agency_addres;
        
$thumb_id               =   get_post_thumbnail_id($post->ID);
$preview                =   wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_listings');
$preview_img            =   $preview[0];
$agency_skype           =   esc_html( get_post_meta($post->ID, 'agency_skype', true) );
$agency_phone           =   esc_html( get_post_meta($post->ID, 'agency_phone', true) );
$agency_mobile          =   esc_html( get_post_meta($post->ID, 'agency_mobile', true) );
$agency_email           =   is_email( get_post_meta($post->ID, 'agency_email', true) );
$agency_posit           =   esc_html( get_post_meta($post->ID, 'agency_position', true) );
$agency_facebook        =   esc_html( get_post_meta($post->ID, 'agency_facebook', true) );
$agency_twitter         =   esc_html( get_post_meta($post->ID, 'agency_twitter', true) );
$agency_linkedin        =   esc_html( get_post_meta($post->ID, 'agency_linkedin', true) );
$agency_pinterest       =   esc_html( get_post_meta($post->ID, 'agency_pinterest', true) );
$agency_instagram       =   esc_html( get_post_meta($post->ID, 'agency_instagram', true) );
$agency_opening_hours   =   esc_html( get_post_meta($post->ID, 'agency_opening_hours', true) );
$name                   =   get_the_title($post->ID);
$link                   =    esc_url ( get_permalink($post->ID) );
$agency_addres          =    esc_html( get_post_meta($post->ID, 'agency_address', true) );
$agency_languages       =    esc_html( get_post_meta($post->ID, 'agency_languages', true) );
$agency_license         =    esc_html( get_post_meta($post->ID, 'agency_license', true) );
$agency_taxes           =    esc_html( get_post_meta($post->ID, 'agency_taxes', true) );
$agency_website         =    esc_html( get_post_meta($post->ID, 'agency_website', true) );
?>

<div class="header_agency_wrapper">
    <div class="header_agency_container">
        <div class="row">
            
            <div class="col-md-4">
                <a href="<?php print esc_url($link);?>">
                    <img src="<?php print esc_url($preview_img);?>"  alt="<?php esc_html_e('image','wpresidence');?>" class="img-responsive"/>
                </a>

            </div>
            
            
            <div class="col-md-8">
                <h1 class="agency_title"><?php print esc_html($name); ?></h1>
                
                <div class="col-md-6 agency_details">
                    <?php 
                    if($agency_addres!=''){
                        echo '<div class="agency_detail agency_address"><strong>'.esc_html__('Adress:','wpresidence').'</strong> '.esc_html($agency_addres).'</div>';
                    }
                    ?>
                    <?php 
                    if($agency_email!=''){
                        echo '<div class="agency_detail agency_email"><strong>'.esc_html__('Email:','wpresidence').'</strong> <a href="mailto:'.esc_html($agency_email).'">'.esc_html($agency_email).'</a></div>';
                    }
                    ?>
                    <?php 
                    if($agency_mobile!=''){
                        echo '<div class="agency_detail agency_mobile"><strong>'.esc_html__('Mobile:','wpresidence').'</strong> <a href="tel:'.esc_html($agency_mobile).'">'.esc_html($agency_mobile).'</a></div>';
                    }
                    ?>
                    <?php 
                    if($agency_phone!=''){
                        echo '<div class="agency_detail agency_phone"><strong>'.esc_html__('Phone:','wpresidence').'</strong> <a href="tel:'.esc_html($agency_phone).'">'.esc_html($agency_phone).'</a></div>';
                    }
                    ?>

                    <?php 
                    if($agency_skype!=''){
                        echo '<div class="agency_detail agency_skype"><strong>'.esc_html__('Skype:','wpresidence').'</strong> '.esc_html($agency_skype).'</div>';
                    }
                    ?>
                </div>   
                
                <div class="col-md-6 agency_details">
                    <?php 
                    if($agency_website!=''){
                        echo '<div class="agency_detail agency_taxes"><strong>'.esc_html__('Website:','wpresidence').'</strong> <a href="'.esc_url($agency_website).'" target="_blank">'.esc_html($agency_website).'</a></div>';
                    }
                    ?>
                    
                    <?php 
                    if($agency_languages!=''){
                        echo '<div class="agency_detail agency_website"><strong>'.esc_html__('We Speak:','wpresidence').'</strong> '.esc_html($agency_languages).'</div>';
                    }
                    ?>

                    <?php 
                    if($agency_opening_hours!=''){
                        echo '<div class="agency_detail agency_opening_hours"><strong>'.esc_html__('Opening Hours:','wpresidence').'</strong> '.esc_html($agency_opening_hours).'</div>';
                    }
                    ?>

                     <?php 
                    if($agency_license!=''){
                        echo '<div class="agency_detail agency_license"><strong>'.esc_html__('License:','wpresidence').'</strong> '.esc_html($agency_license).'</div>';
                    }
                    ?>

                    <?php 
                    if($agency_taxes!=''){
                        echo '<div class="agency_detail agency_taxes"><strong>'.esc_html__('Our Taxes:','wpresidence').'</strong> '.esc_html($agency_taxes).'</div>';
                    }
                    ?>
                </div>
                
                <a href="#agency_contact" class="wpresidence_button agency_contact_but"  ><?php esc_html_e('Contact Us','wpresidence');?></a>
                
            </div>
            
        
        </div>
    
    </div>
    
</div>