<?php

namespace App\Controllers\Admin;

use App\Config;
use App\Models\SessionKeys;
use App\Models\Users;
use Core\Aes;
use Core\CoreHackAttempt;
use Core\Ddos;
use Core\UserLocation;
use \Core\View;
use Core\Visitors;

/**
 * User admin controller
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
                $hA->isHackAttempt("admin_login", "before", $user);
            } catch (\Exception $e) {
                $hA->isHackAttempt("admin_login", "before", "");
            }
            throw new \Exception("A DDoS hack attack has been detected.");
        }

        // If user has a session, we then update the date of the last activity of the user
        if (isset($_SESSION["user"]) && isset($_SESSION["key"])) {
            $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
            $user = $this->getUser();
            $user['last_activity_at'] = $actualDate->format('Y-m-d H:i:s');
            $users = new Users();
            $users::persistAndFlush($user);

            //if user has a session, then if he is admin: redirect him to dashboard home page. Otherwise
            //redirect him to home page of DraftMedia.
            if ($user['role'] == 'admin') {
                if (Config::APP_ENV) {
                    $redirectUrl = Config::APP_DEV_URL;
                } elseif (!Config::APP_ENV) {
                    $redirectUrl = Config::APP_PROD_URL;
                }
                header("LOCATION: ".$redirectUrl."Admin/Summary/index");
            } else {
                if (Config::APP_ENV) {
                    header("LOCATION: " . Config::APP_DEV_URL);
                } else {
                    header("LOCATION: " . Config::APP_PROD_URL);
                }
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
     * This method is in charge of receiving the data from the login form that the user submits to be able to log in.
     * Also, this method will validate that data and if any error occurs while its validation, JSON will be echo'ed so
     * that Javascript reads it and displays the corresponding error message. But if everything goes ok, then the user
     * will be granted to start a session with the web page.
     * On the other hand, if the user happens to already be logged in, then he will be re-directed to the home page.
     *
     * RETURNS JsonResponse
     *
     * @author Miranda Meza César
     * DATE November 24, 2018
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
                $hA->isHackAttempt("isHackAttempt", "index", $this->getUser());
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
            }
        }
    }

    /**
     * Display and render the Admin Login view of the website.
     *
     * @return void
     */
    public function indexAction()
    {
        View::renderTemplate('Admin/Login/index.html.twig', [
        ]);
    }
}
