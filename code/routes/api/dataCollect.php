<?php 
    use \App\Http\Response;
    use \App\Controller\Api;

    // rota de filtrar
    $objRouter->get('/api/data-collect/{id}', [
        'middlewares' => [
            'api',
            'user-basic-auth'
        ],
        function($request, $id){
            return new Response(200, Api\DataCollect::getDataCollect($request, $id), 'application/json');
        }
    ]);

    // rota de criação
    $objRouter->post('/api/data-collect', [
        'middlewares' => [
            'api',
            'user-basic-auth'
        ],
        function($request){
            return new Response(201, Api\DataCollect::setAddDataCollect($request), 'application/json');
        }
    ]);

    // rota de alteração
    $objRouter->put('/api/data-collect/{id}', [
        'middlewares' => [
            'api',
            'user-basic-auth'
        ],
        function($request, $id){
            return new Response(200, Api\DataCollect::setEditDataCollect($request, $id), 'application/json');
        }
    ]);
?>