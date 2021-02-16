<?php

	/**
	 * A Plugin that shows all related pending orders to a subscrition to double check credit reporting
	 *
	 * @package cul-admin-pending-orders
	 *
	 * Plugin Name:       CUL - Show all pending related orders
	 * Description:       Plugin that shows all related pending orders to a subscrition to double check credit reporting
	 * Version:           1.0
	 * Author:            CUL
	 */


	/**
	 * Adds Menu to admin
	 */

	add_action( 'admin_menu', 'pending_admin_menu' );

	function pending_admin_menu() {
		add_menu_page( 'Pending orders for subscritions', 'Pending Orders', 'manage_options', 'cul-admin-pending-orders/cul-admin-pending-orders.php', 'pending_orders_admin_menu', 'dashicons-remove', 6  );
	}

	function pending_orders_admin_menu(){
	
		echo '<div class="wrap">
				<h2>View pending orders.</h2>
				<p>Remember to update the array of rentals</p>
			</div>';

		//Change ids to check here.
		$latePaymentSubs = array(62459,60358,56648,56642,55890,53357,52366,50259,47525,47336,46958,46691,44441,43083,40655,39330,39252,37894,36433,36081,35981,34413,34323,33958,33019,32118,31579,31065,30913,30615,30201,29516,28845,28779,28498,28391,28233,27909,27903,27847,27846,27757,27705,27441,26168,25972,25925,25630,25624,24208,23588,23119,22948,22246,22215,22000,21862,21504,21333,21147,20783,20743,20703,20417,20372,20253,20193,20023,19783,19776,19575,19574,19570,19556,18612,18292,17694,17518,16310,15150,15098,14919,14731,14710,14665,14095,13644,13102,12168,12166,11710,11198,11116,9805,9533,9336,9249,9181,8677,8675,8673,8616,8339,8006,7824,7818,7315,7293,7032,7012,6975,6958,6830,6805,6538,6485,6377,6364,6078,6060,5785,5561,5243,2932,2684);

		foreach ($latePaymentSubs as $subscription_id) {
			$subscription = wcs_get_subscription($subscription_id);

			$relared_orders_ids_array = $subscription->get_related_orders();

		    // count pending orders	
		    $pending_order_count = 0;	    
		    foreach ($relared_orders_ids_array as $order_id){
		    	
		        $order = wc_get_order( $order_id );
		        //$order_status  = $order->get_status();

		        if ( $order->has_status('pending') || $order->has_status('bad-payment') || $order->has_status('unreachable') || $order->has_status('late-payment') ) {
		        	$pending_order_count += 1;
		        }
		    }
		    if($pending_order_count<=1){
		    	echo  '<a style="background-color:#D64E07;color:#ffffff;"href="https://vivecul.com.co/wp-admin/post.php?post='.$subscription_id.'.&action=edit" target="_blank">'.$subscription_id."</a>,".$pending_order_count.",".get_post_status($subscription_id)."<br>";
		    }
		    else {
		    	echo  '<a href="https://vivecul.com.co/wp-admin/post.php?post='.$subscription_id.'.&action=edit" target="_blank">'.$subscription_id."</a>,".$pending_order_count.",".get_post_status($subscription_id)."<br>";
		    }
		}
		//get all pending orders
			/*$args = array(
	                'customer_id' => $wp_user_id,
	                'post_status' => 'completed',
	                'post_type' => 'shop_order',
	                'return' => 'ids',
	                'orderby' => 'start_date',
					'order'   => 'ASC',
	                'subscription_status' => array( 'wc-late-payment-60', 'wc-late-payment-90', 'wc-late-payment-90','wc-late-payment-120','wc-late-payment-150','wc-late-payment-180',),
	            );
	            $numorders_completed = 0;
	            echo $numorders_completed = wcs_get_subscriptions( $args );*/

	
	}