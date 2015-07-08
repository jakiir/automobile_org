<?php
function inquiry_send(){
        $email_address = $_POST['email_address'];
        if($email_address):
			$your_name = $_POST['your_name'];
			$inquiry_parts = $_POST['inquiry_parts'];
			$product_inquiry = $_POST['product_inquiry'];
			
			$email_to = 'jakir44.du@gmail.com';					 
			$email_subject = "Contact from automobile inquiry";  
			
			function died($error) { 
				// your error code can go here 
				echo "We are very sorry, but there were error(s) found with the form you submitted. "; 
				echo "These errors appear below.<br /><br />";
				 echo $error."<br /><br />"; 
				echo "Please go back and fix these errors.<br /><br />"; 
				die();		
			}   
			// validation expected data exists
		 
			if(!isset($your_name) || !isset($product_inquiry) || !isset($email_address))  
			{ 
				died('We are sorry, but there appears to be a problem with the form you submitted.');    
			}
		 
			$first_name = $your_name; // required    
			$email_from = $email_address; // required 
			$inquiry_parts = $inquiry_parts; // not required 
			$comments = $product_inquiry; // required     
		 
			$error_message = "";
		 
			$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
		 
		  if(!preg_match($email_exp,$email_from)) {
		 
			$error_message .= 'The Email Address you entered does not appear to be valid.<br />';
		 
		  }		 
		  
		  $string_exp = "/^[A-Za-z .'-]+$/";		 
		  if(!preg_match($string_exp,$your_name)) { 
			$error_message .= 'The First Name you entered does not appear to be valid.<br />'; 
		  } 		  
		 
		  if(strlen($comments) < 2) {		 
			$error_message .= 'The Comments you entered do not appear to be valid.<br />';		 
		  }
		 
		  if(strlen($error_message) > 0) {
		 
			died($error_message);
		 
		  }
		 
			$email_message = "Form details below.\n\n";     
		 
			function clean_string($string) {
		 
			  $bad = array("content-type","bcc:","to:","cc:","href");
		 
			  return str_replace($bad,"",$string);
		 
			}     
		 
			$email_message .= "<p>Name: ".clean_string($your_name)."</p>"; 
			$email_message .= "<p>Email: ".clean_string($email_from)."</p>"; 
			$email_message .= "<p>Inquiry parts: ".clean_string($inquiry_parts)."</p>"; 
			$email_message .= "<p>Comments: ".clean_string($comments)."</p>";
		 
		// create email headers

		$headers		= 'MIME-Version: 1.0' . "\r\n";
		$headers	   .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers	   .= 'From: "'.$your_name.'"' . "\r\n";
		$headers	   .= 'Reply-To: '.$email_from. "\r\n";	


		$mail_send = wp_mail($email_to, $email_subject, $email_message, $headers);  
		 if($mail_send){
			 $results = array(
				'success' => true,
				'mess' => 'Email successfully sent.'
			 );
		 } else {
			 $results = array(
				'success' => false,
				'mess' => 'Email not send, there are some error to send email.'
			 );
		 }			
		echo json_encode($results);
        endif;
  die();
  }
add_action( 'wp_ajax_nopriv_inquiry_send','inquiry_send' );
add_action( 'wp_ajax_inquiry_send','inquiry_send' );

function autoMobileUpdateCart(){
	$itemId = $_POST['itemId'];
        if($itemId):
        $itemSku = $_POST['itemSku'];
        $quantity = $_POST['quantity'];
        $itemPrice = $_POST['itemPrice'];
        @session_start();
        $sessionId = session_id();
		
		if($quantity == '' || $quantity == 0){
			$results = array(
				'success' => false,
				'mess' => 'Product quantity is null.'
			 );
		} else {       
	   $auto_mobile_info = '_auto_mobile_info_'.$sessionId;
        if ( get_option( $auto_mobile_info ) !== false ) {

            $get_mobile_info = get_option( $auto_mobile_info );
            $get_mobile_info_uns = unserialize($get_mobile_info);
            $singleArray = array();
            foreach ($get_mobile_info_uns as $key => $value){
                $singleArray[$key] = $value['item_id'];
            }

                if (in_array($itemId, $singleArray)) {

                foreach ($get_mobile_info_uns as $key => $get_mobile_info_unss){
                    if($get_mobile_info_unss['item_id'] === $itemId){
                        $itemQuantity = $quantity;
                        $item_price = $itemPrice;
                        $itemInfo = array(
                            $key => array(
                                        'item_id'           => $get_mobile_info_unss['item_id'],
                                        'item_sku'          => $itemSku,
                                        'item_quantity'     => $itemQuantity,
                                        'item_price'        => $item_price
                                    )
                        );
                        $itemInfoResult = array_merge($get_mobile_info_uns, $itemInfo );
                        $item_inform = serialize($itemInfoResult);
                        update_option( $auto_mobile_info, $item_inform );

							if ( is_user_logged_in() ) {
								$user_ID = get_current_user_id();
								update_user_meta( $user_ID, 'auto_mobile_shopping_cart', $item_inform );
							}

						}
					}
				}
			}
			
			$results = array(
				'success' => true,
				'mess' => 'Update successfully.'
			 );
		}
	endif;
	echo json_encode($results);
	die();
}
add_action( 'wp_ajax_nopriv_autoMobileUpdateCart','autoMobileUpdateCart' );
add_action( 'wp_ajax_autoMobileUpdateCart','autoMobileUpdateCart' );

