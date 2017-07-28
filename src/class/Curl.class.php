<?php

namespace bexio;

class Curl {

    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';
    
    const CURL_TIMEOUT_IN_SECS = 15;

    public static $successFullHttpCodes = array(200, 201, 204);

    public function call($url, $urlParams = array(), $postParams = null, $method = self::METHOD_GET, $headers = array()) {
        $finalUrl = $url . $this->getUrlParameterString($urlParams);
        $data = $this->makeCurlCall($finalUrl, $postParams, $method, $headers);
        return $data;
    }

    /**
     * Creates a curl call for the given url, automatically validates the return value for errors.
     * If an error has been found a new Exception will be thrown.
     * 
     * @param string $url
     * @param array $postParams Parameters for Post and Put-Requests
     * @param string $method HTTP-Method (GET, PUT, POST, DELETE)
     * @param string $headers HTTP-Headers
     * @throws Exception
     */
    private function makeCurlCall($url, $postParams = array(), $method = self::METHOD_GET, $headers = array()) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_VERBOSE, 0);
        curl_setopt($curl, CURLOPT_TIMEOUT, self::CURL_TIMEOUT_IN_SECS);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

        if ($headers) {
            $usableHeaders = array();
            foreach ($headers as $name => $value) {
                $usableHeaders[] = sprintf('%s: %s', $name, $value);
            }

            curl_setopt($curl, CURLOPT_HTTPHEADER, $usableHeaders);
        }

        if ($postParams) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postParams);
        }

        $data = curl_exec($curl);
        $this->checkForError($curl, $data);

        return $data;
    }

    /**
     * Checks for any errors in the api response.
     * If an error has been found a new Exception will be thrown.
     *
     * @param string $data the resulting data
     * @throws Exception
     */
    private function checkForError($curl, $data) {
        $curlInfo = curl_getinfo($curl);
        if (isset($curlInfo['http_code']) && !in_array($curlInfo['http_code'], self::$successFullHttpCodes)) {
            throw new Exception($curlInfo['http_code'] ? $data : 'could not get a response from the service', $curlInfo['http_code'] ? $curlInfo['http_code'] : 500);
        }
    }

    /**
     * Builds a valid http query
     *
     * @param array $urlParams
     * @return string
     */
    private function getUrlParameterString(array $urlParams) {
        if (!$urlParams) {
            return "";
        }

        return "?" . http_build_query($urlParams);
    }

}
