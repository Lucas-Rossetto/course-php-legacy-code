<?php



namespace controllers;
use core\View;

class PagesController
{
    public function defaultAction()
    {
        $v = new View('homepage', 'back');
        $v->assign('pseudo', 'prof');
    }
}
