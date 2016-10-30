<?php
class Uri_model extends CI_Model {

    var $originalUri = '';
    var $shortUri = '';
    var $date = 0;

    function Uri_model()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function saveUriPair()
    {
        $this->originalUri = $_POST['originalUri'];
        $this->shortUri = $_POST['shortUri'];
        $this->date = time();

        $this->db->query('INSERT INTO srv_uristore (`original_uri`, `short_uri`, `date`) VALUES ("' . $this->originalUri . '", "' . $this->shortUri . '", "' . $this->date . '")');
    }
}