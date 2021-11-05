<?php
  namespace App\Http;

  class Request{

    // instância do router
    private $router;

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
    public function __construct($router){
      $this->router       = $router;
      $this->queryParams  = $_GET ?? [];
      $this->postVars     = $_POST ?? [];
      $this->headers      = getallheaders();
      $this->httpMethod   = $_SERVER['REQUEST_METHOD'] ?? '';
      $this->setUri();
    }

    // método responsável por definir a URI
    private function setUri(){
      
      // uri completa (Com gets)
      $this->uri = $_SERVER['REQUEST_URI'] ?? '';

      // remove gets da uri
      $explodeUri = explode('?', $this->uri);

      // definir uri com o valor da rota
      $this->uri = $explodeUri[0];
    }

    public function getRouter(){
      return $this->router;
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