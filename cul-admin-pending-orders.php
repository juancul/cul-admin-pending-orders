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
		$latePaymentSubs = array(89782,86359,85954,82787,81588,81343,81336,80788,80662,80605,80591,80353,79765,79183,78324,78243,77853,77764,75059,74903,69548,68726,68469,67558,66774,65372,65298,64866,64838,64752,64526,64224,63906,63672,63279,62459,62131,60963,60659,60358,60320,60070,59692,58920,57834,56648,56642,56105,55890,55879,55653,54417,53357,52938,52898,52366,50259,50009,48124,47525,47336,47023,46958,46691,46404,45966,44865,44441,43830,43187,43083,42178,42125,41912,41215,41161,40655,39353,39330,39252,37925,37894,37887,37835,37797,37203,36969,36883,36882,36433,36137,36081,35981,35618,35614,35121,35013,34527,34456,34413,34323,34226,33019,32851,32292,32170,32146,32118,31808,31782,31747,31744,31683,31601,31579,31065,31058,31003,30913,30886,30824,30615,30538,30500,30266,30265,30201,29932,29864,29473,29445,28845,28779,28498,28391,28233,27934,27909,27903,27864,27847,27846,27757,27618,27441,27405,27278,27026,26809,26724,26475,26423,26168,26161,26105,26102,26084,25972,25925,25848,25786,25679,25624,25546,25249,25245,25141,25116,25090,25008,24789,24752,24674,24648,24324,24208,24204,24189,24165,24160,24111,23745,23696,23588,23513,23171,23119,22948,22706,22691,22670,22646,22254,22246,22215,22124,22040,22000,21972,21951,21862,21504,21338,21333,21308,21289,21230,21147,20946,20813,20783,20743,20703,20417,20372,20309,20253,20247,20194,20193,20140,20066,20023,19974,19793,19783,19776,19753,19575,19574,19570,19556,19212,19167,19120,18612,18292,17694,17518,17342,16905,16705,16666,16367,16310,16264,16252,15150,15098,15017,14919,14731,14710,14665,14292,14095,13644,13634,13571,13102,13059,13056,12970,12936,12911,12344,12284,12168,12166,12055,11767,11710,11231,11198,11116,10810,10759,10730,10577,10575,10361,10270,10260,10245,10238,10237,10208,9805,9785,9533,9336,9249,9181,9166,9135,8981,8939,8934,8729,8677,8675,8673,8670,8638,8616,8339,8173,8113,8006,7824,7818,7603,7535,7527,7523,7489,7346,7324,7315,7293,7286,7234,7036,7032,7012,6975,6958,6941,6847,6832,6830,6815,6806,6805,6620,6566,6491,6485,6377,6364,6230,6126,6078,6060,5997,5884,5800,5785,5766,5670,5608,5561,5396,5282,5243,3627,2953,2932,2892,2721,2691,2687,2684,2582,2578);

		echo  '<table>
		    		<th>Alquiler</th>
    				<th>Pagos Pendientes</th>
    				<th>Estado</th>
    				<th>Nombre</th>
    				<th>Apellido</th>
    				<th>Email</th>';
		foreach ($latePaymentSubs as $subscription_id) {
			$subscription = wcs_get_subscription($subscription_id);

			$related_orders_ids_array = $subscription->get_related_orders();
			$user_id = $value = get_post_meta( $subscription_id, '_customer_user', true );
			$user_info = get_userdata($user_id);
			$first_name = $user_info->first_name;
      		$last_name = $user_info->last_name;
      		$email = $user_info->user_email;

		    // count pending orders	
		    $pending_order_count = 0;	    
		    foreach ($related_orders_ids_array as $order_id){
		    	
		        $order = wc_get_order( $order_id );
		        //$order_status  = $order->get_status();

		        if ( $order->has_status('pending') || $order->has_status('bad-payment') || $order->has_status('unreachable') || $order->has_status('late-payment') ) {
		        	$pending_order_count += 1;
		        }
		    }
		    
		    if($pending_order_count<=1){
		    	echo  '<tr>
		    				<td><a style="background-color:#D64E07;color:#ffffff;"href="https://vivecul.com.co/wp-admin/post.php?post='.$subscription_id.'.&action=edit" target="_blank">'.$subscription_id.'</a></td>
		    				<td>'.$pending_order_count.'</td>
		    				<td>'.get_post_status($subscription_id).'</td>
		    				<td>'.$first_name.'</td>
		    				<td>'.$last_name.'</td>
		    				<td>'.$email.'</td>
		    			</tr>';  
		    }
		    else {
		    	echo  '<tr>
		    				<td><a href="https://vivecul.com.co/wp-admin/post.php?post='.$subscription_id.'.&action=edit" target="_blank">'.$subscription_id.'</a></td>
		    				<td>'.$pending_order_count.'</td>
		    				<td>'.get_post_status($subscription_id).'</td>
		    				<td>'.$first_name.'</td>
		    				<td>'.$last_name.'</td>
		    				<td>'.$email.'</td>
		    			</tr>';
		    }
		}
		echo  '</table>';
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