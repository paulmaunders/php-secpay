<?

/*
 * secpay.php
 *
 * PHP Secpay v0.1
 *
 * Date: 2009-09-01
 * Requires: Zend Framework v1.8 or later
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Copyright 2010 Paul Maunders (http://www.pyrosoft.co.uk/blog/)
 */


// Implements the SECVPN.validateCardFull method 
// Documentation @ http://www.secpay.com/xmlrpc/realtimeTransaction.html

function ValidateCardFull(

	// Argument list same as old function to be backwards compatible

	$transId,			
	$ip,				
	$name, 			
	$cardNumber, 		
	$amount,			
	$expiryDate, 		
	$card_type,       
	$options = array(), 		
	$issueNumber ="", 
	$startDate ="", 	
	$order ="", 		
	$shipping ="", 	
	$billing ="" 
	
	) {
					
	$options = http_build_query($options); // Convert array to query string
					
	// http://www.secpay.com/xmlrpc/realtimeTransaction.html			
	$values = array(
	SECPAY_USER, // mid - Merchant ID
	SECPAY_PASSWORD, // vpn_pswd - VPN Password
	(string) $transId, // trans_id - Transaction ID 
	(string) $ip, // ip - IP Address
	(string) $name, // name - Cardholder Name
	(string) $cardNumber, // card_number - Card Number
	(string) $amount, // amount - Amount to charge
	(string) $expiryDate, // expiry_date - Card Expiry Date
	(string) $issueNumber, // issue_number - Card Issue Number
	(string) $startDate, // start_date - Card Start Date
	(string) $order, // order - Order Details
	(string) $shipping, // shipping - Shipping Address Details
	(string) $billing, // billing - Billing Address Details
	(string) $options, // options - Optional Parameters			
	);

	return secpay_xmlrpc_call('SECVPN.validateCardFull', $values);

} 


// Implements the SECVPN.repeatCardFullAddr method 
// Documentation @ http://www.secpay.com/xmlrpc/repeatTransaction.html

function RepeatCardFullAddr(

	// Argument list same as old function to be backwards compatible

	$orig_trans_id,	
	$amount,			
	$new_trans_id,	
	$exp_date = "", 	
	$order ="", 	   
	$shipping ="", 	 
	$billing ="", 
	$options =""	

	) {
	
	$options = http_build_query($options); // Convert array to query string
	
	// https://www.secpay.com/xmlrpc/repeatTransaction.html
	$values = array(
	SECPAY_USER, // mid - Merchant ID
	SECPAY_PASSWORD, // vpn_pswd - VPN Password
	(string) $orig_trans_id, // trans_id - Transaction ID 
	(string) $amount, // amount - Amount to charge
	SECPAY_REMOTE_PASSWORD, // remote_pswd	- Remote Password
	(string) $new_trans_id, // new_trans_id - New Transacton ID
	(string) $exp_date, // exp_date - Expiry Date (optional)
	(string) $order, // order - Order Details
	(string) $shipping, // shipping - Shipping Address Details
	(string) $billing, // billing - Billing Address Details
	(string) $options, // options - Optional Parameters			
	);

	return secpay_xmlrpc_call('SECVPN.repeatCardFullAddr', $values);
	
}

function secpay_xmlrpc_call ($call, $values) {

	$client = new Zend_XmlRpc_Client('https://www.secpay.com/secxmlrpc/make_call');
	
	//echo "<pre>"; var_dump($values); echo "</pre>";
	
	try {
	  $response = $client->call($call, $values);
	} catch (Zend_XmlRpc_Client_FaultException $e) {
	  echo 'ERROR ['.$e->getCode().']:'.$e->getMessage();
	} catch (Zend_XmlRpc_Client_HttpException $e) {
	  echo 'ERROR ['.$e->getCode().']:'.$e->getMessage();                
	}

	// echo "<pre>"; var_dump($response); echo "</pre>";

	if ($response) {
	
		parse_str($response, $result); // Convert response query string to array
		return $result;
	
	} else {
		
		$result['?valid'] = false;
		$result['message'] = "no valid response from SECpay";
		$result['code'] = "no valid response from SECpay";
		return $result;
	
	}

}

?>