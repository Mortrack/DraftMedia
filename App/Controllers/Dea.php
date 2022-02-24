<?php

namespace App\Controllers;     //The namespace must match the father directory oh the .php file were it will be used

use App\Config;
use App\Models\DeaLanguage;
use App\Models\DeaRequests;
use App\Models\DeaWebdesign;
use App\Models\DeaWebdesignColors;
use App\Models\DeaWebdesignViews;
use App\Models\DraftmediaVisits;
use App\Models\Users;
use Core\CoreHackAttempt;
use Core\Ddos;
use Core\StringNormalizer;
use \Core\View;
use Core\Visitors;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * Home controller
 *
 * PHP version 5.4
 */
class Dea extends \Core\Controller
{

    /**
     * Before filter
     *
     * @throws \Exception
     */
    protected function before()
    {
        //TODO: Terminate all open sessions if there are multiple concurrent active logins for all befores.
        session_start();

        // We set protection against DDoS Attacks
        $ddos = new Ddos();
        if ($ddos->isThereAnAttack(10)) {
            $hA = new CoreHackAttempt();
            $user = '';
            try {
                $user = $this->getUser();
                $hA->isHackAttempt("dea", "before", $user);
            } catch (\Exception $e) {
                $hA->isHackAttempt("dea", "before", "");
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
     * This method is in charge of sanitizing and validating the DEA request input data to then save it on the
     * database of the server of Draft Media.
     *
     * @author Miranda Meza César
     * DATE November 02, 2018
     */
    public function ajaxSubmitDeaFormAction()
    {
        $errors = '';
        // ------------------------------------------------ //
        // ----- SANITIZE AND VALIDATION OF DEA FORM  ----- //
        // ------------------------------------------------ //
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
                    $hA->isHackAttempt("dea", "ajaxSubmitDeaForm", $this->getUser());
                    throw new \Exception("User was scrypting on Draft Media Server. Language value couldn't be identified.");
                }
            } else {
                $language = 'english';
            }

            $stringNormalizer = new StringNormalizer();
            $first_name = $stringNormalizer->normalize($_POST['first_name']);
            $last_name = $stringNormalizer->normalize($_POST['last_name']);
            $phone = $stringNormalizer->normalize($_POST['phone']);
            $sex = $stringNormalizer->normalize($_POST['sex']);
            $company_name = $stringNormalizer->normalize($_POST['company_name']);
            $country = $stringNormalizer->normalize($_POST['country']);
            $know_about_us = $stringNormalizer->normalize($_POST['know_about_us']);
            $workfield = $stringNormalizer->normalize($_POST['workfield']);
            $terms_and_conditions = $stringNormalizer->normalize($_POST['terms_and_conditions']);
            $service_required = $stringNormalizer->normalize($_POST['service_required']);
            $package_required = $stringNormalizer->normalize($_POST['package_required']);
            $project_name = $stringNormalizer->normalize($_POST['project_name']);
            $website_category = $stringNormalizer->normalize($_POST['website_category']);
            $website_language = $stringNormalizer->normalize($_POST['website_language']);
            $website_views = $stringNormalizer->normalize($_POST['website_views']);
            $is_base_colors = $stringNormalizer->normalize($_POST['is_base_colors']);
            $base_colors_lvl_attch = $stringNormalizer->normalize($_POST['base_colors_lvl_attch']);
            if (isset($_POST['base_color_code']) && isset($_POST['base_color_priority'])) {
                $base_color_code = $_POST['base_color_code'];
                $base_color_priority = $_POST['base_color_priority'];
            } else {
                $base_color_code = [];
                $base_color_priority = [];
            }
            $website_url = $stringNormalizer->normalize($_POST['website_url']);
            $target_audience = $stringNormalizer->normalize($_POST['target_audience']);
            $what_to_transmit = $stringNormalizer->normalize($_POST['what_to_transmit']);
            $viewsDetails = $_POST['viewsDetails'];

            // ----- Client's first name sanitize and validation ----- //
            if (!empty($first_name)) {
                $first_name = filter_var($first_name, FILTER_SANITIZE_STRING);
                $first_name = htmlspecialchars($first_name, ENT_QUOTES, 'UTF-8');
                $first_name = strtolower($first_name);
                $first_name = str_replace(' ', ' ', ucwords(str_replace('-', ' ', $first_name)));
            } else {
                if ($language=='spanish') {
                    $errors .= 'Porfavor agrega el/los nombre(s) de la persona con quien nos dirigiremos.' . '<br>';
                }
                if ($language=='english') {
                    $errors .= 'Please add the name(s) of the person with whom we will be in contact with.' . '<br>';
                }
            }

            // ----- Client's last name sanitize and validation ----- //
            if (!empty($last_name)) {
                $last_name = filter_var($last_name, FILTER_SANITIZE_STRING);
                $last_name = htmlspecialchars($last_name, ENT_QUOTES, 'UTF-8');
                $last_name = strtolower($last_name);
                $last_name = str_replace(' ', ' ', ucwords(str_replace('-', ' ', $last_name)));
            } else {
                if ($language=='spanish') {
                    $errors .= 'Porfavor agrega el/los Apellido(s) de la persona con quien nos dirigiremos.' . '<br>';
                }
                if ($language=='english') {
                    $errors .= 'Please add the last name of the person with whom we will be in contact with.' . '<br>';
                }
            }

            // ----- Client's phone number sanitize and validation ----- //
            $phone = filter_var($phone, FILTER_SANITIZE_NUMBER_FLOAT);
            $phone = htmlspecialchars($phone, ENT_QUOTES, 'UTF-8');
            if (filter_var($phone, FILTER_VALIDATE_FLOAT) == false) {
                if ($language=='spanish') {
                    $errors .= 'Porfavor agrega un número telefónico válido.' . '<br>';
                }
                if ($language=='english') {
                    $errors .= 'Please add a valid phone number.' . '<br>';
                }
            }

            // ----- Client's sex sanitize and validation ----- //
            if (!empty($sex)) {
                $sex = filter_var($sex, FILTER_SANITIZE_STRING);
                $sex = htmlspecialchars($sex, ENT_QUOTES, 'UTF-8');
            } else {
                if ($language=='spanish') {
                    $errors .= 'Porfavor indicanos el género de la persona con quien nos dirigiremos.' . '<br>';
                }
                if ($language=='english') {
                    $errors .= 'Please add the gender of the person with whom we will be in contact with.' . '<br>';
                }
            }

            // ----- Client's company name sanitize and validation ----- //
            $company_name = filter_var($company_name, FILTER_SANITIZE_STRING);
            $company_name = htmlspecialchars($company_name, ENT_QUOTES, 'UTF-8');

            // ----- Client's country sanitize and validation ----- //
            if (!empty($country)) {
                $country = filter_var($country, FILTER_SANITIZE_STRING);
                $country = htmlspecialchars($country, ENT_QUOTES, 'UTF-8');
            } else {
                if ($language=='spanish') {
                    $errors .= 'Porfavor indícanos el país de ubicación del negocio/trabajo de con quien nos dirigiremos.' . '<br>';
                }
                if ($language=='english') {
                    $errors .= 'Please indicate us the country of location of the person with whom we will be in contact with.' . '<br>';
                }
            }

            // ----- Client's "know_about_us" sanitize and validation ----- //
            if (!empty($know_about_us)) {
                $know_about_us = filter_var($know_about_us, FILTER_SANITIZE_STRING);
                $know_about_us = htmlspecialchars($know_about_us, ENT_QUOTES, 'UTF-8');
            } else {
                if ($language=='spanish') {
                    $errors .= 'Porfavor indícanos cómo te enteraste de nosotros.' . '<br>';
                }
                if ($language=='english') {
                    $errors .= 'Please tell us how you found out about us.' . '<br>';
                }
            }

            // ----- Client's workfield sanitize and validation ----- //
            if (!empty($workfield)) {
                $workfield = filter_var($workfield, FILTER_SANITIZE_STRING);
                $workfield = htmlspecialchars($workfield, ENT_QUOTES, 'UTF-8');
            } else {
                if ($language=='spanish') {
                    $errors .= 'Porfavor indícanos a qué sector laboral te dedicas tu o la empresa a la que representas.' . '<br>';
                }
                if ($language=='english') {
                    $errors .= 'Please indicate the labor sector where you, or the company you represent, work.' . '<br>';
                }
            }

            // ----- Client's acceptance of terms_and_conditions sanitize and validation ----- //
            if (!empty($terms_and_conditions)) {
                $terms_and_conditions = filter_var($terms_and_conditions, FILTER_SANITIZE_STRING);
                $terms_and_conditions = htmlspecialchars($terms_and_conditions, ENT_QUOTES, 'UTF-8');
                if ($terms_and_conditions == 'true') {
                    $terms_and_conditions = true;
                } elseif ($terms_and_conditions == 'false') {
                    $terms_and_conditions = false;
                }
            } else {
                if ($language=='spanish') {
                    $errors .= 'Porfavor acepta los términos y condiciones para poder continuar.' . '<br>';
                }
                if ($language=='english') {
                    $errors .= 'Please accept the terms and conditions to continue.' . '<br>';
                }
            }

            // ----- Client's service required sanitize and validation ----- //
            if (!empty($service_required)) {
                $service_required = filter_var($service_required, FILTER_SANITIZE_STRING);
                $service_required = htmlspecialchars($service_required, ENT_QUOTES, 'UTF-8');
            } else {
                if ($language=='spanish') {
                    $errors .= 'Porfavor indícanos cual es el servicio profesional que necesitas de Draft Media.' . '<br>';
                }
                if ($language=='english') {
                    $errors .= 'Please tell us what is the professional service you need from Draft Media.' . '<br>';
                }
            }

            // ----- Client's package required sanitize and validation ----- //
            if (!empty($package_required)) {
                $package_required = filter_var($package_required, FILTER_SANITIZE_STRING);
                $package_required = htmlspecialchars($package_required, ENT_QUOTES, 'UTF-8');
            } else {
                if ($language=='spanish') {
                    $errors .= 'Porfavor indícanos cual es el paquete que quieres contratar.' . '<br>';
                }
                if ($language=='english') {
                    $errors .= 'Please tell us which is the package you want to hire.' . '<br>';
                }
            }

            if ($service_required == 'dea_webdesign') {

                // ----- Client's project name sanitize and validation ----- //
                if (!empty($project_name)) {
                    $project_name = filter_var($project_name, FILTER_SANITIZE_STRING);
                    $project_name = htmlspecialchars($project_name, ENT_QUOTES, 'UTF-8');
                } else {
                    if ($language=='spanish') {
                        $errors .= 'Porfavor define el nombre que tendrá tu proyecto / empresa en el sitio web.' . '<br>';
                    }
                    if ($language=='english') {
                        $errors .= 'Please define the name that your project / company will have on the website.' . '<br>';
                    }
                }

                // ----- Client's website category sanitize and validation ----- //
                if (!empty($website_category)) {
                    $website_category = filter_var($website_category, FILTER_SANITIZE_STRING);
                    $website_category = htmlspecialchars($website_category, ENT_QUOTES, 'UTF-8');
                } else {
                    if ($language=='spanish') {
                        $errors .= 'Porfavor indícanos la categoría de tipo de sitio web que deseas.' . '<br>';
                    }
                    if ($language=='english') {
                        $errors .= 'Please tell us the category of type of website you want.' . '<br>';
                    }
                }

                // ----- Client's website language sanitize and validation ----- //
                if (!empty($website_language)) {
                    $website_language = filter_var($website_language, FILTER_SANITIZE_STRING);
                    $website_language = htmlspecialchars($website_language, ENT_QUOTES, 'UTF-8');
                } else {
                    if ($language=='spanish') {
                        $errors .= 'Porfavor define el lenguaje en el que deseas que diseñemos tu sitio web.' . '<br>';
                    }
                    if ($language=='english') {
                        $errors .= 'Please define the language in which you want us to design your website.' . '<br>';
                    }
                }

                // ----- Client's website number of views sanitize and validation ----- //
                if (!empty($website_views)) {
                    $website_views = filter_var($website_views, FILTER_SANITIZE_NUMBER_INT);
                    $website_views = htmlspecialchars($website_views, ENT_QUOTES, 'UTF-8');
                } else {
                    if ($language=='spanish') {
                        $errors .= 'Porfavor define el número de vistas que deseas emplear en tu sitio web.' . '<br>';
                    }
                    if ($language=='english') {
                        $errors .= 'Please define the number of views you want to use on your website.' . '<br>';
                    }
                }

                // ----- Client's desition on defining his own base colors sanitize and validation ----- //
                if (!empty($is_base_colors)) {
                    $is_base_colors = filter_var($is_base_colors, FILTER_SANITIZE_STRING);
                    $is_base_colors = htmlspecialchars($is_base_colors, ENT_QUOTES, 'UTF-8');
                    if ($is_base_colors == 'true') {
                        $is_base_colors = true;
                    } elseif ($is_base_colors == 'false') {
                        $is_base_colors = false;
                    }
                } else {
                    if ($language=='spanish') {
                        $errors .= 'Porfavor indícanos si deseas proponer tú los colores base o que quede a nuestro criterio.' . '<br>';
                    }
                    if ($language=='english') {
                        $errors .= 'Please let us know if you want to propose the base colors or leave it at our discretion.' . '<br>';
                    }
                }

                // ----- Client's desire of us attaching to his color propositions sanitize and validation ----- //
                $base_colors_lvl_attch = filter_var($base_colors_lvl_attch, FILTER_SANITIZE_STRING);
                $base_colors_lvl_attch = htmlspecialchars($base_colors_lvl_attch, ENT_QUOTES, 'UTF-8');

                // ----- Client's proposal of base colors sanitize and validation ----- //
                for ($n=0; $n<count($base_color_code); $n++) {
                    $base_color_code[$n] = filter_var($base_color_code[$n], FILTER_SANITIZE_STRING);
                    $base_color_code[$n] = htmlspecialchars($base_color_code[$n], ENT_QUOTES, 'UTF-8');
                    $base_color_priority[$n] = filter_var($base_color_priority[$n], FILTER_SANITIZE_NUMBER_INT);
                    $base_color_priority[$n] = htmlspecialchars($base_color_priority[$n], ENT_QUOTES, 'UTF-8');
                }

                // ----- Client's website URL sanitize and validation ----- //
                if (!empty($website_url)) {
                    $website_url = filter_var($website_url, FILTER_SANITIZE_STRING);
                    $website_url = htmlspecialchars($website_url, ENT_QUOTES, 'UTF-8');
                } else {
                    if ($language=='spanish') {
                        $errors .= 'Porfavor define el URL / dominio que deseas para tu sitio web.' . '<br>';
                    }
                    if ($language=='english') {
                        $errors .= 'Please define the URL / domain you want for your website.' . '<br>';
                    }
                }

                // ----- Client's target audience sanitize and validation ----- //
                if (!empty($target_audience)) {
                    $target_audience = filter_var($target_audience, FILTER_SANITIZE_STRING);
                    $target_audience = htmlspecialchars($target_audience, ENT_QUOTES, 'UTF-8');
                } else {
                    if ($language=='spanish') {
                        $errors .= 'Porfavor indícanos cual es tu público objetivo.' . '<br>';
                    }
                    if ($language=='english') {
                        $errors .= 'Please tell us what your target audience is.' . '<br>';
                    }
                }

                // ----- Client's desire of what he wants to transmit on his website sanitize and validation ----- //
                if (!empty($what_to_transmit)) {
                    $what_to_transmit = htmlspecialchars($what_to_transmit, ENT_QUOTES, 'UTF-8');
                } else {
                    if ($language=='spanish') {
                        $errors .= 'Porfavor indícanos lo que deseas transmitir a tus usuarios en tu sitio web.' . '<br>';
                    }
                    if ($language=='english') {
                        $errors .= 'Please tell us what you want to transmit to your users on your website.' . '<br>';
                    }
                }

                // ----- Client's specifications of the views that he wants for his website sanitize and validation ----- //
                if (!empty($viewsDetails)) {
                    for ($n=0; $n<count($viewsDetails); $n++) {
                        $viewsDetails[$n]['type_of_website'] = $stringNormalizer->normalize(htmlspecialchars($viewsDetails[$n]['type_of_website'], ENT_QUOTES, 'UTF-8'));
                        $viewsDetails[$n]['sections_quantity'] = (int)$stringNormalizer->normalize(htmlspecialchars($viewsDetails[$n]['sections_quantity'], ENT_QUOTES, 'UTF-8'));
                        $viewsDetails[$n]['section1_content'] = $stringNormalizer->normalize(htmlspecialchars($viewsDetails[$n]['section1_content'], ENT_QUOTES, 'UTF-8'));
                        $viewsDetails[$n]['section2_content'] = $stringNormalizer->normalize(htmlspecialchars($viewsDetails[$n]['section2_content'], ENT_QUOTES, 'UTF-8'));
                        $viewsDetails[$n]['section3_content'] = $stringNormalizer->normalize(htmlspecialchars($viewsDetails[$n]['section3_content'], ENT_QUOTES, 'UTF-8'));
                        $viewsDetails[$n]['section4_content'] = $stringNormalizer->normalize(htmlspecialchars($viewsDetails[$n]['section4_content'], ENT_QUOTES, 'UTF-8'));
                        $viewsDetails[$n]['section5_content'] = $stringNormalizer->normalize(htmlspecialchars($viewsDetails[$n]['section5_content'], ENT_QUOTES, 'UTF-8'));
                        $viewsDetails[$n]['is_user_art_concept'] = (int)$stringNormalizer->normalize(htmlspecialchars($viewsDetails[$n]['is_user_art_concept'], ENT_QUOTES, 'UTF-8'));
                        $viewsDetails[$n]['is_ext_art_concept'] = (int)$stringNormalizer->normalize(htmlspecialchars($viewsDetails[$n]['is_ext_art_concept'], ENT_QUOTES, 'UTF-8'));
                        $viewsDetails[$n]['ext_art_concept_url'] = $stringNormalizer->normalize(htmlspecialchars($viewsDetails[$n]['ext_art_concept_url'], ENT_QUOTES, 'UTF-8'));
                        $viewsDetails[$n]['ext_art_concept_exp'] = $stringNormalizer->normalize(htmlspecialchars($viewsDetails[$n]['ext_art_concept_exp'], ENT_QUOTES, 'UTF-8'));
                        $viewsDetails[$n]['is_user_ani_concept'] = (int)$stringNormalizer->normalize(htmlspecialchars($viewsDetails[$n]['is_user_ani_concept'], ENT_QUOTES, 'UTF-8'));
                        $viewsDetails[$n]['is_ext_ani_concept'] = (int)$stringNormalizer->normalize(htmlspecialchars($viewsDetails[$n]['is_ext_ani_concept'], ENT_QUOTES, 'UTF-8'));
                        $viewsDetails[$n]['ext_ani_concept_url'] = $stringNormalizer->normalize(htmlspecialchars($viewsDetails[$n]['ext_ani_concept_url'], ENT_QUOTES, 'UTF-8'));
                        $viewsDetails[$n]['ext_ani_concept_exp'] = $stringNormalizer->normalize(htmlspecialchars($viewsDetails[$n]['ext_ani_concept_exp'], ENT_QUOTES, 'UTF-8'));
                        $viewsDetails[$n]['is_other_concept'] = (int)$stringNormalizer->normalize(htmlspecialchars($viewsDetails[$n]['is_other_concept'], ENT_QUOTES, 'UTF-8'));
                        $viewsDetails[$n]['other_concept_url'] = $stringNormalizer->normalize(htmlspecialchars($viewsDetails[$n]['other_concept_url'], ENT_QUOTES, 'UTF-8'));
                        $viewsDetails[$n]['other_concept_exp'] = $stringNormalizer->normalize(htmlspecialchars($viewsDetails[$n]['other_concept_exp'], ENT_QUOTES, 'UTF-8'));
                        $viewsDetails[$n]['is_logic_diagram'] = (int)$stringNormalizer->normalize(htmlspecialchars($viewsDetails[$n]['is_logic_diagram'], ENT_QUOTES, 'UTF-8'));
                    }
                } else {
                    if ($language=='spanish') {
                        $errors .= 'Porfavor especifícanos lo que deseas en la vista(s) de tu sitio web.' . '<br>';
                    }
                    if ($language=='english') {
                        $errors .= 'Please specify what you want in the view(s) of your website.' . '<br>';
                    }
                }
            }


            // --------------------------------------------------------------------------- //
            // ----- Server response with regard of the DEA Modal Validation process ----- //
            // --------------------------------------------------------------------------- //
            if ($errors == '') {
                $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
                $user = $this->getUser();

                // ----- We save the record of the DEA request (part1: saving the data of dea_requests table) ----- //
                $deaRequest = new DeaRequests();
                $deaRequest->setFirstName($first_name);
                $deaRequest->setLastName($last_name);
                $deaRequest->setPhone($phone);
                $deaRequest->setSex($sex);
                $deaRequest->setCompanyName($company_name);
                $deaRequest->setCountry($country);
                $deaRequest->setKnowAboutUs($know_about_us);
                $deaRequest->setWorkfield($workfield);
                $deaRequest->setTermsAndConditions($terms_and_conditions);
                $deaRequest->setServiceRequired($service_required);
                $deaRequest->setPackageRequired($package_required);
                /*
                    Porfavor, suba los archivos pendientes
                    En Proceso de Revision
                    Aprobado
                    En desarrollo
                    Vigente
                    Vencido
                */
                if ($service_required == 'dea_webdesign') {
                    $deaRequest->setServiceStatus("Porfavor, suba los archivos pendientes");
                } else {
                    $deaRequest->setServiceStatus("En Proceso de Revision");
                }

                // We create a temporal identified on Status cell so that we can retrieve the real id
                // of this DEA request on the database (after that we set the true value of status).
                $timestamp = $actualDate->getTimestamp() - 32400; //32400 = desfase por bug propio de php date
                $temporalId = $first_name . $last_name . $phone . $sex . $company_name . $country . $know_about_us . $workfield . $terms_and_conditions . $service_required . $package_required . $user['id'] . $timestamp;
                $deaRequest->setStatus($temporalId);
                $deaRequest->setCreatedBy($user['id']);
                $deaRequest->setCreatedAt($actualDate->format('Y-m-d H:i:s'));
                $deaRequest::persistAndFlush($deaRequest);

                // We retrieve the DEA request from the database and we insert the true value of status.
                $deaRequestId = $deaRequest::findBy(["status" => $temporalId]);
                if ($deaRequestId!=null) {
                    if (count($deaRequestId)==1) {
                        $deaRequestId = $deaRequestId[0]["id"];
                        $deaRequest->setId($deaRequestId);
                        $deaRequest->setStatus('ACTIVE'); //ACTIVE=este record esta vigente //DELETED=este record ha sido borrado
                        $deaRequest::persistAndFlush($deaRequest);

                        // ----- We save the record of the DEA request (part2: saving the rest of the data) ----- //
                        if ($service_required=='dea_webdesign') {
                            $serviceRequired = new DeaWebdesign();
                            $serviceRequired->setDeaRequestsId($deaRequest->getId());
                            $serviceRequired->setProjectName($project_name);
                            $serviceRequired->setWebsiteCategory($website_category);
                            $deaLanguage = new DeaLanguage();
                            $deaLanguage->setDeaRequestsId($deaRequest->getId());
                            $deaLanguage->setEnglish(0);
                            $deaLanguage->setSpanish(0);
                            if ($website_language=='english') {
                                $deaLanguage->setEnglish(1);
                            }
                            if ($website_language=='spanish') {
                                $deaLanguage->setSpanish(1);
                            }
                            $deaLanguage::persistAndFlush($deaLanguage);
                            $deaLanguage_Id = $deaLanguage::findBy(["dea_requests_id" => $deaRequest->getId()])[0]['id'];
                            $serviceRequired->setDeaLanguageId($deaLanguage_Id);
                            $serviceRequired->setWebsiteViews($website_views);
                            $serviceRequired->setIsBaseColors($is_base_colors);
                            $serviceRequired->setBaseColorsLvlAttch($base_colors_lvl_attch);
                            $serviceRequired->setWebsiteUrl($website_url);
                            $serviceRequired->setTargetAudience($target_audience);
                            $serviceRequired->setWhatToTransmit($what_to_transmit);
                            $serviceRequired::persistAndFlush($serviceRequired);
                            $serviceRequired_Id = $serviceRequired::findBy(["dea_requests_id" => $deaRequest->getId()])[0]['id'];
                            for ($n=0; $n<count($base_color_code); $n++) {
                                $webdesignColors = new DeaWebdesignColors();
                                $webdesignColors->setDeaWebdesignId($serviceRequired_Id);
                                $webdesignColors->setBaseColorCode($base_color_code[$n]);
                                $webdesignColors->setBaseColorPriority($base_color_priority[$n]);
                                $webdesignColors::persistAndFlush($webdesignColors);
                            }
                            for ($n=0; $n<count($viewsDetails); $n++) {
                                $deaWebdesignView = new DeaWebdesignViews();
                                $deaWebdesignView->setDeaWebdesignId($serviceRequired_Id);
                                $deaWebdesignView->setTypeOfWebsite($viewsDetails[$n]['type_of_website']);
                                $deaWebdesignView->setSectionsQuantity($viewsDetails[$n]['sections_quantity']);
                                $deaWebdesignView->setIsUserArtConcept($viewsDetails[$n]['is_user_art_concept']);
                                $deaWebdesignView->setIsExtArtConcept($viewsDetails[$n]['is_ext_art_concept']);
                                $deaWebdesignView->setExtArtConceptUrl($viewsDetails[$n]['ext_art_concept_url']);
                                $deaWebdesignView->setExtArtConceptExp($viewsDetails[$n]['ext_art_concept_exp']);
                                $deaWebdesignView->setIsUserAniConcept($viewsDetails[$n]['is_user_ani_concept']);
                                $deaWebdesignView->setIsExtAniConcept($viewsDetails[$n]['is_ext_ani_concept']);
                                $deaWebdesignView->setExtAniConceptUrl($viewsDetails[$n]['ext_ani_concept_url']);
                                $deaWebdesignView->setExtAniConceptExp($viewsDetails[$n]['ext_ani_concept_exp']);
                                $deaWebdesignView->setIsOtherConcept($viewsDetails[$n]['is_other_concept']);
                                $deaWebdesignView->setOtherConceptUrl($viewsDetails[$n]['other_concept_url']);
                                $deaWebdesignView->setOtherConceptExp($viewsDetails[$n]['other_concept_exp']);
                                $deaWebdesignView->setIsLogicDiagram($viewsDetails[$n]['is_logic_diagram']);
                                $deaWebdesignView->setSection1Content($viewsDetails[$n]['section1_content']);
                                $deaWebdesignView->setSection2Content($viewsDetails[$n]['section2_content']);
                                $deaWebdesignView->setSection3Content($viewsDetails[$n]['section3_content']);
                                $deaWebdesignView->setSection4Content($viewsDetails[$n]['section4_content']);
                                $deaWebdesignView->setSection5Content($viewsDetails[$n]['section5_content']);
                                $deaWebdesignView::persistAndFlush($deaWebdesignView);
                            }
                        }

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
                                $mail->addAddress($user['email']);// Who to

                                //Content
                                $mail->isHTML(true);                                  // Set email format to HTML
                                $mail->Subject = 'Draft Media - Tu solicitud DEA ha sido registrada exitosamente'; //El subject no agarra acentos
                                if ($language=='english') {
                                    $mail->Subject = 'Draft Media - Your DEA request has been successfully registered'; //El subject no agarra acentos
                                }
                                $preparedMessage ='
                                <html>
                                    <body>
                                      <p>De: Draft Media</p>
                                      <p>¡La solicitud del servicio profesional (' . $service_required . ":" . $package_required . ') que registraste en Draft Media fue registrada exitósamente!.</p>
                                      <p>El equipo de Draft Media analizará tu petición y evaluará si se trata de un proyecto realizable por la empresa.</p>
                                      <br>
                                      <br>
                                      <p>¡Te Contactaremos pronto!.</p>
                                      <p>GRACIAS POR TU INTERES EN NOSOTROS. TE DESEAMOS EXITO EN TU PROYECTO.</p>
                                    </body>
                                </html>
                                ';
                                if ($language=='english') {
                                    if ($package_required=='paquete personal') {
                                        $pR = 'Personal Package';
                                    } elseif ($package_required=='paquete emprendedor') {
                                        $pR = 'Entrepreneur Package';
                                    } elseif ($package_required=='paquete empresarial') {
                                        $pR = 'Business Package';
                                    } else {
                                        throw new \Exception("\"Package Required\" does not posses a known value. Its current value is: $package_required");
                                    }
                                    $preparedMessage ='
                                    <html>
                                        <body>
                                          <p>From: Draft Media</p>
                                          <p>The professional service request (' . $service_required . ":" . $pR . ') that you registered in Draft Media was registered successfully!.</p>
                                          <p>The Draft Media team will analyze your request and evaluate if it is a project that can be carried out by the company.</p>
                                          <br>
                                          <br>
                                          <p>We will contact you soon!.</p>
                                          <p>THANKS FOR YOUR INTEREST ON US. WE WISH YOU SUCCESS IN YOUR PROJECT.</p>
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
                                            $mail->Subject = 'Draft Media Admin Panel - A user has requested a Service'; //El subject no agarra acentos
                                            $preparedMessage ='
                                            <html>
                                                <body>
                                                  <p>De: '.$user['email'].'</p>
                                                  <p>Un usuario, con nombre de '.$user['first_name'].' '.$user['last_name'].', ha solicitado un Servicio de Draft Media:</p>
                                                  <p>'.$service_required.'</p>
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

                        // ----- We send a JSON to javascript to inform that the DEA request was successful ----- //
                        $message = "Tu Solicitud DEA se ha registrado exitósamente!" . '</br></br>' . "El personal de Draft Media la revisará y evaluará para luego contactarte." . '</br>' . " Te invitamos a revisar tu correo electrónico para leer más detalles.";
                        if ($language=='english') {
                            $message = "Your DEA Application has been successfully registered!" . '</br></br>' . "The staff of Draft Media will review and evaluate it and then contact you." . '</br>' . " We invite you to check your email to read more details.";
                        }
                        echo json_encode([
                            'status' => 201, //201 = Created
                            'message' => $message,
                            'data' => $deaRequest->getId()
                        ]);
                    } else {
                        throw new \Exception("Temporal ID searched, on \"status\" cell on \"dea_requests\" table, on the database was duplicated (" . $temporalId . ")");
                    }
                } else {
                    throw new \Exception("Temporal ID searched, on \"status\" cell on \"dea_requests\" table, on the database could not be found (" . $temporalId . ")");
                }
            } else {
                // ----- We send a JSON to javascript to inform that an error happened ----- //
                echo json_encode([
                    'status' => 400, //400=Bad Request
                    'message' => $errors,
                    'data' => []
                ]);
            }
        }
    }

    /**
     * This method is in charge of directly upload the desired file, of the DEA request, to the server of DraftMedia.
     *
     * @author Miranda Meza César
     * DATE November 01, 2018
     */
    public function ajaxUploadFileAction()
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
                $hA->isHackAttempt("dea", "ajaxUploadFile", $this->getUser());
                throw new \Exception("User was scrypting on Draft Media Server. Language value couldn't be identified.");
            }
        } else {
            $language = 'english';
        }

        //x = id of "dea_webdesign" table but encrypted to not let the user have an idea of what this is.
        $deaWebdesignId = $_POST['x'];

        // ----- "dea_webdesign" Id of the Client's request service sanitize and validation ----- //
        if (!empty($deaWebdesignId)) {
            $deaWebdesignId = filter_var($deaWebdesignId, FILTER_SANITIZE_NUMBER_INT);
            $deaWebdesignId = htmlspecialchars($deaWebdesignId, ENT_QUOTES, 'UTF-8');
        } else {
            $hA = new CoreHackAttempt();
            $hA->isHackAttempt("dea", "ajaxUploadFile", $this->getUser());
            throw new \Exception("User was scrypting on Draft Media Server");
        }

        if (isset($_GET)) {
            if (isset($_GET["serviceRequired"])) {
                $fileType = get_object_vars(json_decode($_POST['fileType']));
                for ($n=0; $n<count($fileType); $n++) {
                    $fileType[$n] = filter_var($fileType[$n], FILTER_SANITIZE_STRING);
                    $fileType[$n] = htmlspecialchars($fileType[$n], ENT_QUOTES, 'UTF-8');
                }
                $view = (int)$_POST['view']-1;
                $view = filter_var($view, FILTER_SANITIZE_NUMBER_INT);
                $view = htmlspecialchars($view, ENT_QUOTES, 'UTF-8');
                $deaWebdesign = new DeaWebdesign();
                $clientDeaWebdesign = $deaWebdesign::find($deaWebdesignId);
                // If there's no match with the Id decrypted, then the user was trying to hack. Else proceed
                if ($clientDeaWebdesign != null) {
                    $deaRequests_id = $clientDeaWebdesign[0]['dea_requests_id'];
                    $deaRequests = new DeaRequests();
                    $deaRequest = $deaRequests::find($deaRequests_id)[0];
                    $user = $this->getUser();
                    if (($deaRequest['created_by']==$user['id']) || ($user['role']=='admin')) {
                        // If $serviceRequired matches any of the services provided by Draft Media, then proceed
                        if ($deaRequest['service_required'] == 'dea_webdesign') {
                            $errors = "";
                            $uploadDirectory = './img/uploads/dea/';
                            $user = $this->getUser();
                            if (!file_exists('./img/uploads/dea/' . $user["id"])) {
                                mkdir('./img/uploads/dea/' . $user["id"], 0777, true);
                            }
                            $deaWebdesignViews = new DeaWebdesignViews();
                            $userWebdesignViews = $deaWebdesignViews::findBy(["dea_webdesign_id" => $deaWebdesignId]);
                            if ($userWebdesignViews != null) {
                                foreach($_FILES as $file) {
                                    if (preg_match("/[\<\>\!\@\#\$\%\^\&\*\(\)\{\}\[\]\\\|\=\+\?\/\¡\¿\"\']+/", explode(".", $file["name"])[0]) == 0) {
                                        if (($file['size']/1024/1024) <= 5) {
                                            $temp = explode(".", $file["name"]);
                                            $newfilename = round(microtime(true)) . '.' . end($temp);
                                            $dirDestination = $uploadDirectory . $user['id'] . '/' . $newfilename;
                                            if (move_uploaded_file($file['tmp_name'], $dirDestination)) {
                                                // File uploaded successfully
                                                if ($deaRequest['service_required'] == 'dea_webdesign') {
                                                    if (count($fileType) == 1) {
                                                        //update on data base the directory of the uploaded file for artisticConcept / animationConcept
                                                        if (!empty($userWebdesignViews[$view][$fileType["0"]])) {
                                                            unlink($userWebdesignViews[$view][$fileType["0"]]);
                                                        }
                                                        $userWebdesignViews[$view][$fileType["0"]] = $dirDestination;
                                                        $deaWebdesignViews::persistAndFlush($userWebdesignViews[$view]);
                                                    } else {
                                                        //update on data base the directory of the uploaded file and the explanation of the logic diagram
                                                        if (!empty($userWebdesignViews[$view][$fileType["0"]])) {
                                                            unlink($userWebdesignViews[$view][$fileType["0"]]);
                                                        }
                                                        $userWebdesignViews[$view][$fileType["0"]] = $dirDestination;
                                                        $stringNormalizer = new StringNormalizer();
                                                        $userWebdesignViews[$view]["logic_diagram_exp"] = $stringNormalizer->normalize($fileType["1"]);
                                                        $deaWebdesignViews::persistAndFlush($userWebdesignViews[$view]);
                                                    }
                                                }
                                            } else {
                                                if ($language=='spanish') {
                                                    $errors = "Intente cargar el archivo con una dirección menor a 255 caracteres. Si esto no funciona, entonces algo pudiera estar corrompido en el archivo que se desea cargar." . '<br>';
                                                }
                                                if ($language=='english') {
                                                    $errors = "Try loading the file with an address less than 255 characters. If this does not work, then something could be corrupted in the file that you want to upload." . '<br>';
                                                }
                                            }
                                        } else {
                                            if ($language=='spanish') {
                                                $errors = "El archivo pesa más de 5MB. Reduzca la calidad del archivo para poder cargarlo." . '<br>';
                                            }
                                            if ($language=='english') {
                                                $errors = "The file weighs more than 5MB. Reduce the quality of the file to be able to load it." . '<br>';
                                            }
                                        }
                                    } else {
                                        if ($language=='spanish') {
                                            $errors = "El nombre del archivo no es aceptable." . '<br>';
                                        }
                                        if ($language=='english') {
                                            $errors = "The name of the file is not acceptable." . '<br>';
                                        }
                                    }
                                }
                            } else {
                                $hA = new CoreHackAttempt();
                                $hA->isHackAttempt("dea", "ajaxUploadFile", $this->getUser());
                                throw new \Exception("User was scrypting on Draft Media Server");
                            }
                            $message = "El archivo se cargo exitosamente.";
                            if ($language=='english') {
                                $message = "The file was successfully uploaded.";
                            }
                            if ($errors=="") {
                                echo json_encode([
                                    'status' => 200, //200 = OK
                                    'message' => $message,
                                    'data' => []
                                ]);
                            } else {
                                echo json_encode([
                                    'status' => 500, //500 = Internal Server Error
                                    'message' => $errors,
                                    'data' => []
                                ]);
                            }
                        } else {
                            $hA = new CoreHackAttempt();
                            $hA->isHackAttempt("dea", "ajaxUploadFile", $this->getUser());
                            throw new \Exception("User was scrypting on Draft Media Server");
                        }
                    } else {
                        $hA = new CoreHackAttempt();
                        $hA->isHackAttempt("dea", "ajaxUploadFile", $this->getUser());
                        throw new \Exception("User was scrypting on Draft Media Server");
                    }
                } else {
                    $hA = new CoreHackAttempt();
                    $hA->isHackAttempt("dea", "ajaxUploadFile", $this->getUser());
                    throw new \Exception("User was scrypting on Draft Media Server");
                }
            } else {
                $hA = new CoreHackAttempt();
                $hA->isHackAttempt("dea", "ajaxUploadFile", $this->getUser());
                throw new \Exception("User was scrypting on Draft Media Server");
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
    public function ajaxDeaUploadFilesVisitsAction() {
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
                    $draftmediaVisits[$n]['Dea_uploadFiles_auth_visits']++;
                    $DMV::persistAndFlush($draftmediaVisits[$n]);
                }
            } else {
                //else, count an anonymous visit
                $DMV = new DraftmediaVisits();
                $draftmediaVisits = $DMV::findAll();
                $n = count($draftmediaVisits)-1;
                $draftmediaVisits[$n]['Dea_uploadFiles_anonym_visits']++;
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
    public function ajaxDeaUploadFilesTimeAction() {
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
                        $draftmediaVisits[$n]['Dea_uploadFiles_auth_time']++;
                    }
                    $DMV::persistAndFlush($draftmediaVisits[$n]);
                }
            } else {
                //else, count as anonymous time
                $DMV = new DraftmediaVisits();
                $draftmediaVisits = $DMV::findAll();
                $n = count($draftmediaVisits)-1;
                for ($i=0; $i<5; $i++) {
                    $draftmediaVisits[$n]['Dea_uploadFiles_anonym_time']++;
                }
                $DMV::persistAndFlush($draftmediaVisits[$n]);
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
    public function ajaxDeaIndexVisitsAction() {
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
                    $draftmediaVisits[$n]['Dea_index_auth_visits']++;
                    $DMV::persistAndFlush($draftmediaVisits[$n]);
                }
            } else {
                //else, count an anonymous visit
                $DMV = new DraftmediaVisits();
                $draftmediaVisits = $DMV::findAll();
                $n = count($draftmediaVisits)-1;
                $draftmediaVisits[$n]['Dea_index_anonym_visits']++;
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
    public function ajaxDeaIndexTimeAction() {
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
                        $draftmediaVisits[$n]['Dea_index_auth_time']++;
                    }
                    $DMV::persistAndFlush($draftmediaVisits[$n]);
                }
            } else {
                //else, count as anonymous time
                $DMV = new DraftmediaVisits();
                $draftmediaVisits = $DMV::findAll();
                $n = count($draftmediaVisits)-1;
                for ($i=0; $i<5; $i++) {
                    $draftmediaVisits[$n]['Dea_index_anonym_time']++;
                }
                $DMV::persistAndFlush($draftmediaVisits[$n]);
            }
        }
    }

    /**
     * This method shows the upload files view of the DEA request that the client made. For easier code maintainability
     * and trustworthiness of the functionality of the DEA requests system, it was decided to separate the uploads
     * part and the rest of the DEA requests functionality.
     *
     * @return void
     * @throws \Exception
     *
     * @author Miranda Meza César
     * DATE November 07, 2018
     */
    public function uploadFilesAction()
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
                $hA->isHackAttempt("dea", "uploadFiles", $this->getUser());
                throw new \Exception("User was scrypting on Draft Media Server. Language value couldn't be identified.");
            }
        } else {
            $language = 'english';
        }

        $deaRequestsId = $_POST['x'];

        // ----- "dea_webdesign" Id of the Client's request service sanitize and validation ----- //
        if (!empty($deaRequestsId)) {
            $deaRequestsId = filter_var($deaRequestsId, FILTER_SANITIZE_NUMBER_INT);
            $deaRequestsId = htmlspecialchars($deaRequestsId, ENT_QUOTES, 'UTF-8');
            $user = $this->getUser();
            $deaRequests = new DeaRequests();
            $deaRequest = $deaRequests::find($deaRequestsId);
            if ($deaRequest == null) {
                $hA = new CoreHackAttempt();
                $hA->isHackAttempt("dea", "uploadFiles", $this->getUser());
                throw new \Exception("User was scrypting on Draft Media Server");
            }
            if ($deaRequest[0]['created_by']!=$user['id'] && $user['role']!='admin') {
                $hA = new CoreHackAttempt();
                $hA->isHackAttempt("dea", "uploadFiles", $this->getUser());
                throw new \Exception("User was scrypting on Draft Media Server");
            }
            $deaWebdesign = new DeaWebdesign();
            $deaWebdesignId = $deaWebdesign::findBy(["dea_requests_id" => $deaRequestsId]);
            if ($deaWebdesignId != null) {
                $deaWebdesignId = $deaWebdesignId[0]['id'];
            }
        } else {
            $hA = new CoreHackAttempt();
            $hA->isHackAttempt("dea", "uploadFiles", $this->getUser());
            throw new \Exception("User was scrypting on Draft Media Server");
        }

        $HTML = '';
        if ($deaWebdesignId != null) {
            $deaWebdesignViews = new DeaWebdesignViews();
            $websiteViews = $deaWebdesignViews::findBy(["dea_webdesign_id" => $deaWebdesignId]);
            if ($language=='spanish') {
                for($n=0; $n<count($websiteViews); $n++) {
                    if ($websiteViews[$n]['is_user_art_concept']=='1' || $websiteViews[$n]['is_user_ani_concept']=='1' || $websiteViews[$n]['is_logic_diagram']=='1') {
                        $HTML .=
                            '
                    <div id="Vista'. ($n+1) .'">
                        <h2 class="text-center title-text fontsize_16px" style="margin-top: 20px; font-weight: bold; color: #1B1B1B; margin-right: 10%; margin-left: 10%;">Tienes archivos pendientes para subir en la Vista '. ($n+1) .'</h2>
                        <h2 class="text-center title-text fontsize_16px" style="margin-top: 0px; font-weight: bold; color: #1B1B1B; margin-right: 10%; margin-left: 10%;">('. $websiteViews[$n]['type_of_website'] .')</h2>
                    ';
                        if ($websiteViews[$n]['is_user_art_concept'] == '1') {
                            $HTML .=
                                '
                        <div class="C-verticalAlignEnd" style="float: left; min-height: 141px; margin-right: 10%; margin-left: 10%; width: 85%;">
                            <form enctype="multipart/form-data">
                                <label class="content-text" style="font-weight: bold; color: #1B1B1B; display: block; text-align: start;">Sube tu concepto artístico de esta vista: *</label>
                                <input class="uArtC content-text" type="file" id="#user_art_concept_dir" style="font-weight: bold; color: #1B1B1B; display: block;"/>
                                <input type="submit" class="content-text" value="Upload" style="font-weight: 450; color: #1B1B1B; display: block;"/>
                            </form>
                        </div>
                        ';
                        }
                        if ($websiteViews[$n]['is_user_ani_concept'] == '1') {
                            $HTML .=
                                '
                        <div class="C-verticalAlignEnd" style="float: left; min-height: 141px; margin-right: 10%; margin-left: 10%; width: 85%;">
                            <form enctype="multipart/form-data">
                                <label class="content-text" style="font-weight: bold; color: #1B1B1B; display: block; text-align: start;">Sube tu concepto de animación de esta vista: *</label>
                                <input class="rAniC content-text" type="file" id="#user_ani_concept_dir" style="font-weight: bold; color: #1B1B1B; display: block;"/>
                                <input type="submit" class="content-text" value="Upload" style="font-weight: 450; color: #1B1B1B; display: block;"/>
                            </form>
                        </div>
                        ';
                        }
                        if ($websiteViews[$n]['is_logic_diagram'] == '1') {
                            $HTML .=
                                '
                        <div class="C-verticalAlignEnd" style="float: left; min-height: 141px; margin-right: 10%; margin-left: 10%; width: 85%;">
                            <form enctype="multipart/form-data">
                                <label class="content-text" style="font-weight: bold; color: #1B1B1B; display: block; text-align: start;">Sube tu diagrama lógico / técnico de esta vista: *</label>
                                <input class="lDiaD content-text" type="file" id="#logic_diagram_dir" style="font-weight: bold; color: #1B1B1B; display: block;"/>
                                <input class="content-text" type="submit" value="Save Description and Upload File" style="font-weight: 450; color: #1B1B1B; display: block;"/>
                            </form>
                        </div>
                        <div class="C-verticalAlignEnd" style="float: left; margin-right: 10%; margin-left: 10%; width: 85%; margin-bottom: 50px;">
                            <div class="form-group label-floating">
                                <label class="content-text" style="font-weight: bold; color: #1B1B1B; display: block; text-align: start;">Porfavor, escríbenos aquí mismo una breve explicación de tu diagrama *</label>
                                <input class="content-text form-control lDiaE" type="text" id="logic_diagram_exp" style="display: block; width: 93%;"/>
                            </div>
                        </div>
                        ';
                        }
                        $HTML .=
                            '
                    </div>
                    ';
                    }
                }
            }
            if ($language=='english') {
                for($n=0; $n<count($websiteViews); $n++) {
                    if ($websiteViews[$n]['is_user_art_concept']=='1' || $websiteViews[$n]['is_user_ani_concept']=='1' || $websiteViews[$n]['is_logic_diagram']=='1') {
                        $HTML .=
                            '
                    <div id="Vista'. ($n+1) .'">
                        <h2 class="text-center title-text fontsize_16px" style="margin-top: 20px; font-weight: bold; color: #1B1B1B; margin-right: 10%; margin-left: 10%;">You have pending files to upload in View '. ($n+1) .'</h2>';
                        if (strtolower($websiteViews[$n]['type_of_website'])=='pagina de inicio') {
                            $HTML .=
                                '
                                    <h2 class="text-center title-text fontsize_16px" style="margin-top: 0px; font-weight: bold; color: #1B1B1B; margin-right: 10%; margin-left: 10%;">(Home page)</h2>
                                ';
                        } elseif (strtolower($websiteViews[$n]['type_of_website'])=='pagina de inicio de sesion') {
                            $HTML .=
                                '
                                    <h2 class="text-center title-text fontsize_16px" style="margin-top: 0px; font-weight: bold; color: #1B1B1B; margin-right: 10%; margin-left: 10%;">(Login page)</h2>
                                ';
                        } elseif (strtolower($websiteViews[$n]['type_of_website'])=='pagina de registro de cuenta') {
                            $HTML .=
                                '
                                    <h2 class="text-center title-text fontsize_16px" style="margin-top: 0px; font-weight: bold; color: #1B1B1B; margin-right: 10%; margin-left: 10%;">(Register page)</h2>
                                ';
                        } elseif (strtolower($websiteViews[$n]['type_of_website'])=='pagina para pefil de usuario') {
                            $HTML .=
                                '
                                    <h2 class="text-center title-text fontsize_16px" style="margin-top: 0px; font-weight: bold; color: #1B1B1B; margin-right: 10%; margin-left: 10%;">(User Profile page)</h2>
                                ';
                        } elseif (strtolower($websiteViews[$n]['type_of_website'])=='pagina tipo blog') {
                            $HTML .=
                                '
                                    <h2 class="text-center title-text fontsize_16px" style="margin-top: 0px; font-weight: bold; color: #1B1B1B; margin-right: 10%; margin-left: 10%;">(Blog page)</h2>
                                ';
                        } elseif (strtolower($websiteViews[$n]['type_of_website'])=='pagina tipo e-commerce') {
                            $HTML .=
                                '
                                    <h2 class="text-center title-text fontsize_16px" style="margin-top: 0px; font-weight: bold; color: #1B1B1B; margin-right: 10%; margin-left: 10%;">(e-commerce page)</h2>
                                ';
                        } elseif (strtolower($websiteViews[$n]['type_of_website'])=='pagina para carrito de compras') {
                            $HTML .=
                                '
                                    <h2 class="text-center title-text fontsize_16px" style="margin-top: 0px; font-weight: bold; color: #1B1B1B; margin-right: 10%; margin-left: 10%;">(Shopping cart page)</h2>
                                ';
                        } elseif (strtolower($websiteViews[$n]['type_of_website'])=='pagina de portafolio de trabajos personal') {
                            $HTML .=
                                '
                                    <h2 class="text-center title-text fontsize_16px" style="margin-top: 0px; font-weight: bold; color: #1B1B1B; margin-right: 10%; margin-left: 10%;">(Portfolio page)</h2>
                                ';
                        } elseif (strtolower($websiteViews[$n]['type_of_website'])=='pagina de nosotros / acerca de') {
                            $HTML .=
                                '
                                    <h2 class="text-center title-text fontsize_16px" style="margin-top: 0px; font-weight: bold; color: #1B1B1B; margin-right: 10%; margin-left: 10%;">(About Us page)</h2>
                                ';
                        } elseif (strtolower($websiteViews[$n]['type_of_website'])=='pagina de contacto') {
                            $HTML .=
                                '
                                    <h2 class="text-center title-text fontsize_16px" style="margin-top: 0px; font-weight: bold; color: #1B1B1B; margin-right: 10%; margin-left: 10%;">(Contact page)</h2>
                                ';
                        } elseif (strtolower($websiteViews[$n]['type_of_website'])=='pagina de inicio de dashboard') {
                            $HTML .=
                                '
                                    <h2 class="text-center title-text fontsize_16px" style="margin-top: 0px; font-weight: bold; color: #1B1B1B; margin-right: 10%; margin-left: 10%;">(Dashboard Home page)</h2>
                                ';
                        } elseif (strtolower($websiteViews[$n]['type_of_website'])=='pagina adicional para dashboard') {
                            $HTML .=
                                '
                                    <h2 class="text-center title-text fontsize_16px" style="margin-top: 0px; font-weight: bold; color: #1B1B1B; margin-right: 10%; margin-left: 10%;">(Additional Dashboard page)</h2>
                                ';
                        } elseif (strtolower($websiteViews[$n]['type_of_website'])=='otro / pagina personalizable') {
                            $HTML .=
                                '
                                    <h2 class="text-center title-text fontsize_16px" style="margin-top: 0px; font-weight: bold; color: #1B1B1B; margin-right: 10%; margin-left: 10%;">(Other / Customized page)</h2>
                                ';
                        } else {
                            throw new \Exception('strtolower($websiteViews[$n][\'type_of_website\']) didn\'t had a match with the value it had ('.strtolower($websiteViews[$n]['type_of_website']).')');
                        }
                        if ($websiteViews[$n]['is_user_art_concept'] == '1') {
                            $HTML .=
                                '
                        <div class="C-verticalAlignEnd" style="float: left; min-height: 141px; margin-right: 10%; margin-left: 10%; width: 85%;">
                            <form enctype="multipart/form-data">
                                <label class="content-text" style="font-weight: bold; color: #1B1B1B; display: block; text-align: start;">Upload your artistic concept of this view: *</label>
                                <input class="uArtC content-text" type="file" id="#user_art_concept_dir" style="font-weight: bold; color: #1B1B1B; display: block;"/>
                                <input type="submit" class="content-text" value="Upload" style="font-weight: 450; color: #1B1B1B; display: block;"/>
                            </form>
                        </div>
                        ';
                        }
                        if ($websiteViews[$n]['is_user_ani_concept'] == '1') {
                            $HTML .=
                                '
                        <div class="C-verticalAlignEnd" style="float: left; min-height: 141px; margin-right: 10%; margin-left: 10%; width: 85%;">
                            <form enctype="multipart/form-data">
                                <label class="content-text" style="font-weight: bold; color: #1B1B1B; display: block; text-align: start;">Upload your concept of animation from this view: *</label>
                                <input class="rAniC content-text" type="file" id="#user_ani_concept_dir" style="font-weight: bold; color: #1B1B1B; display: block;"/>
                                <input type="submit" class="content-text" value="Upload" style="font-weight: 450; color: #1B1B1B; display: block;"/>
                            </form>
                        </div>
                        ';
                        }
                        if ($websiteViews[$n]['is_logic_diagram'] == '1') {
                            $HTML .=
                                '
                        <div class="C-verticalAlignEnd" style="float: left; min-height: 141px; margin-right: 10%; margin-left: 10%; width: 85%;">
                            <form enctype="multipart/form-data">
                                <label class="content-text" style="font-weight: bold; color: #1B1B1B; display: block; text-align: start;">Upload your logic / technical diagram of this view: *</label>
                                <input class="lDiaD content-text" type="file" id="#logic_diagram_dir" style="font-weight: bold; color: #1B1B1B; display: block;"/>
                                <input class="content-text" type="submit" value="Save Description and Upload File" style="font-weight: 450; color: #1B1B1B; display: block;"/>
                            </form>
                        </div>
                        <div class="C-verticalAlignEnd" style="float: left; margin-right: 10%; margin-left: 10%; width: 85%; margin-bottom: 50px;">
                            <div class="form-group label-floating">
                                <label class="content-text" style="font-weight: bold; color: #1B1B1B; display: block; text-align: start;">Please, write a brief explanation of your diagram here *</label>
                                <input class="content-text form-control lDiaE" type="text" id="logic_diagram_exp" style="display: block; width: 93%;"/>
                            </div>
                        </div>
                        ';
                        }
                        $HTML .=
                            '
                    </div>
                    ';
                    }
                }
            }

        } else {
            $deaWebdesignId = 'null';
        }

        // Render and display the upload Files view
        View::renderTemplate('Dea/uploadFiles/index.html.twig', [
            "HTML" => $HTML,
            "x" => $deaWebdesignId, //x = "dea_webdesign" id of current service request from client.
            'language' => $language
        ]);
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
                $hA->isHackAttempt("dea", "index", $this->getUser());
                throw new \Exception("User was scrypting on Draft Media Server. Language value couldn't be identified.");
            }
        } else {
            $language = 'english';
        }

        View::renderTemplate('Dea/index/index.html.twig', [
            'language' => $language
        ]);
    }
}
