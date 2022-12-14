<?php
global $listing_edit;
global $is_edit;
$current_user = wp_get_current_user();
$userID                 =   $current_user->ID;
$user_login             =   $current_user->user_login;
$agent_id               =   get_the_author_meta('user_agent_id',$userID);
$user_custom_picture    =   get_template_directory_uri().'/img/default_user.png';



$agent_first_name       = '';
$agent_last_name        = '';
$agent_skype            = '';
$agent_phone            = '';
$agent_mobile           = '';
$agent_email            = '';
$agent_posit            = '';
$agent_custom_picture   = '';
$agent_facebook         = '';
$agent_twitter          = '';
$agent_linkedin         = '';
$agent_pinterest        = '';
$agent_instagram        = '';
$agent_description      = '';  
$agent_website          = '';
$agent_category_selected= '';
$agent_action_selected  = '';
$agent_city             = '';
$agent_area             = '';
$agent_county           = '';
$agent_member           ='';
        
  
$agent_thumb=get_template_directory_uri().'/img/default_user.png';     
if($listing_edit!=0){
   
    $user_to_edit       =   get_post_meta($listing_edit, 'user_meda_id',true );
    $user_for_agent     =   get_user_by('ID',$user_to_edit);
        
    
    $agent_first_name   =   get_post_meta( $listing_edit, 'first_name', true ) ;
    $agent_last_name    =   get_post_meta( $listing_edit, 'last_name',  true) ;
    $agent_phone        =   get_post_meta($listing_edit, 'agent_phone', true);
    $agent_skype        =   get_post_meta($listing_edit, 'agent_skype', true);
    $agent_posit        =   get_post_meta($listing_edit, 'agent_position', true);
    
    $agent_mobile       =   get_post_meta($listing_edit, 'agent_mobile', true);
    $agent_email        =   get_post_meta($listing_edit, 'agent_email', true);
    $agent_facebook     =   get_post_meta( $listing_edit, 'agent_facebook' , true) ;
    $agent_twitter      =   get_post_meta( $listing_edit, 'agent_twitter' , true) ;
    $agent_linkedin     =   get_post_meta( $listing_edit, 'agent_linkedin' , true) ;
    $agent_pinterest    =   get_post_meta( $listing_edit, 'agent_pinterest' , true) ;
    $agent_instagram    =   get_post_meta( $listing_edit, 'agent_instagram' , true) ;
    $agent_description  =   get_post_field('post_content', $listing_edit);
    $agent_website      =   get_post_meta( $listing_edit, 'agent_website' , true) ;
    $agent_member       =   get_post_meta( $listing_edit, 'agent_member' , true) ;
    
    $agent_category_selected    =   '';
    $agent_category_array       =   get_the_terms($listing_edit, 'property_category_agent');
    if(isset($agent_category_array[0])){
      $agent_category_selected   =   $agent_category_array[0]->term_id;
    }
    
    $agent_action_selected      =   '';
    $agent_action_array         =   get_the_terms($listing_edit, 'property_action_category_agent');
    if(isset($agent_action_array[0])){
        $agent_action_selected   =   $agent_action_array[0]->term_id;
    }

    
    $agent_city='';
    $agent_city_array     =   get_the_terms($listing_edit, 'property_city_agent');
    if(isset($agent_city_array[0])){
        $agent_city         =   $agent_city_array[0]->name;
    }

     $agent_area='';
    $agent_area_array     =   get_the_terms($listing_edit, 'property_area_agent');
    if(isset($agent_area_array[0])){
        $agent_area          =   $agent_area_array[0]->name;
    }

    $agent_county='';
    $agent_county_array     =   get_the_terms($listing_edit, 'property_county_state_agent');
    if(isset($agent_county_array[0])){
        $agent_county          =   $agent_county_array[0]->name;
    }

    $agent_thumb        =  wp_get_attachment_image_src( get_post_thumbnail_id($listing_edit ),'property_listings' );  
    
    if(isset($agent_thumb[0])){
        $agent_thumb=$agent_thumb[0];
    }
 
    if($agent_thumb==''){
        $agent_thumb=get_template_directory_uri().'/img/default_user.png';
    }

    
    
}
?>

 
<div class="col-md-12 user_profile_div"> 
    <div id="profile_message">
        </div> 
<div class="add-estate profile-page profile-onprofile row"> 
    
    <div class="col-md-4 profile_label">
        <div class="user_details_row"><?php _e('Photo','wpestate');?></div> 
        <div class="user_profile_explain"><?php _e('Upload your profile photo.','wpestate')?></div>
    </div>

    <div class="profile_div col-md-4" id="profile-div">
        <?php print '<img id="profile-image" src="'.$agent_thumb.'" alt="user image" data-profileurl="'.$agent_thumb.'" data-smallprofileurl="" >';

        //print '/ '.$user_small_picture;?>

        <div id="upload-container">                 
            <div id="aaiu-upload-container">                 

                <button id="aaiu-uploader" class="wpresidence_button wpresidence_success"><?php _e('Upload  profile image.','wpestate');?></button>
                <div id="aaiu-upload-imagelist">
                    <ul id="aaiu-ul-list" class="aaiu-upload-list"></ul>
                </div>
            </div>  
        </div>
        <span class="upload_explain"><?php _e('*minimum 500px x 500px','wpestate');?></span>                    
    </div>
