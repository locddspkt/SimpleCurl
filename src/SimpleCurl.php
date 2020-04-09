<?php


namespace SimpleCurl;

class SimpleCurl {

    private static $httpCode; //latest httpCode returned;
    private static $timeout = 180; //default timeout


    /***
     * @param bool $hasHyphens
     * @param bool $hasBraces
     * @return string
     */
    private static function guid($hasHyphens = true, $hasBraces = false) {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        }
        else {
            mt_srand((double)microtime() * 10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = $hasHyphens ? chr(45) : '';// "-"
            $braceStart = $hasBraces ? chr(123) : '';
            $braceEnd = $hasBraces ? chr(125) : '';
            if ($hasHyphens == false) {
                $hyphen = '';
            }
            $uuid = $braceStart// "{"
                . substr($charid, 0, 8) . $hyphen
                . substr($charid, 8, 4) . $hyphen
                . substr($charid, 12, 4) . $hyphen
                . substr($charid, 16, 4) . $hyphen
                . substr($charid, 20, 12)
                . $braceEnd;// "}"
            return $uuid;
        }
    }

    public static function SetTimeout($timeout) {
        if (is_numeric($timeout) === false) return false;
        if ($timeout < 0) return false;
        self::$timeout = $timeout;
    }

    private static function generateClientAgent() {
        return 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.34 Safari/537.36 Custom/' . self::guid(false);
    }

    private static function checkSupport() {
        return function_exists('curl_version');
    }

    /***
     * alias of getData (will be removed)
     * @param $url
     * @param bool $params
     * @param bool $cookieFile
     * @param array $externalHeaders
     * @param array $curlOptions
     * @return string $response
     */
    public static function Get($url, $params = false, $cookieFile = false, $externalHeaders = array(), $curlOptions = array()) {
        if (self::checkSupport() === false) return false;

        //first build the url
        if ($params !== false) {
            if (strpos($url, '?') === false) $url .= '?';
            if (is_array($params)) {
                $body = '';
                foreach ($params as $key => $value) {
                    $value = urlencode($value);
                    $body .= "&{$key}=$value";
                }
            }
            else {
                $body = $params;
            }
            $url .= $body;
        }


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //timeout can be override in options
        curl_setopt($ch, CURLOPT_TIMEOUT, self::$timeout);

        if ($cookieFile !== false) {
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
        }

        //simulate the client = chrome
        $headers = array(self::generateClientAgent());

        if (!empty($externalHeaders)) {
            $headers = array_merge($headers, $externalHeaders);
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);


        curl_setopt($ch, CURLOPT_URL, $url); //define now
        curl_setopt($ch, CURLOPT_POST, 0);

        //for curl options
        if (!empty($curlOptions) && is_array($curlOptions)) {
            foreach ($curlOptions as $key => $value) {
                curl_setopt($ch, $key, $value);
            }
        }
        $output = curl_exec($ch);

        if ($output === false) {
            trigger_error(curl_error($ch));
        }

        self::$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $output;
    }

    public static function Post($url, $postData = false, $cookieFile = false, $externalHeaders = array(), $curlOptions = array()) {
        if (self::checkSupport() === false) return false;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //timeout can be override in options
        curl_setopt($ch, CURLOPT_TIMEOUT, self::$timeout);
        if ($cookieFile !== false) {
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
        }
        //simulate the client = chrome
        $headers = array(self::generateClientAgent());

        if (!empty($externalHeaders)) {
            $headers = array_merge($headers, $externalHeaders);
        }


        if ($postData !== false) {
            if (is_array($postData)) {
                $postData = http_build_query($postData);
            }

            $postData = utf8_encode($postData);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);

        //for curl options always at the last to override others
        if (!empty($curlOptions) && is_array($curlOptions)) {
            foreach ($curlOptions as $key => $value) {
                curl_setopt($ch, $key, $value);
            }
        }

        $output = curl_exec($ch);

        if ($output === false) {
            trigger_error(curl_error($ch));
        }

        self::$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $output;
    }

    /***
     * the latest http code
     */
    public static function GetHttpCode() {
        return self::$httpCode;
    }
}