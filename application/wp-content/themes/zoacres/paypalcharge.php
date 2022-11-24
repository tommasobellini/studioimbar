<?php
 
// Template Name: Paypal Page

$home_link = home_url( '/' );

if ( !is_user_logged_in() ) {
	wp_redirect( $home_link ); exit;
}

$current_user = wp_get_current_user();
$userID = $current_user->ID;
$user_email = $current_user->user_email;

if( isset( $_GET['token'] ) ){

	//Paypal response
	$allowed_html = array();
    $token = esc_html( wp_kses( $_GET['token'], $allowed_html) );
    
	 // get transfer data
    $save_data = get_user_meta( $userID, 'paypal_pack_transfer', true );
    $payment_execute_url = $save_data['paypal_execute'];
    $token = $save_data['paypal_token'];
    $pack_id = $save_data['pack_id'];
	$transaction_date = $save_data['date'];
	$transaction_id = $save_data['transaction_id'];
	$recursive = 0;
	
	if( isset( $save_data['recursive'] ) ){
		$recursive = 1;
	}
	
	//Redirect Final
	$auth_pages = get_pages(array(
		'meta_key' => '_wp_page_template',
		'meta_value' => 'zoacres-property-new.php'
	));
	if( $auth_pages ){
		$auth_dash_link = get_permalink( $auth_pages[0]->ID );
	}else{
		$auth_dash_link = home_url( '/' );
	}

	if( $recursive != 1 ){
		if( isset($_GET['PayerID']) ){
		
			$payerId = esc_html( wp_kses( $_GET['PayerID'], $allowed_html) );  
	
			$payment_execute = array(
				'payer_id' => $payerId
			);
			$json = json_encode($payment_execute);
			$json_resp = zoacres_make_post_call($payment_execute_url, $json,$token);
	
			//empty user meta 
			update_user_meta( $current_user->ID, 'paypal_pack_transfer', "" );
	
			if($json_resp['state']=='approved' ){
	
				$zoacres_options = get_option('zoacres_options');
				$pay_by = esc_html__( 'Paypal', 'zoacres' );
				$payer_email = '';
				$currency = isset( $zoacres_options['package-currencies'] ) ? esc_html( $zoacres_options['package-currencies'] ) : 'USD';
				
				zoacres_update_user_membership( $pack_id, $transaction_id, $currency, $pay_by, $payer_email );
				$grade_stat = zoacres_check_user_membership_grade( $pack_id, $user_email );

				if( !$grade_stat ){
					zoacres_down_user_membership_grade( $pack_id, $user_email );
				}else{
					zoacres_up_user_membership_grade( $pack_id, $user_email );
				}
				
				wp_redirect( $auth_dash_link ); exit;
	
			}
			wp_redirect( $auth_dash_link ); exit;
		} //end if Get PayerID	
	}else{
		//recursive enabled
		$inc_folder = 'inc/';
		require_once $inc_folder.'paypal-recurring.php';
	
		$zoacres_options = get_option('zoacres_options');
		$pack_price                     =   get_post_meta( $pack_id, 'zoacres_package_price', true );
		$billing_time_limit             =   get_post_meta( $pack_id, 'zoacres_package_time_limit', true );
		$billing_period = "Day";
		switch( $billing_time_limit ){
			case "days": 
				$billing_period = "Day";
			break;
			
			case "week": 
				$billing_period = "Week";
			break;
			
			case "month": 
				$billing_period = "Month";
			break;
			
			case "year": 
				$billing_period = "Year";
			break;
		}
		
		$billing_freq                   =   intval( get_post_meta( $pack_id, 'zoacres_package_time_units', true ) );
		$paypal_status                  =   isset( $zoacres_options['paypal-mode'] ) ? esc_html( $zoacres_options['paypal-mode'] ) : 'sandbox';
		$paypal_api_username            = isset( $zoacres_options['paypal-api-username'] ) ? esc_html( $zoacres_options['paypal-api-username'] ) : '';
		$paypal_api_password            = isset( $zoacres_options['paypal-api-password'] ) ? esc_html( $zoacres_options['paypal-api-password'] ) : '';
		$paypal_api_signature           = isset( $zoacres_options['paypal-api-signature'] ) ? esc_html( $zoacres_options['paypal-api-signature'] ) : '';
		$submission_curency_status      =   isset( $zoacres_options['package-currencies'] ) ? esc_html( $zoacres_options['package-currencies'] ) : 'USD';
		$pack_name             			=   get_the_title( $pack_id );
		
		$obj=new Paypal_Recurring;
		$obj->environment       =   $paypal_status;
		$obj->paymentType       =   urlencode('Sale');          // or 'Sale' or 'Order'
		$obj->API_UserName      =   urlencode( $paypal_api_username );
		$obj->API_Password      =   urlencode( $paypal_api_password );
		$obj->API_Signature     =   urlencode( $paypal_api_signature );
		$obj->API_Endpoint      =   "https://api-3t.paypal.com/nvp";
		$obj->paymentType       =   urlencode('Sale');  
		$obj->returnURL         =   urlencode($auth_dash_link);
		$obj->cancelURL         =   urlencode($auth_dash_link);
		$obj->paymentAmount     =   $pack_price;
		$obj->currencyID        =   $submission_curency_status;
		$obj->startDate         =   $transaction_date;
		$obj->billingPeriod     =   urlencode($billing_period);         
		$obj->billingFreq       =   urlencode($billing_freq); 
		$obj->productdesc       =   urlencode($pack_name.__(' package on ','zoacres').get_bloginfo('name') );
		$obj->user_id           =   $current_user->ID;
		$obj->pack_id           =   $pack_id;
		
		if( $obj->getExpressCheckout($token_recursive) ){
			
			$pay_by = esc_html__( 'Paypal', 'zoacres' );
			$payer_email = '';
			$currency = $submission_curency_status;
			$transaction_id = 'PAY' . time();
			
			zoacres_update_user_membership( $pack_id, $transaction_id, $currency, $pay_by, $payer_email );
			$grade_stat = zoacres_check_user_membership_grade( $pack_id, $user_email );
			if( !$grade_stat ){
				zoacres_down_user_membership_grade( $pack_id, $user_email );
			}else{
				zoacres_up_user_membership_grade( $pack_id, $user_email );
			}
			
			wp_redirect( $auth_dash_link ); exit;
		}
	}
	wp_redirect( $auth_dash_link ); exit;
	
}else{

	if ( ! isset( $_POST['paypal_security'] ) || ! wp_verify_nonce( $_POST['paypal_security'], 'paypal_nonce' ) ) {
		wp_redirect( $home_link ); exit;
		exit;
	}else{

		if( $userID === 0 ){
			exit('out');
		}
		
		$allowed_html   =   array();
		$packName       =   esc_html(wp_kses($_POST['pack_name'],$allowed_html));
		$pack_id        =   intval($_POST['pack_id']);
		$is_pack        =   get_posts('post_type=zoacres-package&p='.$pack_id);
		
		if( !empty ( $is_pack ) ) {
		
			$zoacres_options = get_option('zoacres_options');
			$clientId = isset( $zoacres_options['paypal-client-id'] ) ? $zoacres_options['paypal-client-id'] : '';
			if( empty( $clientId ) ) wp_redirect( $home_link );
			
			if( isset( $_POST['paypal_recurring'] ) && $_POST['paypal_recurring'] == 'yes' ){
				//Paypal recurring start
				$inc_folder = 'inc/';
				require_once $inc_folder.'paypal-recurring.php';
				
				$pack_price                     =   get_post_meta( $pack_id, 'zoacres_package_price', true );
				$billing_time_limit             =   get_post_meta( $pack_id, 'zoacres_package_time_limit', true );
				$billing_period = "Day";
				switch( $billing_time_limit ){
					
					case "days": 
						$billing_period = "Day";
					break;
					
					case "week": 
						$billing_period = "Week";
					break;
					
					case "month": 
						$billing_period = "Month";
					break;
					
					case "year": 
						$billing_period = "Year";
					break;

				}
				
				$billing_freq                   =   intval( get_post_meta( $pack_id, 'zoacres_package_time_units', true ) );
				$pack_name                      =   get_the_title( $pack_id );
				$submission_curency_status      =   isset( $zoacres_options['package-currencies'] ) ? esc_html( $zoacres_options['package-currencies'] ) : 'USD';
				$paypal_status                  =   isset( $zoacres_options['paypal-mode'] ) ? esc_html( $zoacres_options['paypal-mode'] ) : 'sandbox';
				$paymentType                    =   "Sale";
				
				$auth_pages = get_pages(array(
					'meta_key' => '_wp_page_template',
					'meta_value' => 'paypalcharge.php'
				));
				
				if( $auth_pages ){
					$dash_profile_link = get_permalink( $auth_pages[0]->ID );
				}else{
					$dash_profile_link = $home_link;
				}
				
				$paypal_api_username            = isset( $zoacres_options['paypal-api-username'] ) ? esc_html( $zoacres_options['paypal-api-username'] ) : '';
				$paypal_api_password            = isset( $zoacres_options['paypal-api-password'] ) ? esc_html( $zoacres_options['paypal-api-password'] ) : '';
				$paypal_api_signature           = isset( $zoacres_options['paypal-api-signature'] ) ? esc_html( $zoacres_options['paypal-api-signature'] ) : '';
				
				$obj=new Paypal_Recurring;
				$obj->environment               =   $paypal_status;
				$obj->paymentType               =   $paymentType;
				$obj->productdesc               =   urlencode($pack_name.__(' package on ','zoacres').get_bloginfo('name') );
				$time                           =   time(); 
				$date                           =   date('Y-m-d H:i:s',$time); 
				$obj->startDate                 =   urlencode($date);
				$obj->billingPeriod             =   urlencode($billing_period);         
				$obj->billingFreq               =   urlencode($billing_freq);                
				$obj->paymentAmount             =   urlencode($pack_price);
				$obj->currencyID                =   urlencode($submission_curency_status);  
				$obj->API_UserName              =   urlencode( $paypal_api_username );
				$obj->API_Password              =   urlencode( $paypal_api_password );
				$obj->API_Signature             =   urlencode( $paypal_api_signature );
				$obj->API_Endpoint              =   "https://api-3t.paypal.com/nvp";
				$obj->returnURL                 =   urlencode($dash_profile_link);
				$obj->cancelURL                 =   urlencode($dash_profile_link); 
				
				$save_data['paypal_execute']     =   '';
				$save_data['paypal_token']       =   '';
				$save_data['pack_id']            =   $pack_id;
				$save_data['recursive']          =   1;
				$save_data['date']               =   $date;
				$save_data['transaction_id']     =   '';
				update_user_meta( $current_user->ID, 'paypal_pack_transfer', $save_data );
				 
				$obj->setExpressCheckout();
				
				//Paypal recurring end				
			}else{
				//Normal paypal pay
				$pack_price = get_post_meta( $pack_id, 'zoacres_package_price', true );
				$currency_code = isset( $zoacres_options['package-currencies'] ) ? esc_html( $zoacres_options['package-currencies'] ) : 'USD';
				$paypal_status = isset( $zoacres_options['paypal-mode'] ) ? $zoacres_options['paypal-mode'] : '';
			  
				$host = 'https://api.sandbox.paypal.com';
				if( $paypal_status == 'live' ){
					$host   =   'https://api.paypal.com';
				}
				
				$url        = $host.'/v1/oauth2/token';
				$postArgs   = 'grant_type=client_credentials';
				$token      = zoacres_get_access_token($url, $postArgs);
				$url        = $host.'/v1/payments/payment';
			
				$auth_pages = get_pages(array(
					'meta_key' => '_wp_page_template',
					'meta_value' => 'paypalcharge.php'
				));
				
				if( $auth_pages ){
					$paypal_dash_link = get_permalink( $auth_pages[0]->ID );
				}else{
					$paypal_dash_link = $home_link;
				}
			
				$payment = array(
					'intent' => 'sale',
					"redirect_urls"=>array(
						"return_url"=>$paypal_dash_link,
						"cancel_url"=>$paypal_dash_link
					),
					'payer' => array("payment_method"=>"paypal"),
				);
				
				$payment['transactions'][0] = array(
					'amount' => array(
						'total' => $pack_price,
						'currency' => $currency_code,
					),
					'description' => $packName.' '. esc_html__('membership payment on ','zoacres') . esc_url( home_url( '/' ) )
				);                  
						
				$json = json_encode($payment);
				$json_resp = zoacres_make_post_call($url, $json, $token);
				foreach ($json_resp['links'] as $link) {
						if($link['rel'] == 'execute'){
								$payment_execute_url = $link['href'];
								$payment_execute_method = $link['method'];
						} else 	if($link['rel'] == 'approval_url'){
										$payment_approval_url = $link['href'];
										$payment_approval_method = $link['method'];
								}
				}
				$transaction_id = $json_resp['id'];
				
				$time                            =   time();
				$date                            =   date('Y-m-d H:i:s',$time); 
				 
				$save_data['paypal_execute']     =   $payment_execute_url;
				$save_data['paypal_token']       =   $token;
				$save_data['pack_id']            =   $pack_id;
				$save_data['date']               =   $date;
				$save_data['transaction_id']	 =   $transaction_id;
				update_user_meta( $current_user->ID, 'paypal_pack_transfer', $save_data );
				wp_redirect( $payment_approval_url ); exit;
				//Normal paypal pay end
			}
			
		}
			
		wp_redirect( $home_link ); // if no options are suit it'll redirect to home url
		die();
	   
	}
	
} // token not set

