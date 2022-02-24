<?php

namespace App\Controllers;

use App\Config;
use App\Models\ContactUs;
use App\Models\DraftmediaVisits;
use App\Models\Users;
use Core\CoreHackAttempt;
use Core\Ddos;
use \Core\View;
use Core\Visitors;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * Home controller
 *
 * PHP version 5.4
 */
class Home extends \Core\Controller
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
                $hA->isHackAttempt("home", "before", $user);
            } catch (\Exception $e) {
                $hA->isHackAttempt("home", "before", "");
            }
            throw new \Exception("A DDoS hack attack has been detected.");
        }

        //If current URL is HTTP, then re-direct it to HTTPS
        if (!Config::APP_ENV) {
            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") {
            } else {
                header('Location: '.Config::APP_PROD_URL);
            }
        }

        // Call once getUser method just to make the user go through credentials validations and through
        // a hack-attempt validation aswell. If nothing goes wrong, then the user hasn't tried anything
        // he shoulnd't and he can proceed. Otherwise he won't be able to.
        $xx = $this->getUser();

        // If user has a session, we then update the date of the last activity of the user and his
        // session_key if needed
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


    public function ajaxContactUsAction() {
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
                $hA->isHackAttempt("home", "ajaxContactUs", $this->getUser());
                throw new \Exception("User was scrypting on Draft Media Server. Language value couldn't be identified.");
            }
        } else {
            $language = 'english';
        }

        $errors = '';
        // ----------------------------------------------------- //
        // ----- SANITIZE AND VALIDATION OF REGISTER FORM  ----- //
        // ----------------------------------------------------- //
        if (isset($_POST)) {
            $name = $_POST['name_input'];
            $email = $_POST['email_input'];
            $message = $_POST['message_input'];

            // ----- User's name sanitize and validation ----- //
            if (!empty($name)) {
                $name = filter_var($name, FILTER_SANITIZE_STRING);
                $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
                $name = strtolower($name);
                $name = str_replace(' ', ' ', ucwords(str_replace('-', ' ', $name)));
            } else {
                if ($language=='spanish') {
                    $errors .= 'Porfavor agrega tu(s) nombre(s).' . '<br>';
                }
                if ($language=='english') {
                    $errors .= 'Please add your name(s).' . '<br>';
                }
            }

            // ----- User's email sanitize and validation ----- //
            if (!empty($email)) {
                $email = filter_var($email, FILTER_SANITIZE_EMAIL);
                if (filter_var($email, FILTER_VALIDATE_EMAIL) != false) {
                    $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
                } else {
                    if ($language=='spanish') {
                        $errors .= 'Porfavor agrega un correo electrónico valido.' . '<br>';
                    }
                    if ($language=='english') {
                        $errors .= 'Please add a valid email' . '<br>';
                    }
                }
            } else {
                if ($language=='spanish') {
                    $errors .= 'Porfavor agrega tu correo electrónico.' . '<br>';
                }
                if ($language=='english') {
                    $errors .= 'Please add your email' . '<br>';
                }
            }

            // ----- User's message sanitize and validation ----- //
            if (!empty($message)) {
                $message = filter_var($message, FILTER_SANITIZE_STRING);
                $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
                $message = strtolower($message);
                $message = str_replace(' ', ' ', ucwords(str_replace('-', ' ', $message)));
            } else {
                if ($language=='spanish') {
                    $errors .= 'Porfavor agrega tu mensaje' . '<br>';
                }
                if ($language=='english') {
                    $errors .= 'Please add your message.' . '<br>';
                }
            }

            // --------------------------------------------------------------------------------- //
            // ----- Server response with regard of the ContactUs Modal Validation process ----- //
            // --------------------------------------------------------------------------------- //
            if ($errors === '') {
                $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));

                // ----- We save the record of the contactUs on the database ----- //
                $contactUs = new ContactUs();
                $contactUs->setName($name);
                $contactUs->setEmail($email);
                $contactUs->setMessage($message);
                $contactUs->setIsAttended(0);
                $contactUs->setStatus("ACTIVE");
                $user = $this->getUser();
                if ($user != null) {
                    $user_id = $user["id"];
                } else {
                    $user_id = "";
                }
                $contactUs->setCreatedBy($user_id);
                $contactUs->setCreatedAt($actualDate->format('Y-m-d H:i:s'));
                $contactUs::persistAndFlush($contactUs);

                // ----- We send an email to the administrators of DraftMedia to let them know about the msg ----- //
                if (!Config::APP_ENV) {
                    $users = new Users();
                    $allUsers = $users::findBy(["status" => "ACTIVE"]);
                    if ($allUsers != null) {
                        $adminUsers = [];
                        $specificUsersMatched = 0;
                        foreach ($allUsers as $specificUser) {
                            if ($specificUser['role'] == 'admin') {
                                $adminUsers[$specificUsersMatched] = $specificUser;
                                $specificUsersMatched++;
                            }
                        }
                        if (!empty($adminUsers)) {
                            foreach ($adminUsers as $specificAdmin) {
                                $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
                                try {
                                    //Server settings
                                    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
                                    $mail->isSMTP();                                      // Set mailer to use SMTP
                                    $mail->Host = Config::HOSTGATOR_HOST;                 // Specify main and backup SMTP servers
                                    $mail->SMTPAuth = true;                               // Enable SMTP authentication
                                    $mail->Username = Config::HOSTGATOR_SMTP_USERNAME;    // SMTP username
                                    $mail->Password = Config::HOSTGATOR_SMTP_PASSWORD;    // SMTP password
                                    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
                                    $mail->Port = Config::HOSTGATOR_PORT;                 // TCP port to connect to

                                    //Recipients
                                    $mail->setFrom(Config::HOSTGATOR_SMTP_USERNAME, 'Draft Media');
                                    $mail->addReplyTo(Config::HOSTGATOR_SMTP_USERNAME, 'Draft Media');
                                    $mail->addAddress($specificAdmin['email']);// Who to

                                    //Content
                                    $mail->isHTML(true);                                  // Set email format to HTML
                                    $mail->Subject = 'Draft Media Admin Panel - A Contact Us request has been made by '.$name; //El subject no agarra acentos
                                    $preparedMessage ='
                                    <html>
                                        <body>
                                          <p>De: '.$email.'</p>
                                          <p>Un usuario, con nombre de '.$name.', ha solicitado contactarse con Draft Media. Su mensaje es el siguiente:</p>
                                          <p>ENCRYPTED MESSAGE (See message on admin dashboard)</p>
                                          <br><br>
                                          <p>Se requiere que algún administrador revise este mensaje y responda como corresponda.</p>
                                        </body>
                                    </html>
                                    ';
                                    $mail->Body    = $preparedMessage;

                                    if(!$mail->Send()) {
                                        throw new \Exception("An error ocurred while trying to send an email to the user: $mail->ErrorInfo");
                                    }
                                } catch (\Exception $e) {
                                    throw new \Exception("An error ocurred while trying to send an email to the user: $mail->ErrorInfo");
                                }
                            }
                        } else {
                            throw new \Exception("There isn't anyone designated as administrator on DraftMedia");
                        }
                    } else {
                        throw new \Exception("There isn't anyone designated as administrator on DraftMedia");
                    }
                }
                $messageResponse = "Your message has been sent successfully. Draft Media's staff will review it and will contact you soon.";
                if ($language=='spanish') {
                    $messageResponse = "Tu mensaje ha sido enviado satisfactoriamente. El personal de Draft Media lo revisará y te contactará pronto.";
                }
                echo json_encode([
                    'status' => 200, //200 = Created
                    'message' => $messageResponse,
                    'data' => []
                ]);
            } else {
                //header($errors, true, 400);
                echo json_encode([
                    'status' => 400, //400=Bad Request
                    'message' => $errors,
                    'data' => []
                ]);
            }
        }
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
    public function ajaxHomeIndexVisitsAction() {
        $visitors = new Visitors();
        if ($visitors->isDraftmediaVisitsEnabled()) {
            $x = $visitors->isVisit($this->getUser());
            $visitors->checkDraftmediaDate();
            if (isset($_SESSION["user"]) || isset($_SESSION["key"])) {
                $user = $this->getUser();
                $DMV = new DraftmediaVisits();
                $draftmediaVisits = $DMV::findAll();
                $n = count($draftmediaVisits)-1;
                if ($user['role'] != 'admin') {
                    // If user has an active session, then count an authenticated visit
                    $draftmediaVisits[$n]['Home_index_auth_visits']++;
                    $DMV::persistAndFlush($draftmediaVisits[$n]);
                }
            } else {
                //else, count an anonymous visit
                $DMV = new DraftmediaVisits();
                $draftmediaVisits = $DMV::findAll();
                $n = count($draftmediaVisits)-1;
                $draftmediaVisits[$n]['Home_index_anonym_visits']++;
                $DMV::persistAndFlush($draftmediaVisits[$n]);
            }

            // We update the current online users on the website and the maximum users that the
            // website had online for a certain amount of time (periodically).
            $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
            $actualDateTime = strtotime($actualDate->format('Y-m-d H:i:s'));
            $users = new Users();
            $allUsers = $users::findBy(["status" => "ACTIVE"]);
            if ($allUsers != null) {
                $usersOnline = 0;
                foreach ($allUsers as $specificUser) {
                    $lastActivityTime = strtotime($specificUser['last_activity_at']);
                    if ($specificUser['role'] != 'admin') {
                        if (($actualDateTime-$lastActivityTime) <= 300) {
                            $usersOnline++;
                        }
                    }
                }
                if ($usersOnline > $draftmediaVisits[$n]['max_users_online']) {
                    $draftmediaVisits[$n]['max_users_online'] = $usersOnline;
                }
                $draftmediaVisits[$n]['current_users_online'] = $usersOnline;
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
    public function ajaxHomeIndexTimeAction() {
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
                        $draftmediaVisits[$n]['Home_index_auth_time']++;
                    }
                    $DMV::persistAndFlush($draftmediaVisits[$n]);
                }
            } else {
                //else, count as anonymous time
                $DMV = new DraftmediaVisits();
                $draftmediaVisits = $DMV::findAll();
                $n = count($draftmediaVisits)-1;
                for ($i=0; $i<5; $i++) {
                    $draftmediaVisits[$n]['Home_index_anonym_time']++;
                }
                $DMV::persistAndFlush($draftmediaVisits[$n]);
            }
        }
    }

    public function ajaxLanguageSelectionAction()
    {
        $errors = '';
        // --------------------------------------------------------- //
        // ----- SANITIZE AND VALIDATION OF LAGUAGE SELECTION  ----- //
        // --------------------------------------------------------- //
        if (isset($_POST)) {
            $language = $_POST['language'];
            // ----- Language sanitize and validation ----- //
            if (!empty($language)) {
                $language = filter_var($language, FILTER_SANITIZE_STRING);
                $language = htmlspecialchars($language, ENT_QUOTES, 'UTF-8');
                $language = strtolower($language);
            } else {
                $errors = "Language selected is null.";
            }

            // -------------------------------------------------------------------------- //
            // ----- Server response with regard of the Language Validation process ----- //
            // -------------------------------------------------------------------------- //
            if ($errors === '') {
                if ($language=='english' || $language=='spanish') {
                    if (isset($_COOKIE["1D5M9_7L5a3n0"])) {
                        setcookie("1D5M9_7L5a3n0",'',time()- (365 * 24 * 60 * 60), '/');
                    }
                    setcookie("1D5M9_7L5a3n0",$language,time()+ (365 * 24 * 60 * 60), '/');
                    echo json_encode([
                        'status' => 200, //200 = Created
                        'message' => "El cambio de lenguaje se efectuó exitosamente.",
                        'data' => []
                    ]);
                } else {
                    $hA = new CoreHackAttempt();
                    $hA->isHackAttempt("home", "ajaxLanguageSelection", $this->getUser());
                    throw new \Exception("User was scrypting on Draft Media Server");
                }
            } else {
                throw new \Exception($errors);
            }
        }
    }

    /**
     * Show the Home page of the entire website.
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
                $hA->isHackAttempt("home", "index", $this->getUser());
                throw new \Exception("User was scrypting on Draft Media Server. Language value couldn't be identified.");
            }
        } else {
            $language = 'english';
        }

        // We render the corresponding view and we send to it the variables needed within the view template.
        $user = $this->getUser();
        if ($user != null) {
            $user_firstname = $user["first_name"];
        } else {
            $user_firstname = "";
        }
        View::renderTemplate('Home/index.html.twig', [
            'isUserLoggedIn' => (isset($_SESSION["user"]) || isset($_SESSION["key"])),
            'user_firstname' => $user_firstname,
            'language' => $language
        ]);
    }
}
