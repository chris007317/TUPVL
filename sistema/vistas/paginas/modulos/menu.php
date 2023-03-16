<aside class="main-sidebar elevation-2 sidebar-light-indigo">
    <!-- Brand Logo -->
    <a href="inicio" class="brand-link">
      <img src="../sistema/vistas/img/icono.png" alt="Logo TuPVL" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light ml-2">Tu PVL</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition"><div class="os-resize-observer-host observed"><div class="os-resize-observer" style="left: 0px; right: auto;"></div></div><div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;"><div class="os-resize-observer"></div></div><div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 609px;"></div><div class="os-padding"><div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;"><div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <?php 
            if ($datosUsuario['fotoUsuario'] == '') {
              $imgUsuario = $rutaSistema.'vistas/img/usuarios/admin.png';
            }else{
              $imgUsuario = $rutaSistema.$datosUsuario['fotoUsuario']; 
            }
           ?>
          <img src="<?php echo $imgUsuario; ?>" class="img-circle elevation-2" alt="Imagen usuario">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $datosUsuario['apellidoPaternoPersona'].' '.$datosUsuario['apellidoMaternoPersona'].' '.substr($datosUsuario['nombrePersona'], 0, 1).'.';  ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="inicio" class="nav-link">
              <i class="fas fa-home nav-icon"></i>
              <p>Inicio</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="consultas" class="nav-link">
              <i class="fas fa-hand-paper nav-icon"></i>
              <p>Consultas</p>
            </a>
          </li>
          <?php if ($datosUsuario['idTipoUsuario'] != 4): ?>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="fas fa-boxes nav-icon"></i>
              <p>
                Gestión alimentos
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              
              
            <?php if ($datosUsuario['idTipoUsuario'] != 3 && $datosUsuario['idTipoUsuario'] != 4): ?>
              <li class="nav-item">
                <a href="alimentos" class="nav-link">
                  <i class="fas fa-glass-whiskey nav-icon"></i>
                  <p>Alimentos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="proveedores" class="nav-link">
                  <i class="fas fa-dolly nav-icon"></i>
                  <p>Proveedores</p>
                </a>
              </li>
            <?php endif ?>
              <li class="nav-item">
                <a href="entradas" class="nav-link">
                  <i class="fas fa-clipboard-check nav-icon"></i>
                  <p>Entradas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="almacen" class="nav-link">
                  <i class="fas fa-warehouse nav-icon"></i>
                  <p>Almacén</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="fas fa-tasks nav-icon"></i>
              <p>
                Gestión Comités
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="comites" class="nav-link">
                  <i class="fas fa-house-user nav-icon"></i>
                  <p>Comités</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="presidentes" class="nav-link">
                  <i class="fas fa-user-tie nav-icon"></i>
                  <p>Presidentes</p>
                </a>
              </li>
            </ul>
          </li>
          <?php endif ?>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="fas fa-folder-open nav-icon"></i>
              <p>
                Mesa de Partes
                <i class="right fas fa-angle-left"></i>
                <?php if ($totalPost > 0): ?>
                  <span class="right badge badge-info"><i class="fas fa-bell"></i></span>
                <?php endif ?>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="nuevo-postulante" class="nav-link">
                  <i class="fas fa-folder-plus nav-icon"></i>
                  <p>Registrar Postulante</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="postulantes" class="nav-link">
                  <i class="fas fa-users nav-icon"></i>
                  <p>Postulantes
                    <?php if ($totalPost > 0): ?>
                      <span  class="right badge badge-dark"><?php echo $totalPost; ?></span>                      
                    <?php endif ?>
                    <?php if ($nuevosPostuante['total'] > 0): ?>
                      <span class="right badge badge-info"><?php echo $nuevosPostuante['total']; ?></span>                      
                    <?php endif ?>
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="fas fa-child nav-icon"></i>
              <p>
                Beneficiarios
                <i class="right fas fa-angle-left"></i>
                <?php if ($benPorVencer > 0): ?>
                  <span class="right badge badge-danger"><i class="fas fa-bell"></i></span>
                <?php endif ?>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="nuevo-beneficiario" class="nav-link">
                  <i class="fas fa-plus-square nav-icon"></i>
                  <p>Registrar beneficiario</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="beneficiarios" class="nav-link">
                  <i class="fas fa-address-book nav-icon"></i>
                  <p>Beneficiarios
                    <?php if ($benPorVencer > 0): ?>
                      <span  class="right badge badge-danger"><?php echo $benPorVencer; ?></span>                      
                    <?php endif ?>
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="socios" class="nav-link">
                  <i class="fas fa-user-friends nav-icon"></i>
                  <p>Socios</p>
                </a>
              </li>
            </ul>
          </li>
          <?php if ($datosUsuario['idTipoUsuario'] != 4): ?>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="fas fa-people-carry nav-icon"></i>
                <p>
                  Salidas
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="nueva-entrega" class="nav-link">
                    <i class="fas fa-list-ol nav-icon"></i>
                    <p>Programar entregas</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="lista-entregas" class="nav-link">
                    <i class="fas fa-boxes nav-icon"></i>
                    <p>Lista entregas</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="entregar-productos" class="nav-link">
                    <i class="fas fa-truck-loading nav-icon"></i>
                    <p>Entregar productos</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="entregados" class="nav-link">
                    <i class="fas fa-check nav-icon"></i>
                    <p>Entregados</p>
                  </a>
                </li>
              </ul>
            </li>            
          <?php endif ?>

          <?php if ($datosUsuario['idTipoUsuario'] == 1): ?>
            <li class="nav-item">
              <a href="reportes" class="nav-link">
                <i class="fas fa-database nav-icon"></i>
                <p>Reportes</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="usuarios" class="nav-link">
                <i class="fas fa-user-circle nav-icon"></i>
                <p>Gestión usuarios</p>
              </a>
            </li>            
          <?php endif ?>
          <?php if ($datosUsuario['idTipoUsuario'] == 1 || $datosUsuario['idTipoUsuario'] == 2): ?>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="fas fa-toolbox nav-icon"></i>
                <p>
                  Configuración
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="municipalidad" class="nav-link">
                    <i class="fas fa-building nav-icon"></i>
                    <p>Municipalidad</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="requisitos" class="nav-link">
                    <i class="fas fa-clipboard-list nav-icon"></i>
                    <p>Requisitos</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="tipo-beneficiario" class="nav-link">
                    <i class="fas fa-id-badge nav-icon"></i>
                    <p>Tipo Beneficiaros</p>
                  </a>
                </li>
              </ul>
            </li>            
          <?php endif ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div></div></div><div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden"><div class="os-scrollbar-track"><div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div></div></div><div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden"><div class="os-scrollbar-track"><div class="os-scrollbar-handle" style="height: 42.5384%; transform: translate(0px, 0px);"></div></div></div><div class="os-scrollbar-corner"></div></div>
    <!-- /.sidebar -->
  </aside>