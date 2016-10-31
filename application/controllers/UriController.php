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
        $this->load->model('Uri_model');
        $this->load->model('User_model');

        log_message('info', 'User try to check ' . $_POST['originalUri'] . ' at ' . date('d-m-Y', time()));
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

        // Получаем уже сохранённые урлы
        $data['stored'] = $this->Uri_model->getUserStored();

        // Получаем юзеров
        $data['users'] = $this->User_model->getUsers();

        // Получаем отправленные нам урлы
        $data['myUri'] = $this->Uri_model->getMyUri();

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

    /**
     * Сохраняет пару УРЛов (оргиниальный, короткий)
     *
     * @return bool
     */
    public function saveUriPair() {
        $this->load->model('Uri_model');

        if (!$_POST['originalUri'] || !$_POST['shortUri']) {
            echo 'Incorrect URI';

            return false;
        }

        $inUse = $this->Uri_model->checkShortUri($_POST['shortUri']);
        if ($inUse) {
            echo 'Short URI already in use. Change it please.';

            return false;
        }

        $patternReplace = '(http(s|):\/\/|^)';
        $originalUri = html_escape(str_replace(' ', '', preg_replace($patternReplace, '', $_POST['originalUri'])));
        $shortUri = html_escape(str_replace(' ', '', $_POST['shortUri']));

        // Ещё раз проверяем перед сохранением
        $response = $this->getWebPage($originalUri);
        if ((!$response['content_type'] && !$response['http_code']) || ($response['http_code'] === 404 || $response['http_code'] === 502)) {
            echo 'Website is currently unavailable';

            return false;
        }
        if (strlen($shortUri) > 10) {
            $shortUri = substr($shortUri, 0, 10);
        }

        $this->Uri_model->saveUriPair($originalUri, $shortUri);
        log_message('info', 'User saved original ' . $originalUri . ' and short uri ' . $shortUri . ' at ' . date('d-m-Y', time()));
        echo 'URI saved successfully';
    }

    /**
     * Расшаривает УРЛ выбранному пользователю
     *
     * @return bool
     */
    public function shareUri() {
        $this->load->model('Uri_model');

        if (!is_numeric($_POST['uriId']) || !is_numeric($_POST['userId'])) {
            echo 'Values should be integer!';

            return false;
        }
        $this->Uri_model->shareUri();
        echo 'Shared successfully';
    }
}