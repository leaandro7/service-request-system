<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" 
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema</title>
  <link rel="stylesheet" href="./assets/styles/global.css">
  <link rel="stylesheet" href="./assets/styles/index.css">
  <link rel="stylesheet" href="./assets/styles/dashboard.css">
  <link rel="stylesheet" href="./assets/styles/dashboard_adm.css">
  <link rel="stylesheet" href="./assets/styles/">
  <link rel="stylesheet" href="./assets/styles/form.css">
</head>

<body>

  <div class="container">
    <div class="sidebar">

      <!-- LOGO -->
      <div class="sidebar-header">
        <img src="./assets/images/logo-call-tech.png" alt="">
      </div>
    
        <div class="links">
            <a href="?page=dashboard"><i class="fas fa-table"></i> DashBoard</a>
            <a href="?page=dashboard_adm"><i class="fas fa-user-cog"></i> Administrador</a>
            <a href="?page=form"><i class="fas fa-clipboard-list"></i> Novo Chamado</a>
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
        echo "<p>Página não encontrada</p>";
      }
      ?>
    </main>
  </div>

  <style id="teste-start-btn">
</style>

</body>

</html>