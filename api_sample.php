<?php
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}
function ExistingLocName ($title){
	$key = "ecee6bd2206a752ea3f73e1996a208ba62a91402"; // app key
    $action = 'existing'; // this can be new or existing (i.e. add new LocName or get existing LocName)
    $tmp_fname = 'cookie.txt';

    // get those parameters from the user
    if (!is_null($key)){
        $curlObj = curl_init(); // start a new curl object
        $c_opt = array( CURLOPT_URL => 'http://locname.com/api/partner/', // the api url
                        CURLOPT_POST => true, // this url uses post method
                        CURLOPT_POSTFIELDS => "app_key=".$key."&action=".$action."&title=".$title,
                        CURLOPT_SSL_VERIFYPEER => false,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_RETURNTRANSFER => true, // switching to false will not display the resulting json
                        CURLOPT_COOKIEFILE => $tmp_fname,
                        CURLOPT_COOKIEJAR => $tmp_fname
                        );

        /*** LOGIN **********************************************/
        curl_setopt_array($curlObj, $c_opt); // give the parameters array to the curl object
        $session = curl_exec($curlObj); // execute curl object and put the result in variable session

        /*** THE END ********************************************/
        curl_close($curlObj); // close the opened curl

        header('Content-Type: application/json');
        die(json_encode(array('response' => json_decode($session)))); // decode and display the resulting json
    } else {
        die("missing parameters");
    }
}
function NewLocName ($email,$first_name,$last_name,$title,$country,$city,$address,$building_number,$flat_number,$latitude,$longitude){
    $key = "ecee6bd2206a752ea3f73e1996a208ba62a91402"; // app key
    $action = 'new'; // this can be new or existing (i.e. add new LocName or get existing LocName)
    $tmp_fname = 'cookie.txt';
    if (!is_null($key)){
        $curlObj = curl_init(); // start a new curl object
        $c_opt = array( CURLOPT_URL => 'http://locname.com/api/partner/', // the api url
                        CURLOPT_POST => true, // this url uses post method
                        CURLOPT_POSTFIELDS => "app_key=".$key."&action=".$action."&first_name=".$first_name."&last_name=".$last_name."&email=".$email."&title=".$title."&latitude=".$latitude."&longitude=".$longitude."&address=".$address."&country=".$country."&city=".$city."&building_number=".$building_number."&flat_number=".$flat_number, // those are the post parameters
                        CURLOPT_SSL_VERIFYPEER => false,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_RETURNTRANSFER => true, // switching to false will not display the resulting json
                        CURLOPT_COOKIEFILE => $tmp_fname,
                        CURLOPT_COOKIEJAR => $tmp_fname
                        );

        /*** LOGIN **********************************************/
        curl_setopt_array($curlObj, $c_opt); // give the parameters array to the curl object
        $session = curl_exec($curlObj); // execute curl object and put the result in variable session

        /*** THE END ********************************************/
        curl_close($curlObj); // close the opened curl

        header('Content-Type: application/json');
        die(json_encode(array('response' => json_decode($session)))); // decode and display the resulting json
    } else {
        die("missing parameters");
    }
}

if( !isset($_POST['functionname']) ) { $aResult['error'] = 'No function name!'; }

if( !isset($_POST['arguments']) ) { $aResult['error'] = 'No function arguments!'; }

if( !isset($aResult['error']) ) {

    switch($_POST['functionname']) {
		case 'ExistingLocName':
           if( !is_array($_POST['arguments']) || (count($_POST['arguments']) != 1) ) {
               $aResult['error'] = 'Error in arguments!';
           }
           else {
               $aResult['result'] = ExistingLocName($_POST['arguments'][0]);
           }
           break;
		case 'NewLocName':
           if( !is_array($_POST['arguments']) || (count($_POST['arguments']) > 11) ) {
               $aResult['error'] = 'Error in arguments!';
           }
           else {
               $aResult['result'] = NewLocName($_POST['arguments'][0],$_POST['arguments'][1],$_POST['arguments'][2],$_POST['arguments'][3],$_POST['arguments'][4],$_POST['arguments'][5],$_POST['arguments'][6],$_POST['arguments'][7],$_POST['arguments'][8],$_POST['arguments'][9],$_POST['arguments'][10],$_POST['arguments'][11]);
           }
           break;

        default:
           $aResult['error'] = 'Not found function '.$_POST['functionname'].'!';
           break;
    }

}

echo json_encode($aResult['result']);
?>