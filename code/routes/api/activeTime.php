<?php 
    use \App\Http\Response;
    use \App\Controller\Api;

    // rota de filtro de tempo de acesso
    $objRouter->get('/api/active-time/{id}', [
        'middlewares' => [
            'api',
            'user-basic-auth'
        ],
        function($request, $id){
            return new Response(200, Api\ActiveTime::getActiveTime($request, $id), 'application/json');
        }
    ]);

    // rota para cadastrar tempo de acesso
    $objRouter->post('/api/active-time', [
        'middlewares' => [
            'api',
            'user-basic-auth'
        ],
        function($request){
            return new Response(201, Api\ActiveTime::setAddActiveTime($request), 'application/json');
        }
    ]);

    // rota para atualizar tempo de acesso
    $objRouter->put('/api/active-time/{id}', [
        'middlewares' => [
            'api',
            'user-basic-auth'
        ],
        function($request, $id){
            return new Response(200, Api\ActiveTime::setEditActiveTime($request, $id), 'application/json');
        }
    ]);
?>