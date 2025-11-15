<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema</title>
  <link rel="stylesheet" href="style.css/global.css">
  <link rel="stylesheet" href="style.css/index.css">
  <link rel="stylesheet" href="style.css/dashboard.css">
  <link rel="stylesheet" href="style.css/form.css">
</head>

<body>

  <div class="container">
    <div class="sidebar">
        <h1>Chamado de Serviço</h1>
        <div class="links">
            <a href="?page=dashboard"><i class="fas fa-tachometer-alt"></i>DashBoard</a>
            <a href="?page=form"><i class="fas fa-plus-circle"></i>Novo Chamado</a>
        </div>
    </div>

    <main class="main-content">
      <?php
      // Página padrão: dashboard
      $page = $_GET['page'] ?? 'dashboard';
      $file = "pages/$page.php";

      if (file_exists($file)) {
        include $file;
      } else {
        echo "<p>Página não encontrada 😕</p>";
      }
      ?>
    </main>
  </div>

</body>

</html>