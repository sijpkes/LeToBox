<?php
require 'vendor/autoload.php';

use Tsugi\Util\LTI;
use TinCan;

// Access the LTI object
$lti_request = LTI::isRequest() ? "Yep" : "Nope";

$output = "<p>Test output: is this an LTI request? : ".$lti_request."</p>";

// Access your tincan LRS
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
	            'id' => "http://adlnet.gov/expapi/tincan/",
				'definition' => 
					array(	  'name' => array("en-AU" => "Test Script Run"),
							  'description' => array("en-AU" => "LeToBox object collection script used")
						  )
	        ],
	    ]	
	);
	
} catch (Exception $e) {
	echo "<p>TinCan connection failed, check your settings.<pre>".var_export($e, TRUE)."</pre><br></p>";
}

if($response->success) {
	$output .= "<p>Tincan Query was successful.<br><br>  Response content:<br><br><pre>".$success->content."</pre></p>";
}

echo $output;
?>