</div>

<div class="add-estate profile-page profile-onprofile row"> 
    <div class="col-md-4 profile_label">
        <div class="user_details_row"><?php _e('Agent Details','wpestate');?></div> 
        <div class="user_profile_explain"><?php _e('Add your contact information.','wpestate')?></div>

    </div>
    
    <div class="col-md-8">
        <?php if( $is_edit !=1) { ?>
        <p>
            <label for="firstname"><?php _e('Agent Username','wpestate');?></label>
            <input type="text" id="agent_username" class="form-control" value=""  name="agent_username">
        </p>
        <?php
        
        }else{
            echo '<p style="height:44px;">'.__('Username:','wpestate').' '.$user_for_agent->user_login.' '.__('is not editable','wpestate').'</p>';
        } 
        ?>
    </div>
    
    
    
    
    <div class="col-md-4 col-md-push-4">
        <?php if( $is_edit !=1){ ?>
        <p>
            <label for="firstname"><?php _e('Agent Password','wpestate');?></label>
            <input type="text" id="agent_password" class="form-control" value=""  name="agent_password">
        </p>
        <?php } ?>
        
        <p>
            <label for="firstname"><?php _e('First Name','wpestate');?></label>
            <input type="text" id="firstname" class="form-control" value="<?php echo $agent_first_name;?>"  name="firstname">
        </p>

        <p>
            <label for="userphone"><?php _e('Phone', 'wpestate'); ?></label>
            <input type="text" id="userphone" class="form-control" value="<?php echo $agent_phone;?>"  name="userphone">
        </p>
        <p>
            <label for="useremail"><?php _e('Email','wpestate');?></label>
            <input type="text" id="useremail"  class="form-control" value="<?php echo $agent_email;?>"  name="useremail">
        </p>
        
        <p>
            <label for="agent_member"><?php _e('Member of','wpestate');?></label>
            <input type="text" id="agent_member"  class="form-control" value="<?php echo $agent_member;?>"  name="agent_member">
        </p>
    </div>  

    <div class="col-md-4 col-md-push-4">
        <?php if( $is_edit !=1){ ?>
        <p>
            <label for="firstname"><?php _e('Re-type Password','wpestate');?></label>
            <input type="text" id="agent_repassword" class="form-control" value=""  name="agent_repassword">
        </p>
        <?php } ?>
        
        <p>
            <label for="secondname"><?php _e('Last Name','wpestate');?></label>
            <input type="text" id="secondname" class="form-control" value="<?php echo $agent_last_name;?>"  name="firstname">
        </p>
      
        <p>
            <label for="usermobile"><?php _e('Mobile', 'wpestate'); ?></label>
            <input type="text" id="usermobile" class="form-control" value="<?php echo $agent_mobile;?>"  name="usermobile">
        </p>

        <p>
            <label for="userskype"><?php _e('Skype', 'wpestate'); ?></label>
            <input type="text" id="userskype" class="form-control" value="<?php echo $agent_skype;?>"  name="userskype">
        </p>
        <?php   wp_nonce_field( 'profile_ajax_nonce', 'security-profile' );   ?>
       
    </div>
</div>
                             
<div class="add-estate profile-page profile-onprofile row">       
    <div class="col-md-4 profile_label">
        <div class="user_details_row"><?php _e('Agent Details','wpestate');?></div> 
        <div class="user_profile_explain"><?php _e('Add your social media information.','wpestate')?></div>

    </div>
    <div class="col-md-4">
        <p>
            <label for="userfacebook"><?php _e('Facebook Url', 'wpestate'); ?></label>
            <input type="text" id="userfacebook" class="form-control" value="<?php echo $agent_facebook;?>"  name="userfacebook">
        </p>

        <p>
            <label for="usertwitter"><?php _e('Twitter Url', 'wpestate'); ?></label>
            <input type="text" id="usertwitter" class="form-control" value="<?php echo $agent_twitter;?>"  name="usertwitter">
        </p>

        <p>
            <label for="userlinkedin"><?php _e('Linkedin Url', 'wpestate'); ?></label>
            <input type="text" id="userlinkedin" class="form-control"  value="<?php echo $agent_linkedin;?>"  name="userlinkedin">
        </p>
    </div>
    <div class="col-md-4">
        <p>
            <label for="userinstagram"><?php _e('Instagram Url','wpestate');?></label>
            <input type="text" id="userinstagram" class="form-control" value="<?php echo $agent_instagram;?>"  name="userinstagram">
        </p> 

        <p>
            <label for="userpinterest"><?php _e('Pinterest Url','wpestate');?></label>
            <input type="text" id="userpinterest" class="form-control" value="<?php echo $agent_pinterest;?>"  name="userpinterest">
        </p> 

        <p>
            <label for="website"><?php _e('Website Url (without http)','wpestate');?></label>
            <input type="text" id="website" class="form-control" value="<?php echo $agent_website;?>"  name="website">
        </p>
    </div> 
