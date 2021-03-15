<?php
add_action('wp_ajax_wpestate_image_caption',  'wpestate_image_caption');
if( !function_exists('wpestate_image_caption') ):
    function wpestate_image_caption(){
        check_ajax_referer( 'wpestate_image_upload', 'security' );
        $current_user   =   wp_get_current_user();
        $userID         =   $current_user->ID;
      
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }
     
        
        $attach_id  =   intval($_POST['attach_id']);
        $caption    =   esc_html($_POST['caption']);
        $the_post   =   get_post( $attach_id); 
        $agent_list                     =  (array) get_user_meta($userID,'current_agent_list',true);
        
        
        if (!current_user_can('manage_options') ){
            if( $userID != $the_post->post_author  &&  !in_array($the_post->post_author , $agent_list)) {
                exit('you don\'t have the right to edit this');;
            }
        }
        $my_post = array(
            'ID'           => $attach_id,
            'post_excerpt' => $caption,
        );

      // Update the post into the database
        wp_update_post( $my_post );

        exit;
    }
endif;


add_action('wp_ajax_nopriv_wpestate_me_upload',             'wpestate_me_upload');
add_action('wp_ajax_wpestate_me_upload',             'wpestate_me_upload');
add_action('wp_ajax_aaiu_delete',           'me_delete_file');
add_action('wp_ajax_wpestate_delete_file',  'wpestate_delete_file');


if( !function_exists('wpestate_delete_file') ):
    function wpestate_delete_file(){
        
        if(isset($_POST['isadmin']) && intval($_POST['isadmin'])==1 ){
            check_ajax_referer( 'wpestate_attach_delete', 'security' );
        }else{
            check_ajax_referer( 'wpestate_image_upload', 'security' );
        }
        
        $current_user   =   wp_get_current_user();
        $userID         =   $current_user->ID;
      
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }
     
        
        $attach_id  = intval($_POST['attach_id']);
        $the_post   = get_post( $attach_id); 

        if (!current_user_can('manage_options') ){
            if( $userID != $the_post->post_author ) {
                exit('you don\'t have the right to delete this');;
            }
        }
        
        wp_delete_attachment($attach_id, true);
        exit;
    }
endif;


if( !function_exists('me_delete_file') ):
    function me_delete_file(){
   
        $current_user   =   wp_get_current_user();
        $userID         =   $current_user->ID;
       
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }
        
        
        $attach_id  =   intval($_POST['attach_id']);
        $the_post   =   get_post( $attach_id); 

        if( $current_user->ID != $the_post->post_author ) {
            exit('you don\'t have the right to delete this');;
        }
        
        wp_delete_attachment($attach_id, true);
        exit;
    }
endif;




if( !function_exists('wpestate_me_upload') ):
    function wpestate_me_upload(){
        $current_user   =   wp_get_current_user();
        $userID         =   $current_user->ID;

        
        $filename       =   convertAccentsAndSpecialToNormal($_FILES['aaiu_upload_file']['tmp_name']);
        $base           =   '';
        $allowed_html   =   array();
        
        list($width, $height) = getimagesize($filename);
        
        if(isset($_GET['base'])){
            $base   =   esc_html( wp_kses( $_GET['base'], $allowed_html ) );
        }
        
        $file = array(
            'name'      => convertAccentsAndSpecialToNormal($_FILES['aaiu_upload_file']['name']),
            'type'      => $_FILES['aaiu_upload_file']['type'],
            'tmp_name'  => $_FILES['aaiu_upload_file']['tmp_name'],
            'error'     => $_FILES['aaiu_upload_file']['error'],
            'size'      => $_FILES['aaiu_upload_file']['size'],
            'width'     =>  $width,
            'height'    =>  $height,
            'base'      =>  $base
        );
        $file = fileupload_process($file);
    }  
endif;    
    



    
if( !function_exists('fileupload_process') ):
    function fileupload_process($file){

    
        
    if( $file['type']!='application/pdf'    ){
        if( intval($file['height'])<500 || intval($file['width']) <500 ){
            $response = array('success' => false,'image'=>true);
            print json_encode($response);
            exit;
        }
    }
        
  
    
    $attachment = handle_file($file);

    if (is_array($attachment)) {
        $html = getHTML($attachment);

        $response = array(
            'base' =>  $file['base'],
            'type'      =>  $file['type'],
            'height'      =>  $file['height'],
            'width'      =>  $file['width'],
            'success'   => true,
            'html'      => $html,
            'attach'    => $attachment['id'],


        );

        print json_encode($response);
        exit;
    }

    $response = array('success' => false);
    print json_encode($response);
    exit;
    }
endif;




if( !function_exists('handle_file') ):   
    function handle_file($upload_data){
        $return = false;
        
        
        $uploaded_file = wp_handle_upload($upload_data, array('test_form' => false));

        if (isset($uploaded_file['file'])) {
            $file_loc   =   $uploaded_file['file'];
            $file_name  =   basename($upload_data['name']);
            $file_type  =   wp_check_filetype($file_name);

            $attachment = array(
                'post_mime_type'    => $file_type['type'],
                'post_title'        => preg_replace('/\.[^.]+$/', '', basename($file_name)),
                'post_content'      => '',
                'post_status'       => 'inherit'
            );

            $attach_id      =   wp_insert_attachment($attachment, $file_loc);
            $attach_data    =   wp_generate_attachment_metadata($attach_id, $file_loc);
            wp_update_attachment_metadata($attach_id, $attach_data);

            $return = array('data' => $attach_data, 'id' => $attach_id);

            return $return;
        }

        return $return;
    }
endif;    
    


if( !function_exists('getHTML') ):   
    function getHTML($attachment){
        $attach_id  =   $attachment['id'];
        $file       =   '';
        $html       =   '';

        if( isset($attachment['data']['file'])){
            $file       =   explode('/', $attachment['data']['file']);
            $file       =   array_slice($file, 0, count($file) - 1);
            $path       =   implode('/', $file);

            if(is_page_template('user_dashboard_add.php') ){
                $image      =   $attachment['data']['sizes']['thumbnail']['file'];
            }else{
                $image      =   $attachment['data']['sizes']['user_picture_profile']['file'];
            }
            
            $dir        =   wp_upload_dir();
            $path       =   $dir['baseurl'] . '/' . $path;
            $html   .=   $path.'/'.$image; 
        }

        return $html;
    }
endif;
?>