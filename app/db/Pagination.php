<?php 
  namespace App\Db;

  class Pagination {
    // número máximo de registros por páginas
    private $limit;

    // quantidade total de resultados do banco
    private $results;

    // quantidade de páginas
    private $pages;

    // página atual
    private $currentPage;

    // construtor da classe
    public function __construct($results, $currentPage = 1, $limit = 5) {
      $this->limit = $limit;
      $this->results = $results;
      $this->currentPage = (is_numeric($currentPage) and $currentPage > 0) ? $currentPage : 1;
      $this->calculate();
    }

    // método responsável por calcular a páginação
    public function calculate(){
      // calcula o total de página
      $this->pages = $this->results > 0 ? ceil($this->results / $this->limit) : 1;

      // verifica se a página atual não excede o número de página
      $this->currentPage = $this->currentPage <= $this->pages ? $this->currentPage : $this->pages;
    }

    // método responsável por retornar a claúsula limit do SQL
    public function getLimit(){
      $offset = ($this->limit * ($this->currentPage - 1));
      return $offset.','.$this->limit;
    }

    // método responsável por retornar as opções de páginas disponíveis
    public function getPages(){
      // não retornar páginas disponíveis
      if($this->pages == 1) return [];

      // páginas
      $paginas = [];

      for($i=1; $i<=$this->pages;$i++){
        $paginas[] = [
          'pagina' => $i,
          'atual'   => $i == $this->currentPage
        ];
      }

      return $paginas;
    }
  }
?>