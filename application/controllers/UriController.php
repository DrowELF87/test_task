<?php

class UriController extends CI_Controller {

    function index() {
        $this->checkUri();
    }

    private function checkUri() {
        if (!$_POST['originalUri']) {
            echo 'Type valid Uri in a field';
            return false;
        }

        $response = $this->getWebPage($_POST['originalUri']);
        $this->vd($response);
        die('gag');

    }

    function vd($var) {
        echo '<pre>';
        echo var_dump($var);
        echo '</pre>';
    }

    private function getWebPage($url) {
        $options = array(
            CURLOPT_RETURNTRANSFER => true,   // return web page
            CURLOPT_HEADER         => false,  // don't return headers
            CURLOPT_FOLLOWLOCATION => true,   // follow redirects
            CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
            CURLOPT_ENCODING       => "",     // handle compressed
            CURLOPT_USERAGENT      => "test", // name of client
            CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
            CURLOPT_TIMEOUT        => 120,    // time-out on response
            CURLOPT_SSL_VERIFYPEER => 0,      // to allow https connect
            CURLOPT_SSL_VERIFYHOST => 0,      // to allow https connect
        );

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);

        curl_exec($ch);
//        $this->vd($content);
//        die('gag');
        $info = curl_getinfo($ch);

        curl_close($ch);

        return $info;
    }
}