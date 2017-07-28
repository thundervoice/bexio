<?php

require_once dirname(__FILE__) . "/config/config.php";
require_once dirname(__FILE__) . "/class/OAuth2.class.php";

session_start();

/**
 * If the user does not accept the authorization request, an error will be returned.
 */
if (isset($_GET['error'])) {
    header("Location: index.php?error=" . urlencode($_GET['error_description']));
    die();
}

/**
 * If no code has been returned, something must have gone wrong.
 */
if (!isset($_GET['code'])) {
    header("Location: index.php?error=" . urlencode('Unknown error'));
    die();
}

/**
 * The previously generated state parameter will be checked for congruence.
 * This prevents a CSRF attack vector
 */
if (!isset($_SESSION['state']) || $_SESSION['state'] != $_GET['state']) {
    header("Location: index.php?error=" . urlencode('State mismatch'));
    die();
}

/**
 * The state should only be used once. Therefore the state parameter will be
 * removed from the session
 */
unset($_SESSION['state']);

try {
    /**
     * In order to retrieve an access token, the code from the authorization step needs
     * to be used. Additionally the Client ID, Client Secret and Redirect URL have to be
     * included in the request.
     */
    $client = new OAuth2(BEXIO_CLIENT_ID, BEXIO_CLIENT_SECRET);
    $accessToken = $client->getAccessToken(BEXIO_TOKEN_URL, $_GET['code'], APPLICATION_REDIRECTION_URL);
    
    /**
     * If no access token is set, an error must have occured.
     */
    if (!$accessToken) {
        throw new Exception('Could not fetch an access token');
    }
    
    /**
     * Check if the OAuth Provider has returned an error
     */
    if (isset($accessToken['error'])) {
        throw new Exception($accessToken['error_description']);
    }

    /**
     * Temporarily save the obtained organisation and access_token to the session.
     * 
     * This information should normally be saved to a persistent storage (e.g. database).
     * The obtained refresh token should normally be saved as well.
     */
    $_SESSION['org'] = $accessToken['org'];
    $_SESSION['access_token'] = $accessToken['access_token'];
    
    /**
     * Redirect the user to the result site
     */
    header("Location: result.php");
    die();
    
} catch (Exception $e) {
    header("Location:index.php?error=" . urlencode($e->getMessage()));
    die();
}