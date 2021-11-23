<?php 

    namespace App\Controller\Api;

    use \App\Model\Entity\User as EntityUser;
    use \App\Model\Entity\AccessLevel as EntityAccessLevel;

    class AccessLevel extends Api {

        // método responsável por retornar o nível de acesso do usuário através do id
        public static function getAccessLevel($request, $id){

            // validar id da pontuação
            if(!is_numeric($id)){
                throw new \Exception("O id '".$id."' não é válido.", 400);
            }

            // buscar valor no banco de dados
            $objAccessLevel = EntityAccessLevel::getAccessLevelById($id);

            // validar se valor existe
            if(!$objAccessLevel instanceof EntityAccessLevel){
                throw new \Exception("Nível de acesso '".$id."' não foi encontrada.", 404);
            }

            // recuperar objeto do usuário
            $objUser = EntityUser::loadUser($objAccessLevel->id_usuario);

            // retornar valor para api
            return [
                'id_nivel_acesso' => (int)$objAccessLevel->id_nivel_acesso,
                'tp_nivel_acesso' => $objAccessLevel->tp_nivel_acesso,
                'usuario'         => $objUser
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

            // validar valor para medalha
            if(!isset($postVars['tp_nivel_acesso'])){
                throw new \Exception("Tipo do nível de acesso é um campo obrigatório", 400);
            }

            // validar tamanho da string
            if(strlen($postVars['tp_nivel_acesso']) > 1 || strlen($postVars['tp_nivel_acesso']) <= 0){
                throw new \Exception("Tipo do nível de acesso deve conter 1 caracterer", 400);
            }

            // validar se valor é string
            if(!is_string($postVars['tp_nivel_acesso'])){
                throw new \Exception("Tipo de nível de acesso '".$postVars['tp_nivel_acesso']."' não é válido", 400);
            }

            return $postVars;
        }

        // método responsável por adicionar um nível de acesso ao usuário
        public static function setAddAccessLevel($request){

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
            $objAccessLevel = new EntityAccessLevel();
            $objAccessLevel->id_usuario      = $postVars['id_usuario'];
            $objAccessLevel->tp_nivel_acesso = $postVars['tp_nivel_acesso'];

            // inserir registro no banco de dados
            $objAccessLevel->insertNewAccessLevel();

            // recuperar objeto do usuário
            $objUser = EntityUser::loadUser($objAccessLevel->id_usuario);

            // retornar registro cadastrado
            return [
                'id_nivel_acesso' => (int)$objAccessLevel->id_nivel_acesso,
                'tp_nivel_acesso' => $objAccessLevel->tp_nivel_acesso,
                'usuario'         => $objUser
            ];
        }

        // método repsonsável por atualizar o nível de acesso do usuário
        public static function setEditAccessLevel($request, $id){

            // checar se paramêtro é numérico
            if(!is_numeric($id)){
                throw new \Exception("O id '".$id."' não é válido", 400);
            }

            // buscar variáveis do post
            $postVars = $request->getPostVars();

            // validar campos obrigatórios
            self::handleRequiredFields($postVars);            

            // buscar registro pelo id
            $objAccessLevel = EntityAccessLevel::getAccessLevelById($id);

            // validar se nível de acesso existe
            if(!$objAccessLevel instanceof EntityAccessLevel){
                throw new \Exception("Nível de acesso '".$id."' não encontrado", 404);
            }

            // buscar usuário pelo id
            $objUser = EntityUser::getUserById($postVars['id_usuario']);

            // validar se usuário existe
            if(!$objUser instanceof EntityUser){
                throw new \Exception("O usuário '".$postVars['id_usuario']."' não foi encontrada no banco de dados", 404);
            }

            // validar usuário
            if($objUser->id_usuario == $request->user->id_usuario){
                throw new \Exception("Não é possível editar '".$objUser->id_usuario."' por falta de permissão", 400);
            }

            // carregar dados
            $objAccessLevel->id_usuario      = $postVars['id_usuario'];
            $objAccessLevel->tp_nivel_acesso = $postVars['tp_nivel_acesso'];

            // inserir registro no banco de dados
            $objAccessLevel->updateAccessLevel();

            // recuperar objeto do usuário
            $objUser = EntityUser::loadUser($objAccessLevel->id_usuario);

            // retornar registro atualizado
            return [
                'id_nivel_acesso' => (int)$objAccessLevel->id_nivel_acesso,
                'tp_nivel_acesso' => $objAccessLevel->tp_nivel_acesso,
                'usuario'         => $objUser
            ];
        }
    }
?>