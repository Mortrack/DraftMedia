<?php

namespace Core;

use App\Models\DraftmediaVisitors;
use App\Models\DraftmediaVisits;
use App\Models\DraftmediaVisitsEnable;
use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Device\DeviceParserAbstract;
use GeoIp2\Database\Reader;

/**
 * This class purpose is provide very detailed data about the visitor's characteristics.
 *
 * Class Visitors
 * @package Core
 *
 * @author Miranda Meza César
 * DATE November 20, 2018
 */
class Visitors
{

    /**
     * This method is in charge of retrieving detailed information about the geographical characteristics
     * of were the user was when he visited our website. This method also retrieves information about
     * the electronic device that the user used to visit the site.
     * Lastly, if no errors occur, this method will insert the data into the database of the website
     * for statistical purposes only.
     *
     * @throws \Exception
     *
     * @author Miranda Meza César
     * DATE November 20, 2018
     */
    public function isVisit($user)
    {
        //We retrieve the device system data of the user (for statistical purposes)
        DeviceParserAbstract::setVersionTruncation(DeviceParserAbstract::VERSION_TRUNCATION_NONE);
        $userAgent = $_SERVER['HTTP_USER_AGENT']; // change this to the useragent you want to parse
        $dd = new DeviceDetector($userAgent);
        $dd->parse();
        if ($dd->isBot()) {
            // handle bots,spiders,crawlers,...
            //botInfo = $dd->getBot();
            return false;
        } else {
            $clientInfo = $dd->getClient(); // holds information about browser, feed reader, media player, ...
            $osInfo = $dd->getOs();
            $device = $dd->getDeviceName();
            $brand = $dd->getBrandName();
            $model = $dd->getModel();
            $browser = '';
            if ($clientInfo['type'] == 'browser') {
                $browser = $clientInfo['name'];
            }
            $operativeSystem = $osInfo['name'];
        }
        $user_id = null;
        if ($user != null) {
            $user_id = $user['id'];
        }

        // ---------------------------- //
        // ----- GEOIP2 component ----- //
        // ---------------------------- //
        // This creates the Reader object, which should be reused across
        // lookups.
        $reader = new Reader(dirname(dirname(__FILE__)).'/App/Models/GeoLite2-City_20181113/GeoLite2-City.mmdb');
        $uL = new UserLocation();
        $ip = $uL->getUserRealIpAddress();
        if (filter_var($ip,FILTER_VALIDATE_IP == false)) {
            return false;
        }
        // Replace "city" with the appropriate method for your database, e.g.,
        // "country".
        //$record = $reader->city('187.250.220.251');
        try {
            $record = $reader->city($ip);
        } catch (\Exception $e) {
            return false;
        }

        // Detect if there is an existing record of that ip within our database and retrieve that row value, to update
        // its data. Otherwise, start defining the new data from scratch.
        $dV = new DraftmediaVisitors();
        $specificVisitor = $dV::findBy(["user_real_ip_address" => $ip]);
        $visitor = [];
        if ($specificVisitor != null) {
            $visitor = $specificVisitor[0];
            if ($visitor['user_id']==0 || $visitor['user_id']==null || $visitor['user_id']=='') {
                $visitor['user_id'] = $user_id;
            }
        } else {
            $visitor['id'] = '';
            $visitor['user_id'] = '';
        }
        $visitor['user_real_ip_address'] = $ip;
        $visitor['city'] = $record->city->name;
        $visitor['region'] = $record->mostSpecificSubdivision->name;
        $visitor['country'] = $record->country->name;
        $visitor['browser'] = $browser;
        $visitor['operative_system'] = $operativeSystem;
        $visitor['device'] = $device;
        if ($device=='' || $device==null && $operativeSystem=='Android') {
            $visitor['device'] = 'smartphone';
        }
        $visitor['brand'] = $brand;
        $visitor['model'] = $model;
        $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
        $visitor['last_activity_at'] = $actualDate->format('Y-m-d H:i:s');
        if ($specificVisitor == null) {
            $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
            $visitor['created_at'] = $actualDate->format('Y-m-d H:i:s');
        }
        $dV::persistAndFlush($visitor);
        return true;
    }

