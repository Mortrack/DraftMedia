<?php

namespace App\Controllers;     //The namespace must match the father directory oh the .php file were it will be used

use App\Config;
use Core\CoreHackAttempt;
use Core\Ddos;
use \Core\View;

/**
 * Home controller
 *
 * PHP version 5.4
 */
class Portfolio extends \Core\Controller
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
                $hA->isHackAttempt("portfolio", "before", $user);
            } catch (\Exception $e) {
                $hA->isHackAttempt("portfolio", "before", "");
            }
            throw new \Exception("A DDoS hack attack has been detected.");
        }

        //Since this code isnt finished, do not let the user pass/access anything from this class
        if (Config::APP_ENV) {
            header("LOCATION: " . Config::APP_DEV_URL);
        } else {
            header("LOCATION: " . Config::APP_PROD_URL);
        }

        //TODO: Remember that the visit counter table doesnt have this class in it.
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
     * @return void
     */
    public function indexAction()
    {
        /*
        View::renderTemplate('Login/index.html.twig', [
        ]);
        */
    }
}
