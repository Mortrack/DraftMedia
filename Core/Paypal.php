<?php
/**
 * Created by PhpStorm.
 * User: Cesar
 * Date: 8/16/2018
 * Time: 2:50 PM
 */

namespace Core;

//composer require paypal/rest-api-sdk-php

use App\Config;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

class Paypal
{
    private $companyAccount;
    private $companyClientId;
    private $companySecret;
    private $baseUrl;
    private $returnUrlP1;
    private $returnUrlP2;
    private $cancelUrl;

    public function __construct()
    {
        if (Config::APP_ENV) {
            $this->companyAccount = Config::SANDBOX_ACCOUNT;
            $this->companyClientId = Config::SANDBOX_CLIENT_ID;
            $this->companySecret = Config::SANDBOX_SECRET;
            $this->baseUrl = Config::APP_DEV_URL;
        } elseif (!Config::APP_ENV) {
            $this->companyAccount = Config::LIVE_ACCOUNT;
            $this->companyClientId = Config::LIVE_CLIENT_ID;
            $this->companySecret = Config::LIVE_SECRET;
            $this->baseUrl = Config::APP_PROD_URL;
        } else {
            throw new \Exception("App enviroment/config variable was not set correctly", 500);
        }
        $this->returnUrlP1 = Config::RETURN_URL_p1;
        $this->returnUrlP2 = Config::RETURN_URL_p2;
        $this->cancelUrl = Config::CANCEL_URL;
    }

    public function excecutePaypalPayment($paypalId)
    {
        /* Get payment object by passing paymentId */
        $paymentId = $_GET['paymentId'];
        /* Through paypal's database table's id, get api_context */
        $databasePaypal = new \App\Models\Paypal();
        $apiContext = unserialize($databasePaypal::find($paypalId)[0]['api_context']);
        $payment = Payment::get($paymentId, $apiContext);
        $payerId = $_GET['PayerID'];
        /* Execute payment with payer id */
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);
        try {
            /* Execute payment */
            $result = $payment->execute($execution, $apiContext);
            header("LOCATION: " . $this->baseUrl . $this->returnUrlP1 . $this->returnUrlP2);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            throw new \Exception("$ex->getData()", 500);
        }
    }

    public function setPayment($data, $deaRequestsId, $user_id)
    {
        //Step 1
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                $this->companyClientId,
                $this->companySecret
            )
        );

        //API Config
        $mode = '';
        $info = '';
        if (Config::APP_ENV) {
            $mode = 'sandbox';
            $info = 'DEBUG';
        } elseif (!Config::APP_ENV) {
            $mode = 'live';
            $info = 'INFO';
        }
        $apiContext->setConfig(
            array(
                'mode' => $mode,
                'log.LogEnabled' => true,
                'log.FileName' => '../logs/PayPal.log',
                'log.LogLevel' => $info, // PLEASE USE `INFO` LEVEL FOR LOGGING IN LIVE ENVIRONMENTS
                'cache.enabled' => true,
                //'cache.FileName' => '/PaypalCache' // for determining paypal cache directory
                // 'http.CURLOPT_CONNECTTIMEOUT' => 30
                // 'http.headers.PayPal-Partner-Attribution-Id' => '123123123'
                //'log.AdapterFactory' => '\PayPal\Log\DefaultLogFactory' // Factory class implementing \PayPal\Log\PayPalLogFactory
            )
        );

        /* Save api_context on database's table paypal */
        $jsonApiContext = serialize($apiContext);
        $databasePaypal = new \App\Models\Paypal();
        $databasePaypal->setDeaRequestsId($deaRequestsId);
        $databasePaypal->setUserId($user_id);
        $databasePaypal->setApiContext($jsonApiContext);
        $actualDate = new \dateTime('now', new \dateTimeZone('America/Los_Angeles'));
        $databasePaypal->setDateCreated($actualDate->format('Y-m-d H:i:s'));
        $databasePaypal::persistAndFlush($databasePaypal);
        /* Through database's table paypal, get the id of our actual api_context */
        $paypal = $databasePaypal::findBy(["user_id" => $user_id]);
        $numberMatches = count($paypal);
        $paypal = $paypal[($numberMatches-1)];
        $paypalId = $paypal['id']; //AGREGARLO AL URL DE setReturnUrl

        //Step 2
        $payer = new \PayPal\Api\Payer();
        $payer->setPaymentMethod('paypal');
        $items= [];
        $detailsSubtotal=0;
        $detailsTax=0;
        for ($i=0; $i<count($data); $i++) {
            $item = new Item();
            $item->setName($data[$i]['name'])
                ->setCurrency('USD')
                ->setQuantity($data[$i]['quantity'])
                ->setPrice(number_format(($data[$i]['price']), 2, '.', ''))
                ->setTax(number_format(($data[$i]['tax']), 2, '.', ''))
                ->setDescription($data[$i]['detailedDescription']);
            $detailsSubtotal += $data[$i]['price'];
            $detailsTax += $data[$i]['tax'];
            array_push($items, $item);
        }
        $itemList = new ItemList();
        $itemList->setItems($items);

        $details = new Details();
        $details->setSubtotal(number_format($detailsSubtotal, 2, '.', ''));
        $details->setTax(number_format($detailsTax, 2, '.', ''));

        $amount = new \PayPal\Api\Amount();
        $amount->setTotal(number_format(($detailsSubtotal+$detailsTax), 2, '.', ''));
        $amount->setCurrency('USD');
        $amount->setDetails($details);

        $transaction = new \PayPal\Api\Transaction();
        $transaction->setAmount($amount)
                    ->setDescription($data[0]['description'])
                    ->setItemList($itemList);

        $redirectUrls = new \PayPal\Api\RedirectUrls();
        $redirectUrls->setReturnUrl($this->baseUrl . "/Paypal/$paypalId/paypalPayment")
            ->setCancelUrl($this->baseUrl . $this->cancelUrl);

        $payment = new \PayPal\Api\Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions(array($transaction))
            ->setRedirectUrls($redirectUrls);

        //Step 3
        try {
            $payment->create($apiContext);
            /* Get PayPal redirect URL and redirect user */
            $approvalUrl = $payment->getApprovalLink();
            /* Update api_context new value on database */
            $paypal['api_context'] = serialize($apiContext);
            $databasePaypal::persistAndFlush($paypal);
            /* Send user to approval link */
            header("LOCATION: $approvalUrl");
        }
        catch (\PayPal\Exception\PayPalConnectionException $ex) {
            throw new \Exception($ex->getData(), 500);
        }
    }
}
