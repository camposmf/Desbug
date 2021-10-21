<?php
  namespace App\Http;

  use \Closure;
  use \Exception;

  class Router{
    // url completa do projeto (raiz)
    private $url = '';

    // prefixo de todas as rotas
    private $prefix = '';

    // indice de rotas
    private $routes = [];

    // Uma instância de request
    private $request;

    // método responsável por iniciar a classe e definir valores
    public function __construct($url){
      $this->request = new Request();
      $this->url = $url;
      $this->setPrefix();
    }

    // método responsável por definir o prefixo das rotas
    private function setPrefix(){
      // informações da url atual
      $parseUrl = parse_url($this->url);

      // definir prefixo
      $this->prefix = $parseUrl['path'] ?? '';
    }

    // método (genérico) responsável por adicionar uma rota na classe
    private function addRoute($method, $route, $params=[]){

      // validação dos parâmetros para
      foreach ($params as $key => $value) {
        if($value instanceof Closure){
          $params['controller'] = $value;
          unset($params[$key]);
          continue;
        }
      }

      // expressão regular responsável por criar um padrão de url
      $patternRoute = '/^'.str_replace('/', '\/', $route).'$/';

      // adiciona a rota dentro da classe
      $this->routes[$patternRoute][$method] = $params;
    }

    // método responsável por definir uma rota do tipo GET
    public function get($route, $params = []) {
      return $this->addRoute('GET', $route, $params);
    }

    // método responsável por definir uma rota do tipo POST
    public function post($route, $params = []) {
      return $this->addRoute('POST', $route, $params);
    }

    // método responsável por definir uma rota do tipo PUT
    public function put($route, $params = []) {
      return $this->addRoute('PUT', $route, $params);
    }

    // método responsável por definir uma rota do tipo DELETE
    public function delete($route, $params = []) {
      return $this->addRoute('DELETE', $route, $params);
    }

    // método responsável por retornar a uri desconsiderando o prefixo
    private function getUri(){
      // obtem uri do objeto request 
      $uri = $this->request->getUri();

      // fatia a uri com o prefixo
      $explodeUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];

      // retorna a uri sem prefixo
      return end($explodeUri);
    }

    // método responsável por retornar os dados da rota atual
    private function getRoute(){
      // obtem uri do projeto
      $uri = $this->getUri();

      // validar método
      $httpMethod = $this->request->getHttpMethod();

      // validar as rotas
      foreach ($this->routes as $patternRoute => $methods) {

        // verifica se a uri bate com o padrão
        if(preg_match($patternRoute, $uri)){

          //verifica o método
          if($methods[$httpMethod]){

            // retorno dos parâmetros da rota
            return $methods[$httpMethod];
          }

          // método não permitido
          throw new Exception('Método não é permitido', 405);
        }
      }

      // url não encontrada
      throw new Exception('URL não encontrada', 404);
    }

    // método responsável por executar a rota atual
    public function run(){
      try {
        // obtem a rota atual
        $route = $this->getRoute();

        // verifica controlador
        if(!isset($route['controller'])){
          throw new Exception('Url não pôde ser processada',500);
        }

        // argumentos da função
        $args = [];

        // retorna execução da função
        return call_user_func_array($route['controller'], $args);

      } catch (Exception $e) {
        return new Response($e->getCode(), $e->getMessage());
      }
    }
  }
?>