function autoMobileAddToCart(){
        $itemId = $_POST['itemId'];
        if($itemId):
        $itemSku = $_POST['itemSku'];
		$addtocartType = $_POST['addtocartType'];
        $quantity = $_POST['quantity'];
        $itemPrice = $_POST['itemPrice'];
        @session_start();
        $sessionId = session_id();

        $autoMobielSession = '_auto_mobile_session_'.$sessionId;
        if ( get_option( $autoMobielSession ) !== false ) {
            update_option( $autoMobielSession, $sessionId );
        } else {
            add_option( $autoMobielSession, $sessionId, '', 'yes' );
        }


        $item_info = array(
            'item_1' 	=> array(
                        'item_id'           => $itemId,
                        'item_sku'          => $itemSku,
                        'item_quantity'     => $quantity,
                        'item_price'        => $itemPrice
                    )
        );
        $item_information = serialize($item_info);

        $auto_mobile_info = '_auto_mobile_info_'.$sessionId;
        if ( get_option( $auto_mobile_info ) !== false ) {

            $get_mobile_info = get_option( $auto_mobile_info );
            $get_mobile_info_uns = unserialize($get_mobile_info);
            $singleArray = array();
            foreach ($get_mobile_info_uns as $key => $value){
                $singleArray[$key] = $value['item_id'];
            }


                if (in_array($itemId, $singleArray)) {

                foreach ($get_mobile_info_uns as $key => $get_mobile_info_unss){
                    if($get_mobile_info_unss['item_id'] === $itemId){
                      if($addtocartType === 'oneby'):
						$itemQuantity = $get_mobile_info_unss['item_quantity']+1;
                        $item_price = $get_mobile_info_unss['item_price']+ $itemPrice;
					  else :
						$itemQuantity = $quantity;
                        $item_price = $itemPrice;
					  endif;
					  
                        $itemInfo = array(
                            $key => array(
                                        'item_id'           => $get_mobile_info_unss['item_id'],
                                        'item_sku'          => $itemSku,
                                        'item_quantity'     => $itemQuantity,
                                        'item_price'        => $item_price
                                    )
                        );
                        $itemInfoResult = array_merge($get_mobile_info_uns, $itemInfo );
                        $item_inform = serialize($itemInfoResult);
                        update_option( $auto_mobile_info, $item_inform );

                        if ( is_user_logged_in() ) {
                            $user_ID = get_current_user_id();
                            update_user_meta( $user_ID, 'auto_mobile_shopping_cart', $item_inform );
                        }

                    }
                }

                } else {
                    $lastKey = substr(end(array_keys($get_mobile_info_uns)), -1);
                    $incrLast = intval($lastKey) + 1;
                    $item_info2 = array(
                        'item_'.$incrLast => array(
                                    'item_id'           => $itemId,
                                    'item_sku'          => $itemSku,
                                    'item_quantity'     => $quantity,
                                    'item_price'        => $itemPrice
                                )
                    );

                    $itemInfo_result = array_merge($get_mobile_info_uns, $item_info2 );
                    $item_inform2 = serialize($itemInfo_result);
                    update_option( $auto_mobile_info, $item_inform2 );

                    if ( is_user_logged_in() ) {
                        $user_ID = get_current_user_id();
                        update_user_meta( $user_ID, 'auto_mobile_shopping_cart', $item_inform2 );
                    }

                }

        } else {
            add_option( $auto_mobile_info, $item_information, '', 'yes' );

            if ( is_user_logged_in() ) {
                $user_ID = get_current_user_id();
                update_user_meta( $user_ID, 'auto_mobile_shopping_cart', $item_information );
            }

        }
		
		
        $get_mobile_info = get_option( $auto_mobile_info );
        $get_mobile_info_uns = @unserialize($get_mobile_info);
        if($get_mobile_info_uns){
            foreach($get_mobile_info_uns as $key=>$get_mobile_info_unss):
                $item_quantity_db = $get_mobile_info_unss['item_quantity'];
                $item_price = $get_mobile_info_unss['item_price'];
                
					$quantity_db += $item_quantity_db;
					$totalPrice += $item_price;
				
            endforeach;
		}
		$result = array(
			'success' => true,
			'quantity' => $quantity_db,
			'totalPrice' => $totalPrice				
		);  
		
		else :	
		
		$result = array(
                'success' => false,
				'quantity' => '',
				'totalPrice' => ''				
            );

        endif;

		echo json_encode($result);

  die();
  }
