<?php
// Template Name: User Dashboard Favorite
// Wp Estate Pack
global $no_listins_per_row;
global $wpestate_uset_unit;
global $custom_unit_structure;
        
$custom_unit_structure    =   get_option('wpestate_property_unit_structure');
$wpestate_uset_unit       =   intval ( get_option('wpestate_uset_unit','') );
$no_listins_per_row       =   4;

if ( !is_user_logged_in() ) {   
    wp_redirect(  home_url() );exit;
} 

$current_user = wp_get_current_user();  
$paid_submission_status         =   esc_html ( get_option('wp_estate_paid_submission','') );
$price_submission               =   floatval( get_option('wp_estate_price_submission','') );
$submission_curency_status      =   esc_html( get_option('wp_estate_submission_curency','') );
$userID                         =   $current_user->ID;
$user_option                    =   'favorites'.$userID;
$curent_fav                     =   get_option($user_option);
$show_remove_fav                =   1;   
$show_compare                   =   1;
$show_compare_only              =   'no';
$currency                       =   esc_html( get_option('wp_estate_currency_symbol', '') );
$where_currency                 =   esc_html( get_option('wp_estate_where_currency_symbol', '') );

get_header();
$options=wpestate_page_details($post->ID);


$property_card_type         =   intval(get_option('wp_estate_unit_card_type'));
$property_card_type_string  =   '';
if($property_card_type==0){
    $property_card_type_string='';
}else{
    $property_card_type_string='_type'.$property_card_type;
}

?> 
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
        <?php   get_template_part('templates/breadcrumbs'); ?>
        <?php   get_template_part('templates/user_memebership_profile');  ?>
        <?php   get_template_part('templates/ajax_container'); ?>
        
        <?php if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) != 'no') { ?>
            <h3 class="entry-title"><?php the_title(); ?></h3>
        <?php } ?>
         
        <?php
        if( !empty($curent_fav)){
             $args = array(
                 'post_type'        => 'estate_property',
                 'post_status'      => 'publish',
                 'posts_per_page'   => -1 ,
                 'post__in'         => $curent_fav 
             );


             $prop_selection = new WP_Query($args);
             $counter = 0;
             $options['related_no']=4;
             print '<div id="listing_ajax_container">';
             print'<div class="col-md-12 user_profile_div"> ';
             while ($prop_selection->have_posts()): $prop_selection->the_post(); 
      
                    get_template_part('templates/property_unit'.$property_card_type_string);
         
             endwhile;
             print '</div>';
             print '</div>';
        }else{
            print'<div class="col-md-12 row_dasboard-prop-listing">';
            print '<h4>'.__('You don\'t have any favorite properties yet!','wpestate').'</h4>';
            print'</div>';
        }



      
        ?>    
       
                
                
    </div>
    
 
  
</div>   

<?php get_footer(); ?>