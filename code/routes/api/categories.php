<?php 
    use \App\Http\Response;
    use \App\Controller\Api;

    // rota de listagem de categorias
    $objRouter->get('/api/categories', [
        'middlewares' => [
            'api',
            'user-basic-auth'
        ],
        function($request){
            return new Response(200, Api\Category::getCategories($request), 'application/json');
        }
    ]);
   
    // rota de consultar categoria
    $objRouter->get('/api/categories/{id}', [
        'middlewares' => [
            'api',
            'user-basic-auth'
        ],
        function($request, $id){
            return new Response(200, Api\Category::getCategory($request, $id), 'application/json');
        }
    ]);

    // rota de cadastro de nova categoria
    $objRouter->post('/api/categories', [
        'middlewares' => [
            'api',
            'user-basic-auth'
        ],
        function($request){
            return new Response(201, Api\Category::setAddCategory($request), 'application/json');
        }
    ]);

    // rota de alteração de categoria
    $objRouter->put('/api/categories/{id}', [
        'middlewares' => [
            'api',
            'user-basic-auth'
        ],
        function($request, $id){
            return new Response(200, Api\Category::setEditCategory($request, $id), 'application/json');
        }
    ]);

    // rota de remoção de categoria
    $objRouter->delete('/api/categories/{id}', [
        'middlewares' => [
            'api',
            'user-basic-auth'
        ],
        function($request, $id){
            return new Response(200, Api\Category::setDeleteCategory($request, $id), 'application/json');
        }
    ]);
?>