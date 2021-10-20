<?php

  namespace App\Model\Entity;

  Class User extends ActiveTime {
    public $id          = 1; 
    public $nickname    = 'Jamile_Batata';
    public $username    = 'Jamile';
    public $email       = 'jamile_gosta_batata@gmail.com';
    public $password    = 'jamile_batata123';
    public $birthDate    = '18/02/1999';
    public $image    = 'resources/images/jamile_batata.png';

    /* TODO: Entender como fazer o relacionamento entre as tabelas do banco como Classes no php */
    //public $ActiveTime;

  }
?>