<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function index()
    {
        $data['originalUri'] = '';
        $data['shortUri'] = '';

        // Получаем уже сохранённые урлы
        $this->load->model('Uri_model');
        $data['stored'] = $this->Uri_model->getUserStored();

        // Получаем юзеров
        $this->load->model('User_model');
        $data['users'] = $this->User_model->getUsers();

        // Получаем отправленные нам урлы
        $data['myUri'] = $this->Uri_model->getMyUri();

        $this->load->view('index.tpl', $data);
    }
}