</div>

    
        
<div class="add-estate profile-page profile-onprofile row">
    <div class="col-md-4 profile_label">
        <div class="user_details_row"><?php _e('Agent Area/Categories','wpestate');?></div> 
        <div class="user_profile_explain"><?php _e('What kind of listings do you handle?','wpestate')?></div>
    </div>
    
    <div class="col-md-4 ">
        <p>
            <label for="agent_city"><?php _e('Category','wpestate');?></label>
       
        
        <?php 
    
//           $agent_category_selected='';
//            $agent_category_array            =   get_the_terms($agent_id, 'property_category_agent');
//            if(isset($agent_category_array[0])){
//                $agent_category_selected   =   $agent_category_array[0]->term_id;
//            }
            $args=array(
                'class'       => 'select-submit2',
                'hide_empty'  => false,
                'selected'    => $agent_category_selected,
                'name'        => 'agent_category_submit',
                'id'          => 'agent_category_submit',
                'orderby'     => 'NAME',
                'order'       => 'ASC',
                'show_option_none'   => __('None','wpestate'),
                'taxonomy'    => 'property_category_agent',
                'hierarchical'=> true
            );
            wp_dropdown_categories( $args ); ?>
            
        </p>
    </div>
    
    <div class="col-md-4 ">
          <p>
            <label for="agent_city"><?php _e('Action Category','wpestate');?></label>
           <?php
//            $agent_action_selected='';
//            $agent_action_array            =   get_the_terms($agent_id, 'property_action_category_agent');
//            if(isset($agent_action_array[0])){
//                $agent_action_selected   =   $agent_action_array[0]->term_id;
//            }
            $args=array(
                'class'       => 'select-submit2',
                'hide_empty'  => false,
                'selected'    => $agent_action_selected,
                'name'        => 'agent_action_submit',
                'id'          => 'agent_action_submit',
                'orderby'     => 'NAME',
                'order'       => 'ASC',
                'show_option_none'   => __('None','wpestate'),
                'taxonomy'    => 'property_action_category_agent',
                'hierarchical'=> true
            );
            wp_dropdown_categories( $args ); ?>
           
        </p>
    </div>
    
</div>

        
<div class="add-estate profile-page profile-onprofile row">
    <div class="col-md-4 profile_label">
        <div class="user_details_row"><?php _e('Location','wpestate');?></div> 
        <div class="user_profile_explain"><?php _e('In what area are your properties','wpestate')?></div>
    </div>
    
    <div class="col-md-4">
        <p>
            <label for="agent_city"><?php _e('City','wpestate');?></label>
            <input type="text" id="agent_city" class="form-control" value="<?php echo $agent_city;?>"  name="agent_city">
        </p>
        <p>
            <label for="agent_area"><?php _e('Area','wpestate');?></label>
            <input type="text" id="agent_area" class="form-control" value="<?php echo $agent_area;?>"  name="agent_area">
        </p>
    </div>
    
    <div class="col-md-4">
        <p>
            <label for="agent_county"><?php _e('State/County','wpestate');?></label>
            <input type="text" id="agent_county" class="form-control" value="<?php echo $agent_county;?>"  name="agent_county">
        </p>  
    </div>
</div>
    
<div class="add-estate profile-page profile-onprofile row">
    <div class="col-md-4 profile_label">
        <div class="user_details_row"><?php _e('Agent Details','wpestate');?></div> 
        <div class="user_profile_explain"><?php _e('Add some information about yourself.','wpestate')?></div>
    </div>
    <div class="col-md-8">
         <p>
            <label for="usertitle"><?php _e('Title/Position','wpestate');?></label>
            <input type="text" id="usertitle" class="form-control" value="<?php echo $agent_posit;?>"  name="usertitle">
        </p>

         <p>
            <label for="about_me"><?php _e('About Me','wpestate');?></label>
            <textarea id="about_me" class="form-control" name="about_me"><?php echo $agent_description?></textarea>
        </p>
        <p class="fullp-button">
            <button class="wpresidence_button" id="register_agent">
                <?php 
                if($is_edit!=1){
                    _e('Add New Agent', 'wpestate');
                }else{
                    _e('Edit Agent', 'wpestate'); 
                }
                ?>
            </button>
            

            <input type="hidden" id="is_agent_edit" value="<?php echo $is_edit;?>">
            <input type="hidden" id="user_id"       value="<?php echo $user_to_edit;?>">
            <input type="hidden" id="agent_id"      value="<?php echo $listing_edit;?>">
         
            
        </p>
    </div>
    
            
</div>

</div>