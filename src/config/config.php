<?php
$basePath = "http" . (($_SERVER['SERVER_PORT'] == 443) ? "s://" : "://") . $_SERVER['HTTP_HOST'];


/**
 * The Client ID is used to identify the OAuth Consumer. You may request a
 * Client ID by asking the bexio Support
 */
define('BEXIO_CLIENT_ID', "");

/**
 * The Client Secret is used to verify the OAuth Consumer. This secret should
 * always be kept secret (Most of you may already have guessed it :)).
 * 
 * You may request a Client Secret by asking the bexio Support
 */
define('BEXIO_CLIENT_SECRET', "");

/**
 * The BEXIO_AUTH_URL should be the authorization url of the OAuth Provider
 */
define('BEXIO_AUTH_URL', "https://office.bexio.com/oauth/authorize");

/**
 * The BEXIO_TOKEN_URL should be the url of the OAuth Provider to fetch an access token.
 */
define('BEXIO_TOKEN_URL', "https://office.bexio.com/oauth/access_token");

/**
 * The base url for the bexio API
 */
define('BEXIO_API_URL', "https://office.bexio.com/api2.php");

/**
 * The URL of this sample application. 
 * 
 * Example:
 * If you call the example from http://localhost/oauth_example/index.php
 * you should set this value to http://localhost/oauth_example
 */
define('APPLICATION_PATH', $basePath);

/**
 * The OAuth Provider will redirect the user to this URL after the authorization step
 */
define('APPLICATION_REDIRECTION_URL', APPLICATION_PATH . "/process.php");

/**
 * The scopes you need for your application (Use space to split multiple entries)
 */
define('APPLICATION_SCOPES', "contact_edit monitoring_show");

checkConfig(array(
    BEXIO_CLIENT_ID,
    BEXIO_CLIENT_SECRET,
    BEXIO_AUTH_URL,
    BEXIO_TOKEN_URL,
    BEXIO_API_URL,
    APPLICATION_REDIRECTION_URL,
    APPLICATION_SCOPES
));

function checkConfig(array $configurations) {
    foreach($configurations as $config) {
        if(!$config){
            die('please configure the application (see config/config.php)');
        }
    }
}
