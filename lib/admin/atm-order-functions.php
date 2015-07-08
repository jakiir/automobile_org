<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function atm_register_order_type( $type, $args = array() ) {
	if ( post_type_exists( $type ) ) {
		return false;
	}

	global $atm_order_types;

	if ( ! is_array( $atm_order_types ) ) {
		$atm_order_types = array();
	}

	// Register as a post type
	if ( is_wp_error( register_post_type( $type, $args ) ) ) {
		return false;
	}

	// Register for WC usage
	$order_type_args = array(
		'exclude_from_orders_screen'       => false,
		'add_order_meta_boxes'             => true,
		'exclude_from_order_count'         => false,
		'exclude_from_order_views'         => false,
		'exclude_from_order_reports'       => false,
		'exclude_from_order_sales_reports' => false,
		'class_name'                       => 'ATM_Order'
	);

	$args                    = array_intersect_key( $args, $order_type_args );
	$args                    = wp_parse_args( $args, $order_type_args );
	$atm_order_types[ $type ] = $args;

	return true;
}

function automobile_order_columns( $existing_columns ) {
		$columns                     = array();
		$columns['cb']               = $existing_columns['cb'];
		$columns['order_status']     = '<span class="status_head tips atm-tooltip" data-tooltip="' . esc_attr__( 'Status', 'automobile' ) . '"><i class="fa fa-minus-circle"></i></span>';
		$columns['order_title']      = __( 'Order', 'automobile' );
		$columns['order_items']      = __( 'Purchased', 'automobile' );
		$columns['shipping_address'] = __( 'Ship to', 'automobile' );
		$columns['customer_message'] = '<span class="notes_head tips atm-tooltip" data-tooltip="' . esc_attr__( 'Customer Message', 'automobile' ) . '"><i class="fa fa-envelope"></i></span>';
		$columns['order_notes']      = '<span class="order-notes_head tips atm-tooltip" data-tooltip="' . esc_attr__( 'Order Notes', 'automobile' ) . '"><i class="fa fa-desktop"></i></span>';
		$columns['order_date']       = __( 'Date', 'automobile' );
		$columns['order_total']      = __( 'Total', 'automobile' );
		$columns['order_actions']    = __( 'Actions', 'automobile' );

		return $columns;
}
/**
	 * Output custom columns for coupons
	 * @param  string $column
	 */
	function render_automobile_order_columns( $column ) {
		global $post, $autoMobile;
		$customerId = get_post_meta( get_the_ID(), 'customerId', true );
		$order_status = get_post_meta( get_the_ID(), 'order_status', true );
		switch ( $column ) {
			case 'order_status' :				
				if($order_status) :						
					$order_statuss = unserialize($order_status);
					$iconClass = '';
					if($order_statuss['name'] == 'on-complete') : $iconClass = 'fa-check'; else : $iconClass = 'fa-minus'; endif;
					echo '<mark class="'.$order_statuss['name'].' tips atm-tooltip" data-tooltip="'.$order_statuss['title'].'"><i class="fa '.$iconClass.'"></i></mark>';
				
				else :
				
					echo '<mark class="on-hold tips atm-tooltip" data-tooltip="On Hold"><i class="fa fa-minus"></i></mark>';
					
				endif;
			break;
			case 'order_date' :

				echo $pfx_date = get_the_date( $format, get_the_ID() );

			break;
			case 'customer_message' :
				echo '-';
			break;
			case 'order_items' :
				echo $productTotalItem = get_post_meta( get_the_ID(), 'productTotalItem', true );			
			break;
			case 'shipping_address' :
				$countryList = $autoMobile->create_countryList();
				$stateList = $autoMobile->state_list();
				
				$user_info = get_userdata($customerId);
				$checkout_company_name = get_user_meta( $customerId, 'checkout_company_name', true );
				$user_address = get_user_meta( $customerId, 'checkout_address', true );
				$selectCountry = get_user_meta( $customerId, 'selectCountry', true );
				$checkout_postcode = get_user_meta( $customerId, 'checkout_postcode', true );
				$checkout_town_city = get_user_meta( $customerId, 'checkout_town_city', true );				
				$checkout_phone = get_user_meta( $customerId, 'checkout_phone', true );
				
				if($user_info->display_name): $displayName = $user_info->display_name.', '; else : $displayName = ''; endif;
				if($checkout_company_name): $company_name = $checkout_company_name.', '; else : $company_name = ''; endif;
				if($user_address): $userAddress = $user_address.', '; else : $userAddress = ''; endif;				
				if($checkout_town_city): $checkoutTownCity = $stateList[$selectCountry][$checkout_town_city].', '; else : $checkoutTownCity = '';  endif;
				if($checkout_postcode): $checkoutPostcode = $checkout_postcode.', '; else : $checkoutPostcode = '';  endif;
				if($selectCountry): $select_country = $countryList[$selectCountry]; else : $select_country = ''; endif;	
				
				$address = $displayName.$company_name.$userAddress.$checkoutTownCity.$checkoutPostcode.$select_country;
				$addressMap = $userAddress.$checkoutTownCity.$select_country;
				echo '<a target="_blank" href="http://maps.google.com/maps?&amp;q='.$addressMap.'&amp;z=16">'.$address.'</a>';
			break;
			case 'order_notes' :

				echo 'order note';

			break;
			case 'order_total' :
				$productTotalPrice = get_post_meta( get_the_ID(), 'productTotalPrice', true );
				if($productTotalPrice): echo '$'.$productTotalPrice.' <small class="meta">Via PayPal</small>'; else : echo '$0.00'; endif;
			break;
			case 'order_title' :				
				$user_info = get_userdata($customerId);				
				$userEmail = '<a href="user-edit.php?user_id='.$customerId.'">'.$user_info->display_name.'</a>';
				echo '<div class="tips"><a href="post.php?post='.get_the_ID().'&amp;action=edit"><strong>#'.get_the_ID().'</strong></a> by '.$userEmail.' <small class="meta email"><a href="mailto:'.$user_info->user_email.'">'.$user_info->user_email.'</a></small></div>';
			break;
			case 'order_actions' :				
				if($order_status) :						
					$order_statuss = unserialize($order_status);					
				?><p>
				
					<a class="<?php if($order_statuss['name'] == 'on-hold') : echo 'active'; endif; ?> button tips atm_processing atm-tooltip orderStatus" data-order_id="<?php echo get_the_ID(); ?>"  data-order_status="processing" data-tooltip="Processing" href="#">
						<i class="fa fa-ellipsis-h"></i>
					</a>
					<a class="<?php if($order_statuss['name'] == 'on-complete') : echo 'active'; endif; ?> button tips atm_complete atm-tooltip orderStatus" data-order_id="<?php echo get_the_ID(); ?>"  data-order_status="complete" data-tooltip="Complete" href="#">
						<i class="fa fa-check"></i>
					</a>
					
					<?php else :?>
					
					<a class="button tips atm_processing atm-tooltip orderStatus" data-order_id="<?php echo get_the_ID(); ?>"  data-order_status="processing" data-tooltip="Processing" href="#">
						<i class="fa fa-ellipsis-h"></i>
					</a>
					<a class="button tips atm_complete atm-tooltip orderStatus" data-order_id="<?php echo get_the_ID(); ?>"  data-order_status="complete" data-tooltip="Complete" href="#">
						<i class="fa fa-check"></i>
					</a>
					
					<?php endif; ?>
					
					<?php echo '<a class="button tips atm_view atm-tooltip" data-tooltip="View" href="post.php?post='.get_the_ID().'&amp;action=edit"><i class="fa fa-book"></i></a>';	?>			
				</p>
					<?php

			break;
		}
	}