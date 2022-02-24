<?php

namespace App\Controllers\Admin;

use App\Config;
use App\Models\DraftmediaVisits;
use App\Models\Users;
use Core\CoreHackAttempt;
use Core\Ddos;
use \Core\View;

//https://ads.google.com
/**
 * Summary controller
 *
 * PHP version 5.4
 */
class Summary extends \Core\Controller
{

    /**
     * Before filter
     *
     * @throws \Exception
     */
    protected function before()
    {
        session_start();

        // We set protection against DDoS Attacks
        $ddos = new Ddos();
        if ($ddos->isThereAnAttack(10)) {
            $hA = new CoreHackAttempt();
            $user = '';
            try {
                $user = $this->getUser();
                $hA->isHackAttempt("admin_summary", "before", $user);
            } catch (\Exception $e) {
                $hA->isHackAttempt("admin_summary", "before", "");
            }
            throw new \Exception("A DDoS hack attack has been detected.");
        }

        // If user has a session, we then update the date of the last activity of the user. Otherwise
        // redirect him to home page of DraftMedia.
        if (isset($_SESSION["user"]) && isset($_SESSION["key"])) {
            $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
            $user = $this->getUser();
            $user['last_activity_at'] = $actualDate->format('Y-m-d H:i:s');
            $users = new Users();
            $users::persistAndFlush($user);

            //if user has a session, then if he is admin: let him stay on this view. Otherwise
            //redirect him to home page of DraftMedia.
            if ($user['role'] != 'admin') {
                if (Config::APP_ENV) {
                    header("LOCATION: " . Config::APP_DEV_URL);
                } else {
                    header("LOCATION: " . Config::APP_PROD_URL);
                }
            }

            // We update the current online users on the website and the maximum users that the
            // website had online for a certain amount of time (periodically).
            $DMV = new DraftmediaVisits();
            $draftmediaVisits = $DMV::findAll();
            $n = count($draftmediaVisits)-1;
            $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
            $actualDateTime = strtotime($actualDate->format('Y-m-d H:i:s'));
            $users = new Users();
            $allUsers = $users::findBy(["status" => "ACTIVE"]);
            if ($allUsers != null) {
                $usersOnline = 0;
                foreach ($allUsers as $specificUser) {
                    $lastActivityTime = strtotime($specificUser['last_activity_at']);
                    if (($actualDateTime-$lastActivityTime) <= 900) {
                        $usersOnline++;
                    }
                }
                if ($usersOnline > $draftmediaVisits[$n]['max_users_online']) {
                    $draftmediaVisits[$n]['max_users_online'] = $usersOnline;
                }
                $draftmediaVisits[$n]['current_users_online'] = $usersOnline;
                $DMV::persistAndFlush($draftmediaVisits[$n]);
            }
        } else {
            if (Config::APP_ENV) {
                header("LOCATION: " . Config::APP_DEV_URL);
            } else {
                header("LOCATION: " . Config::APP_PROD_URL);
            }
        }

    }

    /**
     * After filter
     *
     * @return void
     */
    protected function after()
    {
    }

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        View::renderTemplate('Admin/Summary/index.html.twig', [
        ]);
    }
}
