<?php
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 30/04/19
 * Time: 10:01
 */

use controllers\PagesController;
use controllers\UsersController;
use models\Users;

return [
    UserInterface::class => function ($container) {
        $host = $container['config']['database']['host'];
        $driver = $container['config']['database']['driver'];
        $name = $container['config']['database']['name'];
        $user = $container['config']['database']['user'];
        $password = $container['config']['database']['password'];

        return new Users($driver, $host, $name, $user, $password);
    },
    UsersController::class => function ($container) {
        $userModel = $container[UserInterface::class]($container);

        return new UsersController($userModel);

    },
    PagesController::class => function ($container) {
        return new PagesController();
    }
];