add_action( 'wp_ajax_nopriv_autoMobileAddToCart','autoMobileAddToCart' );
add_action( 'wp_ajax_autoMobileAddToCart','autoMobileAddToCart' );


function autoMobileRemoveCart(){
        $itemId = $_POST['itemId'];
        if($itemId):
        $item_key = $_POST['item_key'];
        @session_start();
        $sessionId = session_id();

        $auto_mobile_info = '_auto_mobile_info_'.$sessionId;

            $get_mobile_info = get_option( $auto_mobile_info );
            $get_mobile_info_uns = unserialize($get_mobile_info);

            unset($get_mobile_info_uns[$item_key]);

            //print_r($get_mobile_info_uns);
            $item_inform2 = serialize($get_mobile_info_uns);
            update_option( $auto_mobile_info, $item_inform2 );

            if ( is_user_logged_in() ) {
                $user_ID = get_current_user_id();
                update_user_meta( $user_ID, 'auto_mobile_shopping_cart', $item_inform2 );
            }

        endif;
  die();
  }
add_action( 'wp_ajax_nopriv_autoMobileRemoveCart','autoMobileRemoveCart' );
add_action( 'wp_ajax_autoMobileRemoveCart','autoMobileRemoveCart' );


function user_login_form(){

    
    check_ajax_referer( 'ajax-login-nonce', 'security' );

    
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = true;

    $user_signon = wp_signon( $info, false );
    if ( is_wp_error($user_signon) ){
        echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.')));
    } else {
        echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful, redirecting...')));
    }	
    die();
}
add_action( 'wp_ajax_nopriv_user_login_form','user_login_form' );
add_action( 'wp_ajax_user_login_form','user_login_form' );

function user_regi_form(){

	$firstname				= $_POST['first_name'];
	$lastname				= $_POST['last_name'];
	$fullName				= $firstname.' '.$lastname;
	$user_name				= $_POST['user_name'];		
	$user_email				= $_POST['user_email'];
	$password				= $_POST['password'];
	$password_confirmation	= $_POST['password_confirmation'];
	$t_and_c				= $_POST['t_and_c'];
	$regInfo				= $_POST['regInfo'];
	$regStatus				= $_POST['regStatus'];
	
	$user_exist = username_exists( $user_name );
	$email_exist = email_exists( $user_email );
	if($user_exist):
		$result = array(
			'success' => false,
			'message'=>__($user_name.'already exist!')			
		);
	elseif($email_exist):
		$result = array(
			'success' => false,
			'message'=>__($user_email.'already exist!')			
		);
	else :
		$memberData = array(
							'user_login' => $user_name,
							'first_name' => $firstname,
							'last_name' => $lastname,
							'user_pass' => $password,
							'user_email' => $user_email,
							'user_url' => '',
							'role' => 'atm_customer'
						);
		$createUser = wp_insert_user( $memberData );
			
		$result = array(
			'success' => true,
			'message'=>__($user_email.'already exist!')			
		);
		
	$info = array();
    $info['user_login'] = $user_name;
    $info['user_password'] = $password;
    $info['remember'] = true;
    $user_signon = wp_signon( $info, false );		
	endif;

    echo json_encode($result);
    	
    die();
}
add_action( 'wp_ajax_nopriv_user_regi_form','user_regi_form' );
add_action( 'wp_ajax_user_regi_form','user_regi_form' );


