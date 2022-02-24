<?php

namespace App;

/**
 * Application configuration
 *
 * PHP version 5.4
 */
class Config
{
    /**
     * Development base root
     * @var string
     */
    const APP_DEV_URL = 'http://localhost/';

    /**
     * Production base root
     * @var string
     */
    const APP_PROD_URL = 'https://www.draftmedia.com.mx/';

    /**
     * Database host
     * @var string
     */
    const DB_HOST = '127.0.0.1';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = 'draftmedia';

    /**
     * Database user
     * @var string
     */
    const DB_USERNAME = 'root';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = '';

    /**
     * AES Encryption IV key
     * @var string
     */
    // For confidential reasons, the code assigned here was modified.
    const AES_IV = '1010101010';

    /**
     * AES Encryption Input Key
     * @var string
     */
    // For confidential reasons, the code assigned here was modified.
    const AES_INPUT_KEY = '1212121212';

    /**
     * PAYPAL Credentials
     */
    // For confidential reasons, the code assigned here was deleted.
    const SANDBOX_ACCOUNT = '';
    const SANDBOX_CLIENT_ID = '';
    const SANDBOX_SECRET = '';
    const LIVE_ACCOUNT = '';
    const LIVE_CLIENT_ID = '';
    const LIVE_SECRET = '';

    /**
     * HOSTGATOR SMTP Credentials
     */
    // For confidential reasons, the code assigned here was deleted.
    const HOSTGATOR_SMTP_USERNAME = "";
    const HOSTGATOR_SMTP_PASSWORD = "";
    const HOSTGATOR_PORT = 0;
    const HOSTGATOR_HOST = "";

    /**
     * PAYPAL URLs
     */
    const RETURN_URL_p1 = '/UserRequests';
    const RETURN_URL_p2 = '/index';
    const CANCEL_URL = '/UserRequests/index';

    /**
     * Show or hide detailed error messages on web page
     * TRUE = will show detailed errors on web and wont save them on log file (Development)
     * FALSE = will show friendly errors to users and detailed errors to devs through log file (Production)
     * @var boolean
     */
    const APP_ENV = true;
}
