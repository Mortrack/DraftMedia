<?php

namespace App\Controllers\Admin;

use App\Config;
use App\Models\ContactUs;
use App\Models\DraftmediaVisitors;
use App\Models\DraftmediaVisits;
use App\Models\Users;
use Core\CoreHackAttempt;
use Core\Ddos;
use \Core\View;
use Core\Visitors;

/**
 * Summary controller
 *
 * PHP version 5.4
 */
class Clients extends \Core\Controller
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
                $hA->isHackAttempt("admin_email", "before", $user);
            } catch (\Exception $e) {
                $hA->isHackAttempt("admin_email", "before", "");
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
        } else {
            if (Config::APP_ENV) {
                header("LOCATION: " . Config::APP_DEV_URL);
            } else {
                header("LOCATION: " . Config::APP_PROD_URL);
            }
        }

    }

    /**
     * This method is in charge of updating the "is_attended" value of each message from the "contact_us"
     * table from the database.
     *
     * @throws \Exception
     *
     * @author Miranda Meza César
     * DATE November 27, 2018
     */
    public function ajaxUpdateIsAttendedAction()
    {
        // ----------------------------------------------------- //
        // ----- SANITIZE AND VALIDATION OF REGISTER FORM  ----- //
        // ----------------------------------------------------- //
        if (isset($_POST)) {
            $contactUs_id = $_POST['id'];
            $is_attended = $_POST['is_attended'];

            // ----- contact_us id sanitize and validation ----- //
            if (!empty($contactUs_id)) {
                $contactUs_id = filter_var($contactUs_id, FILTER_SANITIZE_NUMBER_INT);
                $contactUs_id = htmlspecialchars($contactUs_id, ENT_QUOTES, 'UTF-8');
            } else {
                throw new \Exception("\"contact_us -> id\" value is not set.");
            }

            // ----- is_attended value, from "contact_us" table, sanitize and validation ----- //
            if (!empty($is_attended)) {
                $is_attended = filter_var($is_attended, FILTER_SANITIZE_STRING);
                $is_attended = htmlspecialchars($is_attended, ENT_QUOTES, 'UTF-8');
                if ($is_attended == 'true') {
                    $is_attended = true;
                } elseif ($is_attended == 'false') {
                    $is_attended = false;
                }
            } else {
                throw new \Exception("\"contact_us -> is_attended\" value is not set.");
            }


            // --------------------------------------------------------------------------- //
            // ----- Server response with regard of the DEA Modal Validation process ----- //
            // --------------------------------------------------------------------------- //
            $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
            $user = $this->getUser();

            // ----- We save the record of this change made to contact_us table ----- //
            $cU = new ContactUs();
            $contactUs = $cU::find($contactUs_id);
            if ($contactUs != null) {
                $contactUs = $contactUs[0];
                $contactUs['is_attended'] = $is_attended;
                $contactUs['modified_by'] = $user['id'];
                $contactUs['modified_at'] = $actualDate->format('Y-m-d H:i:s');
                $cU::persistAndFlush($contactUs);
            } else {
                throw new \Exception("Couldn't find a match with the id: $contactUs, on the table \"contact_us\"");
            }
        }
    }

    /**
     * This method is in charge of retrieving and process the data needed to display the chart of the
     * annual messages that Draft Media Website has received through the "contact_us" table from the
     * database, but on the current year.
     *
     * @throws \Exception
     *
     * @author Miranda Meza César
     * DATE November 27, 2018
     */
    public function ajaxUpdateAnnuallyReceivedMessagesGraphAction()
    {
        if (isset($_GET)) {
            if (isset($_GET["request"])) {
                $cU = new ContactUs();
                $allContactUs = $cU::findAll();
                if ($allContactUs != null) {
                    $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
                    $actualYear = $actualDate->format('Y');
                    $thisYearContactUs = [];
                    $contactUsMatches = 0;
                    foreach ($allContactUs as $specificContactUs) {
                        $yearOfMessageCreated = date('Y', strtotime($specificContactUs['created_at']));
                        if ($actualYear==$yearOfMessageCreated) {
                            $thisYearContactUs[$contactUsMatches] = $specificContactUs;
                            $contactUsMatches++;
                        }
                    }
                    if (!empty($thisYearContactUs)) {
                        $totalMessages = count($thisYearContactUs);
                        $graphData = [0,0,0,0,0,0,0,0,0,0,0,0];
                        for ($n=0; $n<12; $n++) {
                            foreach ($thisYearContactUs as $specificThisYearCtcUs) {
                                $monthOfMessageCreated = date('m', strtotime($specificThisYearCtcUs['created_at']));
                                if ($n==((int)$monthOfMessageCreated-1)) {
                                    $graphData[$n]++;
                                }
                            }
                        }
                        $max = $graphData[0];
                        $min = $graphData[0];
                        foreach ($graphData as $value) {
                            if ($min > $value) {
                                $min = $value;
                            }
                            if ($max < $value) {
                                $max = $value;
                            }
                        }
                        echo json_encode([
                            'status' => 200, //200 = Created
                            'message' => [],
                            'data' => [$totalMessages, $graphData, $max, $min]
                        ]);
                    } else {
                        $totalMessages = 0;
                        $graphData = [0,0,0,0,0,0,0,0,0,0,0,0];
                        $max = 0;
                        $min = 0;
                        echo json_encode([
                            'status' => 200, //200 = Created
                            'message' => [],
                            'data' => [$totalMessages, $graphData, $max, $min]
                        ]);
                    }
                } else {
                    $totalMessages = 0;
                    $graphData = [0,0,0,0,0,0,0,0,0,0,0,0];
                    $max = 0;
                    $min = 0;
                    echo json_encode([
                        'status' => 200, //200 = Created
                        'message' => [],
                        'data' => [$totalMessages, $graphData, $max, $min]
                    ]);
                }
            } else {
                $hA = new CoreHackAttempt();
                $hA->isHackAttempt("admin_email", "ajaxUpdateAnnuallyReceivedMessagesGraph", $this->getUser());
                throw new \Exception("User was scrypting on Draft Media Server");
            }
        }
    }

    /**
     * This method is in charge of retrieving and process the data needed to display the chart of the
     * annual messages that Draft Media Website has attended from the "contact_us" table from the
     * database, but on the current year.
     *
     * @throws \Exception
     *
     * @author Miranda Meza César
     * DATE November 28, 2018
     */
    public function ajaxUpdateAnnuallyAttendedMessagesGraphAction()
    {
        if (isset($_GET)) {
            if (isset($_GET["request"])) {
                $cU = new ContactUs();
                $allContactUs = $cU::findBy(["is_attended" => '1']);
                if ($allContactUs != null) {
                    $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
                    $actualYear = $actualDate->format('Y');
                    $thisYearContactUs = [];
                    $contactUsMatches = 0;
                    foreach ($allContactUs as $specificContactUs) {
                        $yearOfMessageCreated = date('Y', strtotime($specificContactUs['modified_at']));
                        if ($actualYear==$yearOfMessageCreated) {
                            $thisYearContactUs[$contactUsMatches] = $specificContactUs;
                            $contactUsMatches++;
                        }
                    }
                    if (!empty($thisYearContactUs)) {
                        $totalMessages = count($thisYearContactUs);
                        $graphData = [0,0,0,0,0,0,0,0,0,0,0,0];
                        for ($n=0; $n<12; $n++) {
                            foreach ($thisYearContactUs as $specificThisYearCtcUs) {
                                $monthOfMessageCreated = date('m', strtotime($specificThisYearCtcUs['modified_at']));
                                if ($n==((int)$monthOfMessageCreated-1)) {
                                    $graphData[$n]++;
                                }
                            }
                        }
                        $max = $graphData[0];
                        $min = $graphData[0];
                        foreach ($graphData as $value) {
                            if ($min > $value) {
                                $min = $value;
                            }
                            if ($max < $value) {
                                $max = $value;
                            }
                        }
                        echo json_encode([
                            'status' => 200, //200 = Created
                            'message' => [],
                            'data' => [$totalMessages, $graphData, $max, $min]
                        ]);
                    } else {
                        $totalMessages = 0;
                        $graphData = [0,0,0,0,0,0,0,0,0,0,0,0];
                        $max = 0;
                        $min = 0;
                        echo json_encode([
                            'status' => 200, //200 = Created
                            'message' => [],
                            'data' => [$totalMessages, $graphData, $max, $min]
                        ]);
                    }
                } else {
                    $totalMessages = 0;
                    $graphData = [0,0,0,0,0,0,0,0,0,0,0,0];
                    $max = 0;
                    $min = 0;
                    echo json_encode([
                        'status' => 200, //200 = Created
                        'message' => [],
                        'data' => [$totalMessages, $graphData, $max, $min]
                    ]);
                }
            } else {
                $hA = new CoreHackAttempt();
                $hA->isHackAttempt("admin_email", "ajaxUpdateAnnuallyAttendedMessagesGraph", $this->getUser());
                throw new \Exception("User was scrypting on Draft Media Server");
            }
        }
    }

    /**
     * This method is in charge of retrieving and process the data needed to display the chart of the
     * last week messages that Draft Media Website has received from the "contact_us" table from the
     * database, but on the current year.
     *
     * @throws \Exception
     *
     * @author Miranda Meza César
     * DATE November 28, 2018
     */
    public function ajaxUpdateWeeklyReceivedMessagesGraphAction()
    {
        if (isset($_GET)) {
            if (isset($_GET["request"])) {
                $cU = new ContactUs();
                $allContactUs = $cU::findAll();
                if ($allContactUs != null) {
                    $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
                    $actualYear = $actualDate->format('Y');
                    $thisYearContactUs = [];
                    $contactUsMatches = 0;
                    foreach ($allContactUs as $specificContactUs) {
                        $yearOfMessageCreated = date('Y', strtotime($specificContactUs['created_at']));
                        if ($actualYear==$yearOfMessageCreated) {
                            $thisYearContactUs[$contactUsMatches] = $specificContactUs;
                            $contactUsMatches++;
                        }
                    }
                    $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
                    $actualWeek = (int)$actualDate->format('W');
                    $thisWeekContactUs = [];
                    $contactUsMatches = 0;
                    foreach ($thisYearContactUs as $specificContactUs) {
                        $weekOfMessageCreated = (int)date('W', strtotime($specificContactUs['created_at']));
                        if ($actualWeek==$weekOfMessageCreated) {
                            $thisWeekContactUs[$contactUsMatches] = $specificContactUs;
                            $contactUsMatches++;
                        }
                    }
                    if (!empty($thisWeekContactUs)) {
                        $totalMessages = count($thisWeekContactUs);
                        $graphData = [0,0,0,0,0,0,0];
                        for ($n=0; $n<7; $n++) {
                            foreach ($thisWeekContactUs as $specificThisWeekCtcUs) {
                                $weekOfMessageCreated = date('w', strtotime($specificThisWeekCtcUs['created_at']));
                                if ($n==((int)$weekOfMessageCreated)) {
                                    $graphData[$n]++;
                                }
                            }
                        }
                        $max = $graphData[0];
                        $min = $graphData[0];
                        foreach ($graphData as $value) {
                            if ($min > $value) {
                                $min = $value;
                            }
                            if ($max < $value) {
                                $max = $value;
                            }
                        }
                        echo json_encode([
                            'status' => 200, //200 = Created
                            'message' => [],
                            'data' => [$totalMessages, $graphData, $max, $min]
                        ]);
                    } else {
                        $totalMessages = 0;
                        $graphData = [0,0,0,0,0,0,0];
                        $max = 0;
                        $min = 0;
                        echo json_encode([
                            'status' => 200, //200 = Created
                            'message' => [],
                            'data' => [$totalMessages, $graphData, $max, $min]
                        ]);
                    }
                } else {
                    $totalMessages = 0;
                    $graphData = [0,0,0,0,0,0,0];
                    $max = 0;
                    $min = 0;
                    echo json_encode([
                        'status' => 200, //200 = Created
                        'message' => [],
                        'data' => [$totalMessages, $graphData, $max, $min]
                    ]);
                }
            } else {
                $hA = new CoreHackAttempt();
                $hA->isHackAttempt("admin_email", "ajaxUpdateWeeklyReceivedMessagesGraph", $this->getUser());
                throw new \Exception("User was scrypting on Draft Media Server");
            }
        }
    }

    /**
     * This method is in charge of retrieving and process the data needed to display the chart of the
     * last week messages that Draft Media Website has attended from the "contact_us" table from the
     * database, but on the current year.
     *
     * @throws \Exception
     *
     * @author Miranda Meza César
     * DATE November 28, 2018
     */
    public function ajaxUpdateWeeklyAttendedMessagesGraphAction()
    {
        if (isset($_GET)) {
            if (isset($_GET["request"])) {
                $cU = new ContactUs();
                $allContactUs = $cU::findAll();
                if ($allContactUs != null) {
                    $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
                    $actualYear = $actualDate->format('Y');
                    $thisYearContactUs = [];
                    $contactUsMatches = 0;
                    foreach ($allContactUs as $specificContactUs) {
                        $yearOfMessageCreated = date('Y', strtotime($specificContactUs['modified_at']));
                        if ($actualYear==$yearOfMessageCreated) {
                            $thisYearContactUs[$contactUsMatches] = $specificContactUs;
                            $contactUsMatches++;
                        }
                    }
                    $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
                    $actualWeek = (int)$actualDate->format('W');
                    $thisWeekContactUs = [];
                    $contactUsMatches = 0;
                    foreach ($thisYearContactUs as $specificContactUs) {
                        $weekOfMessageCreated = (int)date('W', strtotime($specificContactUs['modified_at']));
                        if ($actualWeek==$weekOfMessageCreated) {
                            $thisWeekContactUs[$contactUsMatches] = $specificContactUs;
                            $contactUsMatches++;
                        }
                    }
                    if (!empty($thisWeekContactUs)) {
                        $totalMessages = count($thisWeekContactUs);
                        $graphData = [0,0,0,0,0,0,0];
                        for ($n=0; $n<7; $n++) {
                            foreach ($thisWeekContactUs as $specificThisWeekCtcUs) {
                                $weekOfMessageCreated = date('w', strtotime($specificThisWeekCtcUs['modified_at']));
                                if ($n==((int)$weekOfMessageCreated)) {
                                    $graphData[$n]++;
                                }
                            }
                        }
                        $max = $graphData[0];
                        $min = $graphData[0];
                        foreach ($graphData as $value) {
                            if ($min > $value) {
                                $min = $value;
                            }
                            if ($max < $value) {
                                $max = $value;
                            }
                        }
                        echo json_encode([
                            'status' => 200, //200 = Created
                            'message' => [],
                            'data' => [$totalMessages, $graphData, $max, $min]
                        ]);
                    } else {
                        $totalMessages = 0;
                        $graphData = [0,0,0,0,0,0,0];
                        $max = 0;
                        $min = 0;
                        echo json_encode([
                            'status' => 200, //200 = Created
                            'message' => [],
                            'data' => [$totalMessages, $graphData, $max, $min]
                        ]);
                    }
                } else {
                    $totalMessages = 0;
                    $graphData = [0,0,0,0,0,0,0];
                    $max = 0;
                    $min = 0;
                    echo json_encode([
                        'status' => 200, //200 = Created
                        'message' => [],
                        'data' => [$totalMessages, $graphData, $max, $min]
                    ]);
                }
            } else {
                $hA = new CoreHackAttempt();
                $hA->isHackAttempt("admin_email", "ajaxUpdateWeeklyAttendedMessagesGraph", $this->getUser());
                throw new \Exception("User was scrypting on Draft Media Server");
            }
        }
    }

    /**
     * This method is in charge of retrieving and process the data needed to display the chart of the
     * last week messages that Draft Media Website has received from the "contact_us" table from the
     * database, but on the current year and in average.
     *
     * @throws \Exception
     *
     * @author Miranda Meza César
     * DATE November 28, 2018
     */
    public function ajaxUpdateAvgWeeklyReceivedMessagesGraphAction()
    {
        if (isset($_GET)) {
            if (isset($_GET["request"])) {
                $cU = new ContactUs();
                $allContactUs = $cU::findAll();
                if ($allContactUs != null) {
                    $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
                    $actualYear = $actualDate->format('Y');
                    $thisYearContactUs = [];
                    $contactUsMatches = 0;
                    foreach ($allContactUs as $specificContactUs) {
                        $yearOfMessageCreated = date('Y', strtotime($specificContactUs['created_at']));
                        if ($actualYear==$yearOfMessageCreated) {
                            $thisYearContactUs[$contactUsMatches] = $specificContactUs;
                            $contactUsMatches++;
                        }
                    }
                    if (!empty($thisYearContactUs)) {
                        $graphData = [0,0,0,0,0,0,0];
                        for ($n=0; $n<7; $n++) {
                            foreach ($thisYearContactUs as $specificThisWeekCtcUs) {
                                $weekOfMessageCreated = date('w', strtotime($specificThisWeekCtcUs['created_at']));
                                if ($n==((int)$weekOfMessageCreated)) {
                                    $graphData[$n]++;
                                }
                            }
                        }
                        $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
                        $actualWeek = (int)$actualDate->format('W');
                        $graphData[0] = round($graphData[0]/$actualWeek, 2);
                        $graphData[1] = round($graphData[1]/$actualWeek, 2);
                        $graphData[2] = round($graphData[2]/$actualWeek, 2);
                        $graphData[3] = round($graphData[3]/$actualWeek, 2);
                        $graphData[4] = round($graphData[4]/$actualWeek, 2);
                        $graphData[5] = round($graphData[5]/$actualWeek, 2);
                        $graphData[6] = round($graphData[6]/$actualWeek, 2);
                        $totalMessages = round(($graphData[0]+$graphData[1]+$graphData[2]+$graphData[3]+$graphData[4]+$graphData[5]+$graphData[6])/($actualWeek*7), 2);
                        $max = $graphData[0];
                        $min = $graphData[0];
                        foreach ($graphData as $value) {
                            if ($min > $value) {
                                $min = $value;
                            }
                            if ($max < $value) {
                                $max = $value;
                            }
                        }
                        echo json_encode([
                            'status' => 200, //200 = Created
                            'message' => [],
                            'data' => [$totalMessages, $graphData, $max, $min]
                        ]);
                    } else {
                        $totalMessages = 0;
                        $graphData = [0,0,0,0,0,0,0];
                        $max = 0;
                        $min = 0;
                        echo json_encode([
                            'status' => 200, //200 = Created
                            'message' => [],
                            'data' => [$totalMessages, $graphData, $max, $min]
                        ]);
                    }
                } else {
                    $totalMessages = 0;
                    $graphData = [0,0,0,0,0,0,0];
                    $max = 0;
                    $min = 0;
                    echo json_encode([
                        'status' => 200, //200 = Created
                        'message' => [],
                        'data' => [$totalMessages, $graphData, $max, $min]
                    ]);
                }
            } else {
                $hA = new CoreHackAttempt();
                $hA->isHackAttempt("admin_email", "ajaxUpdateAvgWeeklyReceivedMessagesGraph", $this->getUser());
                throw new \Exception("User was scrypting on Draft Media Server");
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
     * @throws \Exception
     *
     * @author Miranda Meza César
     * DATE November 27, 2018
     */
    public function indexAction()
    {
        $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
        $actualYear = $actualDate->format('Y');

        // We get all the users that are actually visiting the page at the moment
        $dmVisitors = new DraftmediaVisitors();
        $allVisitors = $dmVisitors::findAll();
        $users = new Users();
        $allUsers = $users::findBy(["status" => "ACTIVE"]);
        if ($allUsers != null) {
            $admin_ids = [];
            $adminIdsMatches = 0;
            foreach ($allUsers as $specificUser) {
                if ($specificUser['role'] == 'admin') {
                    $admin_ids[$adminIdsMatches] = $specificUser['id'];
                    $adminIdsMatches++;
                }
            }
            if ($allVisitors != null) {
                $trueAllVisitors = [];
                $trueVisitorsMatches = 0;
                foreach ($allVisitors as $specificVisitor) {
                    $isAdmin = false;
                    foreach ($admin_ids as $admin_id) {
                        if ($specificVisitor['user_id'] == $admin_id) {
                            $isAdmin = true;
                            break;
                        }
                    }
                    if (!$isAdmin) {
                        $trueAllVisitors[$trueVisitorsMatches] = $specificVisitor;
                        $trueVisitorsMatches++;
                    }
                }
                if ($trueAllVisitors != null) {
                    $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
                    $actualDateTime = strtotime($actualDate->format('Y-m-d H:i:s'));
                    $usersOnline = 0;
                    foreach ($trueAllVisitors as $specificVisitor) {
                        $lastActivityTime = strtotime($specificVisitor['last_activity_at']);
                        if (($actualDateTime-$lastActivityTime) <= 300) {
                            $usersOnline++;
                        }
                    }
                } else {
                    $usersOnline = 0;
                }
            } else {
                $usersOnline = 0;
            }
        } else {
            $usersOnline = 0;
        }

        // We get all the authenticated users that are actually visiting the page at the moment
        $visitors = new Visitors();
        $dmVisits = new DraftmediaVisits();
        $authUsersOnline = 0;
        while (true) {
            if ($visitors->isDraftmediaVisitsEnabled()) {
                $visitors->checkDraftmediaDate();
                $draftmediaVisits = $dmVisits::findAll();
                $n = count($draftmediaVisits)-1;
                $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
                $actualDateTime = strtotime($actualDate->format('Y-m-d H:i:s'));
                if ($allUsers != null) {
                    foreach ($allUsers as $specificUser) {
                        $lastActivityTime = strtotime($specificUser['last_activity_at']);
                        if ($specificUser['role'] != 'admin') {
                            if (($actualDateTime-$lastActivityTime) <= 300) {
                                $authUsersOnline++;
                            }
                        }
                    }
                    if ($authUsersOnline > $draftmediaVisits[$n]['max_users_online']) {
                        $draftmediaVisits[$n]['max_users_online'] = $authUsersOnline;
                    }
                    $draftmediaVisits[$n]['current_users_online'] = $authUsersOnline;
                    $dmVisits::persistAndFlush($draftmediaVisits[$n]);
                }
                break;
            }
        }

        // We get all the total number of sessions made on the website
        $allDraftmediaVisits = $dmVisits::findAll();
        $numberOfSessions = 0;
        if ($allDraftmediaVisits != null) {
            foreach ($allDraftmediaVisits as $specificDraftMediaVisit) {
                $numberOfSessions += $specificDraftMediaVisit['number_of_sessions'];
            }
        }

        // We get all the sessions made per user
        $usersThatMadeSession = 0;
        if ($allUsers != null) {
            foreach ($allUsers as $specificUser) {
                if ($specificUser['role']!='admin') {
                    $usersThatMadeSession++;
                }
            }
            $sessionsPerUser = $numberOfSessions/$usersThatMadeSession;
        } else {
            $sessionsPerUser = 0;
        }


        // We get the average duration per session
        if ($allDraftmediaVisits != null) {
            $totalDurationOfAllSessions = 0;
            foreach ($allDraftmediaVisits as $specificDraftMediaVisit) {
                $totalDurationOfAllSessions += $specificDraftMediaVisit['Aboutus_index_auth_time'];
                $totalDurationOfAllSessions += $specificDraftMediaVisit['CompanyPolitics_privacyPolitics_auth_time'];
                $totalDurationOfAllSessions += $specificDraftMediaVisit['CompanyPolitics_termsAndConditions_auth_time'];
                $totalDurationOfAllSessions += $specificDraftMediaVisit['Dea_uploadFiles_auth_time'];
                $totalDurationOfAllSessions += $specificDraftMediaVisit['Dea_index_auth_time'];
                $totalDurationOfAllSessions += $specificDraftMediaVisit['Home_index_auth_time'];
                $totalDurationOfAllSessions += $specificDraftMediaVisit['Login_index_auth_time'];
                $totalDurationOfAllSessions += $specificDraftMediaVisit['Pricing_index_auth_time'];
                $totalDurationOfAllSessions += $specificDraftMediaVisit['Register_index_auth_time'];
                $totalDurationOfAllSessions += $specificDraftMediaVisit['Services_index_auth_time'];
                $totalDurationOfAllSessions += $specificDraftMediaVisit['UserProfile_index_auth_time'];
                $totalDurationOfAllSessions += $specificDraftMediaVisit['UserRequests_index_auth_time'];
            }
            $durationPerSession = $totalDurationOfAllSessions/$numberOfSessions;
        } else {
            $durationPerSession = 0;
        }

        // We get the total number of visits to the pages of the website
        $numberOfViewsToPagesByAnonym = 0;
        $numberOfViewsToPagesByAuth = 0;
        if ($allDraftmediaVisits != null) {
            foreach ($allDraftmediaVisits as $specificDraftMediaVisit) {
                $numberOfViewsToPagesByAnonym += $specificDraftMediaVisit['Aboutus_index_anonym_visits'];
                $numberOfViewsToPagesByAnonym += $specificDraftMediaVisit['CompanyPolitics_privacyPolitics_anonym_visits'];
                $numberOfViewsToPagesByAnonym += $specificDraftMediaVisit['CompanyPolitics_termsAndConditions_anonym_visits'];
                $numberOfViewsToPagesByAnonym += $specificDraftMediaVisit['Dea_uploadFiles_anonym_visits'];
                $numberOfViewsToPagesByAnonym += $specificDraftMediaVisit['Dea_index_anonym_visits'];
                $numberOfViewsToPagesByAnonym += $specificDraftMediaVisit['Home_index_anonym_visits'];
                $numberOfViewsToPagesByAnonym += $specificDraftMediaVisit['Login_index_anonym_visits'];
                $numberOfViewsToPagesByAnonym += $specificDraftMediaVisit['Pricing_index_anonym_visits'];
                $numberOfViewsToPagesByAnonym += $specificDraftMediaVisit['Register_index_anonym_visits'];
                $numberOfViewsToPagesByAnonym += $specificDraftMediaVisit['Services_index_anonym_visits'];
                $numberOfViewsToPagesByAnonym += $specificDraftMediaVisit['UserProfile_index_anonym_visits'];
                $numberOfViewsToPagesByAnonym += $specificDraftMediaVisit['UserRequests_index_anonym_visits'];

                $numberOfViewsToPagesByAuth += $specificDraftMediaVisit['Aboutus_index_auth_visits'];
                $numberOfViewsToPagesByAuth += $specificDraftMediaVisit['CompanyPolitics_privacyPolitics_auth_visits'];
                $numberOfViewsToPagesByAuth += $specificDraftMediaVisit['CompanyPolitics_termsAndConditions_auth_visits'];
                $numberOfViewsToPagesByAuth += $specificDraftMediaVisit['Dea_uploadFiles_auth_visits'];
                $numberOfViewsToPagesByAuth += $specificDraftMediaVisit['Dea_index_auth_visits'];
                $numberOfViewsToPagesByAuth += $specificDraftMediaVisit['Home_index_auth_visits'];
                $numberOfViewsToPagesByAuth += $specificDraftMediaVisit['Login_index_auth_visits'];
                $numberOfViewsToPagesByAuth += $specificDraftMediaVisit['Pricing_index_auth_visits'];
                $numberOfViewsToPagesByAuth += $specificDraftMediaVisit['Register_index_auth_visits'];
                $numberOfViewsToPagesByAuth += $specificDraftMediaVisit['Services_index_auth_visits'];
                $numberOfViewsToPagesByAuth += $specificDraftMediaVisit['UserProfile_index_auth_visits'];
                $numberOfViewsToPagesByAuth += $specificDraftMediaVisit['UserRequests_index_auth_visits'];
            }
            $totalNumberOfViewsToPages = $numberOfViewsToPagesByAnonym + $numberOfViewsToPagesByAuth;
        } else {
            $totalNumberOfViewsToPages = 0;
        }

        // We get the viewed pages per session
        if ($numberOfSessions != 0) {
            $viewsPerSession = $numberOfViewsToPagesByAuth/$numberOfSessions;
        } else {
            $viewsPerSession = 0;
        }

        // We get the pages viewed per visitor
        if ($allVisitors!=null) {
            $pagesViewedPerVisitor = $totalNumberOfViewsToPages/count($allVisitors);
        } else {
            $pagesViewedPerVisitor = 0;
        }

        // We get the total number of visitors that the website has had
        if ($allUsers!=null && $allVisitors!=null && $trueAllVisitors!=null) {
            $totalVisitors = count($trueAllVisitors);
        } else {
            $totalVisitors = 0;
        }

        //We get the average duration per visitor
        if ($allDraftmediaVisits != null && $allUsers!=null && $allVisitors!=null && $trueAllVisitors!=null && $totalVisitors!=0) {
            $totalDurationOfAnonymVisitor = 0;
            foreach ($allDraftmediaVisits as $specificDraftMediaVisit) {
                $totalDurationOfAnonymVisitor += $specificDraftMediaVisit['Aboutus_index_anonym_time'];
                $totalDurationOfAnonymVisitor += $specificDraftMediaVisit['CompanyPolitics_privacyPolitics_anonym_time'];
                $totalDurationOfAnonymVisitor += $specificDraftMediaVisit['CompanyPolitics_termsAndConditions_anonym_time'];
                $totalDurationOfAnonymVisitor += $specificDraftMediaVisit['Dea_uploadFiles_anonym_time'];
                $totalDurationOfAnonymVisitor += $specificDraftMediaVisit['Dea_index_anonym_time'];
                $totalDurationOfAnonymVisitor += $specificDraftMediaVisit['Home_index_anonym_time'];
                $totalDurationOfAnonymVisitor += $specificDraftMediaVisit['Login_index_anonym_time'];
                $totalDurationOfAnonymVisitor += $specificDraftMediaVisit['Pricing_index_anonym_time'];
                $totalDurationOfAnonymVisitor += $specificDraftMediaVisit['Register_index_anonym_time'];
                $totalDurationOfAnonymVisitor += $specificDraftMediaVisit['Services_index_anonym_time'];
                $totalDurationOfAnonymVisitor += $specificDraftMediaVisit['UserProfile_index_anonym_time'];
                $totalDurationOfAnonymVisitor += $specificDraftMediaVisit['UserRequests_index_anonym_time'];
            }
            $durationPerVisitor = ($durationPerSession+$totalDurationOfAnonymVisitor)/$totalVisitors;
        } else {
            $durationPerVisitor = 0;
        }

        // We get the total number of user accounts that the website has
        $numberOfUserAccounts = 0;
        if ($allUsers != null) {
            foreach ($allUsers as $specificUser) {
                if ($specificUser['role'] != 'admin') {
                    $numberOfUserAccounts++;
                }
            }
        }

        // We get the porcentage of new visitors (criteria of 30 days)
        $porcentageOfNewVisitors = 0;
        if ($allUsers!=null && $allVisitors!=null && $trueAllVisitors!=null) {
            $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
            $actualDateTime = strtotime($actualDate->format('Y-m-d H:i:s'));
            foreach ($trueAllVisitors as $specificTrueVisitor) {
                $createdAtTime = strtotime($specificTrueVisitor['created_at']);
                if (($actualDateTime-$createdAtTime) < 2592000) {
                    $porcentageOfNewVisitors++;
                }
            }
            $porcentageOfNewVisitors = $porcentageOfNewVisitors/count($trueAllVisitors)*100;
        }

        // We get the porcentage of returning visitors
        $porcentageOfReturningVisitors = 0;
        if ($allUsers!=null && $allVisitors!=null && $trueAllVisitors!=null) {
            $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
            $actualDateTime = strtotime($actualDate->format('Y-m-d H:i:s'));
            foreach ($trueAllVisitors as $specificTrueVisitor) {
                $lastActivityTime = strtotime($specificTrueVisitor['last_activity_at']);
                $createdAtTime = strtotime($specificTrueVisitor['created_at']);
                if ((($actualDateTime-$lastActivityTime) < 2592000) && (($actualDateTime-$createdAtTime) > 2592000)) {
                    $porcentageOfReturningVisitors++;
                }
            }
            $porcentageOfReturningVisitors = $porcentageOfReturningVisitors/count($trueAllVisitors)*100;
        }






        // We pass on to variable "HTML" the table with the content of the messages of "contact_us" table form db
        //$HTML ='';




        View::renderTemplate('Admin/Clients/index.html.twig', [
            "usersOnline" => $usersOnline,
            "authUsersOnline" => $authUsersOnline,
            "totalVisitors" => $totalVisitors,
            "numberOfUserAccounts" => $numberOfUserAccounts,
            "porcentageOfNewVisitors" => round($porcentageOfNewVisitors, 2),
            "porcentageOfReturningVisitors" => round($porcentageOfReturningVisitors, 2),
            "sessionsPerUser" => round($sessionsPerUser, 2),
            "durationPerSession" => round($durationPerSession, 2),
            "durationPerVisitor" => round($durationPerVisitor, 2),
            "totalNumberOfViewsToPages" => $totalNumberOfViewsToPages,
            "viewsPerSession" => round($viewsPerSession, 2),
            "pagesViewedPerVisitor" => round($pagesViewedPerVisitor, 2),
            "actualYear" => $actualYear
        ]);
    }
}
