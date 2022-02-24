<?php

namespace Core;

use App\Models\HackAttempts;
use GeoIp2\Database\Reader;

/**
 * This class purpose is to provide tools to monitor all types of hack attempts to the server.
 *
 * Class Ddos
 * @package Core
 *
 * @author Miranda Meza César
 * DATE November 17, 2018
 */
class CoreHackAttempt
{

    /**
     * This method is in charge of making a record on the database of any identified hack attempt by the
     * developer by employing this method whenever he considers to place this on the main code of the
     * system.
     * NOTE that this method doesn't detect hack attempts automatically, it just "raises a flag" by
     * registering on the database anything we consider as a hack attempt.
     * So that the developer can use this efficiently, he must be expirienced at coding systems from
     * scratch. Otherwise he wouldn't have the required knowledge and experience to identify where to
     * exactly use this method correctly.
     * IMPORTANT: "$class" argument value must match the column name of the selected/corresponding database.
     *
     * @throws \Exception
     *
     * @author Miranda Meza César
     * DATE November 17, 2018
     */
    public function isHackAttempt(string $class, string $method, $user_id)
    {
        // If this happens, then the user made a hack attempt
        $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
        $hackAttempts = new HackAttempts();
        $allHackAttempts = $hackAttempts::findAll();
        $userLocation = new UserLocation();
        $userRealIpAddress = $userLocation->getUserRealIpAddress();
        $n=0;
        if ($allHackAttempts == null) {
            $allHackAttempts[$n][$class] = 1;
        } else {
            $n = count($allHackAttempts)-1;
            $allHackAttempts[$n][$class]++;
        }
        $allHackAttempts[$n]['user_real_ip_address'] = $userRealIpAddress;
        $allHackAttempts[$n]['method'] = $method;

        // We get atacker's geographic location
        // ---------------------------- //
        // ----- GEOIP2 component ----- //
        // ---------------------------- //
        // This creates the Reader object, which should be reused across
        // lookups.
        $reader = new Reader(dirname(dirname(__FILE__)).'/App/Models/GeoLite2-City_20181113/GeoLite2-City.mmdb');
        $uL = new UserLocation();
        $ip = $uL->getUserRealIpAddress();
        if (filter_var($ip,FILTER_VALIDATE_IP == true)) {
            // Replace "city" with the appropriate method for your database, e.g.,
            // "country".
            //$record = $reader->city('187.250.220.251');
            try {
                $record = $reader->city($ip);
            } catch (\Exception $e) {
                //We save that geographic location
                $allHackAttempts[$n]['country'] = '';
                $allHackAttempts[$n]['region'] = '';
                $allHackAttempts[$n]['city'] = '';
                $allHackAttempts[$n]['zipcode'] = '';
                $allHackAttempts[$n]['organization'] = '';
                $allHackAttempts[$n]['latitude'] = '';
                $allHackAttempts[$n]['longitude'] = '';
                $allHackAttempts[$n]['created_by'] = $user_id;
                $allHackAttempts[$n]['created_at'] = $actualDate->format('Y-m-d H:i:s');
                $allHackAttempts[$n]['id'] = null;
                $hackAttempts::persistAndFlush($allHackAttempts[$n]);
            }

            //We save that geographic location
            $allHackAttempts[$n]['country'] = $record->country->name;
            $allHackAttempts[$n]['region'] = $record->mostSpecificSubdivision->name;
            $allHackAttempts[$n]['city'] = $record->city->name;
            $allHackAttempts[$n]['zipcode'] = $record->postal->code;
            $allHackAttempts[$n]['organization'] = '';
            $allHackAttempts[$n]['latitude'] = $record->location->latitude;
            $allHackAttempts[$n]['longitude'] = $record->location->longitude;
            $allHackAttempts[$n]['created_by'] = $user_id;
            $allHackAttempts[$n]['created_at'] = $actualDate->format('Y-m-d H:i:s');
            $allHackAttempts[$n]['id'] = null;
            $hackAttempts::persistAndFlush($allHackAttempts[$n]);
        }
        $allHackAttempts[$n]['country'] = '';
        $allHackAttempts[$n]['region'] = '';
        $allHackAttempts[$n]['city'] = '';
        $allHackAttempts[$n]['zipcode'] = '';
        $allHackAttempts[$n]['organization'] = '';
        $allHackAttempts[$n]['latitude'] = '';
        $allHackAttempts[$n]['longitude'] = '';
        $allHackAttempts[$n]['created_by'] = $user_id;
        $allHackAttempts[$n]['created_at'] = $actualDate->format('Y-m-d H:i:s');
        $allHackAttempts[$n]['id'] = null;
        $hackAttempts::persistAndFlush($allHackAttempts[$n]);
    }
}
