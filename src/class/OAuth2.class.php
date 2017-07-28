<?php

namespace bexio;

class OAuth2 {

    protected $client_id = null;
    protected $client_secret = null;

    public function __construct($client_id, $client_secret = null) {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
    }

    public function getAuthenticationUrl($auth_endpoint, $redirect_uri, $state, $scopes) {
        $parameters = array(
            'client_id' => $this->client_id,
            'redirect_uri' => $redirect_uri,
            'state' => $state,
            'scope' => $scopes,
        );

        return $auth_endpoint . '?' . http_build_query($parameters, null, '&');
    }

    public function getAccessToken($token_url, $access_code, $redirect_uri) {
        $postFields = array('client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'code' => $access_code,
            'redirect_uri' => $redirect_uri
        );

        $curl = new Curl();
        $result = $curl->call($token_url, array(), $postFields, Curl::METHOD_POST);
        return json_decode($result, true);
    }

}

