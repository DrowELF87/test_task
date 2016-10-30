<?php
class Uri_model extends CI_Model {

    var $originalUri = '';
    var $shortUri = '';
    var $date = '';

    function UriModel()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function get_last_ten_entries()
    {
        var_dump($this->db);
        die();
        $query = $this->db->get('srv_uristore', 10);
        return $query->result();
    }

    function saveUriPair()
    {
        $this->originalUri = $_POST['originalUri'];
        $this->shortUri = $_POST['shortUri'];
        $this->date = time();

        $this->db->insert('srv_uristore', $this);
    }

    function update_entry()
    {
        $this->title   = $_POST['title'];
        $this->content = $_POST['content'];
        $this->date    = time();

        $this->db->update('entries', $this, array('id' => $_POST['id']));
    }

}