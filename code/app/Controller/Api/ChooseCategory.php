<?php 
    namespace App\Controller\Api;

    use \App\Db\Pagination;
    use \App\Model\Entity\User as EntityUser;
    use \App\Model\Entity\Category as EntityCategory;
    use \App\Model\Entity\ChooseCategory as EntityChooseCategory;

    class ChooseCategory extends Api {

        // método responsável por obter a renderização dos itens de categoria
        private static function getChooseCategoriesItems($request, &$objPagination){
            // array de usuários
            $itens = [];
        
            // quantidade total de registros
            $totalCount = EntityChooseCategory::getChooseCategories(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;
        
            // página atual
            $queryParams = $request->getQueryParams();
            $currentPage = $queryParams['page'] ?? 1;
        
            // instância da paginação
            $objPagination = new Pagination($totalCount, $currentPage, 5);
        
            // resultados da página
            $results = EntityChooseCategory::getChooseCategories(null, null, $objPagination->getLimit());
        
            // popular array
            while($objChooseCategory = $results->fetchObject(EntityChooseCategory::class)){
        
                // buscar objetos
                $objUser = EntityUser::loadUser($objChooseCategory->id_usuario);
                $objCategory = EntityCategory::loadCategory($objChooseCategory->id_categoria);

                $itens[] = [
                    'id_escolhe_categoria' => (int)$objChooseCategory->id_escolhe_categoria,
                    'usuario'              => $objUser,
                    'categoria'            => $objCategory,
                ];
            }
            
            // retornar valores
            return $itens;
        }
        
        // método responsável por retornar as escolhas de categorias cadastradas
        public static function getChooseCategories($request){
            return [
                'choose-categories' => self::getChooseCategoriesItems($request, $objPagination),
                'pagination' => parent::getPagination($request, $objPagination)
            ];
        }
        
        // método responsável por retornar um único usuário atráves do id
        public static function getChooseCategory($request, $id){

            // validar id do usuário
            if(!is_numeric($id)){
                throw new \Exception("O id '".$id."' não é válido.", 400);
            }

            // buscar categoria
            $objChooseCategory = EntityChooseCategory::getChooseCategory($id);

            // valida se a categoria  existe
            if(!$objChooseCategory instanceof EntityChooseCategory){
                throw new \Exception("A escolha de categoria '".$id."' não foi encontrado.", 404);
            }

            // buscar objetos
            $objUser = EntityUser::loadUser($objChooseCategory->id_usuario);
            $objCategory = EntityCategory::loadCategory($objChooseCategory->id_categoria);

            // retornar categoria
            return [
                'id_escolhe_categoria' => (int)$objChooseCategory->id_escolhe_categoria,
                'usuario'              => $objUser,
                'categoria'            => $objCategory,
            ];
        }
    }
?>