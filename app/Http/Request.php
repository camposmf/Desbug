<?php
  namespace App\Http;

  class Request{
    // método http da requisição
    private $httpMethod;

    // uri da página
    private $uri;

    // parâmetros da url
    private $queryParams = [];

    // variáveis recebidas no post da página ($_POST)
    private $postVars = [];

    // cabeçalho da requisição
    private $headers = []; 

    // método responsável por iniciar a classe e definir valores
    public function __construct(){
      $this->queryParams  = $_GET ?? [];
      $this->postVars     = $_POST ?? [];
      $this->headers      = getallheaders();
      $this->uri          = $_SERVER['REQUEST_URI'] ?? '';
      $this->httpMethod   = $_SERVER['REQUEST_METHOD'] ?? '';
    }

    public function getHttpMethod() {
      return $this->httpMethod;
    }

    public function getUri() {
      return $this->uri;
    }

    public function getQueryParams(){
      return $this->queryParams;
    }

    public function getPostVars(){
      return $this->postVars;
    }

    public function getHeaders(){
      return $this->headers;
    }

    
  }
?>