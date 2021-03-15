<?php
global $post;
global $userID;
global $current_user;
$message_from_user      =   get_post_meta($post->ID, 'message_from_user', true);
$user                   =   get_user_by( 'id', $message_from_user );
$message_from_user_name =   $user->user_login;
$message_status         =   get_post_meta($post->ID, 'message_status'.$userID, true);
$message_title          =   get_the_title($post->ID);
$message_content        =   get_the_content();
?>

<div class="col-md-12"> 
    <div class="message_listing " data-messid="<?php print intval($post->ID); ?> ">

        <div class="message_header">
            <div class="col-md-3">
                <?php
                if($message_status=='unread'){
                    print '<span class="mess_unread mess_tooltip" data-original-title="'. esc_attr__( 'new message','wpresidence').'"><i class="fas fa-exclamation-circle"></i>/span>';        
                }
                ?>
           
                <?php 
                  
                if($current_user->user_login == $message_from_user_name ){
                    print ' <span class="mess_from"><strong>'.esc_html__( 'Conversation started by you ','wpresidence'). '</strong></span>';
                }else{
                    print ' <span class="mess_from"><strong>'.esc_html__( 'From','wpresidence'). ': </strong>'.esc_html($message_from_user_name).'</span>';       
                }
                
                ?>
             </div>
            
            <div class="col-md-4">
                <span class="mess_subject"> <strong><?php esc_html_e('Subject','wpresidence');?>: </strong><?php print esc_html($message_title);?></span>
            </div>
            
            <div class="col-md-2">
                <span class="mess_date"><?php echo get_the_date();?></span>
            </div>
            
            <div class=" message-action text-right" >
                <span data-original-title="<?php esc_attr_e('reply to message','wpresidence');?>"  class="mess_reply mess_tooltip">       
                    <i class="fas fa-reply"></i> 
                </span>
                <div class="delete_wrapper">
                    <span data-original-title="<?php esc_attr_e('delete message','wpresidence');?>"  class="mess_delete mess_tooltip">
                        <i class="fas fa-times deleteprop"></i>
                    </span>
                </div>
            </div>
            
          
        </div>   

        <div class="mess_content">
            <h4><?php print esc_html($message_title);?></h4>
            <div class="message_content">
                <?php 
                $pieces= explode('||',$message_content);
              
                print nl2br($pieces[0]);
                if(isset($pieces[1])){
                    print '</br>';
                    print esc_html(nl2br($pieces[1]));
                }
                ?>
                
                <?php
                print '<div class="mess_content-list-replies">';
                    $args_child = array(
                        'post_type'         => 'wpestate_message',
                        'post_status'       => 'publish',
                        'posts_per_page'             => -1,
                        'order'             => 'ASC',
                        'post_parent'       => $post->ID,
                    );

                    $message_selection_child = new WP_Query($args_child);
                    while ($message_selection_child->have_posts()): $message_selection_child->the_post(); 
                        $user = get_user_by( 'id', $post->post_author );
                        print '<div class="mess_content-list-replies_unit">'
                        . '<h4><strong>'.esc_html__( 'From: ','wpresidence').'</strong> '.esc_html($user->user_login).' - ' .get_the_title($post->ID).'</h4>'
                                .nl2br(get_the_content()).'</div>';
                    endwhile;
                    wp_reset_query();
                print'</div>';
                
                ?>
                
                <span class="wpresidence_button  mess_send_reply_button2"><?php esc_html_e('Reply','wpresidence');?></span>              
            </div>
        </div>

        <div class="mess_reply_form">
          
                <h4><?php esc_html_e('Reply','wpresidence');?></h4>
                <input type="text" class="subject_reply" value="Re: <?php echo esc_html($message_title); ?>">
                <textarea name="message_reply_content" class="message_reply_content"></textarea></br>
                <span class="wpresidence_button  mess_send_reply_button"  data-messid="<?php print intval($post->ID);?>">
                    <?php esc_html_e('Send Reply','wpresidence');?>
                </span>
            
        </div>    
    </div>
</div>