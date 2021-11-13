<?php 
    namespace App\Controller\Api;

    use \App\Db\Pagination;
    use \App\Model\Entity\Medal as EntityModel;

    class Medal extends Api{

        // método responsável por obter a renderização dos itens das medalhas
        private static function getMedalsItems($request, &$objPagination){
            
            // array de medalhas
            $itens = [];

            // quantidade total de registros
            $quantidadeTotal = EntityModel::getMedals(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

            // página atual
            $queryParams = $request->getQueryParams();
            $paginaAtual = $queryParams['page'] ?? 1;

            // intância da paginação
            $objPagination = new Pagination($quantidadeTotal, $paginaAtual, 5);

            // resultados da api
            $results = EntityModel::getMedals(null, 'id_medalha ASC', $objPagination->getLimit());

            // retornar resultado
            while($objMedal = $results->fetchObject(EntityModel::class)){
                $itens[] = [
                    'id_medalha'        =>  (int)$objMedal->id_medalha,
                    'ds_medalha'        =>  $objMedal->ds_medalha,
                    'img_medalha'       =>  $objMedal->img_medalha,
                    'vl_medalha_total'  =>  $objMedal->vl_medalha_total
                ];
            }

            return $itens;
        }

        public static function getMedals($request){
            return [
                'medals'     => self::getMedalsItems($request, $objPagination),
                'pagination' => parent::getPagination($request, $objPagination)
            ];
        }

    }

?>