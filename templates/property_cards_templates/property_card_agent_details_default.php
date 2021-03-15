<?php 
$agent_id       =   intval  ( get_post_meta($post->ID, 'property_agent', true) );
$thumb_id       =   get_post_thumbnail_id($agent_id);
$agent_face     =   wp_get_attachment_image_src($thumb_id, 'agent_picture_thumb');

if ($agent_id==0 || $agent_face[0]==''){
    $agent_face[0]=get_the_author_meta( 'custom_picture',$post->post_author);
    if( $agent_face[0]==''){
        $agent_face[0]= get_theme_file_uri('/img/default-user_1.png');
    }
}

?>
<div class="property_agent_wrapper">
    <div class="property_agent_image" style="background-image:url('<?php print esc_attr($agent_face[0]); ?>')"></div> 
    <div class="property_agent_image_sign"><i class="far fa-user-circle"></i></div>
    <?php if($agent_id!=0){
            echo '<a href="'.esc_url( get_permalink($agent_id) ) .'">'.get_the_title($agent_id).'</a>';
        }else{
            echo get_the_author_meta( 'first_name',$post->post_author).' '.get_the_author_meta( 'last_name',$post->post_author);
        }
    ?>
</div>
                