<?php
    $key = "ecee6bd2206a752ea3f73e1996a208ba62a91402"; // app key
    $action = 'new'; // this can be new or existing (i.e. add new LocName or get existing LocName)
    $tmp_fname = 'cookie.txt';

    // get those parameters from the user
    $first_name = $_POST['firstname'];
    $last_name = $_POST['lastname'];
    $email = $_POST['email'];
    $title = $_POST['title'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $address = $_POST['address'];
    $country = "Egypt";
    $city = "Cairo";
    $building_number ="105";
    $flat_number = "51";
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

?>
