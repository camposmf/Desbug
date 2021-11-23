<?php 
    use \App\Http\Response;
    use \App\Controller\Api;

    // rota de filtro de situação
    $objRouter->get('/api/situations/{id}', [
        'middlewares' => [
            'api',
            'user-basic-auth'
        ],
        function($request, $id){
            return new Response(200, Api\Situation::getSituation($request, $id), 'application/json');
        }
    ]);

    // rota para cadastrar situação
    $objRouter->post('/api/situations', [
        'middlewares' => [
            'api',
            'user-basic-auth'
        ],
        function($request){
            return new Response(201, Api\Situation::setAddSituation($request), 'application/json');
        }
    ]);

    // rota para atualizar situação
    $objRouter->put('/api/situations/{id}', [
        'middlewares' => [
            'api',
            'user-basic-auth'
        ],
        function($request, $id){
            return new Response(200, Api\Situation::setEditSituation($request, $id), 'application/json');
        }
    ]);
?>