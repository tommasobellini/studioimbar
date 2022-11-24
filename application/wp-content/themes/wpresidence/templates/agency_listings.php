<?php
global $property_unit_slider;
global $no_listins_per_row;
global $wpestate_uset_unit;
global $custom_unit_structure;
global $align_class;
global $prop_unit_class;
global $prop_unit;
$prop_unit                  =   esc_html ( get_option('wp_estate_prop_unit','') );
$prop_unit_class            =   '';
if($prop_unit=='list'){
    $prop_unit_class="ajax12";
    $align_class=   'the_list_view';
}

$user_agency    =   get_post_meta($post->ID,'user_meda_id',true);
$agent_list     =   get_user_meta($user_agency,'current_agent_list',true);
$agent_list[]   =   $user_agency;
$prop_no        =   intval( get_option('wp_estate_prop_no', '') );
$paged = (get_query_var('page')) ? get_query_var('page') : 1;

if(isset($_GET['pagelist'])){
    $paged = intval( $_GET['pagelist'] );
}else{
    $paged = 1;
}

$custom_unit_structure      =   get_option('wpestate_property_unit_structure');
$wpestate_uset_unit         =   intval ( get_option('wpestate_uset_unit','') );
$no_listins_per_row         =   intval( get_option('wp_estate_listings_per_row', '') );
$property_card_type         =   intval(get_option('wp_estate_unit_card_type'));
$property_card_type_string  =   '';
if($property_card_type==0){
    $property_card_type_string='';
}else{
    $property_card_type_string='_type'.$property_card_type;
}


$terms=array();
$selected_term='';


$action_array=array(
            'taxonomy'     => 'property_action_category',
            'field'        => 'slug',
            'terms'        => $selected_term
        );

$args = array(
        'post_type'         =>  'estate_property',
        'author__in'        =>  $agent_list,
        'paged'             =>  $paged,
        'posts_per_page'    =>  $prop_no,
        'post_status'       => 'publish',
        'meta_key'          => 'prop_featured',
        'orderby'           => 'meta_value',
        'order'             => 'DESC',
        );




$prop_selection = new WP_Query($args);
$term_bar='<div class="term_bar_item active_term" data-term_id="0" data-term_name="all">'.__('All','wpestate').' ('.$prop_selection->found_posts.')</div>';


    $key=0;
    while ($prop_selection->have_posts()): $prop_selection->the_post();      
        $property_action_category     =   get_the_terms($post->ID, 'property_action_category') ;
        if( $property_action_category ){
            if(key_exists ($property_action_category[0]->slug,$terms) ){
                $terms[ $property_action_category[0]->slug ][0]=$terms[ $property_action_category[0]->slug ][0]+1;
            }else{
                $terms[ $property_action_category[0]->slug ] = array(1,$property_action_category[0]->name,$property_action_category[0]->term_id);
            }
        }
       
    endwhile;
   
    foreach($terms as $key=>$termen){
        $term_bar.='<div class="term_bar_item " data-term_id="'.$termen[2].'" data-term_name="'. $key.'">'.$termen[1].' ('. $termen[0].')</div>';
    }

    if($prop_selection->have_posts()):
        echo '<div class="mylistings agency_listings_title">';
            echo '<div class="term_bar_wrapper" data-agency_id="'.$user_agency.'" >'.$term_bar.'</div>';
            echo '<div class="spinner" id="listing_loader">
                    <div class="new_prelader"></div>
                </div>
                 <div class="agency_listings_wrapper">';
            while ($prop_selection->have_posts()): $prop_selection->the_post();   
                $property_action_category     =   get_the_terms($post->ID, 'property_action_category') ;
                get_template_part('templates/property_unit'.$property_card_type_string);

            endwhile; 
         kriesi_pagination($prop_selection->max_num_pages, $range = 2);  
        echo '</div></div>';
    endif;



wp_reset_postdata();
wp_reset_query();
