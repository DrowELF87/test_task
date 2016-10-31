<?php
class Uri_model extends CI_Model {

    const FIFTEEN_DAYS = 1296000;

    var $id = 0;
    var $from_user = 0;
    var $to_user = 0;
    var $originalUri = '';
    var $shortUri = '';
    var $date = 0;

    function Uri_model() {
        // Call the Model constructor
        parent::__construct();
    }

    function getUserStored() {
        $query = $this->db->query('SELECT * FROM srv_uristore');

        return $query->result();
    }

    function getMyUri() {
        $query = $this->db->query('SELECT * FROM srv_uristore WHERE to_user = 1');

        return $query->result();
    }

    function saveUriPair($originalUri = '', $shortUri = '') {
        if (!$originalUri || !$shortUri) {
            echo 'URI is incorrect.';

            return false;
        }

        $this->originalUri = $originalUri;
        $this->shortUri = $shortUri;
        $this->date = time();

        $this->db->query('INSERT INTO srv_uristore (`original_uri`, `short_uri`, `date`, `from_user`) VALUES ("' . $this->originalUri . '", "' . $this->shortUri . '", "' . $this->date . '", 1)');
    }

    function checkShortUri($shortUri = '') {
        $query = $this->db->query('SELECT * FROM srv_uristore WHERE short_uri = "' . $shortUri . '"');

        return $query->result();
    }

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

    function shareUri() {
        $this->db->query('INSERT INTO srv_uristore (`original_uri`, `short_uri`, `date`, `from_user`, `to_user`) 
                          SELECT `original_uri`, `short_uri`, `date`, `from_user`, ' . $_POST['userId'] . ' FROM srv_uristore WHERE id = ' . $_POST['uriId'] . ';');
    }
}