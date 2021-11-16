<?php 

    namespace App\Model\Entity;
    use \App\Db\Database;

    class CategoryUser {

        // método responsável por carregador os dados da view
        public static function loadUserValues($objCategoryUser){
            $objUser = new User();
            $objUser->id_usuario    =  (int)$objCategoryUser->id_usuario;
            $objUser->nm_nickname   =  $objCategoryUser->nm_nickname;
            $objUser->nm_usuario    =  $objCategoryUser->nm_usuario;
            $objUser->ds_email      =  $objCategoryUser->ds_email;
            $objUser->dt_nascimento =  $objCategoryUser->dt_nascimento;
            $objUser->img_usuario   =  $objCategoryUser->img_usuario;
            unset($objUser->ds_senha);

            return $objUser;
        }

        // método responsável por listar os registros do banco de dados
        public static function getCategoryUsers($where = null, $order = null, $limit = null, $fields = '*'){
            return (new Database('vw_categoria'))->select($where, $order, $limit, $fields);
        }

    }
?>