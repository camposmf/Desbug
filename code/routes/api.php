<?php 
  // incluí rotas padrões na API
  include __DIR__ . '/api/default.php';

  // incluí rota de Usuários
  include __DIR__ . '/api/users.php';

  // incluí rota de Medalhas
  include __DIR__ . '/api/medals.php';

  // incluí rota de Pontos
  include __DIR__ . '/api/points.php';
  
  // incluí rota de Categorias
  include __DIR__ . '/api/category.php';

  // incluí rota de Nível de Acesso
  include __DIR__ . '/api/accessLevel.php';

  // incluí rota de Tempo de Acesso
  include __DIR__ . '/api/activeTime.php';

  // incluí rota de Situação
  include __DIR__ . '/api/situation.php';

?>