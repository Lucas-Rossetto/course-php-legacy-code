<?php
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 30/04/19
 * Time: 15:57
 */

declare(strict_types=1);

namespace ValueObject;



class Identity {


    public $firstname;
    public $lastname;

    public function setFirstname($firstname): string
    {
        $this->firstname = ucwords(strtolower(trim($firstname)));
    }

    public function setLastname($lastname): string
    {
        $this->lastname = strtoupper(trim($lastname));
    }


}