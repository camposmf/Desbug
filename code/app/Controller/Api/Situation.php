<?php 

    namespace App\Controller\Api;
    use \App\Model\Entity\Situation as EntitySituation;

    class Situation extends Api {

        // método responsável por retornar a situação através do id
        public static function getSituation($request, $id){

            // validar id da situação
            if(!is_numeric($id)){
                throw new \Exception("O id '".$id."' não é válido.", 400);
            }

            // buscar valor no banco de dados
            $objSituation = EntitySituation::getSituationById($id);

            // validar se valor existe
            if(!$objSituation instanceof EntitySituation){
                throw new \Exception("Situação com código '".$id."' não foi encontrada.", 404);
            }

            // retornar valor para api
            return [
                'id_situacao' => (int)$objSituation->id_situacao,
                'tp_situacao' => $objSituation->tp_situacao
            ];
        }

        // método responsável por validar os métodos obrigatórios da entidade
        private static function handleRequiredFields($postVars){

            // validar id do usuário
            if(!isset($postVars['tp_situacao'])){
                throw new \Exception("Tipo da situação é um campo obrigatório", 400);
            }

            // retornar variável
            return $postVars;
        }

        // método responsável por adicionar uma nova situação
        public static function setAddSituation($request){

            // buscar variáveis do post
            $postVars = $request->getPostVars();

            // validar campos obrigatórios
            self::handleRequiredFields($postVars);

            // buscar tipo da situação
            $objTypeSituation = EntitySituation::getSituationByType($postVars['tp_situacao']);

            // validar se tipo já existe
            if($objTypeSituation instanceof EntitySituation){
                throw new \Exception("Tipo da situação '".$postVars['tp_situacao']."' já existe.", 400);
            }

            // carregar dados
            $objSituation = new EntitySituation();
            $objSituation->tp_situacao = $postVars['tp_situacao'];

            // inserir registro no banco de dados
            $objSituation->insertNewSituation();

            // retornar registro cadastrado
            return [
                'id_situacao' => (int)$objSituation->id_situacao,
                'tp_situacao' => $objSituation->tp_situacao
            ];
        }

        // método repsonsável por atualizar uma situação
        public static function setEditSituation($request, $id){

            // checar se paramêtro é numérico
            if(!is_numeric($id)){
                throw new \Exception("O id '".$id."' não é válido", 400);
            }

            // buscar variáveis do post
            $postVars = $request->getPostVars();

            // validar campos obrigatórios
            self::handleRequiredFields($postVars);      

            // buscar registro pelo id
            $objSituation = EntitySituation::getSituationById($id);

            // validar se situação existe
            if(!$objSituation instanceof EntitySituation){
                throw new \Exception("Código da Situação '".$id."' não encontrado", 404);
            }

            // buscar tipo da situação
            $objTypeSituation = EntitySituation::getSituationByType($postVars['tp_situacao']);

            // validar se tipo já existe
            if($objTypeSituation instanceof EntitySituation){
                throw new \Exception("Tipo da situação '".$postVars['tp_situacao']."' já existe.", 400);
            }

            // carregar dados
            $objSituation->tp_situacao = $postVars['tp_situacao'];

            // inserir registro no banco de dados
            $objSituation->updateSituation();

            // retornar registro atualizado
            return [
                'id_situacao' => (int)$objSituation->id_situacao,
                'tp_situacao' => $objSituation->tp_situacao
            ];
        }
    }
?>