function autoMobileMakeNModel(){
        $automobile_year = $_POST['automobile_year'];
		global $wpdb;
        if($automobile_year):			
			$results = $wpdb->get_results( "select post_id, meta_key from $wpdb->postmeta where meta_value = '$automobile_year'", ARRAY_A );
			$automobile_make = array();
			$automobile_make_val = array();
			$automobile_model = array();
			$automobile_model_val = array();
			foreach($results as $result):
				$postId = $result['post_id'];
				$automobile_make[] = get_post_meta( $postId, 'advanced_automobile_make', true );
				
				$txt_automobile_make = get_post_meta( $postId, 'advanced_automobile_make', true );
				$auto_mobile_make = '_auto_mobile_make';
				$get_auto_mobile_make = get_option( $auto_mobile_make );
				$get_auto_mobile_make_uns = @unserialize($get_auto_mobile_make);
				$automobile_make_val[] = $get_auto_mobile_make_uns[$txt_automobile_make];
				
				
				$automobile_model[] = get_post_meta( $postId, 'advanced_automobile_model', true );
				
				$txt_automobile_model = get_post_meta( $postId, 'advanced_automobile_model', true );
				$auto_mobile_model = '_auto_mobile_model';
				$get_auto_mobile_model = get_option( $auto_mobile_model );
				$get_auto_mobile_model_uns = @unserialize($get_auto_mobile_model);
				$automobile_model_val[] =  $get_auto_mobile_model_uns[$txt_automobile_model];
			endforeach;
			$automobile_make = array_unique($automobile_make);
			$automobile_make_val = array_unique($automobile_make_val);
			$automobile_model = array_unique($automobile_model);
			$automobile_model_val = array_unique($automobile_model_val);
			$result = array(
                'success' => true,
				'make' => $automobile_make,
				'make_val' => $automobile_make_val,
				'model' => $automobile_model,
				'model_val' => $automobile_model_val
            );
		else :
            $result = array(
                'success' => false,
				'make' => '',
				'make_val' => '',
				'model' => '',
				'model_val' => ''
            );
        endif;
		
		echo json_encode($result);	
		
  die();
  }
add_action( 'wp_ajax_nopriv_autoMobileMakeNModel','autoMobileMakeNModel' );
add_action( 'wp_ajax_autoMobileMakeNModel','autoMobileMakeNModel' );


/*function get_country_state(){
        $country = $_POST['country'];
        if($country):
        global $autoMobile;
        $statesPath = $autoMobile->statesPath;
        if (!file_exists($statesPath . $country . '.php')) {
            $result = array(
                'success' => false
            );
            echo json_encode($result);
        } else {
            require_once( $statesPath . $country . '.php' );
            $states['success'] = true;
            echo json_encode($states);
        }
        endif;
  die();
  }
add_action( 'wp_ajax_nopriv_get_country_state','get_country_state' );
add_action( 'wp_ajax_get_country_state','get_country_state' );*/


/*function get_country_state_by_country($country = '', $checkout_town_city = ''){        
        if($country):
        global $autoMobile;
		//$output = array();
        $statesPath = $autoMobile->statesPath;
        if (!file_exists($statesPath . $country . '.php')) {
            return $output = null;
        } else {
            require_once( $statesPath . $country . '.php' );
            return $output =  $states[$country][$checkout_town_city];            
        }
        endif;		
}*/

