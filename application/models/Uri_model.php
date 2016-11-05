<?php
class Uri_model extends CI_Model {

    const FIFTEEN_DAYS = 1296000;

    var $id = 0;
    var $from_user = 0;
    var $to_user = 0;
    var $originalUri = '';
    var $shortUri = '';
    var $date = 0;

    /**
     * Uri_model constructor.
     */
    function Uri_model() {
        // Call the Model constructor
        parent::__construct();
    }

    /**
     * Получаем сохранённые УРЛы
     *
     * @return object
     */
    function getUserStored() {
        $query = $this->db->query('SELECT * FROM srv_uristore');

        return $query->result();
    }

    /**
     * Получаем УРЛы, которые создали сами
     *
     * @return object
     */
    function getMyUri() {
        $query = $this->db->query('SELECT * FROM srv_uristore WHERE to_user = ' . $this->session->id);

        return $query->result();
    }

    /**
     * Сохраняем пару original/short uri
     *
     * @param string $originalUri
     * @param string $shortUri
     * @return bool
     */
    function saveUriPair($originalUri = '', $shortUri = '') {
        if (!$originalUri || !$shortUri) {
            echo 'URI is incorrect.';

            return false;
        }

        $this->originalUri = $originalUri;
        $this->shortUri = $shortUri;
        $this->date = time();

        $this->db->query('INSERT INTO srv_uristore (`original_uri`, `short_uri`, `date`, `from_user`) VALUES ("' . $this->originalUri . '", "' . $this->shortUri . '", "' . $this->date . '", ' . $this->session->id . ')');
    }

    /**
     * Проверяем на наличие короткого урла
     *
     * @param string $shortUri
     * @return mixed
     */
    function checkShortUri($shortUri = '') {
        $query = $this->db->query('SELECT * FROM srv_uristore WHERE short_uri = "' . $shortUri . '"');

        return $query->result();
    }

    /**
     * Чистим протухшие урлы
     */
    function checkBadUri() {
        $query = $this->db->query('SELECT * FROM srv_uristore');

        foreach ($query->result() as $checkBadItem) {
            if (time() >= ($checkBadItem->date + FIFTEEN_DAYS)) {
                $badItems[] = $checkBadItem->id;
            }
        }
        if (!empty($badItems)) {
            $this->db->query('DELETE FROM srv_uristore WHERE id IN (' . implode(',', $badItems) . ')');
        }
    }

    /**
     * Расшариваем УРЛ пользователю
     */
    function shareUri() {
        $this->db->query('INSERT INTO srv_uristore (`original_uri`, `short_uri`, `date`, `from_user`, `to_user`) 
                          SELECT `original_uri`, `short_uri`, `date`, `from_user`, ' . $_POST['userId'] . ' FROM srv_uristore WHERE id = ' . $_POST['uriId'] . ';');
    }
}