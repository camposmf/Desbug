<?php 

    namespace App\Controller\Api;
    use \App\Model\Entity\Activity as EntityActivity;
    use \App\Model\Entity\DataCollect as EntityDataCollect;

    class DataCollect extends Api {

        // método responsável por retornar a situação através do id
        public static function getDataCollect($request, $id){

            // validar id da situação
            if(!is_numeric($id)){
                throw new \Exception("O id '".$id."' não é válido.", 400);
            }

            // buscar valor no banco de dados
            $objDataCollect = EntityDataCollect::getDataCollectById($id);

            // validar se valor existe
            if(!$objDataCollect instanceof EntityDataCollect){
                throw new \Exception("Código '".$id."' não foi encontrada.", 404);
            }

            // recupeara objeto atividade
            $objActivityResult = EntityActivity::getActivityById($objDataCollect->id_atividade);
            $objActivity = EntityDataCollect::loadActivity($objActivityResult);

            // retornar valor para api
            return [
                'id_coleta_dado'     => (int)$objDataCollect->id_coleta_dado,
                'atividade'          => $objActivity,
                'vl_sentimento_ant'  => $objDataCollect->vl_sentimento_ant,
                'vl_sentimento_prox' => $objDataCollect->vl_sentimento_prox
            ];
        }

        // método responsável por validar os métodos obrigatórios da entidade
        private static function handleRequiredFields($postVars){

            // validar id da atividade
            if(!isset($postVars['id_atividade'])){
                throw new \Exception("Id da atividade é um campo obrigatório", 400);
            }

            // validar se id da atividade é númerico
            if(!is_numeric($postVars['id_atividade'])){
                throw new \Exception("Id da atividade '".$postVars['id_atividade']."' não é válido", 400);
            }

            // validar valor pré sentimento
            if(isset($postVars['vl_sentimento_ant'])){
                if(strlen($postVars['vl_sentimento_ant']) > 1 || strlen($postVars['vl_sentimento_ant']) <= 0){
                    throw new \Exception("Valor do pré-sentimento deve conter 1 caracterer", 400);
                }
            }

            // validar valor pós sentimento
            if(isset($postVars['vl_sentimento_prox'])){
                if(strlen($postVars['vl_sentimento_prox']) > 1 || strlen($postVars['vl_sentimento_prox']) <= 0){
                    throw new \Exception("Valor do pós-sentimento deve conter 1 caracterer", 400);
                }
            }

            // retornar variável
            return $postVars;
        }

        // método responsável por adicionar registro no banco de dados
        public static function setAddDataCollect($request){

            // buscar variáveis do post
            $postVars = $request->getPostVars();

            // validar campos obrigatórios
            self::handleRequiredFields($postVars);

            // buscar atividade
            $objActivity = EntityActivity::getActivityById($postVars['id_atividade']);

            // validar se atividade existe
            if(!$objActivity instanceof EntityActivity){
                throw new \Exception("Atividade '".$postVars['id_atividade']."' não foi encontrada.", 404);
            }

            // carregar dados
            $objDataCollect = new EntityDataCollect();
            $objDataCollect->id_atividade       = $postVars['id_atividade'];
            $objDataCollect->vl_sentimento_ant  = $postVars['vl_sentimento_ant'];
            $objDataCollect->vl_sentimento_prox = $postVars['vl_sentimento_prox'];

            // inserir registro no banco de dados
            $objDataCollect->insertNewDataCollect();

            // recupeara objeto atividade
            $objActivityResult = EntityActivity::getActivityById($objDataCollect->id_atividade);
            $objActivity = EntityDataCollect::loadActivity($objActivityResult);

            // retornar valor para api
            return [
                'id_coleta_dado'     => (int)$objDataCollect->id_coleta_dado,
                'atividade'          => $objActivity,
                'vl_sentimento_ant'  => $objDataCollect->vl_sentimento_ant,
                'vl_sentimento_prox' => $objDataCollect->vl_sentimento_prox
            ];
        }

        // método responsável por atualizar registro no banco de dados
        public static function setEditDataCollect($request, $id){

            // buscar variáveis do post
            $postVars = $request->getPostVars();

            // validar campos obrigatórios
            self::handleRequiredFields($postVars);

            // buscar DataCollect
            $objDataCollect = EntityDataCollect::getDataCollectById($id);

            // validar se DataCollect existe
            if(!$objDataCollect instanceof EntityDataCollect){
                throw new \Exception("Registro DataCollect '".$id."' não foi encontrada.", 404);
            }

            // buscar atividade
            $objActivity = EntityActivity::getActivityById($postVars['id_atividade']);

            // validar se atividade existe
            if(!$objActivity instanceof EntityActivity){
                throw new \Exception("Atividade '".$postVars['id_atividade']."' não foi encontrada.", 404);
            }

            // carregar dados
            $objDataCollect->id_atividade       = $postVars['id_atividade'];
            $objDataCollect->vl_sentimento_ant  = $postVars['vl_sentimento_ant'];
            $objDataCollect->vl_sentimento_prox = $postVars['vl_sentimento_prox'];

            // inserir registro no banco de dados
            $objDataCollect->updateDataCollect();

            // recupeara objeto atividade
            $objActivityResult = EntityActivity::getActivityById($objDataCollect->id_atividade);
            $objActivity = EntityDataCollect::loadActivity($objActivityResult);

            // retornar valor para api
            return [
                'id_coleta_dado'     => (int)$objDataCollect->id_coleta_dado,
                'atividade'          => $objActivity,
                'vl_sentimento_ant'  => $objDataCollect->vl_sentimento_ant,
                'vl_sentimento_prox' => $objDataCollect->vl_sentimento_prox
            ];
        }
    }
?>