function add_customer_info(){
		$checkout_first_name = $_POST['checkout_first_name'];
        $checkout_last_name = $_POST['checkout_last_name'];
		$display_name = $checkout_first_name.' '.$checkout_last_name;
        $checkout_email = $_POST['checkout_email'];
        $checkout_password = $_POST['checkout_password']; 
        $checkout_address = $_POST['checkout_address'];        
        $selectCountry = $_POST['selectCountry'];
        $checkout_postcode = $_POST['checkout_postcode'];
        $checkout_town_city = $_POST['checkout_town_city'];
		$checkout_state = $_POST['checkout_state'];
        $checkout_notes = $_POST['checkout_notes'];
		$subTotalPrice = $_POST['subTotalPrice'];
		$productTotalPrice = $_POST['productTotalPrice'];
		$productTotalItem = $_POST['productTotalItem'];
		
		$product_info['product_ids'] = $_POST['product_ids'];
		$product_info['product_names'] = $_POST['product_names'];
		$product_info['product_item_prices'] = $_POST['product_item_prices'];
		$product_info['product_total_price'] = $_POST['product_total_price'];
		$product_info['product_quantity'] = $_POST['product_quantity'];
		$product_info['product_shipping'] = $_POST['product_shipping'];		
		$product_information = serialize($product_info);
				
        $registrationId = $_POST['registrationId'];
        date_default_timezone_set("GMT");
        $date = date("F j, Y, g:i a");
        $post_title = 'atm_order-' . $date;
        $now_time = time();
        $post_pwd = 'atm_order_'.$now_time;
    //global $wpdb; 	
        if ( 'POST' == $_SERVER['REQUEST_METHOD'] && isset($registrationId) && isset($checkout_email) && isset($checkout_password)) :

        $username = username_exists( $checkout_email );
        $userEmail = email_exists( $checkout_email );
            if ( !is_user_logged_in() ) {
        if($username){
            $result = array(
                'success' => false,
                'mess'    => 'Email address already exist!'
            );
        }
        elseif($userEmail){
            $result = array(
                'success' => false,
                'mess'    => 'Email address already exist!'
            );
        } else {
                $customerData = array(
                    'user_login' => $checkout_email,
                    'display_name' => $display_name,
                    'first_name' => $checkout_first_name,
                    'last_name' => $checkout_last_name,
                    'user_pass' => $checkout_password,
                    'user_email' => $checkout_email,
                    'user_url' => '',
                    'role' => 'atm_customer'
                );
                $createUser = wp_insert_user($customerData);
                if ($createUser) {
                    add_user_meta($createUser, 'checkout_address', $checkout_address, true);
                    add_user_meta($createUser, 'checkout_phone', $checkout_phone, true);
                    add_user_meta($createUser, 'checkout_company_name', $checkout_company_name, true);
                    add_user_meta($createUser, 'selectCountry', $selectCountry, true);
                    add_user_meta($createUser, 'checkout_postcode', $checkout_postcode, true);
                    add_user_meta($createUser, 'checkout_town_city', $checkout_town_city, true);
					add_user_meta($createUser, 'checkout_state', $checkout_state, true);					
                    add_user_meta($createUser, 'checkout_notes', $checkout_notes, true);				
					

                    $the_order_post = get_page_by_title($post_title);
                    if (!$the_order_post) {
                        // Create order post object
                        $post = array(
                            'post_title' => $post_title,
                            'post_content' => '',
                            'post_status' => 'publish',
                            'post_type' => 'automobile_order',
                            'post_author' => $createUser,
                            'ping_status' => 'closed',
                            'post_parent' => 0,
                            'menu_order' => 0,
                            'to_ping' => '',
                            'pinged' => '',
                            'post_password' => $post_pwd,
                            'guid' => '',
                            'post_content_filtered' => '',
                            'post_excerpt' => '',
                            'import_id' => 0
                        );
                        // Insert the automobile order post into the database					
						
                        $orderId = wp_insert_post($post);
						add_post_meta( $orderId, 'product_information', $product_information, true );
						add_post_meta( $orderId, 'subTotalPrice', $subTotalPrice, true );
						add_post_meta( $orderId, 'productTotalPrice', $productTotalPrice, true );
						add_post_meta( $orderId, 'productTotalItem', $productTotalItem, true );
						add_post_meta( $orderId, 'customerId', $createUser, true );
						$orderStatus = array(
							'name' => 'on-hold',
							'title' => 'On Hold'
						);
						$orderStatuSer = serialize($orderStatus);
						add_post_meta( $orderId, 'order_status', $orderStatuSer, true );
                    }

                }
				
			$qty_po = 0;
			foreach($_POST['product_ids'] as $product_id):
				//echo $product_id;
				//echo $_POST['product_quantity'][$qty_po];
				$qty_product = get_post_meta($product_id, 'txt_automobile_qty', true) - $_POST['product_quantity'][$qty_po];
				update_post_meta($product_id, 'txt_automobile_qty', $qty_product);
				$qty_po++;
			endforeach;			
			
            $result = array(
				'success' => true,
				'mess'    => 'ok',
				'post_id' => $orderId
			);
			
        }
            } else {
                $user_ID = get_current_user_id();
                $updateData = '';
                if($checkout_password == ''){
                    $updateData = array(
                        'ID' => $user_ID,
                        'user_email' => $checkout_email,
                        'display_name' => $display_name,
                        'first_name' => $checkout_first_name,
                        'last_name' => $checkout_last_name
                    );
                }
                if($checkout_password != ''){
                    $updateData = array(
                        'ID' => $user_ID,
                        'user_pass' => $checkout_password,
                        'user_email' => $checkout_email,
                        'display_name' => $display_name,
                        'first_name' => $checkout_first_name,
                        'last_name' => $checkout_last_name
                    );
                }
                wp_update_user( $updateData );

                update_user_meta($user_ID, 'checkout_address', $checkout_address);
                update_user_meta($user_ID, 'checkout_phone', $checkout_phone);
                update_user_meta($user_ID, 'checkout_company_name', $checkout_company_name);
                update_user_meta($user_ID, 'selectCountry', $selectCountry);
                update_user_meta($user_ID, 'checkout_postcode', $checkout_postcode);
                update_user_meta($user_ID, 'checkout_town_city', $checkout_town_city);
				update_user_meta($user_ID, 'checkout_state', $checkout_state);				
                update_user_meta($user_ID, 'checkout_notes', $checkout_notes);

                $the_order_post = get_page_by_title($post_title);
                $orderId = '';
                if (!$the_order_post) {
                    // Create order post object
                    $post = array(
                        'post_title' => $post_title,
                        'post_content' => '',
                        'post_status' => 'publish',
                        'post_type' => 'automobile_order',
                        'post_author' => $user_ID,
                        'ping_status' => 'closed',
                        'post_parent' => 0,
                        'menu_order' => 0,
                        'to_ping' => '',
                        'pinged' => '',
                        'post_password' => $post_pwd,
                        'guid' => '',
                        'post_content_filtered' => '',
                        'post_excerpt' => '',
                        'import_id' => 0
                    );
                    // Insert the automobile order post into the database
                    $orderId = wp_insert_post($post);
					add_post_meta( $orderId, 'product_information', $product_information, true );
					add_post_meta( $orderId, 'subTotalPrice', $subTotalPrice, true );
					add_post_meta( $orderId, 'productTotalPrice', $productTotalPrice, true );
					add_post_meta( $orderId, 'productTotalItem', $productTotalItem, true );
					add_post_meta( $orderId, 'customerId', $user_ID, true );
					$orderStatus = array(
							'name' => 'on-hold',
							'title' => 'On Hold'
						);
					$orderStatuSer = serialize($orderStatus);
					add_post_meta( $orderId, 'order_status', $orderStatuSer, true );
					
                }
				
			$qty_po = 0;
			foreach($_POST['product_ids'] as $product_id):
				//echo $product_id;
				//echo $_POST['product_quantity'][$qty_po];
				$qty_product = get_post_meta($product_id, 'txt_automobile_qty', true) - $_POST['product_quantity'][$qty_po];
				update_post_meta($product_id, 'txt_automobile_qty', $qty_product);
				$qty_po++;
			endforeach;

                $result = array(
                    'success' => true,
                    'mess'    => 'ok',
                    'post_id' => $orderId
                );
            }

        else :
            $result = array(
                'success' => false,
                'mess'    => 'Error found',
				'post_id' => ''
        );
        endif;
        echo json_encode($result);
  die();
  }
