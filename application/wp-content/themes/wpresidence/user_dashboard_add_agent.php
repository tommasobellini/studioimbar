<?php
// Template Name: User Dashboard Add agent
// Wp Estate Pack

if ( !is_user_logged_in() ) {   
     wp_redirect(  home_url() );exit;
} 

$current_user = wp_get_current_user();
$dash_profile_link = get_dashboard_profile_link();


get_header();
$options    =   wpestate_page_details($post->ID);

$user_role = get_user_meta( $current_user->ID, 'user_estate_role', true) ;
if($user_role!=3 && $user_role !=4){
    wp_redirect(  home_url() );exit;
}
global $listing_edit;
global $is_edit;

//edit
$listing_edit=0;
$is_edit=0;
if(isset($_GET['listing_edit'])){
    $listing_edit=intval($_GET['listing_edit']);
    $is_edit=1;
}

?>

<!--  -->
<?php
$current_user               =   wp_get_current_user();
$user_custom_picture        =   get_the_author_meta( 'small_custom_picture' , $current_user->ID  );
$user_small_picture_id      =   get_the_author_meta( 'small_custom_picture' , $current_user->ID  );
if( $user_small_picture_id == '' ){

    $user_small_picture[0]=get_template_directory_uri().'/img/default-user_1.png';
}else{
    $user_small_picture=wp_get_attachment_image_src($user_small_picture_id,'agent_picture_thumb');
    
}
?>
<!--  -->


<div class="row row_user_dashboard">

    <div class="col-md-3 user_menu_wrapper">
       <div class="dashboard_menu_user_image">
            <div class="menu_user_picture" style="background-image: url('<?php print $user_small_picture[0];  ?>');height: 80px;width: 80px;" ></div>
            <div class="dashboard_username">
                <?php _e('Welcome back, ','wpestate'); echo $user_login.'!';?>
            </div> 
        </div>
          <?php  get_template_part('templates/user_menu');  ?>
    </div>  
    

    <div class="col-md-9 dashboard-margin">
        <?php get_template_part('templates/breadcrumbs'); ?>
        <?php  get_template_part('templates/user_memebership_profile');  ?>
        <?php get_template_part('templates/ajax_container'); ?>
        <?php while (have_posts()) : the_post(); ?>
            <?php if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) != 'no' && $is_edit==0) { ?>
                <h3 class="entry-title"><?php the_title(); ?></h3>
            <?php }else{
                  print '<h3 class="entry-title">'.__('Edit Agent','wpestate').'</h3>';
            } ?>
         
            <div class="single-content"><?php the_content();?></div><!-- single content-->

        <?php endwhile; // end of the loop. ?>
            
            
        <?php  
        get_template_part('templates/add_new_agent_template');
        ?>
         
    </div>
  
  
</div>   
<?php get_footer(); ?>