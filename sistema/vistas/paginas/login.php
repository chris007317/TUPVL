<body>
	<header class="header" id="header">
		<div class="nav-content" id="nav-content">
			<div class="contenedor1">
				<nav class="nav">
					<div class="logo-nav pd-top-5">
						<a href="<?php echo $ruta; ?>" class="logo"><img src="vistas/img/login/logo.svg"></a>
					</div>
					<div class="nenu" id="menu">
						<div class="menu-section">
							<ul class="menu-list" id="menu-list">
								<li class="menu-item"><a class="menu-link" href="<?php echo $ruta; ?>">Inicio</a></li>
								<li class="menu-item"><a class="menu-link" href="<?php echo $ruta.'inscripcion'; ?>">Inscripción</a></li>
								<li class="menu-item"><a class="menu-link" href="#">Politicas</a></li>
							</ul>
						</div>
						<div class="icon-section no-visible">
							<a href="#" class="social-l">
								<i class="fab fa-facebook-f"></i>
							</a>
							<a href="#" class="social-l">
								<i class="fab fa-twitter"></i>
							</a>
						</div>
					</div>
				</nav>
			</div>
		</div>
	</header>
	<main>
		<div class="contenedor cont-login">
			<div class="login-banner"></div>
			<div class="login">
				<div class="header-login">
					<img src="vistas/img/login/nombre.svg">
				</div>
				<div class="body-login">
					<form method="POST">
						<h3>Iniciar Sesión</h3>
						<div class="input-grupo-login">
							<input type="text" name="txtUsuarioPvl" placeholder="Ingrese usuario" autofocus>
							<div class="text-icono">
								<i class="fas fa-user"></i>
							</div>
						</div>
						<div class="input-grupo-login">
							<input type="password" name="txtContraPvl" placeholder="Ingrese contraseña">
							<div class="text-icono">
								<i class="fas fa-lock icon"></i>
							</div>
						</div>
						<div class="enlase">
							<a class="link-recuperar" href="">Recuperar contraseña</a>
						</div>
						<button type="submit" class="btn-login">Ingresar</button>
						<?php 
							$ingresar = new ControladorUsuario();
            				$ingresar->ctrIngresoUsuario();
						 ?>
					</form>
				</div>
			</div>
		</div>
	</main>
</body>