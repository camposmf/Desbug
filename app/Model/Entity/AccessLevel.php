<?php
  namespace App\Model\Entity;

  Class AccessLevel {
    public $id;
    public $blTypeAccess;
    public $user;

    public function __construct(){
      $this->user = new User();
    }
  }
?>