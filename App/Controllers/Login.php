<?php

namespace App\Controllers;     //The namespace must match the father directory oh the .php file were it will be used

use App\Config;
use App\Models\DraftmediaVisits;
use App\Models\SessionKeys;
use App\Models\Users;
use \Core\Aes;
use Core\CoreHackAttempt;
use Core\Ddos;
use Core\UserLocation;
use \Core\View;
use Core\Visitors;

/**
 * Home controller
 *
 * PHP version 5.4
 */
class Login extends \Core\Controller
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
                $hA->isHackAttempt("login", "before", $user);
            } catch (\Exception $e) {
                $hA->isHackAttempt("login", "before", "");
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
     * This method is in charge of receiving the data from the login form that the user submits to be able to log in.
     * Also, this method will validate that data and if any error occurs while its validation, JSON will be echo'ed so
     * that Javascript reads it and displays the corresponding error message. But if everything goes ok, then the user
     * will be granted to start a session with the web page.
     * On the other hand, if the user happens to already be logged in, then he will be re-directed to the home page.
     *
     * RETURNS JsonResponse
     *
     * @author Miranda Meza César
     * DATE November 28, 2018
     */
    public function ajaxLoginAction()
    {
        //TODO: Falta implementar registro de HackAttempts
        //TODO: Mejorar sistema con https://www.owasp.org/index.php/Session_Management_Cheat_Sheet
        //TODO: Mejorar sistema con https://www.owasp.org/index.php/Authentication_Cheat_Sheet
        // If user has an active session, then redirect to home.
        if (isset($_SESSION["user"]) || isset($_SESSION["key"])) {
            //user loged in
            if (Config::APP_ENV) {
                header("LOCATION: " . Config::APP_DEV_URL);
            } else {
                header("LOCATION: " . Config::APP_PROD_URL);
            }
        }

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
                $hA->isHackAttempt("login", "ajaxLogin", $this->getUser());
                throw new \Exception("User was scrypting on Draft Media Server. Language value couldn't be identified.");
            }
        } else {
            $language = 'english';
        }

        // If a log in has been requested, then validate the data and if data is correct, start session. Else send error
        if (isset($_POST)) {
            $email = filter_var($_POST['email_input'], FILTER_SANITIZE_EMAIL);
            $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
            $password = htmlspecialchars($_POST['password_input'], ENT_QUOTES, 'UTF-8');
            $errors = '';
            if(empty($email) || empty($password))
            {
                if ($language=='spanish') {
                    $errors .= '<li>Porfavor ingresa tu correo y contraseña</li>';
                }
                if ($language=='english') {
                    $errors .= '<li>Please enter your email and password</li>';
                }
            } else {
                $users = new Users();
                $accountsExists = $users->findBy(["email"=>$email]);
                // ----- We validate if the account's actual status (active/delete) or if it exists ----- //
                $isAccountActivated = false;
                foreach ($accountsExists as $accountExists) {
                    if ($accountsExists==null || $accountExists["status"]=='DELETED') {
                        $isAccountActivated = false;
                    } else {
                        $isAccountActivated = true;
                        $user = $accountExists;
                        break;
                    }
                }
                // ----- If account exists and is active, validate credentials ----- //
                if ($isAccountActivated == true) {
                    if (!empty($user)) {
                        $inputMessage = $user["password"];
                        $inputKey = Config::AES_INPUT_KEY;
                        $blockSize = '256';
                        $aes = new Aes($inputMessage, $inputKey, $blockSize);
                        $decrypt = $aes->decrypt();
                        if (!password_verify($password, $decrypt)) {
                            if ($language=='spanish') {
                                $errors .= '<li>El correo y/o contraseña que ingresaste no son correctos</li>';
                            }
                            if ($language=='english') {
                                $errors .= '<li>The email and/or password that you entered are not correct</li>';
                            }
                        }
                    } else {
                        if ($language=='spanish') {
                            $errors .= '<li>El correo y/o contraseña que ingresaste no son correctos</li>';
                        }
                        if ($language=='english') {
                            $errors .= '<li>The email and/or password that you entered are not correct</li>';
                        }
                    }
                } else {
                    if ($language=='spanish') {
                        $errors .= '<li>El correo y/o contraseña que ingresaste no son correctos</li>';
                    }
                    if ($language=='english') {
                        $errors .= '<li>The email and/or password that you entered are not correct</li>';
                    }
                }
            }

            // if there aren't errors, then start a session for the user. Otherwise, send a JSON with the error(s)
            if ($errors == '') {

                // We generate the unique key for this session
                $isSessionKeyUnique = false;
                $sessionKeys = new SessionKeys();
                $allSessionKeys = $sessionKeys::findAll();
                while (!$isSessionKeyUnique) {
                    $options = [
                        'cost' => 13,
                    ];
                    $randomString = uniqid(mt_rand(0, 1000000));
                    $randomStringHashed = password_hash($randomString, PASSWORD_BCRYPT, $options);
                    $inputMessage = $randomStringHashed;
                    $inputKey = Config::AES_INPUT_KEY;
                    $blockSize = '256';
                    $aes = new Aes($inputMessage, $inputKey, $blockSize);
                    $encrypt = $aes->encrypt();
                    $session_key = $encrypt;
                    $isSessionKeyUnique = true;
                    foreach ($allSessionKeys as $existingKey) {
                        if ($session_key == $existingKey['session_key']) {
                            $isSessionKeyUnique = false;
                        }
                    }
                }
                $sessionKey = $sessionKeys::findBy(["user_id"=>$user["id"]]);
                $visitors = new Visitors();
                $browser = $visitors->getUserBrowser();
                if ($browser == false) {
                    $browser = '';
                }
                if ($sessionKey!=null) {
                    $sessionKeyIsMatch = false;
                    for ($sessionMatches=0; $sessionMatches<count($sessionKey); $sessionMatches++) {
                        if ($sessionKey[$sessionMatches]['browser'] == $browser) {
                            $sessionKey = $sessionKey[$sessionMatches];
                            $sessionKeyIsMatch = true;
                            break;
                        }
                    }
                    if ($sessionKeyIsMatch) {
                        $sessionKey['session_key'] = $session_key;
                    } else {
                        $sessionKey = [];
                        $sessionKey['id'] = null;
                        $sessionKey['user_id'] = $user["id"];
                        $sessionKey['session_key'] = $session_key;
                        $sessionKey['browser'] = $browser;
                    }
                } else {
                    $sessionKey['id'] = null;
                    $sessionKey['user_id'] = $user["id"];
                    $sessionKey['session_key'] = $session_key;
                    $sessionKey['browser'] = $browser;
                }
                $uL = new UserLocation();
                $sessionKey['ip'] = $uL->getUserRealIpAddress();
                $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
                $actualDateTime = strtotime($actualDate->format('Y-m-d H:i:s'));
                $expirationDateTime = $actualDateTime + 1*60*60;
                $expirationDate = date('Y-m-d H:i:s', $expirationDateTime);
                $expirationDateObject = new \dateTime($expirationDate, new \dateTimeZone('America/Los_Angeles'));
                $sessionKey['expiration_at'] = $expirationDateObject->format('Y-m-d H:i:s');
                $sessionKeys::persistAndFlush($sessionKey);

                // We define the date of this last session start and we update the database with this new data
                $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
                $user["connected_at"] = $actualDate->format('Y-m-d H:i:s');
                $users::persistAndFlush($user);

                // We start the session
                $inputMessage = $user["id"];
                $inputKey = Config::AES_INPUT_KEY;
                $blockSize = '256';
                $aes = new Aes($inputMessage, $inputKey, $blockSize);
                $encrypt = $aes->encrypt();
                $user_id = $encrypt;
                $_SESSION['user'] = $user_id;
                // We start the session
                $inputMessage = $randomString;
                $inputKey = Config::AES_INPUT_KEY;
                $blockSize = '256';
                $aes = new Aes($inputMessage, $inputKey, $blockSize);
                $encrypt = $aes->encrypt();
                $randomStringEncrypted = $encrypt;
                $_SESSION["key"] = $randomStringEncrypted;

                // We Create a cookie on the user's device with his credentials only if he checked the "remember me" box
                $rememberMe = filter_var($_POST["rememberMe_checkbox"], FILTER_SANITIZE_STRING);
                $rememberMe = htmlspecialchars($rememberMe, ENT_QUOTES, 'UTF-8');
                if ($rememberMe == "true") {
                    if (isset($_COOKIE["1D0u3M6l5e_615m3U0d1"])) {
                        setcookie("1D0u3M6l5e_615m3U0d1",'',time()- (365 * 24 * 60 * 60));
                    }
                    if (isset($_COOKIE["PL1m0U3d516_615D3u0M1lp"])) {
                        setcookie("PL1m0U3d516_615D3u0M1lp",'',time()- (365 * 24 * 60 * 60));
                    }
                    $inputMessage = $email;
                    $inputKey = Config::AES_INPUT_KEY;
                    $blockSize = '256';
                    $aes = new Aes($inputMessage, $inputKey, $blockSize);
                    $encrypt = $aes->encrypt();
                    setcookie("1D0u3M6l5e_615m3U0d1",$encrypt,time()+ (365 * 24 * 60 * 60));
                    $inputMessage = $password;
                    $inputKey = Config::AES_INPUT_KEY;
                    $blockSize = '256';
                    $aes = new Aes($inputMessage, $inputKey, $blockSize);
                    $encrypt = $aes->encrypt();
                    setcookie("PL1m0U3d516_615D3u0M1lp",$encrypt,time()+ (365 * 24 * 60 * 60));
                } elseif ($rememberMe == "false") {
                    if (isset($_COOKIE["1D0u3M6l5e_615m3U0d1"])) {
                        setcookie("1D0u3M6l5e_615m3U0d1",'',time()- (365 * 24 * 60 * 60));
                    }
                    if (isset($_COOKIE["PL1m0U3d516_615D3u0M1lp"])) {
                        setcookie("PL1m0U3d516_615D3u0M1lp",'',time()- (365 * 24 * 60 * 60));
                    }
                }

                // Add another +1 on the "number_of_sessions" column value on "draftmedia_visits" table from db.
                if ($user["role"] != 'admin') {
                    $DMV = new DraftmediaVisits();
                    $draftmediaVisits = $DMV::findAll();
                    $n = count($draftmediaVisits)-1;
                    $draftmediaVisits[$n]['number_of_sessions']++;
                    $DMV::persistAndFlush($draftmediaVisits[$n]);
                }

                $message = "Has iniciado sesion exitosamente.";
                if ($language=='english') {
                    $message = "You have successfully logged in.";
                }
                echo json_encode([
                    'status' => 202, //202=Accepted
                    'message' => $message,
                    'data' => []
                ]);
            } else {
                echo json_encode([
                    'status' => 406, //406=Not Acceptable
                    'message' => $errors,
                    'data' => []
                ]);
                //header($errors, true, 406);
            }
        }
    }

    public function ajaxResetPasswordAction() {
        // If user has an active session, then redirect to home.
        if (isset($_SESSION["user"]) || isset($_SESSION["key"])) {
            //user loged in
            if (Config::APP_ENV) {
                header("LOCATION: " . Config::APP_DEV_URL);
            } else {
                header("LOCATION: " . Config::APP_PROD_URL);
            }
        }

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
                $hA->isHackAttempt("login", "ajaxResetPassword", $this->getUser());
                throw new \Exception("User was scrypting on Draft Media Server. Language value couldn't be identified.");
            }
        } else {
            $language = 'english';
        }

        //TODO: Change the user's email proccess is pending
        // ----- Eee ----- //

        $message = 'Por razones de seguridad no se puede cambiar el correo electrónico de momento.';
        if ($language=='english') {
            $message = "For security reasons the email cannot be changed at this time.";
        }
        echo json_encode([
            'status' => 503, //503=Service Unavailable
            //'message' => "isEmailChange",
            'message' => $message,
            'data' => []
        ]);
    }

    /**
     * This method is in charge of ending a session started by the user and, afterwords, it will redirect the user to
     * the Home page of the website.
     *
     * REDIRECTS to Home URL
     *
     * @author Miranda Meza César
     * DATE October 22, 2018
     */
    public function logoutAction()
    {
        if (isset($_SESSION["user"]) && isset($_SESSION["key"])) {
            //Save a record, on the database, of the time when the user logged out of his account
            $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
            $user = $this->getUser();
            $users = new Users();
            $user["disconnected_at"] = $actualDate->format('Y-m-d H:i:s');
            $users::persistAndFlush($user);

            //"Destroy" (end) the session of the user
            $_SESSION = array();
            session_destroy();
        }
        if (Config::APP_ENV) {
            header("LOCATION: " . Config::APP_DEV_URL);
        } else {
            header("LOCATION: " . Config::APP_PROD_URL);
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
    public function ajaxLoginIndexVisitsAction() {
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
                    $draftmediaVisits[$n]['Login_index_auth_visits']++;
                    $DMV::persistAndFlush($draftmediaVisits[$n]);
                }
            } else {
                //else, count an anonymous visit
                $DMV = new DraftmediaVisits();
                $draftmediaVisits = $DMV::findAll();
                $n = count($draftmediaVisits)-1;
                $draftmediaVisits[$n]['Login_index_anonym_visits']++;
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
    public function ajaxLoginIndexTimeAction() {
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
                        $draftmediaVisits[$n]['Login_index_auth_time']++;
                    }
                    $DMV::persistAndFlush($draftmediaVisits[$n]);
                }
            } else {
                //else, count as anonymous time
                $DMV = new DraftmediaVisits();
                $draftmediaVisits = $DMV::findAll();
                $n = count($draftmediaVisits)-1;
                for ($i=0; $i<5; $i++) {
                    $draftmediaVisits[$n]['Login_index_anonym_time']++;
                }
                $DMV::persistAndFlush($draftmediaVisits[$n]);
            }
        }
    }

    /**
     * This method is in charge of rendering and displaying the Login view to the user. This method also identifies if
     * there is an existing cookie with the credentials of the user, which were saved because of his desition through
     * the "remember me" checkbox on the Login view. Now, if there happens to be an existing cookie with the
     * credentials, then the user's credentials will be automatically typed on the Login form when the view displays.
     * Lastly, this method also detects if the user has already a session started with the website and if this is true,
     * then the user will be re-directed to the home page of the website
     *
     * @throws \Exception
     *
     * @author Miranda Meza César
     * DATE October 22, 2018
     */
    public function indexAction()
    {
        // If user has an active session, then redirect to home.
        if (isset($_SESSION["user"]) || isset($_SESSION["key"])) {
            //user loged in
            if (Config::APP_ENV) {
                header("LOCATION: " . Config::APP_DEV_URL);
            } else {
                header("LOCATION: " . Config::APP_PROD_URL);
            }
        }

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
                $hA->isHackAttempt("login", "index", $this->getUser());
                throw new \Exception("User was scrypting on Draft Media Server. Language value couldn't be identified.");
            }
        } else {
            $language = 'english';
        }

        // ----- Retrieve and decrypt the email and password of the user if he used the "remember me" checkbox ----- //
        if (isset($_COOKIE["1D0u3M6l5e_615m3U0d1"]) && isset($_COOKIE["PL1m0U3d516_615D3u0M1lp"])) {
            $email = htmlspecialchars($_COOKIE['1D0u3M6l5e_615m3U0d1'], ENT_QUOTES, 'UTF-8');
            $password = htmlspecialchars($_COOKIE['PL1m0U3d516_615D3u0M1lp']);
            setcookie("1D0u3M6l5e_615m3U0d1",'',time()- (365 * 24 * 60 * 60));
            setcookie("PL1m0U3d516_615D3u0M1lp",'',time()- (365 * 24 * 60 * 60));
            setcookie("1D0u3M6l5e_615m3U0d1",$email,time()+ (365 * 24 * 60 * 60));
            setcookie("PL1m0U3d516_615D3u0M1lp",$password,time()+ (365 * 24 * 60 * 60));
            // We decrypt the user's email contained on the cookie
            $inputMessage = $email;
            $inputKey = Config::AES_INPUT_KEY;
            $blockSize = '256';
            $aes = new Aes($inputMessage, $inputKey, $blockSize);
            $decrypt = $aes->decrypt();
            $email = $decrypt;

            // We decrypt the user's password contained on the cookie
            $inputMessage = $password;
            $inputKey = Config::AES_INPUT_KEY;
            $blockSize = '256';
            $aes = new Aes($inputMessage, $inputKey, $blockSize);
            $decrypt = $aes->decrypt();
            $password = $decrypt;
        } else {
            $email= "";
            $password = "";
        }
        View::renderTemplate('Login/index.html.twig', [
            'email'    => $email,
            'password' => $password,
            'isUserLoggedIn' => (isset($_SESSION["user"]) || isset($_SESSION["key"])),
            'language' => $language
        ]);
    }
}
