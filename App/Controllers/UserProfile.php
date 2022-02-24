<?php

namespace App\Controllers;

use App\Config;
use App\Models\DraftmediaVisits;
use App\Models\Users;
use \Core\Aes;
use Core\CoreHackAttempt;
use Core\Ddos;
use \Core\View;
use Core\Visitors;

/**
 * Home controller
 *
 * PHP version 5.4
 */
class UserProfile extends \Core\Controller
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
                $hA->isHackAttempt("user_profile", "before", $user);
            } catch (\Exception $e) {
                $hA->isHackAttempt("user_profile", "before", "");
            }
            throw new \Exception("A DDoS hack attack has been detected.");
        }

        // If user doesn't have an active session, then redirect to home.
        if (!isset($_SESSION["user"]) || !isset($_SESSION["key"])) {
            if (Config::APP_ENV) {
                header("LOCATION: " . Config::APP_DEV_URL);
            } else {
                header("LOCATION: " . Config::APP_PROD_URL);
            }
        } else {
            // Call once getUser method just to make the user go through credentials validations and through
            // a hack-attempt validation aswell. If nothing goes wrong, then the user hasn't tried anything
            // he shoulnd't and he can proceed. Otherwise he won't be able to.
            $xx = $this->getUser();
        }

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
     * This method is in charge of
     *
     * RETURNS JsonResponse
     *
     * @author Miranda Meza César
     * DATE October 26, 2018
     */
    public function ajaxChangeEmailConfirmationLinkAction()
    {
        //TODO: Change the user's email proccess is pending
    }

    /**
     * This method is in charge of validating the new password that the user wants to have. If validations are passed,
     * then the new password is applied as the new and official password for the user by saving it on the corresponding
     * cell on our database.
     *
     * RETURNS JsonResponse
     *
     * @author Miranda Meza César
     * DATE October 27, 2018
     */
    public function ajaxChangePasswordAction()
    {
        $errors = '';
        // ---------------------------------------------------------------- //
            // ----- SANITIZE AND VALIDATION OF CHANGE-PASSWORD FORM  ----- //
        // ---------------------------------------------------------------- //
        if (isset($_POST)) {
            $actualPassword = htmlspecialchars($_POST['actualPassword_input'], ENT_QUOTES, 'UTF-8');
            $newPassword1 = htmlspecialchars($_POST['newPassword1_input'], ENT_QUOTES, 'UTF-8');
            $newPassword2 = htmlspecialchars($_POST['newPassword2_input'], ENT_QUOTES, 'UTF-8');

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
                    $hA->isHackAttempt("user_profile", "ajaxChangePassword", $this->getUser());
                    throw new \Exception("User was scrypting on Draft Media Server. Language value couldn't be identified.");
                }
            } else {
                $language = 'english';
            }

            // ----- Validate actual password of user's credentials ----- //
            if (!empty($actualPassword)) {
                $user = $this->getUser();
                if (!empty($user)) {
                    $inputMessage = $user["password"];
                    $inputKey = Config::AES_INPUT_KEY;
                    $blockSize = '256';
                    $aes = new Aes($inputMessage, $inputKey, $blockSize);
                    $decrypt = $aes->decrypt();
                    if (!password_verify($actualPassword, $decrypt)) {
                        if ($language=='spanish') {
                            $errors .=  'La contraseña que indicaste como la actual no es correcta.' . '<br>';
                        }
                        if ($language=='english') {
                            $errors .=  'The password that you indicated as actual is not correct.' . '<br>';
                        }
                    } else {

                        // ----- User's new password sanitize and validation ----- //
                        if (!empty($newPassword1) && !empty($newPassword2)) {
                            if ($newPassword1 === $newPassword2) {
                                if (strlen($newPassword1)>5) {
                                    preg_match_all("/[0-9]/", $newPassword1, $numberMatches);
                                    preg_match_all("/[a-z A-Z]/", $newPassword1, $characterMatches);
                                    if ($numberMatches[0]!='' && $numberMatches[0]!=null && $characterMatches[0]!='' && $characterMatches[0]!=null) {
                                        $options = [
                                            'cost' => 13,
                                        ];
                                        $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
                                        $newPassword = password_hash($newPassword1, PASSWORD_BCRYPT, $options);
                                        $inputMessage = $newPassword;
                                        $inputKey = Config::AES_INPUT_KEY;
                                        $blockSize = '256';
                                        $aes = new Aes($inputMessage, $inputKey, $blockSize);
                                        $newPassword = $aes->encrypt();
                                        $user["password"] = $newPassword;
                                        $user["modified_at"] = $actualDate->format('Y-m-d H:i:s');
                                        $user["modified_by"] = $user["id"];
                                        $users = new Users();
                                        $users::persistAndFlush($user);
                                    } else {
                                        if ($language=='spanish') {
                                            $errors .= 'Tu nueva contraseña debe poseer al menos un caracter del abecedario y al menos un caracter numérico.' . '<br>';
                                        }
                                        if ($language=='english') {
                                            $errors .= 'Your new password must have at least one character of the alphabet and at least one numeric character.' . '<br>';
                                        }
                                    }
                                } else {
                                    if ($language=='spanish') {
                                        $errors .= 'Tu nueva contraseña debe tener al menos 6 caracteres.' . '<br>';
                                    }
                                    if ($language=='english') {
                                        $errors .= 'Your new password must have at least 6 characters.' . '<br>';
                                    }
                                }
                            } else {
                                if ($language=='spanish') {
                                    $errors .= 'Tu nueva contraseña no es idéntica en ambos casilleros.' . '<br>';
                                }
                                if ($language=='english') {
                                    $errors .= 'Your new password is not identical in both boxes.' . '<br>';
                                }
                            }
                        } else {
                            if ($language=='spanish') {
                                $errors .= 'Porfavor agrega tu nueva contraseña en ambos casilleros.' . '<br>';
                            }
                            if ($language=='english') {
                                $errors .= 'Please add your new pasword in both boxes.' . '<br>';
                            }
                        }
                    }
                } else {
                    // If this happens, then the user tried to change someones password without having a session
                    // started with the website, which would be most likely a hack-atack. This should not happen.
                    $hA = new CoreHackAttempt();
                    $hA->isHackAttempt("user_profile", "ajaxChangePassword", $this->getUser());
                }
            } else {
                if ($language=='spanish') {
                    $errors .= 'Porfavor agrega tu contraseña actual.' . '<br>';
                }
                if ($language=='english') {
                    $errors .= 'Please enter your actual password.' . '<br>';
                }
            }
            $message = "Se realizó el cambio de contraseña con éxito.";
            if ($language=='english') {
                $message = "The password change was successful.";
            }
            if ($errors === '') {
                echo json_encode([
                    'status' => 200, //200 = OK
                    'message' => $message,
                    'data' => []
                ]);
            } else {
                echo json_encode([
                    'status' => 400, //400=Bad Request
                    'message' => $errors,
                    'data' => []
                ]);
            }
        }
    }

    /**
     * This method is in charge of validating the data that the user wants to change from his current profile. If the
     * validations are passed, then the changes are saved on the database of this project. Otherwise, an error will be
     * popped to the user, which will let him know what wen't wrong.
     *
     * RETURNS JsonResponse
     *
     * @author Miranda Meza César
     * DATE October 26, 2018
     */
    public function ajaxSaveChangesAction()
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
                $hA->isHackAttempt("user_profile", "ajaxSaveChanges", $this->getUser());
                throw new \Exception("User was scrypting on Draft Media Server. Language value couldn't be identified.");
            }
        } else {
            $language = 'english';
        }

        $errors = '';
        $user = $this->getUser();
        $firstName = $_POST['firstname_input'];
        $lastName = $_POST['lastname_input'];
        $email = $_POST["email_input"];

        // ----- User's first name sanitize and validation ----- //
        if (!empty($firstName)) {
            $firstName = filter_var($firstName, FILTER_SANITIZE_STRING);
            $firstName = htmlspecialchars($firstName, ENT_QUOTES, 'UTF-8');
            $firstName = strtolower($firstName);
            $firstName = str_replace(' ', ' ', ucwords(str_replace('-', ' ', $firstName)));
        } else {
            if ($language=='spanish') {
                $errors .= 'Porfavor agrega tu(s) nombre(s).' . '<br>';
            }
            if ($language=='english') {
                $errors .= 'Please enter your name(s).' . '<br>';
            }
        }

        // ----- User's last name sanitize and validation ----- //
        if (!empty($lastName)) {
            $lastName = filter_var($lastName, FILTER_SANITIZE_STRING);
            $lastName = htmlspecialchars($lastName, ENT_QUOTES, 'UTF-8');
            $lastName = strtolower($lastName);
            $lastName = str_replace(' ', ' ', ucwords(str_replace('-', ' ', $lastName)));
        } else {
            if ($language=='spanish') {
                $errors .= 'Porfavor agrega tu(s) Apellido(s).' . '<br>';
            }
            if ($language=='english') {
                $errors .= 'Please enter your Last Name' . '<br>';
            }
        }

        // ----- User's email sanitize and validation ----- //
            if (!empty($email)) {
                $email = filter_var($email, FILTER_SANITIZE_EMAIL);
                if (filter_var($email, FILTER_VALIDATE_EMAIL) != false) {
                    $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
                    $users = new Users();
                    $accountsExists = $users->findBy(["email" => $email]);
                    // We validate if the account, that wants to be activated, is already an existing account //
                    $isEmailAvailable = false;
                    foreach ($accountsExists as $accountExists) {
                        if ($accountsExists==null || $accountExists["status"]=='DELETED' || $accountExists["email"]==$user["email"]) {
                            $isEmailAvailable = false;
                        } else {
                            $isEmailAvailable = true;
                            //$user = $accountExists;
                            break;
                        }
                    }
                    // If validation determined that the request of the account to register already exists as an
                    // ACTIVE account, then send error
                    if ($isEmailAvailable == true) {
                        if ($language=='spanish') {
                            $errors .= 'El correo electrónico que ingresaste ya está registrado.' . '<br>';
                        }
                        if ($language=='english') {
                            $errors .= 'The email that you entered has already been registered.' . '<br>';
                        }
                    }
                } else {
                    if ($language=='spanish') {
                        $errors .= 'Porfavor agrega un correo electrónico valido.' . '<br>';
                    }
                    if ($language=='english') {
                        $errors .= 'Please enter a valid email.' . '<br>';
                    }
                }
            } else {
                if ($language=='spanish') {
                    $errors .= 'Porfavor agrega tu correo electrónico.' . '<br>';
                }
                if ($language=='english') {
                    $errors .= 'Please enter your email.' . '<br>';
                }
            }

        // ------------------------------------------------------------------------------ //
        // ----- Server response with regard of the Change Email Validation process ----- //
        // ------------------------------------------------------------------------------ //
        if ($errors === '') {

            // ----- Identify if there are new changes that want to be applied by the user ----- //
            //Instead of creating a new object were we will only have 2-3 parameters that will differ, we clone what
            //we already have on "$user" to "$newUser"
            $newUser = $user;
            $newUser["first_name"] = $firstName;
            $newUser["last_name"] = $lastName;
            if ($newUser["first_name"]!=$user["first_name"] || $newUser["last_name"]!=$user["last_name"] || $user["email"]!=$email) {
                // ----- There are new changes to the user's account data, apply them ----- //
                $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
                $newUserObject = new Users();
                $newUser["modified_at"]=$actualDate->format('Y-m-d H:i:s');
                $newUser["modified_by"]=$user["id"];
                if (($newUser["first_name"]!=$user["first_name"] || $newUser["last_name"]!=$user["last_name"]) && $user["email"]==$email) {
                    $newUserObject::persistAndFlush($newUser);
                    $message = "Tus datos han sido guardados exitosamente.";
                    if ($language=='english') {
                        $message = "Your data has been saved successfully.";
                    }
                    echo json_encode([
                        'status' => 200, //200=OK
                        //'message' => "isntEmailChange",
                        'message' => $message,
                        'data' => []
                    ]);
                }
                if ($user["email"]!=$email) {
                    if ($newUser["first_name"]!=$user["first_name"] || $newUser["last_name"]!=$user["last_name"]) {
                        $newUserObject::persistAndFlush($newUser);
                    }

                    //TODO: Change the user's email proccess is pending
                    // ----- Eee ----- //

                    $message = "Tus datos han sido guardados a excepción del correo. Por razones de seguridad no se puede cambiar el correo electrónico de momento.";
                    if ($language=='english') {
                        $message = "Your data has been saved except for the email. For security reasons the email cannot be changed at this time.";
                    }
                    echo json_encode([
                        'status' => 200, //200=OK
                        //'message' => "isEmailChange",
                        'message' => $message,
                        'data' => []
                    ]);
                }
            } else {
                $message = "Tus datos han sido guardados exitosamente.";
                if ($language=='english') {
                    $message = "Your data has been saved successfully.";
                }
                echo json_encode([
                    'status' => 200, //200=OK
                    //'message' => "noChanges ForReal",
                    'message' => $message,
                    'data' => []
                ]);
            }
        }  else {
            //header($errors, true, 400);
            echo json_encode([
                'status' => 400, //400=Bad Request
                'message' => $errors,
                'data' => []
            ]);
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
    public function ajaxUserProfileIndexVisitsAction() {
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
                    $draftmediaVisits[$n]['UserProfile_index_auth_visits']++;
                    $DMV::persistAndFlush($draftmediaVisits[$n]);
                }
            } else {
                //else, count an anonymous visit
                $DMV = new DraftmediaVisits();
                $draftmediaVisits = $DMV::findAll();
                $n = count($draftmediaVisits)-1;
                $draftmediaVisits[$n]['UserProfile_index_anonym_visits']++;
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
    public function ajaxUserProfileIndexTimeAction() {
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
                        $draftmediaVisits[$n]['UserProfile_index_auth_time']++;
                    }
                    $DMV::persistAndFlush($draftmediaVisits[$n]);
                }
            } else {
                //else, count as anonymous time
                $DMV = new DraftmediaVisits();
                $draftmediaVisits = $DMV::findAll();
                $n = count($draftmediaVisits)-1;
                for ($i=0; $i<5; $i++) {
                    $draftmediaVisits[$n]['UserProfile_index_anonym_time']++;
                }
                $DMV::persistAndFlush($draftmediaVisits[$n]);
            }
        }
    }

    /**
     * This method is in charge of rendering and displaying the User's Profile view.
     *
     * @throws \Exception
     *
     * @author Miranda Meza César
     * DATE October 26, 2018
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
                $hA->isHackAttempt("user_profile", "index", $this->getUser());
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
        $fileExists = false;
        if (file_exists('img/profile/' . $user["first_name"] . ' ' . $user["last_name"] . '.jpg')) {
            $fileExists = true;
        }
        View::renderTemplate('UserProfile/index.html.twig', [
            'user'    => $user,
            'isUserLoggedIn' => (isset($_SESSION["user"]) || isset($_SESSION["key"])),
            'user_firstname' => $user_firstname,
            'fileExists' => $fileExists,
            'language' => $language
        ]);
    }
}
