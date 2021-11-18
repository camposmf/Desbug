<?php 
    use \App\Http\Response;
    use \App\Controller\Api;

    // rota de listagem de atividades
    $objRouter->get('/api/activities', [
        'middlewares' => [
            'api',
            'user-basic-auth'
        ],
        function($request){
            return new Response(200, Api\Activity::getActivities($request), 'application/json');
        }
    ]);
   
    // rota de consultar atividade
    $objRouter->get('/api/activities/{id}', [
        'middlewares' => [
            'api',
            'user-basic-auth'
        ],
        function($request, $id){
            return new Response(200, Api\Activity::getActivity($request, $id), 'application/json');
        }
    ]);

    // rota de cadastro de nova uma nova atividade
    $objRouter->post('/api/activities', [
        'middlewares' => [
            'api',
            'user-basic-auth'
        ],
        function($request){
            return new Response(201, Api\Activity::setAddActivity($request), 'application/json');
        }
    ]);

    // rota de alteração de uma atividade
    $objRouter->put('/api/activities/{id}', [
        'middlewares' => [
            'api',
            'user-basic-auth'
        ],
        function($request, $id){
            return new Response(200, Api\Activity::setEditActivity($request, $id), 'application/json');
        }
    ]);

    // rota de remoção de uma atividade
    $objRouter->delete('/api/activities/{id}', [
        'middlewares' => [
            'api',
            'user-basic-auth'
        ],
        function($request, $id){
            return new Response(200, Api\Activity::setDeleteActivity($request, $id), 'application/json');
        }
    ]);
?>