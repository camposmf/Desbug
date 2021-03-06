<?php 
    namespace App\Controller\Api;

    use \App\Db\Pagination;
    use \App\Model\Entity\User as EntityUser;

    class User extends Api {

        // método responsável por obter a renderização dos itens de usuários
        private static function getUsersItems($request, &$objPagination){
            // array de usuários
            $itens = [];

            // quantidade total de registros
            $quantidadeTotal = EntityUser::getUsers(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

            // página atual
            $queryParams = $request->getQueryParams();
            $paginaAtual = $queryParams['page'] ?? 1;

            // instância da paginação
            $objPagination = new Pagination($quantidadeTotal, $paginaAtual, 5);

            // resultados da página
            $results = EntityUser::getUsers(null, 'id_usuario ASC', $objPagination->getLimit());

            // retornar valores
            while($objUser = $results->fetchObject(EntityUser::class)){
                $itens[] = [
                    'id_usuario'    =>  (int)$objUser->id_usuario,
                    'nm_nickname'   =>  $objUser->nm_nickname,
                    'nm_usuario'    =>  $objUser->nm_usuario,
                    'ds_email'      =>  $objUser->ds_email,
                    'dt_nascimento' =>  $objUser->dt_nascimento,
                    'img_usuario'   =>  $objUser->img_usuario
                ];
            }

            return $itens;
        }

        // método responsável por retornar os usuários cadastrados
        public static function getUsers($request){
            return [
                'users'      => self::getUsersItems($request, $objPagination),
                'pagination' => parent::getPagination($request, $objPagination)
            ];
        }

        // método responsável por retornar um único usuário atráves do id
        public static function getUser($request, $id){

            // validar id do usuário
            if(!is_numeric($id)){
                throw new \Exception("O id '".$id."' não é válido.", 400);
            }

            // buscar usuário
            $objUser = EntityUser::getUserById($id);

            // valida se o usuário existe
            if(!$objUser instanceof EntityUser){
                throw new \Exception('O usuário '.$id.' não foi encontrado.', 404);
            }

            // retornar usuário
            return [
                'id_usuario'    =>  (int)$objUser->id_usuario,
                'nm_nickname'   =>  $objUser->nm_nickname,
                'nm_usuario'    =>  $objUser->nm_usuario,
                'ds_email'      =>  $objUser->ds_email,
                'dt_nascimento' =>  $objUser->dt_nascimento,
                'img_usuario'   =>  $objUser->img_usuario
            ];
        }

        // método responsável por validar os métodos obrigatórios da entidade
        private static function handleRequiredFields($postVars){

            // validar campo nickname
            if(!isset($postVars['nm_nickname'])){
                throw new \Exception('O campo Nickname é obrigatório', 400);
            }

            // validar campo nome do usuário
            if(!isset($postVars['nm_usuario'])){
                throw new \Exception('O campo Nome do usuário é obrigatório', 400);
            }
                  
             // validar campo email
            if(!isset($postVars['ds_email'])){
                throw new \Exception('O campo Email é obrigatório', 400);
            }
                  
            // validar campo senha
            if(!isset($postVars['ds_senha'])){
                throw new \Exception('O campo Senha é obrigatório', 400);
            }
              
            // validar campo data de nascimento
            if(!isset($postVars['dt_nascimento'])){
                throw new \Exception('O campo Data de Nascimento é obrigatório', 400);
            }

            return $postVars;
        }

        // método responsável por cadastrar um novo usuário
        public static function setAddUser($request){

            // post vars
            $postVars = $request->getPostVars();

            // validar campos obrigatórios
            self::handleRequiredFields($postVars);

            // valida a duplicação de e-mail 
            $objUserEmail = EntityUser::getUserByEmail($postVars['ds_email']);
            if($objUserEmail instanceof EntityUser){
                throw new \Exception("O e-mail '".$postVars['ds_email']."' já está em uso.", 400);
            }

            // carregar os dados na user model
            $objUser = new EntityUser();
            $objUser->nm_nickname    =  $postVars['nm_nickname'];
            $objUser->nm_usuario     =  $postVars['nm_usuario'];
            $objUser->ds_email       =  $postVars['ds_email'];
            $objUser->dt_nascimento  =  $postVars['dt_nascimento'];
            $objUser->ds_senha       =  password_hash($postVars['ds_senha'], PASSWORD_DEFAULT);
            $objUser->img_usuario    =  isset($postVars['img_usuario']) ? $postVars['img_usuario'] : null;

            // cadastrar dados no banco de dados
            $objUser->insertNewUser();

            // retornar usuário
            return [
                'id_usuario'    =>  (int)$objUser->id_usuario,
                'nm_nickname'   =>  $objUser->nm_nickname,
                'nm_usuario'    =>  $objUser->nm_usuario,
                'ds_email'      =>  $objUser->ds_email,
                'dt_nascimento' =>  $objUser->dt_nascimento,
                'img_usuario'   =>  $objUser->img_usuario
            ];
        }

        // método responsável por atualizar um usuário
        public static function setEditUser($request, $id){

            // checar se paramêtro é numérico
            if(!is_numeric($id)){
                throw new \Exception("O id '".$id."' não é válido", 400);
            }

            // post vars
            $postVars = $request->getPostVars();

            // validar campos obrigatórios
            self::handleRequiredFields($postVars);

            // buscar usuário no banco
            $objUser = EntityUser::getUserById($id);

            // valida a instância
            if(!$objUser instanceof EntityUser){
                throw new \Exception("Usuário '".$id."' não encontrado", 404);
            }

            // valida a duplicação de e-mail 
            $objUserEmail = EntityUser::getUserByEmail($postVars['ds_email']);
            if($objUserEmail instanceof EntityUser && $objUserEmail->id_usuario != $objUser->id_usuario){
                throw new \Exception("O e-mail '".$postVars['ds_email']."' já está em uso.", 400);
            }

            // carregar os dados na user model
            $objUser->nm_nickname    =  $postVars['nm_nickname']   ?? $postVars['nm_nickname'];
            $objUser->nm_usuario     =  $postVars['nm_usuario']    ?? $postVars['nm_usuario'];
            $objUser->ds_email       =  $postVars['ds_email']      ?? $postVars['ds_email'];
            $objUser->dt_nascimento  =  $postVars['dt_nascimento'] ?? $postVars['dt_nascimento'];
            $objUser->img_usuario    =  isset($postVars['img_usuario']) ? $postVars['img_usuario'] : null;
            $objUser->ds_senha       =  isset($postVars['ds_senha']) ? password_hash($postVars['ds_senha'], PASSWORD_DEFAULT) : $postVars['ds_senha'];

            // atualiza dados no banco de dados
            $objUser->updateUser();

            // retornar usuário atualizado
            return [
                'id_usuario'    =>  (int)$id,
                'nm_nickname'   =>  $objUser->nm_nickname,
                'nm_usuario'    =>  $objUser->nm_usuario,
                'ds_email'      =>  $objUser->ds_email,
                'dt_nascimento' =>  $objUser->dt_nascimento,
                'img_usuario'   =>  $objUser->img_usuario
            ];
        }

        // método responsável por deletar um usuário
        public static function setDeleteUser($request, $id){

            // checar se paramêtro é numérico
            if(!is_numeric($id)){
                throw new \Exception("O id '".$id."' não é válido", 400);
            }

            // buscar usuário no banco
            $objUser = EntityUser::getUserById($id);

            // valida a instância
            if(!$objUser instanceof EntityUser){
                throw new \Exception("Usuário '".$id."' não encontrado", 404);
            }

            // impede a exlusão de outros usuários
            if($objUser->id_usuario != $request->user->id_usuario){
                throw new \Exception("Não é possível excluir outros usuários", 400);
            }

            // deleta dados no banco de dados
            $objUser->deleteUser();

            // retornar o sucesso da exclusão
            return [
                'sucesso' => true
            ];
        }
    }
?>