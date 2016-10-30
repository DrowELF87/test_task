<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
        $this->load->view('common/header.tpl');
		$this->load->view('index.tpl');
        $this->load->view('common/footer.tpl');
	}

	public function checkUri() {
	    var_dump($_POST);
        die('ccc');
    }
}