<?php

namespace bexio\Connector;

use bexio;

class bexioConnector {

    /**
     * The bexio API needs a valid Accept-Header, JSON in this case.
     */
    const HTTP_HEADER_ACCEPT = "application/json";

    protected $api_url;
    protected $org;
    protected $access_token;
    protected $curl;

    public function __construct($api_url, $org, $access_token) {
        $this->api_url = $api_url;
        $this->org = $org;
        $this->access_token = $access_token;

        $this->curl = new bexio\Curl();
    }

    /**
     * Call "GET /country"
     * @param type $urlParams
     */
    public function getCountries($urlParams = array()) {
        return $this->call('country', $urlParams);
    }

    public function call($ressource, $urlParams = array(), $postParams = array(), $method = Curl::METHOD_GET) {
        $url = $this->api_url . "/" . $this->org . "/" . $ressource;
        $data = $this->curl->call($url, $urlParams, $postParams, $method, $this->getDefaultHeaders());
        return json_decode($data, true);
    }

    /**
     * In order to use the api, you have to provide both an Authorization and an
     * Accept-Header. The Authorization-Header uses the OAuth access_token.
     * @return type
     */
    protected function getDefaultHeaders() {
        return array(
            'Authorization' => 'Bearer ' . $this->access_token,
            'Accept' => self::HTTP_HEADER_ACCEPT,
        );
    }

}
