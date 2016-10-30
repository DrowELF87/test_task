<?php
class Uri_model extends CI_Model {

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

    function getMyUri () {
        $query = $this->db->query('SELECT * FROM srv_uristore WHERE to_user = 1');

        return $query->result();
    }

    function saveUriPair() {
        $this->originalUri = $_POST['originalUri'];
        $this->shortUri = $_POST['shortUri'];
        $this->date = time();

        $this->db->query('INSERT INTO srv_uristore (`original_uri`, `short_uri`, `date`) VALUES ("' . $this->originalUri . '", "' . $this->shortUri . '", "' . $this->date . '")');
    }
}