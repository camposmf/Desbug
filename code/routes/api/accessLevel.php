<?php 
    use \App\Http\Response;
    use \App\Controller\Api;

    // rota de filtro de nível de acesso
    $objRouter->get('/api/access-level/{id}', [
        'middlewares' => [
            'api',
            'user-basic-auth'
        ],
        function($request, $id){
            return new Response(200, Api\AccessLevel::getAccessLevel($request, $id), 'application/json');
        }
    ]);

    // rota para cadastrar nível de acesso
    $objRouter->post('/api/access-level', [
        'middlewares' => [
            'api',
            'user-basic-auth'
        ],
        function($request){
            return new Response(201, Api\AccessLevel::setAddAccessLevel($request), 'application/json');
        }
    ]);

    // rota para atualizar nível de acesso
    $objRouter->put('/api/access-level/{id}', [
        'middlewares' => [
            'api',
            'user-basic-auth'
        ],
        function($request, $id){
            return new Response(200, Api\AccessLevel::setEditAccessLevel($request, $id), 'application/json');
        }
    ]);
?>