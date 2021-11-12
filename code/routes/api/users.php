<?php 
    use \App\Http\Response;
    use \App\Controller\Api;

    // rota de listagem de usuários
    $objRouter->get('/api/users', [
        'middlewares' => [
            'api'
        ],
        function($request){
            return new Response(200, Api\User::getUsers($request), 'application/json');
        }
    ]);

    // rota de consultar usuário
    $objRouter->get('/api/users/{id}', [
        'middlewares' => [
            'api'
        ],
        function($request, $id){
            return new Response(200, Api\User::getUser($request, $id), 'application/json');
        }
    ]);

    // rota de cadastro de novo usuário
    $objRouter->post('/api/users', [
        'middlewares' => [
            'api'
        ],
        function($request){
            return new Response(201, Api\User::setAddUser($request), 'application/json');
        }
    ]);

    // rota de alteração de usuário
    $objRouter->put('/api/users/{id}', [
        'middlewares' => [
            'api',
            'user-basic-auth'
        ],
        function($request, $id){
            return new Response(200, Api\User::setEditUser($request, $id), 'application/json');
        }
    ]);

    // rota de remoção de usuário
    $objRouter->delete('/api/users/{id}', [
        'middlewares' => [
            'api',
            'user-basic-auth'
        ],
        function($request, $id){
            return new Response(200, Api\User::setDeleteUser($request, $id), 'application/json');
        }
    ]);
?>