add_action( 'wp_ajax_nopriv_add_customer_info','add_customer_info' );
add_action( 'wp_ajax_add_customer_info','add_customer_info' );




function automobile_columns( $columns ) {
    $columns['automobile_make'] = 'Make';
    $columns['automobile_model'] = 'Model';
    $columns['automobile_categories'] = 'Categories';
    unset( $columns['comments'] );
    return $columns;
}


add_action( 'manage_posts_custom_column', 'automobile_populate_columns' );
function automobile_populate_columns( $column ) {
    global $post;
    $txt_automobile_model = '';
    $txt_automobile_make = '';
    $get_advanced_automobile_array = get_post_meta($post->ID, 'advanced_automobile', true);
    $get_advanced_automobile = @unserialize($get_advanced_automobile_array);
    if ( 'automobile_make' == $column ) {
        if ( isset ( $get_advanced_automobile['txt_automobile_make'] ) )
        $txt_automobile_make = $get_advanced_automobile['txt_automobile_make'];
        $auto_mobile_make = '_auto_mobile_make';
        $get_auto_mobile_make = get_option( $auto_mobile_make );
        $get_auto_mobile_make_uns = @unserialize($get_auto_mobile_make);
        echo $get_auto_mobile_make_uns[$txt_automobile_make];
    }
    elseif ( 'automobile_model' == $column ) {
        if ( isset ( $get_advanced_automobile['txt_automobile_model'] ) )
        $txt_automobile_model = $get_advanced_automobile['txt_automobile_model'];
        $auto_mobile_model = '_auto_mobile_model';
        $get_auto_mobile_model = get_option( $auto_mobile_model );
        $get_auto_mobile_model_uns = @unserialize($get_auto_mobile_model);
        echo $get_auto_mobile_model_uns[$txt_automobile_model];
    }
    elseif ( 'automobile_categories' == $column ) {
        $product_categories = wp_get_post_terms($post->ID, 'automobile_product_category', array("fields" => "all"));
        //print_r($product_categories);
        if($product_categories):
            $result_str = array();
        foreach($product_categories as $product_category):
            $result_str[] = '<a href="edit.php?post_status=all&post_type=tlp_automobile&automobile_product_category='.$product_category->term_taxonomy_id.'">'.$product_category->name.'</a>';
        endforeach;
        $result = implode(",<br>",$result_str);
        echo $result;
        endif;
    }
}

add_filter( 'manage_edit-tlp_automobile_sortable_columns', 'sort_automobile' );

function sort_automobile( $columns ) {
    $columns['automobile_make'] = 'automobile_make';
    $columns['automobile_model'] = 'automobile_model';
    $columns['automobile_categories'] = 'automobile_categories';
    return $columns;
}

//add_filter( 'request', 'column_ordering' );

add_filter( 'request', 'automobile_column_orderby' );

