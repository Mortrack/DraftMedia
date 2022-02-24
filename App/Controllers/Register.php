<?php

namespace App\Controllers;     //The namespace must match the father directory oh the .php file were it will be used

use App\Config;
use App\Models\AccountRegistery;
use App\Models\DraftmediaVisits;
use App\Models\Users;
use \Core\Aes;
use Core\CoreHackAttempt;
use Core\Ddos;
use \Core\View;
use Core\Visitors;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * Summary controller
 *
 * PHP version 5.4
 */
class Register extends \Core\Controller
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
                $hA->isHackAttempt("register", "before", $user);
            } catch (\Exception $e) {
                $hA->isHackAttempt("register", "before", "");
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
     * This method is in charge of receiving, through the GET method, the activation links of DraftMedia accounts that
     * were registered but havent been activated. Such activation link is previously sended to the users through the
     * email they registered with the account.
     * Once this method receives the activation link, it validates if there was a request of the registery of the
     * corresponding account to such activation link encripted code. If the links request is valid, then it validates
     * if the requested account to be activated isnt an already existing user-account or if it hasnt been already
     * activated. If both validations are passed, then the user-account is activated and saved on the "users" table from
     * our database and it also sends a success message through a JSON. Else an error message is send through a JSON.
     * IMPORTANT: Note that if there is an attempt to manipulate the data that interacts with the server, it will be
     * considered a hack attempt and a record will be saved on the database of this project.
     *
     * RETURNS JsonResponse
     *
     * @author Miranda Meza César
     * DATE September 25, 2018
     */
    public function ajaxActivationLinkAction()
    {
        if (isset($_GET['a'])) {
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
                    $hA->isHackAttempt("register", "ajaxActivationLink", $this->getUser());
                    throw new \Exception("User was scrypting on Draft Media Server. Language value couldn't be identified.");
                }
            } else {
                $language = 'english';
            }

            // Before we start, lets identify if a session has been started to retrieve the data of the user logged in
            $user = $this->getUser();
            if ($user != null) {
                $user_firstname = $user["first_name"];
            } else {
                $user_firstname = "";
            }

            //activationUrl = 5randomNumber+$+4randomNumber+!+$accountRegisteryId+$F!+6randomNumber+$!+actualDateTimeStamp
            $get = filter_var($_GET['a'], FILTER_SANITIZE_STRING);
            $get = htmlspecialchars($get, ENT_QUOTES, 'UTF-8');
            preg_match_all("/![0-9]+[\$]F/", $get, $match);
            if ($match[0] != null) {
                preg_match_all("/[0-9]+/", $match[0][0], $accountRegisteryId);
                if ($accountRegisteryId[0] != null) {
                    $accountRegisteryId = htmlspecialchars($accountRegisteryId[0][0], ENT_QUOTES, 'UTF-8');
                    $accountRegistery = new AccountRegistery();
                    $idMatch = $accountRegistery->find($accountRegisteryId);
                    //new \Core\Dump($idMatch);die();
                    if ($idMatch != null) {
                        $accountsMatchedByEmail = $accountRegistery->findBy(["email"=>$idMatch[0]["email"]]);
                        $newUserAccount = null;
                        $isIdAndActivationCodeMatched = false;
                        foreach ($accountsMatchedByEmail as $accountMatchedByEmail) {
                            if ($accountMatchedByEmail["activation_code"] == $get) {
                                $newUserAccount = $accountMatchedByEmail;
                                $isIdAndActivationCodeMatched = true;
                                break;
                            }
                        }
                    } else {
                        // If this happens, then the user tried to manipulate the URL or hack the server
                        $isIdAndActivationCodeMatched = false;
                    }
                    if ($isIdAndActivationCodeMatched) {
                        $users = new Users();
                        $accountsExists = $users->findBy(["email"=>$newUserAccount["email"]]);

                        // ----- We validate if the account, that wants to be activated, is already activated or already exists ----- //
                        $isAccountActivated = false;
                        foreach ($accountsExists as $accountExists) {
                            if (($accountsExists==null || $accountExists["status"]=='DELETED') && ($newUserAccount != null)) {
                                $isAccountActivated = false;
                            } else {
                                $isAccountActivated = true;
                                break;
                            }
                        }
                    } else {

                        // If this happens, then the user tried to manipulate the URL or hack the server
                        $hA = new CoreHackAttempt();
                        $hA->isHackAttempt("register", "ajaxActivationLink", $this->getUser());
                        $isAccountActivated = true;
                    }

                    // ----- If validation determined that the newAccount is non-existing on db and hasnt been activated,
                    //       it activates it and registers it on the db ----- //
                    if ($isAccountActivated == false) {

                        // ----- We save the record of the registry of this new account ----- //
                        $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
                        $users->setEmail($newUserAccount["email"]);
                        $users->setFirstName($newUserAccount["first_name"]);
                        $users->setLastName($newUserAccount["last_name"]);
                        $users->setRole($newUserAccount["role"]);
                        $users->setPassword($newUserAccount["password"]);
                        $users->setPrivacyPolitics($newUserAccount["privacy_politics"]);
                        $users->setActivationCode($newUserAccount["activation_code"]);
                        $users->setStatus($newUserAccount["status"]); //ACTIVE=este record esta vigente //DELETED=este record ha sido borrado
                        $users->setCreatedBy($newUserAccount["created_by"]);
                        $users->setCreatedAt($actualDate->format('Y-m-d H:i:s'));
                        $users::persistAndFlush($users);
                        http_response_code(202); //202=Accepted
                        View::renderTemplate('Register/successActivationLink/index.html.twig', [
                            'isUserLoggedIn' => isset($_SESSION["user"]),
                            'user_firstname' => $user_firstname,
                            'language' => $language
                        ]);
                    } else {
                        http_response_code(409); //409=Conflict
                        View::renderTemplate('Register/errorActivationLink/index.html.twig', [
                            'isUserLoggedIn' => isset($_SESSION["user"]),
                            'user_firstname' => $user_firstname,
                            'language' => $language
                        ]);
                    }
                } else {
                    http_response_code(409); //409=Conflict
                    View::renderTemplate('Register/errorActivationLink/index.html.twig', [
                        'isUserLoggedIn' => isset($_SESSION["user"]),
                        'user_firstname' => $user_firstname,
                        'language' => $language
                    ]);
                    $hA = new CoreHackAttempt();
                    $hA->isHackAttempt("register", "ajaxActivationLink", $this->getUser());
                }
            } else {
                http_response_code(409); //409=Conflict
                View::renderTemplate('Register/errorActivationLink/index.html.twig', [
                    'isUserLoggedIn' => isset($_SESSION["user"]),
                    'user_firstname' => $user_firstname,
                    'language' => $language
                ]);
                $hA = new CoreHackAttempt();
                $hA->isHackAttempt("register", "ajaxActivationLink", $this->getUser());
            }
        } else {
            $hA = new CoreHackAttempt();
            $hA->isHackAttempt("register", "ajaxActivationLink", $this->getUser());
            throw new \Exception("\"a\" variable, on GET method, isn't set");
        }
    }


    /**
     * This method is in charge of receiving the register data inputed by the users that filled the register form modal.
     * The data is sended by Javascript to this method and, after receiving such data, this method sanitizes and
     * validates the data. If there are some errors during that process, an error message will be send to Javascript
     * to inform what went wrong. But if the validation and sanitize were successful, then the data that was receivec
     * from the register modal is inserted into the database on "account_registery" table and then a mail is send to the
     * user that register such new account so that he enters to the email he registered and clicks on the validation
     * that was sended to him so that he can activate his account on out website (Note that the mail is only sended on
     * production mode).
     *
     * RETURNS JsonResponse
     *
     * @author Miranda Meza César
     * DATE September 18, 2018
     */
    public function ajaxReceiveRegisterFormAction()
    {
        $errors = '';
        // ----------------------------------------------------- //
        // ----- SANITIZE AND VALIDATION OF REGISTER FORM  ----- //
        // ----------------------------------------------------- //
        if (isset($_POST)) {
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
                    $hA->isHackAttempt("register", "ajaxReceiveRegisterForm", $this->getUser());
                    throw new \Exception("User was scrypting on Draft Media Server. Language value couldn't be identified.");
                }
            } else {
                $language = 'english';
            }

            $firstName = $_POST['firstname_input'];
            $lastName = $_POST['lastname_input'];
            $email = $_POST['email_input'];
            $password1 = htmlspecialchars($_POST['password1_input'], ENT_QUOTES, 'UTF-8');
            $password2 = htmlspecialchars($_POST['password2_input'], ENT_QUOTES, 'UTF-8');
            $privacyPoliticsCheckbox = filter_var($_POST['privacyPolitics_checkbox'], FILTER_SANITIZE_STRING);
            $privacyPoliticsCheckbox = htmlspecialchars($privacyPoliticsCheckbox, ENT_QUOTES, 'UTF-8');

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
                    $errors .= 'Please enter your name(s)' . '<br>';
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
                    $errors .= 'Please enter your Last name.' . '<br>';
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
                    $isAccountActivated = false;
                    foreach ($accountsExists as $accountExists) {
                        if ($accountsExists==null || $accountExists["status"]=='DELETED') {
                            $isAccountActivated = false;
                        } else {
                            $isAccountActivated = true;
                            break;
                        }
                    }
                    // If validation determined that the request of the account to register already exists as an
                    // ACTIVE account, then send error
                    if ($isAccountActivated == true) {
                        if ($language=='spanish') {
                            $errors .= 'El correo electrónico que usaste ya está registrado.' . '<br>';
                        }
                        if ($language=='english') {
                            $errors .= 'The email that you used has already been registered.' . '<br>';
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

            // ----- User's password sanitize and validation ----- //
            if (!empty($password1) && !empty($password2)) {
                if ($password1 === $password2) {
                    if (strlen($password1)>5) {
                        preg_match_all("/[0-9]/", $password1, $numberMatches);
                        preg_match_all("/[a-z A-Z]/", $password1, $characterMatches);
                        if ($numberMatches[0]!='' && $numberMatches[0]!=null && $characterMatches[0]!='' && $characterMatches[0]!=null) {
                            $options = [
                                'cost' => 13,
                            ];
                            $password = password_hash($password1, PASSWORD_BCRYPT, $options);
                            $inputMessage = $password;
                            $inputKey = Config::AES_INPUT_KEY;
                            $blockSize = '256';
                            $aes = new Aes($inputMessage, $inputKey, $blockSize);
                            $password = $aes->encrypt();
                        } else {
                            if ($language=='spanish') {
                                $errors .= 'Tu contraseña debe poseer al menos un caracter del abecedario y al menos un caracter numérico.' . '<br>';
                            }
                            if ($language=='english') {
                                $errors .= 'Your password must have at least one character of the alphabet and at least one numeric character.' . '<br>';
                            }
                        }
                    } else {
                        if ($language=='spanish') {
                            $errors .= 'Tu contraseña debe tener al menos 6 caracteres.' . '<br>';
                        }
                        if ($language=='english') {
                            $errors .= 'Your password must have at least 6 characters.' . '<br>';
                        }
                    }
                } else {
                    if ($language=='spanish') {
                        $errors .= 'Las contraseñas que ingresaste no son idénticas.' . '<br>';
                    }
                    if ($language=='english') {
                        $errors .= 'The passwords that you entered are not identical.' . '<br>';
                    }
                }
            } else {
                if ($language=='spanish') {
                    $errors .= 'Porfavor agrega tu contraseña en ambos casilleros.' . '<br>';
                }
                if ($language=='english') {
                    $errors .= 'Please enter your password in both boxes.' . '<br>';
                }
            }
            // ----- Draft Media's privacy politics acceptance validation ----- //
            if (!$privacyPoliticsCheckbox) {
                if ($language=='spanish') {
                    $errors .= 'Porfavor acepta las políticas de privacidad.' . '<br>';
                }
                if ($language=='english') {
                    $errors .= 'Please accept the privacy politics.' . '<br>';
                }
            } else {
                if ($privacyPoliticsCheckbox) {
                    $privacyPoliticsCheckbox = 1;
                } else {
                    $privacyPoliticsCheckbox = 0;
                }
            }

            // -------------------------------------------------------------------------------- //
            // ----- Server response with regard of the Register Modal Validation process ----- //
            // -------------------------------------------------------------------------------- //
            if ($errors === '') {
                $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));

                // ----- We save the record of the registry of this new account ----- //
                $accountRegistery = new AccountRegistery();
                $accountRegistery->setEmail($email);
                $accountRegistery->setFirstName($firstName);
                $accountRegistery->setLastName($lastName);
                $accountRegistery->setRole("user");
                $accountRegistery->setPassword($password);
                $accountRegistery->setPrivacyPolitics($privacyPoliticsCheckbox);
                $accountRegistery->setStatus("ACTIVE"); //ACTIVE=este record esta vigente //DELETED=este record ha sido borrado
                $accountRegistery->setCreatedBy("DraftMedia Web API");
                $accountRegistery->setCreatedAt($actualDate->format('Y-m-d H:i:s'));
                $actualDate = $actualDate->getTimestamp() - 32400; //32400 = desfase por bug propio de php date
                $temporalActivationUrl = $email . $firstName . $lastName . "user" . $password . $privacyPoliticsCheckbox . $actualDate . "ACTIVE" . "DraftMedia Web API" . $accountRegistery->getCreatedAt();
                $accountRegistery->setActivationCode($temporalActivationUrl);
                $accountRegistery::persistAndFlush($accountRegistery);
                $accountRegisteryId = $accountRegistery::findBy(["activation_code"=>$temporalActivationUrl])[0]["id"];
                $accountRegistery->setId($accountRegisteryId);
                $randNum6 = rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
                $randNum5 = rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
                $randNum4 = rand(0,9).rand(0,9).rand(0,9).rand(0,9);
                //activationUrl = 5randomNumber+$+4randomNumber+!+$accountRegisteryId+$F!+6randomNumber+$!+actualDateTimeStamp
                $activationUrl = $randNum5."$".$randNum4."!".$accountRegisteryId."\$F!".$randNum6."$!".$actualDate;
                $accountRegistery->setActivationCode((string)$activationUrl);
                $accountRegistery::persistAndFlush($accountRegistery);

                // ----- We send the activation link to the user's email ----- //
                //send an email to the user's email with the activation link for his new account
                if (!Config::APP_ENV) {
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
                        $mail->addAddress($email);// Who to

                        //Attachments
                        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

                        //Content
                        $mail->isHTML(true);                                  // Set email format to HTML
                        $mail->Subject = 'Draft Media - Enlace para activacion de Cuenta'; //El subject no agarra acentos
                        if ($language=='english') {
                            $mail->Subject = 'Draft Media - Link for Account activation'; //El subject no agarra acentos
                        }
                        $preparedMessage ='
                        <html>
                            <body>
                              <p>De: Draft Media</p>
                              <p>La cuenta que registraste en Draft Media ha sido registrada exitósamente!.</p>
                              <p>Para empezar a usar tu cuenta, activala dando click al siguiente enlace: " <a href="' . Config::APP_PROD_URL . 'Register/' . 'ajaxActivationLink?a='. $activationUrl . '">Activador De Cuenta en Draft Media</a></p>
                            </body>
                        </html>
                        ';
                        if ($language=='english') {
                            $preparedMessage ='
                            <html>
                                <body>
                                  <p>From: Draft Media</p>
                                  <p>The account you registered in Draft Media has been registered successfully!</p>
                                  <p>To start using your account, activate it by clicking on the following link: " <a href="' . Config::APP_PROD_URL . 'Register/' . 'ajaxActivationLink?a='. $activationUrl . '">Account Activator in Draft Media</a></p>
                                </body>
                            </html>
                            ';
                        }
                        $mail->Body    = $preparedMessage;

                        if(!$mail->Send()) {
                            throw new \Exception("An error ocurred while trying to send an email to the user: $mail->ErrorInfo");
                        }
                    } catch (\Exception $e) {
                        throw new \Exception("An error ocurred while trying to send an email to the user: $mail->ErrorInfo");
                    }
                }

                $message = "Registro de Cuenta Exitoso!" . '</br></br>' . "Actívala y empieza a usarla dando click al enlace de activación que fue enviado a tu correo electrónico.";
                if ($language=='english') {
                    $message = "Successful Account Registration!" . '</br></br>' . "Activate it and start using it by clicking the activation link that was sent to your email.";
                }
                //header('Registro de cuenta exitoso', true, 201); //Aunque usar esto es muy buena practica, el servidor de hostgator se rompe con su uso
                echo json_encode([
                    'status' => 201, //200 = Created
                    'message' => $message,
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
    public function ajaxRegisterIndexVisitsAction() {
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
                    $draftmediaVisits[$n]['Register_index_auth_visits']++;
                    $DMV::persistAndFlush($draftmediaVisits[$n]);
                }
            } else {
                //else, count an anonymous visit
                $DMV = new DraftmediaVisits();
                $draftmediaVisits = $DMV::findAll();
                $n = count($draftmediaVisits)-1;
                $draftmediaVisits[$n]['Register_index_anonym_visits']++;
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
    public function ajaxRegisterIndexTimeAction() {
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
                        $draftmediaVisits[$n]['Register_index_auth_time']++;
                    }
                    $DMV::persistAndFlush($draftmediaVisits[$n]);
                }
            } else {
                //else, count as anonymous time
                $DMV = new DraftmediaVisits();
                $draftmediaVisits = $DMV::findAll();
                $n = count($draftmediaVisits)-1;
                for ($i=0; $i<5; $i++) {
                    $draftmediaVisits[$n]['Register_index_anonym_time']++;
                }
                $DMV::persistAndFlush($draftmediaVisits[$n]);
            }
        }
    }


    /**
     * This method is in charge of rendering and displaying the Register-User view.
     *
     * @throws \Exception
     *
     * @author Miranda Meza César
     * DATE October 22, 2018
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
                $hA->isHackAttempt("register", "index", $this->getUser());
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
        View::renderTemplate('Register/index/index.html.twig', [
            'isUserLoggedIn' => (isset($_SESSION["user"]) || isset($_SESSION["key"])),
            'user_firstname' => $user_firstname,
            'language' => $language
        ]);
    }
}
