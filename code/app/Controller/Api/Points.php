<?php 
    namespace App\Controller\Api;

    use \App\Db\Pagination;
    use \App\Model\Entity\User as EntityUser;
    use \App\Model\Entity\Medal as EntityMedal;
    use \App\Model\Entity\Points as EntityPoints;

    class Points extends Api{

        // método responsável por retornar uma pontuação através do id
        public static function getPoint($request, $id){

            // validar id da pontuação
            if(!is_numeric($id)){
                throw new \Exception("O id '".$id."' não é válido.", 400);
            }

            // buscar pontuação
            $objPoint = EntityPoints::getPointsById($id);

            // validar se a medalha existe
            if(!$objPoint instanceof EntityPoints){
                throw new \Exception("A pontuação '".$id."' não foi encontrada.", 404);
            }
            
            // recuperar usuário da view
            $selectUserResult = EntityUser::getUserById($objPoint->id_usuario);
            $objUser = EntityPoints::loadPointsUserViewValues($selectUserResult);

            // recuperar medalhas da view
            $selectMedalResult = EntityPoints::getItemsById($objPoint->id_usuario);
            $objMedal = EntityPoints::loadPointsMedalViewValues($selectMedalResult);

            // retornar pontuação
            return [
                'id_pontuacao'  => (int)$objPoint->id_pontuacao,
                'usuario'       => $objUser,
                'medalha'       => $objMedal,
                'vl_pontuacao'  => (float)$objPoint->vl_pontuacao
            ];
        }

        // método responsável por validar os métodos obrigatórios da entidade
        private static function handleRequiredFields($postVars){

            // validar id do usuário
            if(!isset($postVars['id_usuario'])){
                throw new \Exception("Id do usuário é um campo obrigatório", 400);
            }

            // validar se id do usuário é númerico
            if(!is_numeric($postVars['id_usuario'])){
                throw new \Exception("Id do usuário '".$postVars['id_usuario']."' não é válido", 400);
            }

            // validar validar id da medalha
            if(!isset($postVars['id_medalha'])){
                throw new \Exception("Id da medalha é um campo obrigatório", 400);
            }

            // validar se id da meadalha é númerico
            if(!is_numeric($postVars['id_medalha'])){
                throw new \Exception("Id da medalha '".$postVars['id_medalha']."' não é válido", 400);
            }

            // validar valor para medalha
            if(!isset($postVars['vl_pontuacao'])){
                throw new \Exception("Valor da pontuação é um campo obrigatório", 400);
            }

            return $postVars;
        }

        // método responsável por criar uma nova Pontuação
        public static function setAddPoints($request){

            // buscar variáveis do post
            $postVars = $request->getPostVars();

            // validar campos obrigatórios
            self::handleRequiredFields($postVars);

            // validar se a medalha existe
            $objMedal = EntityMedal::getMedalById($postVars['id_medalha']);
            if(!$objMedal instanceof EntityMedal){
                throw new \Exception("A medalha '".$postVars['id_medalha']."' não foi encontrada no banco de dados", 404);
            }

            // validar se usuário existe
            $objUser = EntityUser::getUserById($postVars['id_usuario']);
            if(!$objUser instanceof EntityUser){
                throw new \Exception("O usuário '".$postVars['id_usuario']."' não foi encontrada no banco de dados", 404);
            }
            
            // carregar os dados
            $objPoint = new EntityPoints();
            $objPoint->id_medalha    =   $postVars['id_medalha'];
            $objPoint->id_usuario    =   $postVars['id_usuario'];
            $objPoint->vl_pontuacao  =   $postVars['vl_pontuacao'];

            // chamar método de inserção no banco de dados
            $objPoint->insertNewPoints();

            // recuperar usuário da view
            $selectUserResult = EntityUser::getUserById($objPoint->id_usuario);
            $objUser = EntityPoints::loadPointsUserViewValues($selectUserResult);

            // recuperar medalhas da view
            $selectMedalResult = EntityPoints::getItemsById($objPoint->id_usuario);
            $objMedal = EntityPoints::loadPointsMedalViewValues($selectMedalResult);

            // retornar pontuação
            return [
                'id_pontuacao'  => (int)$objPoint->id_pontuacao,
                'usuario'       => $objUser,
                'medalha'       => $objMedal,
                'vl_pontuacao'  => (float)$objPoint->vl_pontuacao
            ];
        }

        // método responsável por alterar os valores das medalhas
        public static function setEditPoints($request, $id){

            // checar se paramêtro é numérico
            if(!is_numeric($id)){
                throw new \Exception("O id '".$id."' não é válido", 400);
            }

            // buscar variáveis do post
            $postVars = $request->getPostVars();

            // validar campos obrigatórios
            self::handleRequiredFields($postVars);

            // validar se pontuação existe
            $objPoint = EntityPoints::getPointsById($id);
            if(!$objPoint instanceof EntityPoints){
                throw new \Exception("Pontuação '".$id."' não encontrada", 404);
            }

            // validar se a medalha existe
            $objMedal = EntityMedal::getMedalById($postVars['id_medalha']);
            if(!$objMedal instanceof EntityMedal){
                throw new \Exception("A medalha '".$postVars['id_medalha']."' não foi encontrada no banco de dados", 404);
            }

            // validar se usuário existe
            $objUser = EntityUser::getUserById($postVars['id_usuario']);
            if(!$objUser instanceof EntityUser){
                throw new \Exception("O usuário '".$postVars['id_usuario']."' não foi encontrada no banco de dados", 404);
            }
            
            // carregar os dados
            $objPoint->id_medalha    =   $postVars['id_medalha'];
            $objPoint->id_usuario    =   $postVars['id_usuario'];
            $objPoint->vl_pontuacao  =   $postVars['vl_pontuacao'];

            // chamar método de inserção no banco de dados
            $objPoint->updatePoints();

            // recuperar usuário da view
            $selectUserResult = EntityUser::getUserById($objPoint->id_usuario);
            $objUser = EntityPoints::loadPointsUserViewValues($selectUserResult);

            // recuperar medalhas da view
            $selectMedalResult = EntityPoints::getItemsById($objPoint->id_usuario);
            $objMedal = EntityPoints::loadPointsMedalViewValues($selectMedalResult);

            // retornar pontuação
            return [
                'id_pontuacao'  => (int)$objPoint->id_pontuacao,
                'usuario'       => $objUser,
                'medalha'       => $objMedal,
                'vl_pontuacao'  => (float)$objPoint->vl_pontuacao
            ];
        }
    }
?>