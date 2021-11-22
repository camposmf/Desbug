<?php 
    namespace App\Controller\Api;

    use \App\Db\Pagination;
    use \App\Model\Entity\Category as EntityCategory;
    use \App\Model\Entity\Activity as EntityActivity;
    use \App\Model\Entity\Situation as EntitySituation;

    class Activity extends Api {

        // método responsável por obter a renderização dos itens de usuários
        private static function getActivitiesItems($request, &$objPagination){
            // array de usuários
            $itens = [];

            // quantidade total de registros
            $totalCount = EntityActivity::getActivities(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

            // página atual
            $queryParams = $request->getQueryParams();
            $currentPage = $queryParams['page'] ?? 1;

            // instância da paginação
            $objPagination = new Pagination($totalCount, $currentPage, 5);

            // resultados da página
            $results = EntityActivity::getActivities(null, 'id_atividade ASC', $objPagination->getLimit());

            // retornar valores
            while($objActivity = $results->fetchObject(EntityActivity::class)){

                // recuperar categoria
                $objCategoryResult = EntityCategory::getCategoryById($objActivity->id_categoria);
                $objCategory = EntityActivity::loadCategory($objCategoryResult);

                // recuperar situacao
                $objSituationResult = EntitySituation::getSituationById($objActivity->id_situacao);
                $objSituation = EntityActivity::loadSituation($objSituationResult);

                $itens[] = [
                    'id_atividade'  =>  (int)$objActivity->id_atividade,
                    'categoria'     =>  $objCategory,
                    'situacao'      =>  $objSituation,
                    'img_atividade' =>  $objActivity->img_atividade,
                    'ds_atividade'  =>  $objActivity->ds_atividade
                ];
            }

            return $itens;
        }

        // método responsável por retornar os usuários cadastrados
        public static function getActivities($request){
            return [
                'activities' => self::getActivitiesItems($request, $objPagination),
                'pagination' => parent::getPagination($request, $objPagination)
            ];
        }

        // método responsável por retornar um único usuário atráves do id
        public static function getActivity($request, $id){

            // validar id da atividade
            if(!is_numeric($id)){
                throw new \Exception("O id '".$id."' não é válido.", 400);
            }

            // buscar atividade
            $objActivity = EntityActivity::getActivityById($id);

            // valida se atividade existe
            if(!$objActivity instanceof EntityActivity){
                throw new \Exception('A atividade '.$id.' não foi encontrado.', 404);
            }

            // recuperar categoria
            $objCategoryResult = EntityCategory::getCategoryById($objActivity->id_categoria);
            $objCategory = EntityActivity::loadCategory($objCategoryResult);

            // recuperar situacao
            $objSituationResult = EntitySituation::getSituationById($objActivity->id_situacao);
            $objSituation = EntityActivity::loadSituation($objSituationResult);

            // retornar atividade
            return [
                'id_atividade'  =>  (int)$objActivity->id_atividade,
                'categoria'     =>  $objCategory,
                'situacao'      =>  $objSituation,
                'img_atividade' =>  $objActivity->img_atividade,
                'ds_atividade'  =>  $objActivity->ds_atividade
            ];
        }

        // método responsável por validar os métodos obrigatórios da entidade
        private static function handleRequiredFields($postVars){

            // validar campo id categoria
            if(!isset($postVars['id_categoria'])){
                throw new \Exception('Id da categoria é um campo obrigatório', 400);
            }

            // validar se id categoria é númerico
            if(!is_numeric($postVars['id_categoria'])){
                throw new \Exception('Id da categoria "'.$postVars['id_categoria'].'" não é válido', 400);
            }

            // validar campo id situação
            if(!isset($postVars['id_situacao'])){
                throw new \Exception('Id da situação é um campo obrigatório', 400);
            }

            // validar se id situacao é númerico
            if(!is_numeric($postVars['id_situacao'])){
                throw new \Exception('Id da situação "'.$postVars['id_situacao'].'" não é válido', 400);
            }
                  
             // validar campo imagem da atividade
            if(!isset($postVars['img_atividade'])){
                throw new \Exception('Imagem da atividade é um campo obrigatório', 400);
            }
                  
            // validar campo descrição da atividade
            if(!isset($postVars['ds_atividade'])){
                throw new \Exception('Descrição da atividade é um campo obrigatório', 400);
            }
              
            return $postVars;
        }

        // método responsável por cadastrar uma nova atividade
        public static function setAddActivity($request){

            // post vars
            $postVars = $request->getPostVars();

            // validar campos obrigatórios
            self::handleRequiredFields($postVars);

            // validar se categoria existe
            $objCategoryResult = EntityCategory::getCategoryById($postVars['id_categoria']);
            if(!$objCategoryResult instanceof EntityCategory){
                throw new \Exception("Categoria '".$postVars['id_categoria']."' não foi encontrada.", 404);
            }

            // validar se situação existe
            $objSituationResult = EntitySituation::getSituationById($postVars['id_situacao']);
            if(!$objSituationResult instanceof EntitySituation){
                throw new \Exception("Situação '".$postVars['id_situacao']."' não foi encontrada.", 404);
            }

            // valida a duplicação da descrição
            $objActivityDescription = EntityActivity::getActivityByDescription($postVars['ds_atividade']);
            if($objActivityDescription instanceof EntityActivity){
                throw new \Exception("A descrição da atividade '".$postVars['ds_atividade']."' já existe no banco de dados.", 400);
            }

            // carregar os dados na user model
            $objActivity = new EntityActivity();
            $objActivity->id_categoria  =  $postVars['id_categoria'];
            $objActivity->id_situacao   =  $postVars['id_situacao'];
            $objActivity->img_atividade =  $postVars['img_atividade'];
            $objActivity->ds_atividade  =  $postVars['ds_atividade'];

            // cadastrar dados no banco de dados
            $objActivity->insertNewActivity();

            // recuperar categoria
            $objCategory = EntityActivity::loadCategory($objCategoryResult);

            // recuperar situacao
            $objSituation = EntityActivity::loadSituation($objSituationResult);

            // retornar atividade
            return [
                'id_atividade'  =>  (int)$objActivity->id_atividade,
                'categoria'     =>  $objCategory,
                'situacao'      =>  $objSituation,
                'img_atividade' =>  $objActivity->img_atividade,
                'ds_atividade'  =>  $objActivity->ds_atividade
            ];
        }

        // método responsável por atualizar uma atividade
        public static function setEditActivity($request, $id){

            // checar se paramêtro é numérico
            if(!is_numeric($id)){
                throw new \Exception("O id '".$id."' não é válido", 400);
            }

            // post vars
            $postVars = $request->getPostVars();

            // validar campos obrigatórios
            self::handleRequiredFields($postVars);

            // validar se atividade existe
            $objActivity = EntityActivity::getActivityById($id);
            if(!$objActivity instanceof EntityActivity){
                throw new \Exception("Atividade '".$id."' não foi encontrada.", 404);
            }

            // validar se categoria existe
            $objCategoryResult = EntityCategory::getCategoryById($postVars['id_categoria']);
            if(!$objCategoryResult instanceof EntityCategory){
                throw new \Exception("Categoria '".$postVars['id_categoria']."' não foi encontrada.", 404);
            }

            // validar se situação existe
            $objSituationResult = EntitySituation::getSituationById($postVars['id_situacao']);
            if(!$objSituationResult instanceof EntitySituation){
                throw new \Exception("Situação '".$postVars['id_situacao']."' não foi encontrada.", 404);
            }

            // carregar os dados na user model
            $objActivity->id_categoria  =  $postVars['id_categoria'];
            $objActivity->id_situacao   =  $postVars['id_situacao'];
            $objActivity->img_atividade =  $postVars['img_atividade'];
            $objActivity->ds_atividade  =  $postVars['ds_atividade'];

            // cadastrar dados no banco de dados
            $objActivity->updateActivity();

            // recuperar categoria
            $objCategory = EntityActivity::loadCategory($objCategoryResult);

            // recuperar situacao
            $objSituation = EntityActivity::loadSituation($objSituationResult);

            // retornar atividade
            return [
                'id_atividade'  =>  (int)$objActivity->id_atividade,
                'categoria'     =>  $objCategory,
                'situacao'      =>  $objSituation,
                'img_atividade' =>  $objActivity->img_atividade,
                'ds_atividade'  =>  $objActivity->ds_atividade
            ];
        }

        // método responsável por deletar uma atividade
        public static function setDeleteActivity($request, $id){

            // checar se paramêtro é numérico
            if(!is_numeric($id)){
                throw new \Exception("O id '".$id."' não é válido", 400);
            }

            // buscar uma atividade no banco
            $objActivity = EntityActivity::getActivityById($id);

            // valida a instância
            if(!$objActivity instanceof EntityActivity){
                throw new \Exception("Atividade '".$id."' não encontrado", 404);
            }

            // deleta dados no banco de dados
            $objActivity->deleteActivity();

            // retornar o sucesso da exclusão
            return [
                'sucesso' => true
            ];
        }
    }
?>