function zoacres_get_access_token( $url, $postdata ) {
	
	$zoacres_options = get_option('zoacres_options');
	$clientId = isset( $zoacres_options['paypal-client-id'] ) ? $zoacres_options['paypal-client-id'] : '';
    $clientSecret = isset( $zoacres_options['paypal-client-secret'] ) ? $zoacres_options['paypal-client-secret'] : '';
       
	$curl = function_exists('zoacres_curl_init') ? zoacres_curl_init( $url ) : ''; //curl_init($url); 
	curl_setopt($curl, CURLOPT_POST, true); 
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_USERPWD, $clientId . ":" . $clientSecret);
	curl_setopt($curl, CURLOPT_HEADER, false); 
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
	curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata); 
	#curl_setopt($curl, CURLOPT_VERBOSE, TRUE);
	$response = function_exists('zoacres_curl_exec') ? zoacres_curl_exec( $curl ) : ''; //curl_exec( $curl );
	if (empty($response)) {
	    // some kind of an error happened
	    die(curl_error($curl));
	    curl_close($curl); // close cURL handler
	} else {
	    $info = curl_getinfo($curl);
	    curl_close($curl); // close cURL handler
		if($info['http_code'] != 200 && $info['http_code'] != 201 ) {
			echo "Received error: " . $info['http_code']. "\n";
			echo "Raw response:".$response."\n";
			die();
	    }
	}

	// Convert the result from JSON format to a PHP array 
	$jsonResponse = json_decode( $response );
	return $jsonResponse->access_token;
}

