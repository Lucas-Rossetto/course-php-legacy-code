<?php

declare(strict_types=1);

namespace controllers;

use interfaces\UserInterface;
use models\Users;
use core\View;
use core\Validator;
use repository\UserRepository;

class UsersController
{

    private $user;

    public function __construct(\UserInterface $user)
    {
        $this->user = $user;
    }

    public function defaultAction()
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
        $user = new Users();
        $form = $user->getRegisterForm();
        $method = strtoupper($form['config']['method']);
        $data = $GLOBALS['_' . $method];

        if ($_SERVER['REQUEST_METHOD'] == $method && !empty($data)) {
            $validator = new Validator($form, $data);
            $form['errors'] = $validator->errors;

            if (empty($form['errors'])) {
                $user->setIdentity($data['identity']);
                $user->setEmail($data['email']);
                $user->setPwd($data['pwd']);
            }
        }

        $v = new View('addUser', 'front');
        $v->assign('form', $form);
    }

    public function loginAction()
    {
        $user = new Users();
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
