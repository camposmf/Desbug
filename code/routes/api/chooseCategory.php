<?php 
    use \App\Http\Response;
    use \App\Controller\Api;

    // rota de listar escolha de categorias
    $objRouter->get('/api/choose-categories', [
        'middlewares' => [
            'api',
            'user-basic-auth'
        ],
        function($request){
            return new Response(200, Api\ChooseCategory::getChooseCategories($request), 'application/json');
        }
    ]);

    // rota de consultar escolha de categorias
    $objRouter->get('/api/choose-categories/{id}', [
        'middlewares' => [
            'api',
            'user-basic-auth'
        ],
        function($request, $id){
            return new Response(200, Api\ChooseCategory::getChooseCategory($request, $id), 'application/json');
        }
    ]);
?>