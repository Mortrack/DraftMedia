<?php

namespace App\Controllers\Admin;

use App\Config;
use App\Models\ContactUs;
use App\Models\Users;
use Core\CoreHackAttempt;
use Core\Ddos;
use \Core\View;

/**
 * Summary controller
 *
 * PHP version 5.4
 */
class Email extends \Core\Controller
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
        // We get the data to create the "contact_us" messages table on the view
        $cU = new ContactUs();
        $messages = $cU::findBy(["status" => "ACTIVE"]);
        $numberOfMessages = count($messages);

        // We pass on to variable "HTML" the table with the content of the messages of "contact_us" table form db
        $HTML ='';
        if ($messages != null) {
            //But let's first update the status values for all the messages
            for ($n=0; $n<$numberOfMessages; $n++) {
                if (($messages[$n]['is_attended'] == 1)) {
                    $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
                    $actualDateTime = strtotime($actualDate->format('Y-m-d H:i:s'));
                    $modifiedDateTime = strtotime($messages[$n]['modified_at']);
                    if (($actualDateTime-$modifiedDateTime) > 604800) {
                        $messages[$n]['status'] = 'DELETED';
                        $messages[$n]['deleted_by'] = 'DraftMedia Web API';
                        $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
                        $messages[$n]['deleted_at'] = $actualDate->format('Y-m-d H:i:s');
                        $cU::persistAndFlush($messages[$n]);
                    }
                }
            }

            //Lets now create the HTML of the messages of "contact_us" table
            $messages = $cU::findBy(["status" => "ACTIVE"]);
            $numberOfMessages = count($messages);
            for ($n=$numberOfMessages-1; $n>=0; $n--) {
                $isAttended = false;
                if ($messages[$n]['is_attended'] == 1) {
                    $isAttended = true;
                }
                $HTML .=
                    '
                    <tr id="'. $messages[$n]['id'] .'">
                        <td>
                            <div class="form-check">
                                <label class="form-check-label">
                    ';
                if ($isAttended) {
                    $HTML .=
                        '
                                <input class="form-check-input contactUs_isAttended" type="checkbox" value="" checked>
                        ';
                } else {
                    $HTML .=
                        '
                                <input class="form-check-input contactUs_isAttended" type="checkbox" value="">
                        ';
                }
                $HTML .=
                    '
                               <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                        </td>
                        <td>'.$messages[$n]['created_at'].'</td>
                        <td>
                            <p class="title"><a href="#" class="dB-tool readContactUsMessage">'.$messages[$n]['name'].' --- '.$messages[$n]['email'].'</a></p>
                            <p class="text-muted contactUsMessage">'.$messages[$n]['message'].'</p>
                        </td>
                        <!--
                        <td class="td-actions">
                            <button type="button" rel="tooltip" class="btn btn-danger btn-sm btn-icon rowDelete-btn">
                                <i class="tim-icons icon-simple-remove"></i>
                            </button>
                        </td>
                        -->
                    </tr>
                    ';

            }
        }

        $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
        $actualYear = $actualDate->format('Y');

        View::renderTemplate('Admin/Email/index.html.twig', [
            "actualYear" => $actualYear,
            "numberOfMessages" => $numberOfMessages,
            "HTML" => $HTML
        ]);
    }
}
