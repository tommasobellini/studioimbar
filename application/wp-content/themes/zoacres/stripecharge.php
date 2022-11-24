<?php
 
 // Template Name: Stripe Charge Page

// Zoacres Stripe 
try {

	require_once ZOACRES_ADMIN . '/Stripe/init.php';
	
	$zoacres_options = get_option('zoacres_options');
	
	$stripe_secret = isset( $zoacres_options['stirpe-secret-key'] ) ? $zoacres_options['stirpe-secret-key'] : '';
	
	\Stripe\Stripe::setApiKey($stripe_secret);
	
	$token  = ''. $_POST['stripeToken'];
	$email  = ''. $_POST['stripeEmail'];
	$pay_amount  = isset( $_POST['pay_amount'] ) ? $_POST['pay_amount'] : '';
	$pack_id  = isset( $_POST['pack_id'] ) ? $_POST['pack_id'] : '';
	$currency  = isset( $_POST['currency'] ) ? $_POST['currency'] : '';
	
	$customer = \Stripe\Customer::create(array(
		'email' => $email,
		'source'  => $token
	));
	
	$charge = \Stripe\Charge::create(array(
		'customer' => $customer->id,
		'amount'   => $pay_amount,
		'currency' => $currency
	));

	$transaction_id = $charge->id; // transaction id
	$transaction_status = $charge->status; //succeeded
	$transaction_amount = $charge->amount; // transaction amount
	
	$current_user = wp_get_current_user();
	$user_email = $current_user->user_email;
	
	if( $transaction_status == 'succeeded' && $transaction_amount == $pay_amount ){
		
		$zoacres_options = get_option('zoacres_options');
		$pay_by = esc_html__( 'Stripe', 'zoacres' );
		$payer_email = $email;
		$currency = isset( $zoacres_options['package-currencies'] ) ? esc_html( $zoacres_options['package-currencies'] ) : 'USD';
		
		zoacres_update_user_membership( $pack_id, $transaction_id, $currency, $pay_by, $payer_email );
		$grade_stat = zoacres_check_user_membership_grade( $pack_id, $user_email );

		if( !$grade_stat ){
			zoacres_down_user_membership_grade( $pack_id, $user_email );
		}else{
			zoacres_up_user_membership_grade( $pack_id, $user_email );
		}
		
	}
	
	$auth_pages = get_pages(array(
		'meta_key' => '_wp_page_template',
		'meta_value' => 'zoacres-property-new.php'
	));
	if( $auth_pages ){
		$auth_dash_link = get_permalink( $auth_pages[0]->ID );
	}else{
		$auth_dash_link = home_url( '/' );
	} 
	
	wp_redirect( $auth_dash_link ); exit;
	
	// Save user inbox message
}
//catch the errors in any way you like
 
catch(Stripe_CardError $e) {
	echo "Stripe Error";
}
 
 
catch (Stripe_InvalidRequestError $e) {
	echo "Invalid parameters were supplied to Stripe's API";
// Invalid parameters were supplied to Stripe's API
 
} catch (Stripe_AuthenticationError $e) {
	echo "Authentication with Stripe's API failed";
// Authentication with Stripe's API failed
// (maybe you changed API keys recently)
 
} catch (Stripe_ApiConnectionError $e) {
	echo "Network communication with Stripe failed";
// Network communication with Stripe failed
} catch (Stripe_Error $e) {
	echo "Display a very generic error to the user, and maybe send yourself an email";
 
// Display a very generic error to the user, and maybe send
// yourself an email
} catch (Exception $e) {
 	echo "Something else happened, completely unrelated to Stripe";
// Something else happened, completely unrelated to Stripe
}
?>