function automobile_column_orderby ( $vars ) {
    if ( !is_admin() )
        return $vars;
    if ( isset( $vars['orderby'] ) && 'automobile_make' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array( 'meta_key' => 'txt_automobile_make', 'orderby' => 'meta_value' ) );
    }
    elseif ( isset( $vars['orderby'] ) && 'automobile_model' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array( 'meta_key' => 'txt_automobile_model', 'orderby' => 'meta_value' ) );
    }
    elseif ( isset( $vars['orderby'] ) && 'automobile_categories' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array( 'meta_key' => 'txt_automobile_categories', 'orderby' => 'meta_value' ) );
    }
    return $vars;
}




// CREATE FILTERS WITH CUSTOM TAXONOMIES

add_action( 'restrict_manage_posts', 'automobile_filter_list' );
function automobile_filter_list() {
    $screen = get_current_screen();
    global $wp_query;
    if ( $screen->post_type == 'tlp_automobile' ) {
        wp_dropdown_categories( array(
            'show_option_all' => 'Show All Category',
            'taxonomy' => 'automobile_product_category',
            'name' => 'automobile_product_category',
            'orderby' => 'name',
            'selected' => ( isset( $wp_query->query['automobile_product_category'] ) ? $wp_query->query['automobile_product_category'] : '' ),
            'hierarchical' => false,
            'depth' => 3,
            'show_count' => false,
            'hide_empty' => true,
        ) );
    }
}

add_action( 'restrict_manage_posts', 'automobile_filter_automobile_make' );
function automobile_filter_automobile_make() {
    $screen = get_current_screen();
    //global $wp_query;
    if ( $screen->post_type == 'tlp_automobile' ) {
        $auto_mobile_make = '_auto_mobile_make';
        $get_auto_mobile_make = get_option( $auto_mobile_make );
        $get_auto_mobile_make_uns = @unserialize($get_auto_mobile_make);
        echo '<select name="txt_automobile_make" id="txt_automobile_make"><option value="">Show All Make</option>';         if($get_auto_mobile_make_uns) {
            foreach ($get_auto_mobile_make_uns as $key=>$get_auto_mobile_make_unss): ?>
                <option value="<?php echo $key; ?>" <?php if ( isset ( $_GET['txt_automobile_make'] ) ) selected( $_GET['txt_automobile_make'], $key ); ?>><?php _e( $get_auto_mobile_make_unss, 'automobile_plugin' )?></option>';         <?php  endforeach;
        }
        echo '</select>';
    }
}

add_action( 'restrict_manage_posts', 'automobile_filter_automobile_model' );
function automobile_filter_automobile_model() {
    $screen = get_current_screen();
    //global $wp_query;
    if ( $screen->post_type == 'tlp_automobile' ) {
        $auto_mobile_model = '_auto_mobile_model';
            $get_auto_mobile_model = get_option( $auto_mobile_model );
            $get_auto_mobile_model_uns = @unserialize($get_auto_mobile_model);
        echo '<select name="txt_automobile_model" id="txt_automobile_model"><option value="">Show All Model</option>';
            if($get_auto_mobile_model_uns) {
                foreach ($get_auto_mobile_model_uns as $key=>$get_auto_mobile_model_unss): ?>
                    <option value="<?php echo $key; ?>" <?php if ( isset ( $_GET['txt_automobile_model'] ) ) selected( $_GET['txt_automobile_model'], $key ); ?>><?php _e( $get_auto_mobile_model_unss, 'automobile_plugin' )?></option>';
                <?php  endforeach;
            }
        echo '</select>';
    }
}


add_filter( 'parse_query','automobile_perform_filtering' );

function automobile_perform_filtering( $query ) {
    $qv = &$query->query_vars;
    global $pagenow;
    if ( ( $qv['automobile_product_category'] ) && is_numeric( $qv['automobile_product_category'] ) ) {
        $term = get_term_by( 'id', $qv['automobile_product_category'], 'automobile_product_category' );
        $qv['automobile_product_category'] = $term->slug;
    }

    if ( is_admin() && $pagenow=='edit.php' && isset($_GET['txt_automobile_make']) && $_GET['txt_automobile_make'] != '' && $_GET['txt_automobile_model'] == '') {
        $qv['meta_key'] = 'advanced_automobile_make';
    if (isset($_GET['txt_automobile_make']) && $_GET['txt_automobile_make'] != '')
        $qv['meta_value'] = $_GET['txt_automobile_make'];
    }

    if ( is_admin() && $pagenow=='edit.php' && isset($_GET['txt_automobile_model']) && $_GET['txt_automobile_model'] != '' && $_GET['txt_automobile_make'] == '') {
        $qv['meta_key'] = 'advanced_automobile_model';
    if (isset($_GET['txt_automobile_model']) && $_GET['txt_automobile_model'] != '')
        $qv['meta_value'] = $_GET['txt_automobile_model'];
    }

    if ( is_admin() && $pagenow=='edit.php' && isset($_GET['txt_automobile_model']) && isset($_GET['txt_automobile_make']) && $_GET['txt_automobile_model'] != '' && $_GET['txt_automobile_make'] != '') {

        $qv['meta_query'] = array(
            'relation' => 'AND',
            array(
                'key' => 'advanced_automobile_make',
                'value' => $_GET['txt_automobile_make'],
                'compare' => '='
            ),

            array(
                'key' => 'advanced_automobile_model',
                'value' => $_GET['txt_automobile_model'],
                'compare' => '='
            )
        );

    }
}

