<?php

/**
 * Class UserController
 * Контроллер для операций, связанных с пользователями
 */
class UserController extends CI_Controller
{
    /**
     * Функция переключения между юзерами
     *
     * @param int $uid
     * @return bool
     */
    function switchUser($uid = 0) {
        if (!$uid || !is_numeric($uid)) {
            echo 'User id is incorrect!';

            return false;
        }

        header('Location:/test_task/index.php/Welcome/index/' . $uid, true, 302);

    }
}