    /**
     * This method is used to get the name of the browser that the user is using. Once retrived, such
     * value is returned by this method.
     * If the code detects a bot-type-user, then it returns a boolean false.
     *
     * @return bool|string
     *
     * @author Miranda Meza César
     * DATE November 23, 2018
     */
    public function getUserBrowser()
    {
        //We retrieve the device system data of the user (for statistical purposes)
        DeviceParserAbstract::setVersionTruncation(DeviceParserAbstract::VERSION_TRUNCATION_NONE);
        $userAgent = $_SERVER['HTTP_USER_AGENT']; // change this to the useragent you want to parse
        $dd = new DeviceDetector($userAgent);
        $dd->parse();
        if ($dd->isBot()) {
            // handle bots,spiders,crawlers,...
            //botInfo = $dd->getBot();
            return false;
        } else {
            $clientInfo = $dd->getClient(); // holds information about browser, feed reader, media player, ...
            $browser = '';
            if ($clientInfo['type'] == 'browser') {
                $browser = $clientInfo['name'];
            }
            return $browser;
        }
    }

    /**
     * This method is used to determine if a new row value is needed on "draftmedia_visits" table.
     * If so, the table editing is disabled through code logic until this code adds the required
     * number of row values until its updated.
     * Each row value on such table is meant to cover 2 hrs per row.
     *
     * @throws \Exception
     *
     * @author Miranda Meza César
     * DATE November 23, 2018
     */
    public function checkDraftmediaDate()
    {
        while(true) {
            $dV = new DraftmediaVisits();
            $allVisits = $dV::findAll();
            $allVisitsLastMatch = count($allVisits)-1;
            $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
            $actualDateTime = strtotime($actualDate->format('Y-m-d H:i:s'));
            $lastRowDateValue = strtotime($allVisits[$allVisitsLastMatch]['date']);
            $hoursDifference = floor((($actualDateTime-$lastRowDateValue)/60/60));
            $timePerRowDifference = floor($hoursDifference/2);
            if ($timePerRowDifference > 0) {
                //Add new row(s) to "draftmedia_visits" table and disable its editing until this is finished
                $DMVE = new DraftmediaVisitsEnable();
                $isEnabled = $DMVE::findAll();
                $isEnabledMatches = count($isEnabled)-1;
                $isEnabled[$isEnabledMatches]['enable'] = 0;
                $DMVE::persistAndFlush($isEnabled[$isEnabledMatches]);

                //We set default values
                $newDV = [];
                for ($n=0; $n<52; $n++) {
                    $newDV[$n] = '0';
                    if ($n==0) {
                        $newDV[$n] = null;
                    }
                }

                //NOTE: for this to work, date values must be rounded in multiples of 2 hours
                $newDV[53] = date("Y-m-d H:i:s", ($lastRowDateValue+60*60*2));
                $dV::persistAndFlush($newDV);
            } else {
                $DMVE = new DraftmediaVisitsEnable();
                $isEnabled = $DMVE::findAll();
                $isEnabledMatches = count($isEnabled)-1;
                $isEnabled[$isEnabledMatches]['enable'] = 1;
                $DMVE::persistAndFlush($isEnabled[$isEnabledMatches]);
                break;
            }
        }
    }

    /**
     * This method is in charge of returning a true if it is permitted to write data on "draftmedia_visits"
     * database table. Otherwise, it will return a false to indicate it is not permitted to write data on it.
     *
     * @return bool
     * @throws \Exception
     *
     * @author Miranda Meza César
     * DATE November 23, 2018
     */
    public function isDraftmediaVisitsEnabled()
    {
        $DMVE = new DraftmediaVisitsEnable();
        $isEnabled = $DMVE::findAll();
        $n = count($isEnabled)-1;
        if ($isEnabled[$n]['enable'] == 1) {
            return true;
        } elseif ($isEnabled[$n]['enable'] == 0) {
            return false;
        } else {
            throw new \Exception("\"enable\" value on table row differs from \"0\" and \"1\"");
        }
    }
}
