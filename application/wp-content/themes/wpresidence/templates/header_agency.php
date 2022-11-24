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
$link                   =   get_permalink($post->ID);

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
                    <img src="<?php print $preview_img;?>"  alt="agent picture" class="img-responsive"/>
                </a>
                
               
             
            </div>
            
            
            <div class="col-md-8">
                <h1 class="agency_title"><?php echo $name?></h1>
                
                <div class="col-md-6 agency_details">
                    <?php 
                    if($agency_addres!=''){
                        echo '<div class="agency_detail agency_address"><strong>'.__('Adress:','wpestate').'</strong> '.$agency_addres.'</div>';
                    }
                    ?>
                    <?php 
                    if($agency_email!=''){
                        echo '<div class="agency_detail agency_email"><strong>'.__('Email:','wpestate').'</strong> <a href="mailto:'.$agency_email.'">'.$agency_email.'</a></div>';
                    }
                    ?>
                    <?php 
                    if($agency_mobile!=''){
                        echo '<div class="agency_detail agency_mobile"><strong>'.__('Mobile:','wpestate').'</strong> <a href="tel:'.$agency_mobile.'">'.$agency_mobile.'</a></div>';
                    }
                    ?>
                    <?php 
                    if($agency_phone!=''){
                        echo '<div class="agency_detail agency_phone"><strong>'.__('Phone:','wpestate').'</strong> <a href="tel:'.$agency_phone.'">'.$agency_phone.'</a></div>';
                    }
                    ?>

                    <?php 
                    if($agency_skype!=''){
                        echo '<div class="agency_detail agency_skype"><strong>'.__('Skype:','wpestate').'</strong> '.$agency_skype.'</div>';
                    }
                    ?>
                </div>   
                
                <div class="col-md-6 agency_details">
                    <?php 
                    if($agency_website!=''){
                        echo '<div class="agency_detail agency_taxes"><strong>'.__('Website:','wpestate').'</strong> <a href="'.$agency_website.'" target="_blank">'.$agency_website.'</a></div>';
                    }
                    ?>
                    
                    <?php 
                    if($agency_languages!=''){
                        echo '<div class="agency_detail agency_website"><strong>'.__('We Speak:','wpestate').'</strong> '.$agency_languages.'</div>';
                    }
                    ?>

                    <?php 
                    if($agency_opening_hours!=''){
                        echo '<div class="agency_detail agency_opening_hours"><strong>'.__('Opening Hours:','wpestate').'</strong> '.$agency_opening_hours.'</div>';
                    }
                    ?>

                     <?php 
                    if($agency_license!=''){
                        echo '<div class="agency_detail agency_license"><strong>'.__('License:','wpestate').'</strong> '.$agency_license.'</div>';
                    }
                    ?>

                    <?php 
                    if($agency_taxes!=''){
                        echo '<div class="agency_detail agency_taxes"><strong>'.__('Our Taxes:','wpestate').'</strong> '.$agency_taxes.'</div>';
                    }
                    ?>
                </div>
                
                <a href="#agency_contact" class="wpresidence_button agency_contact_but"  ><?php _e('Contact Us','wpestate');?></a>
                
            </div>
            
        
        </div>
    
    </div>
    
</div>