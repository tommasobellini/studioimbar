<?php 
$compare_submit =   get_compare_link();
global $leftcompare;
$left_class='';

if ( isset($leftcompare) && $leftcompare==1 ){
    $left_class="margin_compare";
}

?>
<!--Compare Starts here-->     
<div class="prop-compare <?php echo esc_html($left_class); ?>">
    <div id="compare_close"><i class="fa fa-times" aria-hidden="true"></i></div>
    <form method="post" id="form_compare" action="<?php print esc_url($compare_submit); ?>">
        <h4 class="title_compare"><?php _e('Compare Listings','wpestate')?></h4>
        <button   id="submit_compare" class="wpresidence_button"> <?php _e('Compare','wpestate');?> </button>
    </form>
</div>    
<!--Compare Ends here-->  