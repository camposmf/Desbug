<?php 
    use \App\Http\Response;
    use \App\Controller\Api;

    // rota de listagem de usuários
    $objRouter->get('/api/medals', [
        'middlewares' => [
            'api',
            'user-basic-auth'
        ],
        function($request){
            return new Response(200, Api\Medal::getMedals($request), 'application/json');
        }
    ]);


?>