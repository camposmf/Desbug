<?php
  namespace App\Http;

  class Response{

    // código status http
    private $httpCode = 200;

    // cabeçalho do response
    private $headers = [];

    // tipo de conteúdo que está sendo retornado
    private $contentType = 'text/html';

    // Conteúdo do Response
    private $content;

    // método responsável por iniciar a classe e definir valores
    public function __construct($httpCode, $content, $contentType = 'text/html'){
      $this->httpCode = $httpCode;
      $this->content  = $content;
      $this->setContentType($contentType);
    }

    // método responsável de alterar o content type do response
    public function setContentType($contentType){
      $this->contentType = $contentType;
      $this->addHeaders('Content-Type', $contentType);
    } 

    // método responsável por adicionar um resgistro no cabeçalho do Response
    public function addHeaders($key, $value){
      $this->headers[$key] = $value;
    }
    
    // método responsável por enviar os headers para o navegador
    private function sendHeaders(){
      // status
      http_response_code($this->httpCode);

      // enviar headers
      foreach ($this->headers as $key=>$value) {
        header($key.': '.$value);
      }
    }
    // método responsável por enviar a resposta para o usuário
    public function sendResponse(){
      
      // envia os headers
      $this->sendHeaders();

      // envia o conteúdo
      switch ($this->contentType) {
        case 'text/html':
          echo $this->content;
        exit;
      }
    }
  }
?>