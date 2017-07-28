<?php
namespace bexio;

require_once dirname(__FILE__) . "/config/config.php";
require_once dirname(__FILE__) . "/class/OAuth2.class.php";

session_start();

/** 
 * In order to authorize, a state parameter needs to be passed to the authorization url.
 * This state parameter will be returned after the authorization step and must be verified
 * by the consumer to prohibit CSRF-attacks. 
 * 
 * Therefore the state parameter will be saved to the session.
 */
$state = md5(md5(uniqid().uniqid().mt_rand()));
$_SESSION['state'] = $state;


/**
 * The redirect url must contain the following params:
 * 
 * - Client ID
 * - Redirect URL
 * - State
 * - Scopes
 * 
 * The method `getAuthenticationUrl` will generate a valid redirect url.
 * 
 * Note: The Client secret is not needed for this step
 */
$client = new OAuth2(BEXIO_CLIENT_ID);
$authUrl = $client->getAuthenticationUrl(
        BEXIO_AUTH_URL,
        APPLICATION_REDIRECTION_URL, 
        $state, 
        APPLICATION_SCOPES
);

// Redirect to the previously generated auth url
header('Location: ' . $authUrl);
die();