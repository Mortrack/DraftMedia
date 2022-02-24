<?php

namespace App\Controllers;     //The namespace must match the father directory oh the .php file were it will be used

use App\Models\DraftmediaVisits;
use App\Models\Users;
use Core\CoreHackAttempt;
use Core\Ddos;
use \Core\View;
use Core\Visitors;

/**
 * Home controller
 *
 * PHP version 5.4
 */
class Services extends \Core\Controller
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
                $hA->isHackAttempt("services", "before", $user);
            } catch (\Exception $e) {
                $hA->isHackAttempt("services", "before", "");
            }
            throw new \Exception("A DDoS hack attack has been detected.");
        }

        // Call once getUser method just to make the user go through credentials validations and through
        // a hack-attempt validation aswell. If nothing goes wrong, then the user hasn't tried anything
        // he shoulnd't and he can proceed. Otherwise he won't be able to.
        $xx = $this->getUser();

        // If user has a session, we then update the date of the last activity of the user
        if (isset($_SESSION["user"]) && isset($_SESSION["key"])) {
            $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
            $user = $this->getUser();
            $user['last_activity_at'] = $actualDate->format('Y-m-d H:i:s');
            $users = new Users();
            $users::persistAndFlush($user);
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
     * This method is in charge of counting how many times the view has been visited and it also identifies
     * if such visits were made by an authenticated user or an anonymous user.
     *
     * @throws \Exception
     *
     * @author Miranda Meza César
     * DATE November 17, 2018
     */
    public function ajaxServicesIndexVisitsAction() {
        $visitors = new Visitors();
        if ($visitors->isDraftmediaVisitsEnabled()) {
            $x = $visitors->isVisit($this->getUser());
            $visitors->checkDraftmediaDate();
            if (isset($_SESSION["user"]) || isset($_SESSION["key"])) {
                $user = $this->getUser();
                if ($user['role'] != 'admin') {
                    // If user has an active session, then count an authenticated visit
                    $DMV = new DraftmediaVisits();
                    $draftmediaVisits = $DMV::findAll();
                    $n = count($draftmediaVisits)-1;
                    $draftmediaVisits[$n]['Services_index_auth_visits']++;
                    $DMV::persistAndFlush($draftmediaVisits[$n]);
                }
            } else {
                //else, count an anonymous visit
                $DMV = new DraftmediaVisits();
                $draftmediaVisits = $DMV::findAll();
                $n = count($draftmediaVisits)-1;
                $draftmediaVisits[$n]['Services_index_anonym_visits']++;
                $DMV::persistAndFlush($draftmediaVisits[$n]);
            }
        }
    }

    /**
     * This method is in charge of counting how much time has the view been visited and it also identifies
     * if such time was spend by an authenticated user or an anonymous user.
     *
     * @throws \Exception
     *
     * @author Miranda Meza César
     * DATE November 17, 2018
     */
    public function ajaxServicesIndexTimeAction() {
        $visitors = new Visitors();
        if ($visitors->isDraftmediaVisitsEnabled()) {
            $visitors->checkDraftmediaDate();
            if (isset($_SESSION["user"]) || isset($_SESSION["key"])) {
                $user = $this->getUser();
                if ($user['role'] != 'admin') {
                    // If user has an active session, then count as authenticated time
                    $DMV = new DraftmediaVisits();
                    $draftmediaVisits = $DMV::findAll();
                    $n = count($draftmediaVisits)-1;
                    for ($i=0; $i<5; $i++) {
                        $draftmediaVisits[$n]['Services_index_auth_time']++;
                    }
                    $DMV::persistAndFlush($draftmediaVisits[$n]);
                }
            } else {
                //else, count as anonymous time
                $DMV = new DraftmediaVisits();
                $draftmediaVisits = $DMV::findAll();
                $n = count($draftmediaVisits)-1;
                for ($i=0; $i<5; $i++) {
                    $draftmediaVisits[$n]['Services_index_anonym_time']++;
                }
                $DMV::persistAndFlush($draftmediaVisits[$n]);
            }
        }
    }

    /**
     * Show the index page
     *
     * @throws \Exception
     */
    public function indexAction()
    {
        // ----- Language sanitize and validation ----- //
        if (isset($_COOKIE['1D5M9_7L5a3n0'])) {
            $language = $_COOKIE['1D5M9_7L5a3n0'];
            $language = filter_var($language, FILTER_SANITIZE_STRING);
            $language = htmlspecialchars($language, ENT_QUOTES, 'UTF-8');
            $language = strtolower($language);
            if ($language=='english' || $language=='spanish') {
                setcookie("1D5M9_7L5a3n0",'',time()- (365 * 24 * 60 * 60), '/');
                setcookie("1D5M9_7L5a3n0",$language,time()+ (365 * 24 * 60 * 60), '/');
            } else {
                $hA = new CoreHackAttempt();
                $hA->isHackAttempt("services", "index", $this->getUser());
                throw new \Exception("User was scrypting on Draft Media Server. Language value couldn't be identified.");
            }
        } else {
            $language = 'english';
        }

        $user = $this->getUser();
        if ($user != null) {
            $user_firstname = $user["first_name"];
        } else {
            $user_firstname = "";
        }
        View::renderTemplate('Services/index.html.twig', [
            'isUserLoggedIn' => (isset($_SESSION["user"]) || isset($_SESSION["key"])),
            'user_firstname' => $user_firstname,
            'language' => $language
        ]);
    }
}
