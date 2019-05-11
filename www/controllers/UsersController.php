<?php

declare(strict_types=1);

namespace controllers;

use core\View;
use core\Validator;
use interfaces\UserInterface;
use models\Users;
use repository\UserRepository;

class UsersController extends UserRepository
{

    private $user;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function defaultAction() : string
    {
        echo 'users default';
    }

    public function addAction()
    {

        $form = $this->user->getRegisterForm();

        $v = new View('addUser', 'front');
        $v->assign('form', $form);
    }

    public function saveAction()
    {
        $user = new Users(Users::class);
        $form = $user->getRegisterForm();
        $method = strtoupper($form['config']['method']);
        $data = $GLOBALS['_' . $method];

        if ($_SERVER['REQUEST_METHOD'] == $method && !empty($data)) {
            $validator = new Validator($form, $data);
            $form['errors'] = $validator->errors;

            if (empty($form['errors'])) {
                $user->setUser($data['user']);
            }
        }

        $v = new View('addUser', 'front');
        $v->assign('form', $form);
    }

    public function loginAction()
    {
        $user = new Users(Users::class);
        $form = $user->getLoginForm();

        $method = strtoupper($form['config']['method']);
        $data = $GLOBALS['_' . $method];
        if ($_SERVER['REQUEST_METHOD'] == $method && !empty($data)) {
            $validator = new Validator($form, $data);
            $form['errors'] = $validator->errors;

            if (empty($errors)) {
                $token = md5(substr(uniqid() . time(), 4, 10) . 'mxu(4il');
                // TODO: connexion
            }
        }

        $v = new View('loginUser', 'front');
        $v->assign('form', $form);
    }

    public function forgetPasswordAction()
    {
        $v = new View('forgetPasswordUser', 'front');
    }
}
