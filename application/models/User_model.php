<?php
class User_model extends CI_Model {

    var $id = 0;
    var $fname = '';
    var $lname = '';

    function User_model() {
        // Call the Model constructor
        parent::__construct();
    }

    function getUsers() {
        $query = $this->db->query('SELECT * FROM srv_users');

        return $query->result();
    }
}