<?php 
    namespace App\Controller\Api;

    use \App\Db\Pagination;
    use \App\Model\Entity\User as EntityUser;
    use \App\Model\Entity\Category as EntityCategory;

    class Category extends Api {

        // método responsável por obter a renderização dos itens de categoria
        private static function getCategoriesItems($request, &$objPagination){
            // array de usuários
            $itens = [];

            // quantidade total de registros
            $quantidadeTotal = EntityCategory::getCategories(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

            // página atual
            $queryParams = $request->getQueryParams();
            $paginaAtual = $queryParams['page'] ?? 1;

            // instância da paginação
            $objPagination = new Pagination($quantidadeTotal, $paginaAtual, 5);

            // resultados da página
            $results = EntityCategory::getCategoryByView(null, null, $objPagination->getLimit());

            // retornar valores
            while($objCategoryUser = $results->fetchObject(EntityCategory::class)){

                // objeto com os valores do usuário
                $objUser = EntityCategory::loadCategoryViewValues($objCategoryUser);

                $itens[] = [
                    'id_categoria'   =>  (int)$objCategoryUser->id_categoria,
                    'users'          =>  $objUser,
                    'ds_categoria'   =>  $objCategoryUser->ds_categoria,
                    'img_categoria'  =>  $objCategoryUser->img_categoria
                ];
            }

            return $itens;
        }

        // método responsável por retornar os usuários cadastrados
        public static function getCategories($request){
            return [
                'categories' => self::getCategoriesItems($request, $objPagination),
                'pagination' => parent::getPagination($request, $objPagination)
            ];
        }

        // método responsável por retornar um único usuário atráves do id
        public static function getCategory($request, $id){

            // validar id do usuário
            if(!is_numeric($id)){
                throw new \Exception("O id '".$id."' não é válido.", 400);
            }

            // buscar categoria
            $objCategory = EntityCategory::getCategoryById($id);

            // valida se a categoria  existe
            if(!$objCategory instanceof EntityCategory){
                throw new \Exception('O usuário '.$id.' não foi encontrado.', 404);
            }

            // recuperar valor da view
            $selectViewResult = EntityCategory::getCategoryByView('id_usuario = '.$objCategory->id_usuario);
            $objCategoryUser  = $selectViewResult->fetchObject(EntityCategory::class);

            // carregar objeto do usuário com o id da tabela categoria
            $objUser = EntityCategory::loadCategoryViewValues($objCategoryUser);

            // retornar categoria
            return [
                'id_categoria'   =>  (int)$objCategory->id_categoria,
                'users'          =>  $objUser,
                'ds_categoria'   =>  $objCategory->ds_categoria,
                'img_categoria'  =>  $objCategory->img_categoria
            ];
        }

        // // método responsável por validar os métodos obrigatórios da entidade
        private static function handleRequiredFields($postVars){

             // validar id do usuário
            if(!isset($postVars['id_usuario'])){
                throw new \Exception('O campo Id do Usuário é obrigatório', 400);
            }

            if(!is_numeric($postVars['id_usuario'])){
                throw new \Exception('O campo Id do Usuário inválido', 400);
            }

            // validar campo descrição da categoria
            if(!isset($postVars['ds_categoria'])){
                throw new \Exception('O campo descrição da categória é obrigatório', 400);
            }
                  
            // validar campo imagem da categoria
            if(!isset($postVars['img_categoria'])){
                throw new \Exception('O campo imagem é obrigatório', 400);
            }
                  
            return $postVars;
        }

        // método responsável por cadastrar uma nova categoria
        public static function setAddCategory($request){

            // post vars
            $postVars = $request->getPostVars();

            // validar campos obrigatórios
            self::handleRequiredFields($postVars);

            // validar se o id do usuário existe
            $objUser = EntityUser::getUserById($postVars['id_usuario']);
            if(!$objUser instanceof EntityUser){
                throw new \Exception("Usuário '".$postVars['id_usuario']."' não encontrado.", 404);
            }

            // valida a duplicação de descrição da categoria
            $objCategoryDescription = EntityCategory::getCategoryByDescription($postVars['ds_categoria']);
            if($objCategoryDescription instanceof EntityCategory){
                throw new \Exception("Categoria '".$postVars['ds_categoria']."' já foi cadastrada.", 400);
            }

            // carregar os dados na user model
            $objCategory = new EntityCategory();
            $objCategory->id_usuario    =  $postVars['id_usuario'];
            $objCategory->ds_categoria  =  $postVars['ds_categoria'];
            $objCategory->img_categoria =  $postVars['img_categoria'];
            
            // cadastrar dados no banco de dados
            $objCategory->insertNewCategory();

            // recuperar valor da view
            $selectViewResult = EntityCategory::getCategoryByView('id_usuario = '.$objCategory->id_usuario);
            $objCategoryUser  = $selectViewResult->fetchObject(EntityCategory::class);

            // carregar objeto do usuário com o id da tabela categoria
            $objUser = EntityCategory::loadCategoryViewValues($objCategoryUser);

            // retornar usuário
            return [
                'id_categoria'    =>  (int)$objCategory->id_categoria,
                'users'           =>  $objUser,
                'ds_categoria'    =>  $objCategory->ds_categoria,
                'img_categoria'   =>  $objCategory->img_categoria,
            ];
        }

        // método responsável por atualizar uma categoria
        public static function setEditCategory($request, $id){

            // checar se paramêtro é numérico
            if(!is_numeric($id)){
                throw new \Exception("O id '".$id."' não é válido", 400);
            }

            // post vars
            $postVars = $request->getPostVars();

            // validar campos obrigatórios
            self::handleRequiredFields($postVars);

            // buscar categoria no banco de dados
            $objCategory = EntityCategory::getCategoryById($id);
            if(!$objCategory instanceof EntityCategory){
                throw new \Exception("Categoria '".$id."' não encontrada", 404);
            }

            // validar se o id do usuário existe
            $objUser = EntityUser::getUserById($postVars['id_usuario']);
            if(!$objUser instanceof EntityUser){
                throw new \Exception("Usuário '".$postVars['id_usuario']."' não encontrado.", 404);
            }

            // validar a duplicação de descrição da categoria
            $objCategoryDescription = EntityCategory::getCategoryByDescription($postVars['ds_categoria']);
            if($objCategoryDescription instanceof EntityCategory && $objCategoryDescription->id_usuario == $objUser->id_usuario){
                throw new \Exception("Categoria '".$postVars['ds_categoria']."' já foi cadastrada.", 400);
            }

            // carregar os dados na user model
            $objCategory->id_usuario    =  $postVars['id_usuario'];
            $objCategory->ds_categoria  =  $postVars['ds_categoria'];
            $objCategory->img_categoria =  $postVars['img_categoria'];
            
            // cadastrar dados no banco de dados
            $objCategory->updateCategory();

            // recuperar valor da view
            $selectViewResult = EntityCategory::getCategoryByView('id_usuario = '.$objCategory->id_usuario);
            $objCategoryUser  = $selectViewResult->fetchObject(EntityCategory::class);

            // carregar objeto do usuário com o id da tabela categoria
            $objUser = EntityCategory::loadCategoryViewValues($objCategoryUser);

            // retornar usuário
            return [
                'id_categoria'    =>  (int)$objCategory->id_categoria,
                'users'           =>  $objUser,
                'ds_categoria'    =>  $objCategory->ds_categoria,
                'img_categoria'   =>  $objCategory->img_categoria,
            ];
        }

        // método responsável por deletar um usuário
        public static function setDeleteCategory($request, $id){

            // checar se paramêtro é numérico
            if(!is_numeric($id)){
                throw new \Exception("O id '".$id."' não é válido", 400);
            }

            // buscar usuário no banco
            $objCategory = EntityCategory::getCategoryById($id);

            // valida a instância
            if(!$objCategory instanceof EntityCategory){
                throw new \Exception("Categória '".$id."' não encontrado", 404);
            }

            // deleta dados no banco de dados
            $objCategory->deleteCategory();

            // retornar o sucesso da exclusão
            return [
                'sucesso' => true
            ];

        }
    }
?>