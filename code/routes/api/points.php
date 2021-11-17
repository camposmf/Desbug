<?php 
    use \App\Http\Response;
    use \App\Controller\Api;

    // rota de filtro de pontos
    $objRouter->get('/api/points/{id}', [
        'middlewares' => [
            'api',
            'user-basic-auth'
        ],
        function($request, $id){
            return new Response(200, Api\Points::getPoint($request, $id), 'application/json');
        }
    ]);

    // rota para cadastrar novos pontos
    $objRouter->post('/api/points', [
        'middlewares' => [
            'api',
            'user-basic-auth'
        ],
        function($request){
            return new Response(201, Api\Points::setAddPoints($request), 'application/json');
        }
    ]);

    // rota para atualizar valores dos pontos
    $objRouter->put('/api/points/{id}', [
        'middlewares' => [
            'api',
            'user-basic-auth'
        ],
        function($request, $id){
            return new Response(200, Api\Points::setEditPoints($request, $id), 'application/json');
        }
    ]);
?>