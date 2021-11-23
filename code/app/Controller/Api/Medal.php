<?php 
    namespace App\Controller\Api;

    use \App\Db\Pagination;
    use \App\Model\Entity\Medal as EntityMedal;

    class Medal extends Api{

        // método responsável por obter a renderização dos itens das medalhas
        private static function getMedalsItems($request, &$objPagination){
            
            // array de medalhas
            $itens = [];

            // quantidade total de registros
            $totalCount = EntityMedal::getMedals(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

            // página atual
            $queryParams = $request->getQueryParams();
            $currentPage = $queryParams['page'] ?? 1;

            // intância da paginação
            $objPagination = new Pagination($totalCount, $currentPage, 5);

            // resultados da api
            $results = EntityMedal::getMedals(null, 'id_medalha ASC', $objPagination->getLimit());

            // retornar resultado
            while($objMedal = $results->fetchObject(EntityMedal::class)){
                $itens[] = [
                    'id_medalha'        =>  (int)$objMedal->id_medalha,
                    'ds_medalha'        =>  $objMedal->ds_medalha,
                    'img_medalha'       =>  $objMedal->img_medalha,
                    'vl_medalha_total'  =>  (float)$objMedal->vl_medalha_total
                ];
            }

            return $itens;
        }

        // método responsável por retornar os medalhas cadastradas
        public static function getMedals($request){
            return [
                'medals'     => self::getMedalsItems($request, $objPagination),
                'pagination' => parent::getPagination($request, $objPagination)
            ];
        }

        // método responsável por retornar uma única medalha atráves do id
        public static function getMedal($request, $id){

            // validar id do usuário
            if(!is_numeric($id)){
                throw new \Exception("O id '".$id."' não é válido.", 400);
            }

            // buscar medalha pelo id
            $objMedal = EntityMedal::getMedalById($id);

            // validar se a medalha existe
            if(!$objMedal instanceof EntityMedal){
                throw new \Exception("A medalha '".$id."' não foi encontrada.", 404);
            }
            
            // retornar medalha
            return [
                'id_medalha'        => (int)$objMedal->id_medalha,
                'ds_medalha'        => $objMedal->ds_medalha,
                'img_medalha'       => $objMedal->img_medalha,
                'vl_medalha_total'  => (float)$objMedal->vl_medalha_total
            ];
        }

        // método responsável por validar os métodos obrigatórios da entidade
        private static function handleRequiredFields($postVars){

            // validar descrição da medalha
            if(!isset($postVars['ds_medalha'])){
                throw new \Exception("Descrição da melhada é um campo obrigatório", 400);
            }

            // validar imagem da medalha
            if(!isset($postVars['img_medalha'])){
                throw new \Exception("Imagem da medalha é um campo obrigatório", 400);
            }

            // validar valor para medalha
            if(!isset($postVars['vl_medalha_total'])){
                throw new \Exception("Valor para medalha é um campo obrigatório", 400);
            }

            // validar tipo do valor da medalha
            if(!is_numeric($postVars['vl_medalha_total'])){
                throw new \Exception("Valor '".$postVars['vl_medalha_total']."' para medalha está inválido", 400);
            }

            return $postVars;
        }

        // método responsável por criar uma nova medalha
        public static function setAddMedal($request){

            // buscar variáveis do post
            $postVars = $request->getPostVars();

            // validar campos obrigatórios
            self::handleRequiredFields($postVars);

            // buscar medalha pelo nome no banco de dados
            $objMedal = EntityMedal::getMedalByName($postVars['ds_medalha']);

            // validar se nome da medalha já existe
            if($objMedal instanceof EntityMedal){
                throw new \Exception("A medalha '".$postVars['ds_medalha']."' já existe na base de dados", 400);
            }
            
            // carregar os dados
            $objMedal = new EntityMedal();
            $objMedal->ds_medalha       =   $postVars['ds_medalha'];
            $objMedal->img_medalha      =   $postVars['img_medalha'];
            $objMedal->vl_medalha_total =   $postVars['vl_medalha_total'];

            // chamar método de inserção no banco de dados
            $objMedal->insertNewMedal();

            // retornar os dados para api
            return [
                'id_medalha'        =>  (int)$objMedal->id_medalha,
                'ds_medalha'        =>  $objMedal->ds_medalha,
                'img_medalha'       =>  $objMedal->img_medalha,
                'vl_medalha_total'  =>  (float)$objMedal->vl_medalha_total
            ];
        }

        // método responsável por alterar os valores das medalhas
        public static function setEditMedal($request, $id){
            // checar se paramêtro é numérico
            if(!is_numeric($id)){
                throw new \Exception("O id '".$id."' não é válido", 400);
            }

            // post vars
            $postVars = $request->getPostVars();

            // validar campos obrigatórios
            self::handleRequiredFields($postVars);

            // buscar medalha pelo id no banco
            $objMedal = EntityMedal::getMedalById($id);

            // validar se medalha existe
            if(!$objMedal instanceof EntityMedal){
                throw new \Exception("A Medalha '".$id."' não encontrada", 404);
            }

            // buscar medalha pelo nome no banco
            $objMedalByName = EntityMedal::getMedalByName($postVars['ds_medalha']);

            // validar se nome já existe
            if($objMedalByName instanceof EntityMedal){
                throw new \Exception("A medalha '".$postVars['ds_medalha']."' já existe na base de dados", 400);
            }

            // carregar os dados
            $objMedal->ds_medalha       =   $postVars['ds_medalha'];
            $objMedal->img_medalha      =   $postVars['img_medalha'];
            $objMedal->vl_medalha_total =   $postVars['vl_medalha_total'];

            // atualiza dados no banco de dados
            $objMedal->updateMedal();

            // retornar os dados para api
            return [
                'id_medalha'        =>  (int)$objMedal->id_medalha,
                'ds_medalha'        =>  $objMedal->ds_medalha,
                'img_medalha'       =>  $objMedal->img_medalha,
                'vl_medalha_total'  =>  (float)$objMedal->vl_medalha_total
            ];
        }

        // método responsável por deletar medalhas
        public static function setDeleteMedal($request, $id){

            // checar se paramêtro é numérico
            if(!is_numeric($id)){
                throw new \Exception("O id '".$id."' não é válido", 400);
            }

            // buscar medalha no banco
            $objMedal = EntityMedal::getMedalById($id);

            // validar se medalha existe
            if(!$objMedal instanceof EntityMedal){
                throw new \Exception("A Medalha com id '".$id."' não foi encontrada", 404);
            }

            // deleta dados no banco de dados
            $objMedal->deleteMedal();

            // retornar o sucesso da exclusão
            return [
                'sucesso' => true
            ];

        }
    }
?>