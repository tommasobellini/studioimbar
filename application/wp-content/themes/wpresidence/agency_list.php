<?php
// Template Name: Agency list
// Wp Estate Pack
global $no_listins_per_row;
get_header();
wp_suspend_cache_addition(true);
$options                =   wpestate_page_details($post->ID);
$no_listins_per_row     =   intval( get_option('wp_estate_agent_listings_per_row', '') );

$col_class=4;
if($options['content_class']=='col-md-12'){
    $col_class=3;
}

if($no_listins_per_row==3){
    $col_class  =   '6';
    $col_org    =   6;
    if($options['content_class']=='col-md-12'){
        $col_class  =   '4';
        $col_org    =   4;
    }
}else{   
    $col_class  =   '4';
    $col_org    =   4;
    if($options['content_class']=='col-md-12'){
        $col_class  =   '3';
        $col_org    =   3;
    }
}


?>

<div class="row">
    <?php get_template_part('templates/breadcrumbs'); ?>
    <div class=" <?php print esc_html($options['content_class']);?> ">
        <?php get_template_part('templates/ajax_container'); ?>
        <?php 
        while (have_posts()) : the_post(); 
            if ( esc_html (get_post_meta($post->ID, 'page_show_title', true) ) != 'no') { ?>
            <h1 class="entry-title"><?php the_title(); ?></h1>
            <?php } ?>
            <div class="single-content"><?php the_content();?></div>
            <?php
        endwhile; 
        ?>                 
        
        <div id="listing_ajax_container_agent"> 
        <?php
        $args = array(
                'cache_results'     => false,
                'post_type'         => 'estate_agency',
                'paged'             => $paged,
                'posts_per_page'    => 10 );

        $agent_selection = new WP_Query($args);
        while ($agent_selection->have_posts()): $agent_selection->the_post();
            get_template_part('templates/agency_unit'); 
        endwhile;?> 
        </div>
        <?php kriesi_pagination($agent_selection->max_num_pages, $range = 2); ?>         
       
    </div><!-- end 9col container-->
    
<?php  include(locate_template('sidebar.php')); 
wp_suspend_cache_addition(false);?>
</div>   
<?php get_footer(); ?>