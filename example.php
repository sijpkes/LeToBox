<?php
ini_set("log_errors", 1);
ini_set("error_log", "/var/www/html/test/letobox/error.log");

require 'vendor/autoload.php';

error_reporting(E_ALL);

error_log("Starting...");

use Tsugi\Util\LTI;
use TinCan;
	
$lti_request = LTI::isRequest() ? "Yep" : "Nope";

try {
	$lrs = new TinCan\RemoteLRS(
	    "http://myendpoint.edu.au", 
	    '1.0.1',
	    "username", // username
	   	"password"  // password
	);
	
	
	$response = $lrs->saveStatement(
	    [
	        'actor' => [
	            'mbox' => "test_letobox@mailnesia.com",
				'name' => "LeToBoxTest"
	        ],
	        'verb' => [
	            'id' => 'http://adlnet.gov/expapi/verbs/$verb',
				'display' => array("en-AU" => "LeToBox Test Script")
	        ],
	        'object' => [
	            'id' => "http://bold.newcastle.edu.au/tincan/",
				'definition' => 
					array(	  'name' => array("en-AU" => "Test Script"),
							  'description' => array("en-AU" => "LeToBox object collection")
						  )
	        ],
	    ]	
	);
} catch (Exception $e) {
	echo "<p>TinCan connection failed, check your settings.</p>";
}

echo "<p>Test output: is this an LTI request? : ".$lti_request."</p>";

if($response->success) {
	echo "<p>Tincan Query was successful.<br><br>  Response content:<br><br><pre>".$success->content."</pre></p>";
}
?>