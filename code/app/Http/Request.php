<?php
  namespace App\Http;
  use \App\Model\Entity\User;
  
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
      $this->headers      = getallheaders();
      $this->httpMethod   = $_SERVER['REQUEST_METHOD'] ?? '';
      $this->setUri();
      $this->setPostVars();
    }

    // método responsável por definir as variáveis do post
    private function setPostVars(){

      // verifica o método da requisição
      if($this->httpMethod == 'GET') return false;

      // post padrão (form data / enconded)
      $this->postVars = $_POST ?? [];

      // post json
      $inputJson = file_get_contents('php://input');

      $this->postVars = (strlen($inputJson) && empty($_POST)) ? json_decode($inputJson, true) : $this->postVars;
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
    
    public function getHttpMethod() {
      return $this->httpMethod;
    }
    
    public function getUri() {
      return $this->uri;
    }
    
    public function getHeaders(){
      return $this->headers;
    }
    
    public function getQueryParams(){
      return $this->queryParams;
    }
    
    public function getPostVars(){
      return $this->postVars;
    }

    public function getRouter(){
      return $this->router;
    }

  }
?>