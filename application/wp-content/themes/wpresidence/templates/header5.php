<?php
global $wide_header_class;
global $show_top_bar_user_login; 
global $logo_header_type;
$show_top_bar_user_login    =   esc_html ( get_option('wp_estate_show_top_bar_user_login','') );
$logo                       =   get_option('wp_estate_logo_image','');  
$stikcy_logo_image          =   esc_html( get_option('wp_estate_stikcy_logo_image','') );
?>

<div class="header_5_inside">
    <div class="header5_top_row" data-logo="<?php echo  $logo;?>" data-sticky-logo="<?php echo $stikcy_logo_image; ?>">
        <div class="logo col-md-3" >
            <a href="<?php
                $splash_page_logo_link   =   get_option('wp_estate_splash_page_logo_link','');  
                if( is_page_template( 'splash_page.php' ) && $splash_page_logo_link!='' ){
                    echo $splash_page_logo_link;
                }else{
                    echo home_url('','login');
                }
                echo '">';
                if ( $logo!='' ){
                   print '<img id="logo_image" src="'.$logo.'" class="img-responsive retina_ready" alt="logo"/>';	
                } else {
                   print '<img id="logo_image" class="img-responsive retina_ready" src="'. get_template_directory_uri().'/img/logo.png" alt="logo"/>';
                }
                ?>
            </a>
            
        </div>
        
        <div class="col-md-9 header_5_widget_wrap">
            <?php
            $header5_info_widget1_icon   =   get_option('wp_estate_header5_info_widget1_icon','');
            $header5_info_widget1_text1   =   get_option('wp_estate_header5_info_widget1_text1','');
            $header5_info_widget1_text2   =   get_option('wp_estate_header5_info_widget1_text2','');
            if($header5_info_widget1_icon!='' || $header5_info_widget1_text1!=''){
            ?>
            
            <div class="header_5_widget">
                <div class="header_5_widget_icon">
                    <i class="<?php echo $header5_info_widget1_icon;?>"></i>
                </div>
                
                <div class="header_5_widget_text_wrapper">
                    <div class="header_5_widget_text">
                        <?php echo $header5_info_widget1_text1;?>
                    </div>
                    <div class="header_5_widget_text">
                        <?php echo $header5_info_widget1_text2;?>
                    </div>
                </div>
                
            </div>
            
            <?php } ?>
            
             <?php
            $header5_info_widget2_icon   =   get_option('wp_estate_header5_info_widget2_icon','');
            $header5_info_widget2_text1   =   get_option('wp_estate_header5_info_widget2_text1','');
            $header5_info_widget2_text2   =   get_option('wp_estate_header5_info_widget2_text2','');
            if($header5_info_widget2_icon!='' || $header5_info_widget2_text1!=''){
            ?>
            
            <div class="header_5_widget">
                <div class="header_5_widget_icon">
                    <i class="<?php echo $header5_info_widget2_icon;?>"></i>
                </div>
                
                <div class="header_5_widget_text_wrapper">
                    <div class="header_5_widget_text">
                        <?php echo $header5_info_widget2_text1;?>
                    </div>
                    <div class="header_5_widget_text">
                        <?php echo $header5_info_widget2_text2;?>
                    </div>
                </div>
                
            </div>
            
            <?php } ?>
            
            
            
            <?php
            $header5_info_widget3_icon   =   get_option('wp_estate_header5_info_widget3_icon','');
            $header5_info_widget3_text1   =   get_option('wp_estate_header5_info_widget3_text1','');
            $header5_info_widget3_text2   =   get_option('wp_estate_header5_info_widget3_text2','');
            if($header5_info_widget3_icon!='' || $header5_info_widget3_text1!=''){
            ?>
            
            <div class="header_5_widget">
                <div class="header_5_widget_icon">
                    <i class="<?php echo $header5_info_widget3_icon;?>"></i>
                </div>
                
                <div class="header_5_widget_text_wrapper">
                    <div class="header_5_widget_text">
                        <?php echo $header5_info_widget3_text1;?>
                    </div>
                    <div class="header_5_widget_text">
                        <?php echo $header5_info_widget3_text2;?>
                    </div>
                </div>
                
            </div>
            
            <?php } ?>
            
        </div>    
    </div>    
       
    <div class="header5_bottom_row_wrapper">
        <div class="header5_bottom_row">
               


            <nav id="access">
                <?php 
                    wp_nav_menu( 
                        array(  'theme_location'    => 'primary' ,
                                'walker'            => new wpestate_custom_walker
                            ) 
                    ); 
                ?>
            </nav><!-- #access -->
            
            <?php 
          
            if( $show_top_bar_user_login == "yes"){
                print '<div class="header5_user_wrap">';
                get_template_part('templates/top_user_menu');  
                print '</div>';
                
            }
            ?>
            
        </div>
    </div>

</div>