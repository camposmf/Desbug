<?php
    namespace App\Http\Middleware;

    class Queue {

        // mapeamento de middlewares
        private static $map = [];

        // mapeamento de middlewares que serão carregados em todas as rotas
        private static $default = [];

        // fila de middlewares a ser executadas
        private $middlewares = [];

        // closure de execução do controller
        private $controller;

        // argumentos da função do controlador
        private $controllerArgs = [];

        // método responsável por construir a classe de fila de middlewares
        public function __construct($middlewares, $controller, $controllerArgs) {
            $this->middlewares    = array_merge(self::$default, $middlewares);
            $this->controller     = $controller;
            $this->controllerArgs = $controllerArgs;
        }

        // método responsável por definir o mapeamento de middlewares
        public static function setMap($map){
            self::$map = $map;
        }

        // método responsável por definir o mapeamento de middlewares padrões
        public static function setDefault($default){
            self::$default = $default;
        }

        // método responsável por executar o próximo nível da fila de middlewares
        public function next($request){

            // verifica se a fila está vazia
            if(empty($this->middlewares)) return call_user_func_array($this->controller, $this->controllerArgs);

            // tirar middlewares da fila (atender middleware atual)
            $middleware = array_shift($this->middlewares);

            // verifica se o middleware existe
            if(!isset(self::$map[$middleware])){
                throw new \Exception('Problemas ao processar o middleware da requisição', 500);
            }

            // chamando recursivamente o método next
            $queue = $this;
            $next  = function($request) use ($queue){
                return $queue->next($request);
            };

            // executa o middleware atual
            return (new self::$map[$middleware])->handle($request, $next);
        }
    }
?>