function zoacres_make_post_call($url, $postdata,$token) {

	$curl = function_exists('zoacres_curl_init') ? zoacres_curl_init( $url ) : ''; //curl_init($url); 
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array(
				'Authorization: Bearer '.$token,
				'Accept: application/json',
				'Content-Type: application/json'
				));
	
	curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata); 
	#curl_setopt($curl, CURLOPT_VERBOSE, TRUE);
	$response = function_exists('zoacres_curl_exec') ? zoacres_curl_exec( $curl ) : ''; //curl_exec( $curl );
	if (empty($response)) {
	    // some kind of an error happened
	    die(curl_error($curl));
	    curl_close($curl); // close cURL handler
	} else {
	    $info = curl_getinfo($curl);
	    curl_close($curl); // close cURL handler
		if($info['http_code'] != 200 && $info['http_code'] != 201 ) {
			echo "Received error: " . $info['http_code']. "\n";
			echo "Raw response:".$response."\n";
			die();
	    }
	}

	// Convert the result from JSON format to a PHP array 
	$jsonResponse = json_decode($response, TRUE);
	return $jsonResponse;
}

if( !function_exists('zoacres_update_user_recuring_profile') ):
	function zoacres_update_user_recuring_profile( $profile_id,$user_id ){
		  $profile_id=  str_replace('-', 'xxx', $profile_id);
		  $profile_id=  str_replace('%2d', 'xxx', $profile_id);
	  
		  update_user_meta( $user_id, 'profile_id', $profile_id);  
		
	}
endif; // end   wpestate_update_user_recuring_profile  