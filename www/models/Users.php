<?php

declare(strict_types=1);

namespace models;

/*use core\Routing;*/

use interfaces\UserInterface;

class Users implements UserInterface
{

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /* public $id;
     public $identity;
     public $email;
     public $pwd;
     public $role;
     public $status;

     public function __construct($identity , $email ,$pwd)
     {
         $this->identity = $identity;
         $this->email = $email;
         $this->pwd = $pwd;
     }

     public function setEmail($email): string
     {
         $this->email = strtolower(trim($email));
     }

     public function setPwd($pwd): string
     {
         $this->pwd = password_hash($pwd, PASSWORD_DEFAULT);
     }

     public function setRole($role): string
     {
         $this->role = $role;
     }

     public function setStatus($status): string
     {
         $this->status = $status;
     }

     public function setId($id)
     {
         $this->id = $id;
     }

     public function setIdentity($identity){
         $this->identity = $identity;
     }*/
}

