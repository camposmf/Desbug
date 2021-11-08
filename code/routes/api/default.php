<?php 
    use \App\Http\Response;

    // rota raiz da api
    $objRouter->get('/api', [
        function($request){
            return new Response(200, 'Api é top!');
        }
    ])
?>