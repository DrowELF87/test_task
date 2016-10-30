<?php

/**
 * Class UriController
 * Контроллер для обработки УРЛов
 */
class UriController extends CI_Controller {

    function index() {
        $this->checkUri();
    }

    /**
     * Функция для проверки введённого пользователем
     * и генерации короткого УРЛа
     *
     * @return bool
     */
    private function checkUri() {
        if (!trim($_POST['originalUri'])) {
            echo 'Type valid Uri in a field';

            return false;
        }

        $originalUri = str_replace(' ', '', $_POST['originalUri']);
        $data['originalUri'] = html_escape($originalUri);

        // Получаем ответ от запрашиваемой страницы
        $response = $this->getWebPage($originalUri);
        if ((!$response['content_type'] && !$response['http_code']) || ($response['http_code'] === 404 || $response['http_code'] === 502)) {
            echo 'Website is currently unavailable';

            return false;
        }

        // Если всё ок, то генерируем короткий урл
        $data['shortUri'] = $this->generateUri($originalUri);


        $this->load->view('index.tpl', $data);
    }

    /**
     * Функция для генрации короткого УРЛа
     *
     * @param string $originalUri
     * @return bool|string
     */
    private function generateUri($originalUri = '') {
        if (!$originalUri) {
            echo 'Original URI is incorrect';

            return false;
        }

        $resultMatch = array();
        $pattern = '/(http(s|):\/\/|^)(.*?)(\/|$)/';
        preg_match_all($pattern, $originalUri, $resultMatch);

        if (!empty($resultMatch) && isset($resultMatch[1][0])) {
            $resultString = $resultMatch[3][0];
        }

        if (strlen($resultString) > 10) {
            $resultString = substr($resultString, 0, 10);
        }

        return $resultString;
    }

    public function vd($var) {
        echo '<pre>';
        echo var_dump($var);
        echo '</pre>';
    }

    /**
     * Стучимся по указанному адресу и получаем коллбек страницы
     *
     * @param $url
     * @return mixed
     */
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
        $info = curl_getinfo($ch);

        curl_close($ch);

        return $info;
    }

    public function saveUriPair() {
        if (!$_POST['originalUri'] || !$_POST['shortUri']) {
            echo 'Incorrect URI';

            return false;
        }

        $this->load->model('Uri_model');
        $this->Uri_model->saveUriPair();

        echo 'URI saved successfully';
    }
}