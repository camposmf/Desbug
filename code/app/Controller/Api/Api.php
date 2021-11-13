<?php 
    namespace App\Controller\Api;

    class Api{

        // método responsável por retornar os detalhes da API
        public static function getDetails($request){
            return [
                'nome'     =>  'API - Desbug',
                'versao'   =>  'v1.0.0',
                'email'    =>  'desbug-tech@gmail.com',
                'autores'  =>  'Beatriz Rubini, Jamile Sousa, Marcos Albuquerque e Victor Henrique'
            ];
        }

        // método responsável por retornar os detalhes da paginação
        protected static function getPagination($request, $objPagination){
            
            // obter os query queryParams
            $queryParams = $request->getQueryParams();

            // obter páginas
            $pages = $objPagination->getPages();

            // retorno dos dados do detalhes
            return[
                'currentPage' => isset($queryParams['page']) ? (int)$queryParams['page'] : 1,
                'maxPages'    => !empty($pages) ? count($pages) : 1
            ];
        }
    }
?>