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
            $quantidadeTotal = EntityMedal::getMedals(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

            // página atual
            $queryParams = $request->getQueryParams();
            $paginaAtual = $queryParams['page'] ?? 1;

            // intância da paginação
            $objPagination = new Pagination($quantidadeTotal, $paginaAtual, 5);

            // resultados da api
            $results = EntityMedal::getMedals(null, 'id_medalha ASC', $objPagination->getLimit());

            // retornar resultado
            while($objMedal = $results->fetchObject(EntityMedal::class)){
                $itens[] = [
                    'id_medalha'        =>  (int)$objMedal->id_medalha,
                    'ds_medalha'        =>  $objMedal->ds_medalha,
                    'img_medalha'       =>  $objMedal->img_medalha,
                    'vl_medalha_total'  =>  $objMedal->vl_medalha_total
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

            // buscar medalha
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
                'vl_medalha_total'  => $objMedal->vl_medalha_total
            ];
        }

    }

?>