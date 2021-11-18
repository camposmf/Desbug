<?php 

    namespace App\Controller\Api;

    use \App\Model\Entity\User as EntityUser;
    use \App\Model\Entity\ActiveTime as EntityActiveTime;

    class ActiveTime extends Api{
        
        // método responsável por retornar o tempo de acesso do usuário através do id
        public static function getActiveTime($request, $id){

            // validar id da pontuação
            if(!is_numeric($id)){
                throw new \Exception("O id '".$id."' não é válido.", 400);
            }

            // buscar valor no banco de dados
            $objActiveTime = EntityActiveTime::getActiveTimeById($id);

            // validar se valor existe
            if(!$objActiveTime instanceof EntityActiveTime){
                throw new \Exception("Registro com código de identificação '".$id."' não foi encontrado.", 404);
            }

            // recuperar usuário da view
            $userResult = EntityUser::getUserById($objActiveTime->id_usuario);
            $objUser = EntityActiveTime::loadActiveTimeUserViewValues($userResult);

            // retornar valor para api
            return [
                'id_nivel_acesso' => (int)$objActiveTime->id_tempo,
                'usuario'         => $objUser,
                'dt_entrada'      => $objActiveTime->dt_entrada,
                'dt_saida'        => $objActiveTime->dt_saida
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

            // validar se a data de entrada está vázia
            if(!isset($postVars['dt_entrada'])){
                throw new \Exception("Data de entrada é um campo obrigatório", 400);
            }

            // validar se a data de entrada é válida
            if(!strtotime($postVars['dt_entrada'])){
                throw new \Exception("Valor da data de entrada '".$postVars['dt_entrada']."' não é válido.", 400);
            }

            // validar se data de saída é válida
            if(isset($postVars['dt_saida'])){
                if(!strtotime($postVars['dt_saida'])){
                    throw new \Exception("Valor da data de saída '".$postVars['dt_saida']."' não é válido.", 400);
                }
            }

            // retornar postvars
            return $postVars;
        }

        // método responsável por registrar o tempo ativo do usuário
        public static function setAddActiveTime($request){

            // buscar variáveis do post
            $postVars = $request->getPostVars();

            // validar campos obrigatórios
            self::handleRequiredFields($postVars);

            // buscar usuário pelo id
            $objUser = EntityUser::getUserById($postVars['id_usuario']);

            // validar se usuário existe
            if(!$objUser instanceof EntityUser){
                throw new \Exception("O usuário '".$postVars['id_usuario']."' não foi encontrada no banco de dados", 404);
            }

            // carregar dados
            $objActiveTime = new EntityActiveTime();
            $objActiveTime->id_usuario  = $postVars['id_usuario'];
            $objActiveTime->dt_entrada  = $postVars['dt_entrada'];
            $objActiveTime->dt_saida    = $postVars['dt_saida'] ?? null;

            // inserir registro no banco de dados
            $objActiveTime->insertNewActiveTime();

            // recuperar objeto do usuário
            $userResult = EntityUser::getUserById($objActiveTime->id_usuario);
            $objUser = EntityActiveTime::loadActiveTimeUserViewValues($userResult);

            // retornar registro cadatrado
            return [
                'id_nivel_acesso' => (int)$objActiveTime->id_tempo,
                'usuario'         => $objUser,
                'dt_entrada'      => $objActiveTime->dt_entrada,
                'dt_saida'        => $objActiveTime->dt_saida
            ];
        }

        // método responsável por atualizar o tempo ativo do usuário
        public static function setEditActiveTime($request, $id){

            // buscar variáveis do post
            $postVars = $request->getPostVars();

            // validar campos obrigatórios
            self::handleRequiredFields($postVars);

            // buscar registro pelo id
            $objActiveTime = EntityActiveTime::getActiveTimeById($id);

            // validar se registro existe
            if(!$objActiveTime instanceof EntityActiveTime){
                throw new \Exception("Registro com código id '".$id."' não encontrado", 404);
            }

            // buscar usuário pelo id
            $objUser = EntityUser::getUserById($postVars['id_usuario']);

            // validar se usuário existe
            if(!$objUser instanceof EntityUser){
                throw new \Exception("O usuário '".$postVars['id_usuario']."' não foi encontrada no banco de dados", 404);
            }

            // carregar dados
            $objActiveTime->id_usuario  = $postVars['id_usuario'];
            $objActiveTime->dt_entrada  = $postVars['dt_entrada'];
            $objActiveTime->dt_saida    = $postVars['dt_saida'] ?? null;

            // inserir registro no banco de dados
            $objActiveTime->updateActiveTime();

            // recuperar objeto do usuário
            $userResult = EntityUser::getUserById($objActiveTime->id_usuario);
            $objUser = EntityActiveTime::loadActiveTimeUserViewValues($userResult);

            // retornar registro cadatrado
            return [
                'id_nivel_acesso' => (int)$objActiveTime->id_tempo,
                'usuario'         => $objUser,
                'dt_entrada'      => $objActiveTime->dt_entrada,
                'dt_saida'        => $objActiveTime->dt_saida
            ];
        }

    }
?>