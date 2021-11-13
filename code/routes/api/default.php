<?php 
    use \App\Http\Response;
    use \App\Controller\Api;

    // rota raiz da api
    $objRouter->get('/api', [
        'middlewares' => [
            'api'
        ],
        function($request){
            return new Response(200, Api\Api::getDetails($request), 'application/json');
        }
    ]);
?>