<?php
class User_model extends CI_Model {

    var $id = 0;
    var $fname = '';
    var $lname = '';

    /**
     * User_model constructor.
     */
    function User_model() {
        // Call the Model constructor
        parent::__construct();
    }

    /**
     * Получаем юзеров
     *
     * @param bool $isAll
     * @return mixed
     */
    function getUsers($isAll = true) {
        $add = '';
        if (!$isAll) {
            $add = " WHERE id != " . $this->session->id;
        }
        $query = $this->db->query('SELECT * FROM srv_users' . $add);

        return $query->result();
    }

    /**
     * Получаем нужный uid
     *
     * @param int $uid
     * @return int
     */
    function getUid($uid = 0) {
        if (!$uid) {
            return 1;
        } else {
            $query = $this->db->query('SELECT id FROM srv_users WHERE id = ' . $uid);

            return $query->row()->id;
        }
    }
}