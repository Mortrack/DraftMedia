<?php

namespace App\Controllers;     //The namespace must match the father directory oh the .php file were it will be used

use App\Config;
use App\Models\DeaRequests;
use App\Models\DeaWebdesign;
use App\Models\DeaWebdesignViews;
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
class UserRequests extends \Core\Controller
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
                $hA->isHackAttempt("user_requests", "before", $user);
            } catch (\Exception $e) {
                $hA->isHackAttempt("user_requests", "before", "");
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
     * This method is in charge of counting how many times the view has been visited and it also identifies
     * if such visits were made by an authenticated user or an anonymous user.
     *
     * @throws \Exception
     *
     * @author Miranda Meza César
     * DATE November 17, 2018
     */
    public function ajaxUserRequestsIndexVisitsAction() {
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
                    $draftmediaVisits[$n]['UserRequests_index_auth_visits']++;
                    $DMV::persistAndFlush($draftmediaVisits[$n]);
                }
            } else {
                //else, count an anonymous visit
                $DMV = new DraftmediaVisits();
                $draftmediaVisits = $DMV::findAll();
                $n = count($draftmediaVisits)-1;
                $draftmediaVisits[$n]['UserRequests_index_anonym_visits']++;
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
    public function ajaxUserRequestsIndexTimeAction() {
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
                        $draftmediaVisits[$n]['UserRequests_index_auth_time']++;
                    }
                    $DMV::persistAndFlush($draftmediaVisits[$n]);
                }
            } else {
                //else, count as anonymous time
                $DMV = new DraftmediaVisits();
                $draftmediaVisits = $DMV::findAll();
                $n = count($draftmediaVisits)-1;
                for ($i=0; $i<5; $i++) {
                    $draftmediaVisits[$n]['UserRequests_index_anonym_time']++;
                }
                $DMV::persistAndFlush($draftmediaVisits[$n]);
            }
        }
    }

    /**
     * This method is in charge of rendering and displaying the User's Requests view.
     * This method also updates the current status of the user services.
     *
     * @return void
     * @throws \Exception
     *
     * @author Miranda Meza César
     * DATE November 08, 2018
     */
    public function indexAction()
    {
        //TODO: Falta implementar "solicitar vistas adicionales" sobre un mismo pedido.

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
                $hA->isHackAttempt("user_requests", "index", $this->getUser());
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
        if ($user['role'] == 'admin') {
            // find all dea requests
            $dReq = new DeaRequests();
            $deaRequests = $dReq::findBy(["status" => "ACTIVE"]);
        } else {
            // find only the dea requests that were created by the user
            $dReq = new DeaRequests();
            $deaRequests = $dReq::findBy(["created_by" => $user['id']]);
            if ($deaRequests != null) {
                $deaRequests2 = $deaRequests;
                $i=0;
                for ($n=0; $n<count($deaRequests2); $n++) {
                    if ($deaRequests2[$n]['status'] == "ACTIVE") {
                        $deaRequests[$i] = $deaRequests2[$n];
                        $i++;
                    }
                }
            }
        }
        $HTML = '';
        if ($language=='spanish') {
            if ($deaRequests != null) {
                for ($n=0; $n<count($deaRequests); $n++) {
                    $HTML .=
                        '
                    <tr class="content-text text-center C-text-darkgray" id="' . $deaRequests[$n]['id'] . '">
                        
                        <td><span class="content-text C-text-black fontsize_14px">'. date("Y-m-d", strtotime($deaRequests[$n]['created_at'])) .'</span></td>
                        <td><span class="content-text C-text-black fontsize_14px">'. $deaRequests[$n]['first_name'] .' '. $deaRequests[$n]['last_name'] .'</span></td>
                    ';
                    if ($deaRequests[$n]['service_required'] == 'dea_webdesign') {
                        $HTML .=
                            '
                            <td><span class="content-text C-text-black fontsize_14px">Diseño Web</span></td>
                        ';
                    }
                    if ($deaRequests[$n]['service_required'] == 'dea_multimedia') {
                        $HTML .=
                            '
                            <td><span class="content-text C-text-black fontsize_14px">Multimedia</span></td>
                        ';
                    }
                    if ($deaRequests[$n]['service_required'] == 'dea_planning') {
                        $HTML .=
                            '
                            <td><span class="content-text C-text-black fontsize_14px">Planeación</span></td>
                        ';
                    }
                    if ($deaRequests[$n]['service_required'] == 'dea_community_management') {
                        $HTML .=
                            '
                            <td><span class="content-text C-text-black fontsize_14px">Manejo de Redes Sociales</span></td>
                        ';
                    }
                    $HTML .=
                        '
                        <td><span class="content-text C-text-black fontsize_14px">'. $deaRequests[$n]['package_required'] .'</span></td>
                    ';
                    if ($deaRequests[$n]['service_status'] == 'Porfavor, suba los archivos pendientes') {
                        $deaWebdesign = new DeaWebdesign();
                        $deaWebdesign_Id = $deaWebdesign::findBy(["dea_requests_id" => $deaRequests[$n]['id']])[0]['id'];
                        $deaWebdesignViews = new DeaWebdesignViews();
                        $clientWebdesignViews = $deaWebdesignViews::findBy(["dea_webdesign_id" => $deaWebdesign_Id]);
                        if ($clientWebdesignViews != null) {
                            $isDirNull = false;
                        }
                        for ($i=0; $i<count($clientWebdesignViews); $i++) {
                            $view = $clientWebdesignViews[$i];
                            if ($view['is_user_art_concept']=='1') {
                                if ($view['user_art_concept_dir']==null || $view['user_art_concept_dir']=='') {
                                    $isDirNull = true;
                                }
                            }
                            if ($view['is_user_ani_concept']=='1') {
                                if ($view['user_ani_concept_dir']==null || $view['user_ani_concept_dir']=='') {
                                    $isDirNull = true;
                                }
                            }
                            if ($view['is_logic_diagram']=='1') {
                                if ($view['logic_diagram_dir']==null || $view['logic_diagram_dir']=='') {
                                    $isDirNull = true;
                                }
                            }
                            if (!$isDirNull && ($i+1)==count($clientWebdesignViews)) {
                                $deaRequests[$n]['service_status'] = 'En Proceso de Revision';
                                $dReq::persistAndFlush($deaRequests[$n]);
                            }
                            if ($isDirNull && ($i+1)==count($clientWebdesignViews)) {
                                $HTML .=
                                    '
                                    <td><span class="content-text C-text-black fontsize_14px bg-warning">'. $deaRequests[$n]['service_status'] .'</span></td>
                                    ';
                            }
                        }
                    }
                    if ($deaRequests[$n]['service_status'] == 'En Proceso de Revision') {
                        $HTML .=
                            '
                            <td><span class="content-text C-text-black fontsize_14px" style="background:#E6AC00;">'. $deaRequests[$n]['service_status'] .'</span></td>
                        ';
                    }
                    if ($deaRequests[$n]['service_status'] == 'En desarrollo') {
                        $HTML .=
                            '
                            <td><span class="content-text C-text-black fontsize_14px" style="background:#E6AC00;">'. $deaRequests[$n]['service_status'] .'</span></td>
                        ';
                    }
                    if ($deaRequests[$n]['service_status'] == 'Aprobado') {
                        $HTML .=
                            '
                            <td><span class="content-text C-text-black fontsize_14px bg-success">'. $deaRequests[$n]['service_status'] .'</span></td>
                        ';
                    }
                    if ($deaRequests[$n]['service_status'] == 'Vigente' || $deaRequests[$n]['service_status'] == 'Vencido') {
                        $actualDateMonths = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
                        if ($deaRequests[$n]['service_active_up_to'] != null && $deaRequests[$n]['service_active_up_to'] != '') {
                            $serviceActiveUpToDate = date('Y-m-d', strtotime($deaRequests[$n]['service_active_up_to']));
                            $serviceActiveUpToDateObject = new \dateTime($serviceActiveUpToDate, new \dateTimeZone('America/Los_Angeles'));
                            $actualDateMonths->add(new \DateInterval('P1M'));
                            if ($serviceActiveUpToDateObject->diff($actualDateMonths)->m >= 1) {
                                $deaRequests[$n]['service_status'] = 'Vencido';
                                $dReq::persistAndFlush($deaRequests[$n]);
                            } else {
                                $deaRequests[$n]['service_status'] = 'Vigente';
                                $dReq::persistAndFlush($deaRequests[$n]);
                            }
                        } else {
                            $serviceActiveUpToDateObject = null;
                        }
                    }
                    if ($deaRequests[$n]['service_status'] == 'Vigente') {
                        $HTML .=
                            '
                            <td><span class="content-text C-text-black fontsize_14px bg-success">'. $deaRequests[$n]['service_status'] .'</span></td>
                        ';
                    }
                    if ($deaRequests[$n]['service_status'] == 'Vencido') {
                        $HTML .=
                            '
                            <td><span class="content-text C-text-black fontsize_14px bg-warning">'. $deaRequests[$n]['service_status'] .'</span></td>
                        ';
                    }
                    if ($deaRequests[$n]['opening_paid_at']!=null && $deaRequests[$n]['opening_paid_at']!='') {
                        $HTML .=
                            '
                            <td><span class="content-text C-text-black fontsize_14px">'. date("Y-m-d", strtotime($deaRequests[$n]['opening_paid_at'])) .'</span></td>
                        ';
                    } else {
                        $HTML .=
                            '
                            <td><span class="content-text C-text-black fontsize_14px"></span></td>
                        ';
                    }
                    if ($deaRequests[$n]['service_active_up_to']!=null && $deaRequests[$n]['service_active_up_to']!='') {
                        $HTML .=
                            '
                            <td><span class="content-text C-text-black fontsize_14px">'. date("Y-m-d", strtotime($deaRequests[$n]['service_active_up_to'])) .'</span></td>
                        ';
                    } else {
                        $HTML .=
                            '
                            <td><span class="content-text C-text-black fontsize_14px"></span></td>
                        ';
                    }
                    $HTML .=
                        '
                        <td><button class="btn C-bg-black viewDeaDetails btn-block"><span class="title-text C-text-yellow fontsize_10px">Ver</span></button></td>
                    ';
                    if ($deaRequests[$n]['service_status'] == 'Porfavor, suba los archivos pendientes' || $deaRequests[$n]['service_status'] == 'En Proceso de Revision') {
                        $HTML .=
                            '
                            <td><button class="btn C-bg-black deaUploadFiles btn-block"><span class="title-text C-text-yellow fontsize_10px">Subir</span></button></td>
                        ';
                    } else {
                        $HTML .=
                            '
                            <td></td>
                        ';
                    }
                    if ($deaRequests[$n]['service_status']!='En Proceso de Revision' && $deaRequests[$n]['service_status']!='Porfavor, suba los archivos pendientes' && $deaRequests[$n]['service_status']!='En desarrollo') {
                        if ($deaRequests[$n]['service_status'] == 'Vencido' || $deaRequests[$n]['service_status'] == 'Aprobado') {
                            $HTML .=
                                '
                                <td>
                                    <button class="btn C-bg-black paypal mb-1 btn-block" id="paypal"><span class="title-text C-text-yellow fontsize_10px">Paypal / Tarjeta de Credito o Débito</span></button>
                                    <!--<button class="btn C-bg-black depositoBancario btn-block"><span class="title-text C-text-yellow fontsize_10px">Depósito de Banco</span></button>-->
                                </td>
                            ';
                        } elseif ($deaRequests[$n]['service_status'] == 'Vigente'){
                            $serviceActiveUpToDateTime = strtotime($deaRequests[$n]['service_active_up_to']);
                            $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
                            $actualDateTime = strtotime($actualDate->format('Y-m-d H:i:s'));
                            if (($serviceActiveUpToDateTime-$actualDateTime) < 1209600) {
                                $HTML .=
                                    '
                                        <td>
                                            <button class="btn C-bg-black paypal mb-1 btn-block" id="paypal"><span class="title-text C-text-yellow fontsize_10px">Paypal / Tarjeta de Credito o Débito</span></button>
                                            <!--<button class="btn C-bg-black depositoBancario btn-block"><span class="title-text C-text-yellow fontsize_10px">Depósito de Banco</span></button>-->
                                        </td>
                                    ';
                            } else {
                                $HTML .=
                                    '
                                        <td>
                                        </td>
                                    ';
                            }
                        } else {
                            $HTML .=
                                '
                                <td>
                                </td>
                            ';
                        }
                    } else {
                        $HTML .=
                            '
                            <td>
                            </td>
                        ';
                    }
                }
            } else {
                $HTML .=
                    '
                <h2 class="text-center title-text fontsize_16px" style="margin-top: 20px; margin-bottom: 50px; font-weight: bold; color: #1B1B1B; margin-right: 10%; margin-left: 10%;">Hasta el momento, no has solicitado ningún servicio de Draft Media.</h2>
                ';
            }
        }
        if ($language=='english') {
            if ($deaRequests != null) {
                for ($n=0; $n<count($deaRequests); $n++) {
                    $HTML .=
                        '
                    <tr class="content-text text-center C-text-darkgray" id="' . $deaRequests[$n]['id'] . '">
                        <td><span class="content-text C-text-black fontsize_14px">'. date("Y-m-d", strtotime($deaRequests[$n]['created_at'])) .'</span></td>
                        <td><span class="content-text C-text-black fontsize_14px">'. $deaRequests[$n]['first_name'] .' '. $deaRequests[$n]['last_name'] .'</span></td>
                    ';
                    if ($deaRequests[$n]['service_required'] == 'dea_webdesign') {
                        $HTML .=
                            '
                            <td><span class="content-text C-text-black fontsize_14px">Web Design</span></td>
                        ';
                    }
                    if ($deaRequests[$n]['service_required'] == 'dea_multimedia') {
                        $HTML .=
                            '
                            <td><span class="content-text C-text-black fontsize_14px">Multimedia</span></td>
                        ';
                    }
                    if ($deaRequests[$n]['service_required'] == 'dea_planning') {
                        $HTML .=
                            '
                            <td><span class="content-text C-text-black fontsize_14px">Planning</span></td>
                        ';
                    }
                    if ($deaRequests[$n]['service_required'] == 'dea_community_management') {
                        $HTML .=
                            '
                            <td><span class="content-text C-text-black fontsize_14px">Management of Social Networks</span></td>
                        ';
                    }
                    if ($deaRequests[$n]['package_required']=='paquete personal') {
                        $HTML .=
                            '
                                <td><span class="content-text C-text-black fontsize_14px">personal package</span></td>
                            ';
                    }
                    if ($deaRequests[$n]['package_required']=='paquete emprendedor') {
                        $HTML .=
                            '
                                <td><span class="content-text C-text-black fontsize_14px">entrepreneur package</span></td>
                            ';
                    }
                    if ($deaRequests[$n]['package_required']=='paquete empresarial') {
                        $HTML .=
                            '
                                <td><span class="content-text C-text-black fontsize_14px">business package</span></td>
                            ';
                    }
                    if ($deaRequests[$n]['service_status'] == 'Porfavor, suba los archivos pendientes') {
                        $deaWebdesign = new DeaWebdesign();
                        $deaWebdesign_Id = $deaWebdesign::findBy(["dea_requests_id" => $deaRequests[$n]['id']])[0]['id'];
                        $deaWebdesignViews = new DeaWebdesignViews();
                        $clientWebdesignViews = $deaWebdesignViews::findBy(["dea_webdesign_id" => $deaWebdesign_Id]);
                        if ($clientWebdesignViews != null) {
                            $isDirNull = false;
                        }
                        for ($i=0; $i<count($clientWebdesignViews); $i++) {
                            $view = $clientWebdesignViews[$i];
                            if ($view['is_user_art_concept']=='1') {
                                if ($view['user_art_concept_dir']==null || $view['user_art_concept_dir']=='') {
                                    $isDirNull = true;
                                }
                            }
                            if ($view['is_user_ani_concept']=='1') {
                                if ($view['user_ani_concept_dir']==null || $view['user_ani_concept_dir']=='') {
                                    $isDirNull = true;
                                }
                            }
                            if ($view['is_logic_diagram']=='1') {
                                if ($view['logic_diagram_dir']==null || $view['logic_diagram_dir']=='') {
                                    $isDirNull = true;
                                }
                            }
                            if (!$isDirNull && ($i+1)==count($clientWebdesignViews)) {
                                $deaRequests[$n]['service_status'] = 'En Proceso de Revision';
                                $dReq::persistAndFlush($deaRequests[$n]);
                            }
                            if ($isDirNull && ($i+1)==count($clientWebdesignViews)) {
                                $HTML .=
                                    '
                                    <td><span class="content-text C-text-black fontsize_14px bg-warning">Please upload the pending files</span></td>
                                    ';
                            }
                        }
                    }
                    if ($deaRequests[$n]['service_status'] == 'En Proceso de Revision') {
                        $HTML .=
                            '
                            <td><span class="content-text C-text-black fontsize_14px" style="background:#E6AC00;">Under review</span></td>
                        ';
                    }
                    if ($deaRequests[$n]['service_status'] == 'En desarrollo') {
                        $HTML .=
                            '
                            <td><span class="content-text C-text-black fontsize_14px" style="background:#E6AC00;">Under Development</span></td>
                        ';
                    }
                    if ($deaRequests[$n]['service_status'] == 'Aprobado') {
                        $HTML .=
                            '
                            <td><span class="content-text C-text-black fontsize_14px bg-success">Approved</span></td>
                        ';
                    }
                    if ($deaRequests[$n]['service_status'] == 'Vigente' || $deaRequests[$n]['service_status'] == 'Vencido') {
                        $actualDateMonths = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
                        if ($deaRequests[$n]['service_active_up_to'] != null && $deaRequests[$n]['service_active_up_to'] != '') {
                            $serviceActiveUpToDate = date('Y-m-d', strtotime($deaRequests[$n]['service_active_up_to']));
                            $serviceActiveUpToDateObject = new \dateTime($serviceActiveUpToDate, new \dateTimeZone('America/Los_Angeles'));
                            $actualDateMonths->add(new \DateInterval('P1M'));
                            if ($serviceActiveUpToDateObject->diff($actualDateMonths)->m >= 1) {
                                $deaRequests[$n]['service_status'] = 'Vencido';
                                $dReq::persistAndFlush($deaRequests[$n]);
                            } else {
                                $deaRequests[$n]['service_status'] = 'Vigente';
                                $dReq::persistAndFlush($deaRequests[$n]);
                            }
                        } else {
                            $serviceActiveUpToDateObject = null;
                        }
                    }
                    if ($deaRequests[$n]['service_status'] == 'Vigente') {
                        $HTML .=
                            '
                            <td><span class="content-text C-text-black fontsize_14px bg-success">Active</span></td>
                        ';
                    }
                    if ($deaRequests[$n]['service_status'] == 'Vencido') {
                        $HTML .=
                            '
                            <td><span class="content-text C-text-black fontsize_14px bg-warning">Expired</span></td>
                        ';
                    }
                    if ($deaRequests[$n]['opening_paid_at']!=null && $deaRequests[$n]['opening_paid_at']!='') {
                        $HTML .=
                            '
                            <td><span class="content-text C-text-black fontsize_14px">'. date("Y-m-d", strtotime($deaRequests[$n]['opening_paid_at'])) .'</span></td>
                        ';
                    } else {
                        $HTML .=
                            '
                            <td><span class="content-text C-text-black fontsize_14px"></span></td>
                        ';
                    }
                    if ($deaRequests[$n]['service_active_up_to']!=null && $deaRequests[$n]['service_active_up_to']!='') {
                        $HTML .=
                            '
                            <td><span class="content-text C-text-black fontsize_14px">'. date("Y-m-d", strtotime($deaRequests[$n]['service_active_up_to'])) .'</span></td>
                        ';
                    } else {
                        $HTML .=
                            '
                            <td><span class="content-text C-text-black fontsize_14px"></span></td>
                        ';
                    }
                    $HTML .=
                        '
                        <td><button class="btn C-bg-black viewDeaDetails btn-block"><span class="title-text C-text-yellow fontsize_10px">Details</span></button></td>
                    ';
                    if ($deaRequests[$n]['service_status'] == 'Porfavor, suba los archivos pendientes' || $deaRequests[$n]['service_status'] == 'En Proceso de Revision') {
                        $HTML .=
                            '
                            <td><button class="btn C-bg-black deaUploadFiles btn-block"><span class="title-text C-text-yellow fontsize_10px">Upload</span></button></td>
                        ';
                    } else {
                        $HTML .=
                            '
                            <td></td>
                        ';
                    }
                    if ($deaRequests[$n]['service_status']!='En Proceso de Revision' && $deaRequests[$n]['service_status']!='Porfavor, suba los archivos pendientes' && $deaRequests[$n]['service_status']!='En desarrollo') {
                        if ($deaRequests[$n]['service_status'] == 'Vencido' || $deaRequests[$n]['service_status'] == 'Aprobado') {
                            $HTML .=
                                '
                                <td>
                                    <button class="btn C-bg-black paypal mb-1 btn-block" id="paypal"><span class="title-text C-text-yellow fontsize_10px">Paypal / Credit or Debit Card</span></button>
                                    <!--<button class="btn C-bg-black depositoBancario btn-block"><span class="title-text C-text-yellow fontsize_10px">Depósito de Banco</span></button>-->
                                </td>
                            ';
                        } elseif ($deaRequests[$n]['service_status'] == 'Vigente'){
                            $serviceActiveUpToDateTime = strtotime($deaRequests[$n]['service_active_up_to']);
                            $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
                            $actualDateTime = strtotime($actualDate->format('Y-m-d H:i:s'));
                            if (($serviceActiveUpToDateTime-$actualDateTime) < 1209600) {
                                $HTML .=
                                    '
                                        <td>
                                            <button class="btn C-bg-black paypal mb-1 btn-block" id="paypal"><span class="title-text C-text-yellow fontsize_10px">Paypal / Credit or Debit Card</span></button>
                                            <!--<button class="btn C-bg-black depositoBancario btn-block"><span class="title-text C-text-yellow fontsize_10px">Depósito de Banco</span></button>-->
                                        </td>
                                    ';
                            } else {
                                $HTML .=
                                    '
                                        <td>
                                        </td>
                                    ';
                            }
                        } else {
                            $HTML .=
                                '
                                <td>
                                </td>
                            ';
                        }
                    } else {
                        $HTML .=
                            '
                            <td>
                            </td>
                        ';
                    }
                }
            } else {
                $HTML .=
                    '
                <h2 class="text-center title-text fontsize_16px" style="margin-top: 20px; margin-bottom: 50px; font-weight: bold; color: #1B1B1B; margin-right: 10%; margin-left: 10%;">So far, you haven\'t requested any Draft Media service.</h2>
                ';
            }
        }

        View::renderTemplate('UserRequests/index/index.html.twig', [
            'user'    => $user,
            'isUserLoggedIn' => (isset($_SESSION["user"]) || isset($_SESSION["key"])),
            'user_firstname' => $user_firstname,
            'HTML' => $HTML,
            'language' => $language
        ]);
    }
}
