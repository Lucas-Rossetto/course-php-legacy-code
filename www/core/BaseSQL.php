<?php

declare(strict_types=1);
namespace core;

class BaseSQL
{
    private $pdo;
    private $table;

    public function __construct($driver,$host,$name,$user,$password)
    {
        try {
            $this->pdo = new \PDO($driver.':host='.$host.';dbname='.$name, $user, $password);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\Exception $e) {
            die('Erreur SQL : '.$e->getMessage());
        }

        $this->table = get_called_class();
    }


    /**
     * @param array $where  the where clause
     * @param bool  $object if it will return an array of results ou an object
     *
     * @return mixed
     */
    public function getOneBy(array $where, $object = false)
    {
        $sqlWhere = [];
        foreach ($where as $key => $value) {
            $sqlWhere[] = $key.'=:'.$key;
        }
        $sql = ' SELECT * FROM '.$this->table.' WHERE  '.implode(' AND ', $sqlWhere).';';
        $query = $this->pdo->prepare($sql);

        if ($object) {
            $query->setFetchMode(PDO::FETCH_INTO, $this);
        }
        if (!$object) {
            $query->setFetchMode(PDO::FETCH_ASSOC);
        }

        $query->execute($where);

        return $query->fetch();
    }

    public function save()
    {
        $dataObject = get_object_vars($this);
        $dataChild = array_diff_key($dataObject, get_class_vars(get_class()));

        if (is_null($dataChild['id'])) {
            $sql = 'INSERT INTO '.$this->table.' ( '.
                implode(',', array_keys($dataChild)).') VALUES ( :'.
                implode(',:', array_keys($dataChild)).')';

            $query = $this->pdo->prepare($sql);
            $query->execute($dataChild);
        }
        if ($dataChild['id']) {
            $sqlUpdate = [];
            foreach ($dataChild as $key => $value) {
                if ('id' != $key) {
                    $sqlUpdate[] = $key.'=:'.$key;
                }
            }

            $sql = 'UPDATE '.$this->table.' SET '.implode(',', $sqlUpdate).' WHERE id=:id';

            $query = $this->pdo->prepare($sql);
            $query->execute($dataChild);
        }
    }

    public function getRegisterForm(): array
    {
        return [
            'config' => [
                'method' => 'POST',
                'action' => Routing::getSlug('Users', 'save'),
                'class' => '',
                'id' => '',
                'submit' => "S'inscrire",
                'reset' => 'Annuler',],

            'data' => [
                'firstname' => [
                    'type' => 'text',
                    'placeholder' => 'Votre Prénom',
                    'required' => true,
                    'class' => 'form-control',
                    'id' => 'firstname',
                    'minlength' => 2,
                    'maxlength' => 50,
                    'error' => 'Le prénom doit faire entre 2 et 50 caractères',
                ],

                'lastname' => ['type' => 'text', 'placeholder' => 'Votre nom', 'required' => true, 'class' => 'form-control', 'id' => 'lastname', 'minlength' => 2, 'maxlength' => 100,
                    'error' => 'Le nom doit faire entre 2 et 100 caractères',],

                'email' => ['type' => 'email', 'placeholder' => 'Votre email', 'required' => true, 'class' => 'form-control', 'id' => 'email', 'maxlength' => 250,
                    'error' => "L'email n'est pas valide ou il dépasse les 250 caractères",],

                'pwd' => ['type' => 'password', 'placeholder' => 'Votre mot de passe', 'required' => true, 'class' => 'form-control', 'id' => 'pwd', 'minlength' => 6,
                    'error' => 'Le mot de passe doit faire au minimum 6 caractères avec des minuscules, majuscules et chiffres',],

                'pwdConfirm' => ['type' => 'password', 'placeholder' => 'Confirmation', 'required' => true, 'class' => 'form-control', 'id' => 'pwdConfirm', 'confirm' => 'pwd', 'error' => 'Les mots de passe ne correspondent pas'],
            ],
        ];
    }

    public function getLoginForm(): array
    {
        return [
            'config' => [
                'method' => 'POST',
                'action' => '',
                'class' => '',
                'id' => '',
                'submit' => 'Se connecter',
                'reset' => 'Annuler',],

            'data' => [
                'email' => ['type' => 'email', 'placeholder' => 'Votre email', 'required' => true, 'class' => 'form-control', 'id' => 'email',
                    'error' => "L'email n'est pas valide",],

                'pwd' => ['type' => 'password', 'placeholder' => 'Votre mot de passe', 'required' => true, 'class' => 'form-control', 'id' => 'pwd',
                    'error' => 'Veuillez préciser un mot de passe',],
            ],
        ];
    }
}
