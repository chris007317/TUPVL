<?php 
  $totalPost = $totalPostulante['total']; 
  $benPorVencer = $porVencer['total']; 
  $totalNot = $benPorVencer + $nuevosPostuante['total'];
 ?>
<nav class="main-header navbar navbar-expand navbar-dark navbar-danger">
  
    <!-- Botón que colapsa el menú lateral -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a class="nav-link"><?php echo $datosUsuario['nombreMunicipalidad']; ?></a>
      </li>
    </ul>
    <!-- Notificaciones -->
    <?php if ($datosUsuario['idTipoUsuario'] == 1) {
        $tipoUsuario1 = 'RESPONSABLE';
      }else if($datosUsuario['idTipoUsuario'] == 2){
        $tipoUsuario1 = 'ADMINISTRADOR';
      }else if($datosUsuario['idTipoUsuario'] == 3){
        $tipoUsuario1 = 'ASISTENTE';
      }else if ($datosUsuario['idTipoUsuario']) {
        $tipoUsuario1 == 'PROMOTOR';
      }
     ?>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link"><?php echo $tipoUsuario1; ?></a>
      </li>
      <li class="nav-item dropdown">
        <?php if ($totalNot > 0): ?>
          <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
            <i class="far fa-bell"></i>
            <span class="badge badge-danger navbar-badge"><?php echo $totalNot; ?></span>
          </a>
          
        <?php else: ?>
          
        <?php endif ?>
          
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          
          <span class="dropdown-item dropdown-header"><?php echo $totalNot; ?> Notificaciones</span>
          <div class="dropdown-divider"></div>
          <a href="postulantes" class="dropdown-item">
            <i class="fas fa-user-plus mr-2 float-right"></i>
            <span class="badge badge-info"><?php echo $nuevosPostuante['total']; ?> Postulantes nuevos</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="beneficiarios" class="dropdown-item">
            <i class="fas fa-user-times mr-2 float-right"></i>
            <span class="badge badge-danger"><?php echo $benPorVencer; ?> Beneficiarios por vencer</span>
          </a>
      </li>
      <!-- Botón salir del sistema -->
      
      <li class="nav-item">
        <a class="nav-link" href="salir">
          <i class="fas fa-sign-out-alt"></i>
        </a>
      </li>
    </ul>
  </nav>