if (!is_admin()){
    add_action('wp_footer', 'owl_team_js');
}
    if (!function_exists('owl_team_js')) {
        function owl_team_js() {
            wp_enqueue_script( 'automobile-owl-carousel-js', plugins_url('assets/js/owl.carousel.js', dirname(__FILE__)) );
            wp_enqueue_script( 'automobile-bootstrap-font-js', plugins_url('assets/js/bootstrap.min.js', dirname(__FILE__)) );
            wp_enqueue_script( 'automobile-jquery', plugins_url('assets/js/jquery-1.11.1.min.js', dirname(__FILE__)) );
            wp_enqueue_script( 'automobile-custom', plugins_url('assets/js/custom.js', dirname(__FILE__)) );
        }
    }

/**
 * Enqueues styles for front-end.
 *
 */
if (!function_exists('owl_team_public_css')) {
    function owl_team_public_css() {
    //wp_enqueue_style( 'font-awesome', plugins_url('lib/assets/css/font-awesome/css/font-awesome.min.css', dirname(__FILE__)) );    w
    wp_enqueue_style( 'automobile-owl-carousel', plugins_url('assets/style/owl.carousel.css', dirname(__FILE__)) );
    wp_enqueue_style( 'automobile-bootstrap', plugins_url('assets/style/bootstrap.min.css', dirname(__FILE__)) );
    wp_enqueue_style( 'user-style', plugins_url('assets/style/user_style.css', dirname(__FILE__)) );
    wp_enqueue_style( 'automobile-style', plugins_url('assets/style/style.css', dirname(__FILE__)) );
 
    }
}
add_action( 'wp_enqueue_scripts', 'owl_team_public_css' );


  //template filter

add_filter( 'template_include','automobile_include_template_function', 1 );
function automobile_include_template_function( $template_path ) {
if ( get_post_type() == 'tlp_automobile' ) {
if ( is_single() ) {
// checks if the file exists in the theme first,
// otherwise serve the file from the plugin
if ( $theme_file = locate_template( array
( 'automobile-single.php' ) ) ) {
    $template_path = $theme_file;
}
    else
    {
        $template_path = plugin_dir_path( __FILE__ ) . '/template/automobile-single.php';
    }
  }



elseif ( is_archive() ) {
  if ( $theme_file = locate_template( array ( 'automobile_archive.php' ) ) ) {
$template_path = $theme_file;
}

else
        {
            $template_path = plugin_dir_path( __FILE__ ) . '/template/automobile-archive.php';
        }
    }
}
if(is_page( 'shopping-cart' )){
$template_path = plugin_dir_path( __FILE__ ) . '/template/automobile-shopping-cart.php';
}
if(is_page( 'auto-mobile' )){
$template_path = plugin_dir_path( __FILE__ ) . '/template/automobile.php';
}

if(is_page( 'automobile-checkout' )){
$template_path = plugin_dir_path( __FILE__ ) . '/template/automobile-checkout.php';
}

if(is_page( 'automobile-account' )){
$template_path = plugin_dir_path( __FILE__ ) . '/template/automobile-account.php';
}

return $template_path;
}
    function getFeaturedImage( $post_id = NULL, $size = 'large', $arr=false) {
        //global $id;
        $src = '';

            $post_thumbnail_id = get_post_thumbnail_id( $post_id );
            $image = wp_get_attachment_image_src($post_thumbnail_id, $size);
            if(!$image)return false;
            if($arr) return $image;
            if ( $image ) {
            list($src) = $image;
                //list($src, $widthd, $height) = $image;
            }
        return $src;
    }




 //images resize



    if ( ! function_exists( 'automobile_resize' ) ) {

    function automobile_resize( $url = '', $width = '', $height = NULL, $crop = NULL, $single = TRUE ) {

        if ( empty( $url ) )
            return NULL;

        if ( empty( $width ) )
            return NULL;

        $args = array(
            'url'    => $url,
            'width'  => $width,
            'height' => $height,
            'crop'   => $crop,
            'single' => $single
        );

        return wp_img_resizer_src( $args );
    }
}