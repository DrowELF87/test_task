<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Welcome
 * Стартовый класс
 */
class Welcome extends CI_Controller {

    public function index($uid = 0)
    {
        $this->load->model('Uri_model');
        $this->load->model('User_model');

        $data['originalUri'] = '';
        $data['shortUri'] = '';

        // Получаем id и добавляем в сессию
        $this->session->set_userdata(array('id' => $uid ? $uid : $this->User_model->getUid()));

        // Получаем уже сохранённые урлы
        $data['stored'] = $this->Uri_model->getUserStored();

        // Получаем других юзеров
        $data['users'] = $this->User_model->getUsers(false);

        // Получаем всех юзеров
        $data['usersAll'] = $this->User_model->getUsers();

        // Получаем отправленные нам урлы
        $data['myUri'] = $this->Uri_model->getMyUri();

        // Проверяем все протухшие (больше 15 дней) УРЛы и косим их
        $this->Uri_model->checkBadUri();

        $this->load->view('index.tpl', $data);
    }
}