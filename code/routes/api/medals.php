<?php 
    use \App\Http\Response;
    use \App\Controller\Api;

    // rota de listagem de medalhas
    $objRouter->get('/api/medals', [
        'middlewares' => [
            'api',
            'user-basic-auth'
        ],
        function($request){
            return new Response(200, Api\Medal::getMedals($request), 'application/json');
        }
    ]);

    // rota de filtrar medalha
    $objRouter->get('/api/medals/{id}', [
        'middlewares' => [
            'api',
            'user-basic-auth'
        ],
        function($request, $id){
            return new Response(200, Api\Medal::getMedal($request, $id), 'application/json');
        }
    ]);

    // rota de criação de medalha
    $objRouter->post('/api/medals', [
        'middlewares' => [
            'api',
            'user-basic-auth'
        ],
        function($request){
            return new Response(201, Api\Medal::setAddMedal($request), 'application/json');
        }
    ]);

    // rota de alteração de medalha
    $objRouter->put('/api/medals/{id}', [
        'middlewares' => [
            'api',
            'user-basic-auth'
        ],
        function($request, $id){
            return new Response(200, Api\Medal::setEditMedal($request, $id), 'application/json');
        }
    ]);

    // rota de remoção de medalho
    $objRouter->delete('/api/medals/{id}', [
        'middlewares' => [
            'api',
            'user-basic-auth'
        ],
        function($request, $id){
            return new Response(200, Api\Medal::setDeleteMedal($request, $id), 'application/json');
        }
    ]);
?>