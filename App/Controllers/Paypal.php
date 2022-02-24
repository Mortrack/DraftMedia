<?php
/**
 * Created by PhpStorm.
 * User: César
 * Date: 8/13/2018
 * Time: 9:09 PM
 */

namespace App\Controllers;     //The namespace must match the father directory oh the .php file were it will be used

use App\Config;
use App\Models\DeaRequests;
use App\Models\Orders;
use App\Models\Payments;
use App\Models\Products;
use App\Models\Users;
use Core\CoreHackAttempt;
use Core\Ddos;
use Core\Paypal as corePaypal;
use Core\Tcpdf;
use PHPMailer\PHPMailer\PHPMailer;

class Paypal extends \Core\Controller
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
                $hA->isHackAttempt("paypal", "before", $user);
            } catch (\Exception $e) {
                $hA->isHackAttempt("paypal", "before", "");
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
     * This method is called right after the client completed a payment through the paypal API. When this happens,
     * this method save the record of the payment made on the database and activates, re-activates and/or increases
     * the service's activation time that the client paid for.
     *
     * @throws \Exception
     *
     * @author Miranda Meza César
     * DATE November 15, 2018
     */
    public function paypalPaymentAction()
    {
        // If this step is reached, client accepted to buy the provided service. So, execute paypal payment

        // Save, on the database, the payment that the client just made
        $user = $this->getUser();
        $payments = new Payments();
        $payments->setUserId($user['id']);
        $databasePaypal = new \App\Models\Paypal();
        $paypal = $databasePaypal::findBy(["user_id" => $user['id']]);
        $numberMatches = count($paypal);
        $paypal = $paypal[($numberMatches-1)];
        $payments->setDeaRequestsId($paypal['dea_requests_id']);
        $deaRequests = new DeaRequests();
        $deaRequest = $deaRequests::find($paypal['dea_requests_id'])[0];
        $payments->setOrdersId($deaRequest['orders_id']);
        $orders = new Orders();
        $order = $orders::find($deaRequest['orders_id'])[0];
        $payments->setAmountPaid($order['total_to_pay']);
        $payments->setPaymentMethod('Paypal');
        $payments->setStatus('ACTIVE');
        $payments->setCreatedBy($user['id']);
        $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
        $payments->setCreatedAt($actualDate->format('Y-m-d H:i:s'));

        //Update the new values of dea_requests table on the database
        $products = new Products();
        $product = $products::find($order['product_id'])[0];
        if ($order['total_to_pay'] == $product['opening_price']) {
            $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
            $deaRequest['opening_paid_at'] = $actualDate->format('Y-m-d H:i:s');
            $deaRequest['service_active_up_to'] = $actualDate->format('Y-m-d H:i:s');
            $deaRequest['service_status'] = 'En desarrollo';
        }
        if ($order['total_to_pay'] == $product['monthly_fee']) {
            if ($deaRequest['service_active_up_to']!=null || $deaRequest['service_active_up_to']!='') {
                $serviceActiveUpToDate = date('Y-m-d', strtotime($deaRequest['service_active_up_to']));
                $serviceActiveUpToDateObject = new \dateTime($serviceActiveUpToDate, new \dateTimeZone('America/Los_Angeles'));
                $modifiedDate = $serviceActiveUpToDateObject->add(new \DateInterval('P1M'));
                $deaRequest['service_active_up_to'] = $modifiedDate->format('Y-m-d H:i:s');
            } else {
                $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
                $modifiedDate = $actualDate->add(new \DateInterval('P1M'));
                $deaRequest['service_active_up_to'] = $modifiedDate->format('Y-m-d H:i:s');
                if ($deaRequest['opening_paid_at']==null || $deaRequest['opening_paid_at']=='') {
                    $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
                    $deaRequest['opening_paid_at'] = $actualDate->format('Y-m-d H:i:s');
                    $deaRequest['service_status'] = 'En desarrollo';
                }
            }
        }

        // We insert the new row value corresponding to the payment that the user just made so that
        // it can gain its specific id value on the database to then retrieve it and work with it.
        $payments::persistAndFlush($payments);
        $payment = $payments::findBy(['dea_requests_id' => $deaRequest['id']]);
        $paymentMatches = count($payment)-1;


        // ----------------------------- //
        // GENERATE THE INVOICE PDF FILE //
        // ----------------------------- //
        //We use our customized class instead of using the original one (\TCPDF)
        $obj_pdf = new Tcpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $obj_pdf->SetAuthor('Draft Media');

        // set default monospaced font
        $obj_pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        // set default header data
        $obj_pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);
        // set margins
        $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);
        $obj_pdf->SetAutoPageBreak(TRUE, 10);
        $obj_pdf->SetFont('helvetica', '', 12);

        // Add a page
        $obj_pdf->AddPage();

        // We generate the name that the pdf file will have
        $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
        $fileName = 'DR'.$deaRequest['id'].'O'.$deaRequest['orders_id'].'PA'.$payment[$paymentMatches]['id'].'U'.$payment[$paymentMatches]['created_by'].'T'.strtotime($actualDate->format('Y-m-d H:i:s'));
        $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
        $content = '';
        $content .=
            '
                <div>
                      <br><br>
                      <img src="/img/Logo/DraftMediaLogo2.jpg" style="width: 100px;">
                      <br>
                      <br>
                      <table>  
                           <tr>  
                                <th width="45%"><span style="color: #ffffff; font-size: 18px;">-</span><span style="font-weight: bold; letter-spacing: 1px; text-transform: uppercase; font-family: \'Century Gothic\'; font-size: 14px;color: #666666;">Client</span></th>  
                                <th width="55%"><span style="color: #ffffff; font-size: 18px;">-</span><span style="font-weight: bold; letter-spacing: 1px; text-transform: uppercase; font-family: \'Century Gothic\'; font-size: 14px;color: #666666;">Invoice</span></th>  
                           </tr>
                           <tr>
                                <td>
                                    <span style="font-weight: bold; font-family: \'Open Sans\'; font-size: 10px;color: #A8A8A8;">NAME: </span>
                                    <span style="font-weight: bold; font-family: \'Open Sans\'; font-size: 10px;color: #A8A8A8;">'. $deaRequest['first_name'] . ' ' . $deaRequest['last_name'] .'</span>
                                </td>
                                <td>
                                    <span style="font-weight: bold; letter-spacing: 1px; text-transform: uppercase; font-family: \'Century Gothic\'; font-size: 10px;color: #A8A8A8;">Invoice Number</span>
                                    <span style="font-weight: bold; font-family: \'Open Sans\'; font-size: 10px;color: #A8A8A8;">...</span>
                                    <span style="font-weight: bold; font-family: \'Open Sans\'; font-size: 10px;color: #A8A8A8;">'.$fileName.'</span>
                                </td>
                           </tr>
                           <tr>
                                <td>
                                    <span style="font-weight: bold; font-family: \'Open Sans\'; font-size: 10px;color: #A8A8A8;">EMAIL: </span>
                                    <span style="font-weight: bold; font-family: \'Open Sans\'; font-size: 10px;color: #A8A8A8;">'.$user['email'].'</span>
                                </td>
                                <td>
                                    <span style="font-weight: bold; letter-spacing: 1px; text-transform: uppercase; font-family: \'Century Gothic\'; font-size: 10px;color: #A8A8A8;">Date</span>
                                    <span style="font-weight: bold; font-family: \'Open Sans\'; font-size: 10px;color: #A8A8A8;">............................</span>
                                    <span style="font-weight: bold; font-family: \'Open Sans\'; font-size: 10px;color: #A8A8A8;">'.$actualDate->format('m-d-Y').'</span>
                                </td>
                           </tr>
                           <tr>
                                <td>
                                    <span style="font-weight: bold; font-family: \'Open Sans\'; font-size: 10px;color: #A8A8A8;">PHONE: </span>
                                    <span style="font-weight: bold; font-family: \'Open Sans\'; font-size: 10px;color: #A8A8A8;">'.$deaRequest['phone'].'</span>
                                </td>
                                <td>
                                    <span style="font-weight: bold; letter-spacing: 1px; text-transform: uppercase; font-family: \'Century Gothic\'; font-size: 10px;color: #A8A8A8;">Customer ID</span>
                                    <span style="font-weight: bold; font-family: \'Open Sans\'; font-size: 10px;color: #A8A8A8;">..........</span>
                                    <span style="font-weight: bold; font-family: \'Open Sans\'; font-size: 10px;color: #A8A8A8;">U'.$user['id'].'</span>
                                </td>
                           </tr>
                      </table>
                      <br>
                      <br>
                </div>
                <table border="1" cellspacing="0" cellpadding="2">  
                     <tr>  
                          <th width="15%"><span style="font-weight: bold; letter-spacing: 1px; text-transform: uppercase; font-family: \'Century Gothic\'; font-size: 10px;color: #1B1B1B;">Product ID</span></th>
                          <th width="22%"><span style="font-weight: bold; letter-spacing: 1px; text-transform: uppercase; font-family: \'Century Gothic\'; font-size: 10px;color: #1B1B1B;">Product Name</span></th>  
                          <th width="30%"><span style="font-weight: bold; letter-spacing: 1px; text-transform: uppercase; font-family: \'Century Gothic\'; font-size: 10px;color: #1B1B1B;">Product Description</span></th>  
                          <th width="13%"><span style="font-weight: bold; letter-spacing: 1px; text-transform: uppercase; font-family: \'Century Gothic\'; font-size: 10px;color: #1B1B1B;">Quantity</span></th>  
                          <th width="10%"><span style="font-weight: bold; letter-spacing: 1px; text-transform: uppercase; font-family: \'Century Gothic\'; font-size: 10px;color: #1B1B1B;">Price</span></th>
                          <th width="10%"><span style="font-weight: bold; letter-spacing: 1px; text-transform: uppercase; font-family: \'Century Gothic\'; font-size: 10px;color: #1B1B1B;">Total</span></th>
                     </tr>
                     <tr>
                          <td style="height: 450px;"><span style="font-weight: bold; font-family: \'Open Sans\'; font-size: 10px;color: #1B1B1B;">PR'.$deaRequest['products_id'].'</span></td>
                          <td><span style="font-weight: bold; font-family: \'Open Sans\'; font-size: 10px;color: #1B1B1B;">'.$product['name'].'</span></td>
                          <td><span style="font-weight: bold; font-family: \'Open Sans\'; font-size: 10px;color: #1B1B1B;">'.$product['description'].'</span></td>
                          <td><span style="font-weight: bold; font-family: \'Open Sans\'; font-size: 10px;color: #1B1B1B;">1</span></td>
                          <td><span style="font-weight: bold; font-family: \'Open Sans\'; font-size: 10px;color: #1B1B1B;">$'.$payment[$paymentMatches]['amount_paid'].'</span></td>
                          <td><span style="font-weight: bold; font-family: \'Open Sans\'; font-size: 10px;color: #1B1B1B;">$'.$payment[$paymentMatches]['amount_paid'].'</span></td>
                     </tr>
                </table>
                <table style="float: right;">  
                     <tr>  
                          <th width="75%"></th>
                          <th width="15%"></th>
                          <th width="10%"></th>  
                     </tr>
                     <tr>
                          <td></td>
                          <td><span style="text-align: end; font-weight: bold; font-family: \'Open Sans\'; font-size: 10px;color: #1B1B1B;">SUBTOTAL: </span></td>
                          <td><span style="font-weight: bold; font-family: \'Open Sans\'; font-size: 10px;color: #1B1B1B;">$'.$payment[$paymentMatches]['amount_paid'].'</span></td>
                     </tr>';
        /*
        $content .=
            '
                     <tr>
                          <td></td>
                          <td><span style="text-align: end; font-weight: bold; font-family: \'Open Sans\'; font-size: 10px;color: #1B1B1B;">SALES TAX: </span></td>
                          <td><span style="font-weight: bold; font-family: \'Open Sans\'; font-size: 10px;color: #1B1B1B;">$0.00</span></td>
                     </tr>
            ';
        */
        $content .=
            '
                     <tr>
                          <td></td>
                          <td><span style="text-align: end; font-weight: bold; font-family: \'Open Sans\'; font-size: 10px;color: #1B1B1B;">TOTAL DUE: </span></td>
                          <td><span style="font-weight: bold; font-family: \'Open Sans\'; font-size: 10px;color: #1B1B1B;">$'.$payment[$paymentMatches]['amount_paid'].'</span></td>
                     </tr>
                </table>
                <br>
                <br>
                <div style="color:#1B1B1B;">___________________________________________________________________________</div>
                <span style="font-weight: bold; font-family: \'Open Sans\'; font-size: 10px;color: #A8A8A8;">COMPANY NAME: </span>
                <span style="font-weight: bold; font-family: \'Open Sans\'; font-size: 10px;color: #A8A8A8;">Draft Media</span>
                <span style="font-weight: bold; font-family: \'Open Sans\'; font-size: 10px;color: #FFFFFF;">------------------------------------------------------------------</span>
                <span style="font-weight: bold; font-family: \'Open Sans\'; font-size: 10px;color: #A8A8A8;">PHONE: </span>
                <span style="font-weight: bold; font-family: \'Open Sans\'; font-size: 10px;color: #A8A8A8;">(+52)664-6944077</span>
            ';
        $obj_pdf->writeHTML($content, true, false, true, false, '');
        $destinationDirectory = dirname(dirname(dirname(__FILE__))) . '/public/img/Invoice/files/';
        $user = $this->getUser();
        if (!file_exists($destinationDirectory . $user["id"])) {
            mkdir($destinationDirectory . $user["id"], 0777, true);
        }

        // We create the pdf file and save it on a strategic directory
        $obj_pdf->Output($destinationDirectory . $user["id"] . '/' . $fileName . '.pdf', 'F');

        // We now save on the payment the directory of the pdf file corresponding to the invoice that we just created
        $payment[$paymentMatches]['invoice_dir'] = $destinationDirectory . $user["id"] . '/' . $fileName . '.pdf';

        // We update all this new data on the database
        $deaRequests::persistAndFlush($deaRequest);
        $payments::persistAndFlush($payment[$paymentMatches]);

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

                //Attachments
                $mail->addAttachment($payment[$paymentMatches]['invoice_dir']);    // Optional name

                //Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Draft Media - Confirmation of your order ' . $fileName; //El subject no agarra acentos
                $preparedMessage ='
                        <html>
                            <body>
                              <p>De: Draft Media</p>
                              <p>Tu compra se ha efectuado con éxito!.</p>
                              <p>A partir de este momento, el equipo de Draft Media empezará a trabajar en el servicio que solicitaste.</p>
                              <p>Para monitorear el estado del desarrollo de tu pedido, te invitamos a hacerlo a través de la sección "Ver mis pedidos", en el sub-menú de tu inicio de sesión o da click en este botón: " <button href="' . Config::APP_PROD_URL . 'UserRequests/index' . '">Ver mis pedidos</button></p>
                              <p>(Nótese que para que el enlace del botón le redirija correctamente, deberá haberse asegurado de haber iniciado sesión en Draft Media primero)</p>
                              <br><br>
                              <p>Agradecemos tu preferencia y nos despedimos con un cordial saludo.</p>
                              <br><hr><br>
                              <div>
                                  '. $content .'
                              </div>
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

        // We execute the php code that indicates us that the user has already paid for the service he required
        $corePaypal = new corePaypal();
        $corePaypal->excecutePaypalPayment($this->route_params['id']);
    }

    /**
     * This method is in charge of generating a payment order according to what the client has to pay to maintain
     * his service activated, to activate it for the first time or to re-activate it.
     * NOTE that this just generated the payment order and also note that no payment is made or transactioned on this
     * method.
     *
     * @throws \Exception
     *
     * @author Miranda Meza César
     * DATE November 15, 2018
     */
    public function paypalCheckoutAction()
    {
        $deaRequestsId = $_POST['x'];

        // ----- "dea_webdesign" Id of the Client's request service sanitize and validation ----- //
        if (!empty($deaRequestsId)) {
            $deaRequestsId = filter_var($deaRequestsId, FILTER_SANITIZE_NUMBER_INT);
            if (filter_var($deaRequestsId, FILTER_VALIDATE_INT) != false) {
                $deaRequestsId = htmlspecialchars($deaRequestsId, ENT_QUOTES, 'UTF-8');
                $user = $this->getUser();
                $deaRequests = new DeaRequests();
                $deaRequest = $deaRequests::find($deaRequestsId);
            } else {
                $hA = new CoreHackAttempt();
                $hA->isHackAttempt("paypal", "paypalCheckout", $this->getUser());
                throw new \Exception("User was scrypting on Draft Media Server");
            }
            if ($deaRequest == null) {
                $hA = new CoreHackAttempt();
                $hA->isHackAttempt("paypal", "paypalCheckout", $this->getUser());
                throw new \Exception("User was scrypting on Draft Media Server");
            }
            $deaRequest = $deaRequest[0];
            if ($deaRequest['created_by']!=$user['id'] && $user['role']!='admin') {
                $hA = new CoreHackAttempt();
                $hA->isHackAttempt("paypal", "paypalCheckout", $this->getUser());
                throw new \Exception("User was scrypting on Draft Media Server");
            }

            if ($deaRequest['products_id']!=null && $deaRequest['products_id']!='') {

                // If this point is reached, then the user is not trying to hack the server and has all
                // requirements to be able to pay for a Draft Media professional service
                $productsId = $deaRequest['products_id'];
                $products = new Products();
                $product = $products::find($productsId);
                if ($product != null ) {
                    $product = $product[0];
                    $orders = new Orders();
                    $orders->setDeaRequestsId($deaRequest['id']);
                    $user = $this->getUser();
                    $orders->setUserId($deaRequest['created_by']);
                    $orders->setProductId($product['id']);
                    if (($deaRequest['opening_paid_at']==null||$deaRequest['opening_paid_at']=='') && ($product['opening_price']!=0)) {
                        $orders->setTotalToPay($product['opening_price']);
                    } else {
                        $serviceActiveUpTo = $deaRequest['service_active_up_to'];
                        if ($serviceActiveUpTo == null || $serviceActiveUpTo == '') {
                            if ($product['monthly_fee'] != 0) {
                                $orders->setTotalToPay($product['monthly_fee']);
                            }
                        }
                        if (($deaRequest['opening_paid_at']!=null||$deaRequest['opening_paid_at']!='') && ($serviceActiveUpTo!=null||$serviceActiveUpTo!='')) {
                            if ($product['monthly_fee'] != 0) {
                                $orders->setTotalToPay($product['monthly_fee']);
                            }
                        }
                    }
                    if ($orders->getTotalToPay()==null || $orders->getTotalToPay()=='' || $orders->getTotalToPay()=='0') {
                        throw new \Exception("The dea_request with id:".$deaRequest['id'].", has a product id assigned (".$deaRequest['products_id'].") that is free of charge. Assign a price for that product.");
                    }
                    $orders->setStatus("ACTIVE");
                    $orders->setCreatedBy($user['id']);
                    $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
                    $orders->setCreatedAt($actualDate->format('Y-m-d H:i:s'));
                    $orders::persistAndFlush($orders);

                    $orders_id = $orders::findBy(["created_by" => $user['id']]);
                    if ($orders_id == null) {
                        throw new \Exception("For some unkown reason, a match could not be found for the \"created_by\" value of orders_id table, with the finding value of the user's id");
                    }
                    $numberMatches = count($orders_id);
                    $orders_id = $orders_id[($numberMatches-1)]['id'];
                    $deaRequest['orders_id'] = $orders_id;
                    $deaRequests::persistAndFlush($deaRequest);

                    // Define the products that you want to sell
                    $price = number_format((((float)$orders->getTotalToPay())*(1-0.16)), 2, '.', '');
                    $tax = number_format((((float)$orders->getTotalToPay()-$price)), 2, '.', '');
                    $data[0] = [
                        "name"                  => (string)$product['name'],
                        "description"           => "Draft Media Service",
                        "quantity"              => "1",
                        "price"                 => (string)$price,
                        "tax"                   => (string)$tax,
                        "detailedDescription"   => (string)$product['description']
                    ];
                    /*
                    $data[1] = [
                        "name"                  => "Draft Media Service",
                        "description"           => "Photo edition, Video edition and planning",
                        "quantity"              => "1",
                        "price"                 => "90.00",
                        "tax"                   => "0.00",
                        "detailedDescription"   => "This product offers the following detailed services"
                    ];
                    */

                    // Set paypal payment with the products that you want to sell
                    $corePaypal = new corePaypal();
                    $corePaypal->setPayment($data, $deaRequestsId, $this->getUser()['id']);     //The response of this method will redirect to "paypalPayment" method
                } else {
                    throw new \Exception("No product was found on the database with such \"products_id\"");
                }
            } else {
                throw new \Exception("User\'s DEA request does not have \"product_id\" set");
            }
        } else {
            $hA = new CoreHackAttempt();
            $hA->isHackAttempt("paypal", "paypalCheckout", $this->getUser());
            throw new \Exception("User was scrypting on Draft Media Server");
        }
    }
}
