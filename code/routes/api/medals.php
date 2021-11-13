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

    // rota de listagem de usuário
    $objRouter->get('/api/medals/{id}', [
        'middlewares' => [
            'api',
            'user-basic-auth'
        ],
        function($request, $id){
            return new Response(200, Api\Medal::getMedal($request, $id), 'application/json');
        }
    ]);


?>