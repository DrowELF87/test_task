<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function index()
    {
        $data['originalUri'] = '';
        $data['shortUri'] = '';

        $this->load->view('index.tpl', $data);
    }
}