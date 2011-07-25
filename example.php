<pre>
<?

/*
 * secpay.php
 *	
 * PHP Secpay
 * Some functions to help connect to Paypoint / Secpay's XMLRPC API. 
 *
 * Requires: Zend Framework v1.8 or later
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Copyright 2010 Paul Maunders (http://www.pyrosoft.co.uk/blog/)
 */

require_once "config.php";
require_once 'Zend/XmlRpc/Client.php';
require_once "secpay.php";

	
// Example use of the ValidateCardFull function	(to set up a new payment)
	
$options['test_status']='false';
$options['dups']='true';
$options['currency']='GBP';
//$options['mail_merchants']='youremail@example.com';
//$options['mail_attach_merchant']='true';
$options['usage_type']='R';
$options['cv2']='123';

$result = ValidateCardFull(
	'TEST_1', // trans_id - Transaction ID 
	'123.123.123.123', // ip - IP Address
	'mr test test', // name - Cardholder Name
	'4444333322221111', // card_number - Card Number
	'1', // amount - Amount to charge
	'0712', // expiry_date - Card Expiry Date
	'', // card_type
	$options, // options - Optional Parameters
	'0', // issue_number - Card Issue Number
	'0309', // start_date - Card Start Date
	'', // order - Order Details
	'', // shipping - Shipping Address Details
	'' // billing - Billing Address Details		
);

var_dump($result);





// Example use of the RepeatCardFullAddr function (for repeat payments)
	
$options['test_status']='false';
$options['usage_type']='R';

$result = RepeatCardFullAddr(
	'TEST_1',	
	'2',			
	'TEST_1_REPEAT_'.time(),	
	$exp_date="", 	
	$order ="", 	   
	$shipping ="", 	 
	$billing ="", 
	$options	
);


var_dump($result);

?>