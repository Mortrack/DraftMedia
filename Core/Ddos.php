<?php

namespace Core;

//TODO: Implement propper DDoS protection to site, although remember that ppl say that it is best to leave that to paid services like https://www.cloudflare.com/
/**
 * This class purpose is to provide tools to be able to defend against DDoS attacks.
 *
 * Class Ddos
 * @package Core
 *
 * @author Miranda Meza César
 * DATE November 17, 2018
 */
class Ddos
{

    /**
     * This method is in charge of delimiting the amount of requests per second (and by the same ip) that
     * the server will allow before considering it a DDoS attack through the argument variable "$limitps".
     * If a DDoS attack happens to be identified by this method, then it will permanently ban the user's
     * ip by directly writing the ban function on the ".htaccess" server configuration file.
     * Lastly but not least, this method will respond with a boolean true if an ip was banned or with a false
     * if otherwise happened.
     *
     * @param $limitps
     * @return boolean
     *
     * @author Miranda Meza César
     * DATE November 16, 2018
     */
    function isThereAnAttack($limitps)
    {
        //"$limitps" is used to define how many requests per second must occur so that the server considers it
        // a DDoS attack
        $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
        $_SERVER['REQUEST_TIME'] = $actualDate->format('Y-m-d H:i:s');
        if (isset($_SESSION['first_request']) == false) {
            $_SESSION['requests'] = 0;
            $_SESSION['first_request'] = $_SERVER['REQUEST_TIME'];
        }
        $_SESSION['requests']++;
        if ($_SESSION['requests']>=$limitps && (strtotime($_SERVER['REQUEST_TIME'])-strtotime($_SESSION['first_request']))<=1){
            // If this happens, then there is a DDoS attack and the php code will retrieve the user's IP address
            // to then directly ban it on the ".htaccess" server file.
            $uL = new UserLocation();
            $userIpAddress = $uL->getUserRealIpAddress();
            $f = fopen(".htaccess", "a+");
            fwrite($f, "Deny from " . $userIpAddress . "\r\n");
            fclose($f);
            return true;
        }elseif((strtotime($_SERVER['REQUEST_TIME'])-strtotime($_SESSION['first_request'])) > 2){
            $_SESSION['requests'] = 0;
            $_SESSION['first_request'] = $_SERVER['REQUEST_TIME'];
        }
        return false;
    }
}
