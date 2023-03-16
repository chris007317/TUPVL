<nav class="main-header navbar navbar-expand navbar-dark navbar-danger">
  
    <!-- Botón que colapsa el menú lateral -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a class="nav-link">Hola <?php echo $datosAdmin['nombre']; ?></a>
      </li>
    </ul>
    <!-- Notificaciones -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
          <i class="far fa-bell"></i>
          <span class="badge badge-danger navbar-badge">5</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">5 Notificaciones</span>
          <div class="dropdown-divider"></div>
          <a href="index.php?pagina=reservas&not=0" class="dropdown-item">
            <i class="far fa-calendar-alt mr-2 float-right"></i>
            <span class="badge badge-info">3 Reservas nuevas</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="index.php?pagina=reservas&not=0" class="dropdown-item">
            <i class="fas fa-user-check mr-2 float-right"></i>
            <span class="badge badge-info">2 Testimonios nuevos</span>
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