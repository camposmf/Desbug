<?php 
    namespace App\Controller\Api;

    use \App\Db\Pagination;
    use \App\Model\Entity\User as EntityUser;
    use \App\Model\Entity\Category as EntityCategory;
    use \App\Model\Entity\ChooseCategory as EntityChooseCategory;

    class Category extends Api {

        // método responsável por obter a renderização dos itens de categoria
        private static function getCategoriesItems($request, &$objPagination){
            // array de usuários
            $itens = [];

            // quantidade total de registros
            $totalCount = EntityCategory::getCategories(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

            // página atual
            $queryParams = $request->getQueryParams();
            $currentPage = $queryParams['page'] ?? 1;

            // instância da paginação
            $objPagination = new Pagination($totalCount, $currentPage, 5);

            // resultados da página
            $results = EntityCategory::getCategories(null, null, $objPagination->getLimit());

            // retornar valores
            while($objCategoryUser = $results->fetchObject(EntityCategory::class)){

                $itens[] = [
                    'id_categoria'   =>  (int)$objCategoryUser->id_categoria,
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

            // retornar categoria
            return [
                'id_categoria'   =>  (int)$objCategory->id_categoria,
                'ds_categoria'   =>  $objCategory->ds_categoria,
                'img_categoria'  =>  $objCategory->img_categoria
            ];
        }

        // // método responsável por validar os métodos obrigatórios da entidade
        private static function handleRequiredFields($postVars){

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

            // valida a duplicação de descrição da categoria
            $objCategoryDescription = EntityCategory::getCategoryByDescription($postVars['ds_categoria']);
            if($objCategoryDescription instanceof EntityCategory){
                throw new \Exception("Categoria '".$postVars['ds_categoria']."' já foi cadastrada.", 400);
            }

            // carregar os dados
            $objCategory = new EntityCategory();
            $objCategory->ds_categoria  =  $postVars['ds_categoria'];
            $objCategory->img_categoria =  $postVars['img_categoria'];
            
            // cadastrar dados no banco de dados
            $objCategory->insertNewCategory();

            // carregar dados para entidade ChooseCategory
            $objChooseCategory = new EntityChooseCategory();
            $objChooseCategory->id_usuario = $request->user->id_usuario;
            $objChooseCategory->id_categoria = $objCategory->id_categoria;

            // cadastrar valores no banco de dados da entidade ChooseCategory
            $objChooseCategory->insertNewChooseCategory();

            // retornar categoria
            return [
                'id_categoria'    =>  (int)$objCategory->id_categoria,
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

            // validar a duplicação de descrição da categoria
            $objCategoryDescription = EntityCategory::getCategoryByDescription($postVars['ds_categoria']);
            if($objCategoryDescription instanceof EntityCategory){
                throw new \Exception("Categoria '".$postVars['ds_categoria']."' já foi cadastrada.", 400);
            }

            // carregar os dados
            $objCategory->ds_categoria  =  $postVars['ds_categoria'];
            $objCategory->img_categoria =  $postVars['img_categoria'];

            // atualizar dados no banco de dados
            $objCategory->updateCategory();

            // carregar dados para entidade ChooseCategory
            $objChooseCategory = EntityChooseCategory::getChooseCategoryById($objCategory->id_categoria);
            $objChooseCategory->id_categoria = $objCategory->id_categoria;
            $objChooseCategory->id_usuario   = $request->user->id_usuario;

            // atualizar dados no banco de dados
            $objChooseCategory->updateChooseCategory();

            // retornar categoria
            return [
                'id_categoria'    =>  (int)$objCategory->id_categoria,
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

            // buscar escolha da categoria
            $objChooseCategory = EntityChooseCategory::getChooseCategoryById($objCategory->id_categoria);

            // validar escolha da categoria
            if(!$objChooseCategory instanceof EntityChooseCategory){
                throw new \Exception("Escolhada da categória '".$id."' não encontrada", 404);
            }

            // deleta dados no banco de dados
            $objCategory->deleteCategory();
            $objChooseCategory->deleteChooseCategory();

            // retornar o sucesso da exclusão
            return [
                'sucesso' => true
            ];

        }
    }
?>