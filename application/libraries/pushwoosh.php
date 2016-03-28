<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * A PHP library for sending push messages using PushWoosh.
 *
 * This library allows new push notifications to be created using the PushWoosh service.
 *
 * Can be installed using Composer.
 *
 * @package PushWoosh
 */

//namespace PushWoosh;

/**
 * The PushWoosh class is a class for interacting with the PushWoosh push notification service.
 *
 * The constructor of the PushWoosh class takes parameters for the application ID, username and password.
 * @category library
 * @package PushWoosh
 * @license http://opensource.org/licenses/MIT
 * @example <br />
 *  $push = new PushWoosh($appId, $username, $password);<br />
 *  $push->createMessage($users, 'now', null);
 * @version 0.0.2
 * @since 2014-02-27
 * @author Matthew Daly matthew@astutech.com
 */

class Pushwoosh
{
    /**
     * The configuration settings. Should consist of an array with three keys:
     * application, username and password
     * @var array
     */
    protected $config;

    /**
     * Constructor for the PushWoosh object
     *
     * @param string $appId The PushWoosh app ID to use
     * @param string $username The PushWoosh username to use
     * @param string $password The PushWoosh password to use
     *
     * @return PushWoosh
     * @since 2014-02-27
     * @author Matthew Daly matthew@astutech.com
     */
//    public function __construct($appId, $username, $password)
    public function __construct($params)
    {
        // Set the config options up
        $config = array();
        $config['application'] = $params["application"];
        $config['username'] = $params["username"];
        $config['password'] = $params["password"];
        $this->config = $config;
    }

    /**
     * Sends a POST request to create the push message
     *
     * @param string $url The URL to send the POST request to
     * @param string $data The data to be sent, encoded as JSON
     * @param string $optional_headers Any optional headers. Defaults to null
     *
     * @return mixed Returns the response, or false if nothing received
     * @since 2014-02-27
     * @author Matthew Daly matthew@astutech.com
     */
    private function doPostRequest($url, $data, $optional_headers = null)
    {
        $params = array(
            'http' => array(
                'method' => 'POST',
                'content' => $data
            ));
        if ($optional_headers !== null) {
            $params['http']['header'] = $optional_headers;
        }
        $ctx = stream_context_create($params);
        $fp = fopen($url, 'rb', false, $ctx);
        if (!$fp) {
            throw new Exception("Problem with $url, $php_errmsg");
        }

        $response = @stream_get_contents($fp);
        if ($response === false) {
            return false;
        }
        return $response;
    }

    /**
     * Puts together the POST request to create the push message
     *
     * @param string $action The action to take
     * @param array $data The data to send
     *
     * @return bool Confirms that the method executed
     * @since 2014-02-27
     * @author Matthew Daly matthew@astutech.com
     */
    private function pwCall($action, array $data = array())
    {
        $url = 'https://cp.pushwoosh.com/json/1.3/'.$action;
        $json = json_encode(array('request' => $data));
        $res = $this->doPostRequest($url, $json, 'Content-Type: application/json');
        $responseData = json_decode($res);
        if ($responseData->status_code == 200) {
            $response = true;
        } else {
            // Failed - log error and advise
            $response = false;
            error_log("Could not sent push - " . $responseData->status_message);
        }
        return $response;
    }

    /**
     * Creates a push message using PushWoosh
     *
     * @param array $pushes An array of messages to be sent. Each message in the array should be an associative array,
     * with the key 'content' representing the content of the message to be sent, and the key 'devices' representing 
     * the device token to send that message to. Leave 'devices' empty to send that message to all users
     * @param string $sendDate Send date of the message. Defaults to right now
     * @param string $link A link to follow when the push notification is clicked. Defaults to null
     * @param int $ios_badges The iOS badge number. Defaults to 1
     *
     * @return bool Confirms whether the method executed successfully
     * @since 2014-02-27
     * @author Matthew Daly matthew@astutech.com
     */
    public function createMessage(array $pushes, $sendDate = 'now', $link = null, $ios_badges = 1)
    {
        // Get the config settings
        $config = $this->config;

        // Store the message data
        $data = array(
            'application' => $config['application'],
            'username' => $config['username'],
            'password' => $config['password']
        );

        // Loop through each push and add them to the notifications array
        foreach ($pushes as $push) {
            $pushData = array(
                'send_date' => $sendDate,
                'content' => $push['content'],
                'ios_badges' => $ios_badges
            );

            // If a list of devices is specified, add that to the push data
            if (array_key_exists('devices', $push)) {
                $pushData['devices'] = $push['devices'];
            }

            // If a link is specified, add that to the push data
            if ($link) {
                $pushData['link'] = $link;
            }
            $data['notifications'][] = $pushData;
        }

        // Send the message
        $response = $this->pwCall('createMessage', $data);

        // Return a value
        return $response;
    }
}