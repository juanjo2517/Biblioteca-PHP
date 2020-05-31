<!DOCTYPE html>
<html lang="es">

<head>
	<title><?php echo COMPANY; ?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="icon" href="<?php echo SERVERURL; ?>views/assets/book/logo.png" type="image/x-icon">
	<link rel="stylesheet" href="<?php echo SERVERURL; ?>views/css/main.css">
	<?php include "./views/modulos/scripts.php"; ?>

</head>

<body>


	<?php
	$peticionAjax = false;
	require_once "./controllers/viewsController.php";

	$vt = new ViewsController();
	$vistasR = $vt->obtener_vistas_controller();

	if ($vistasR == "login" || $vistasR == "404") :

		if ($vistasR == "login") {
			require_once "./views/contenidos/login.view.php";
		} else {
			require_once "./views/contenidos/404.view.php";
		} else :


		session_start(["name" => 'BP']);

		require_once "./controllers/LoginController.php";

		$loginObj = new LoginController();

		if (!isset($_SESSION['token_BP']) || !isset($_SESSION['usuario_BP'])) {

			$loginObj->forzar_cierre_sesion_controller();
		}




	?>
		<!-- SideBar -->
		<?php include "./views/modulos/lateral.php"; ?>

		<!-- Content page-->
		<section class="full-box dashboard-contentPage">

			<!-- NavBar -->
			<?php include "./views/modulos/navBar.php"; ?>

			<!-- Content page -->
			<?php require_once $vistasR; ?>

		</section>


	<?php
		require "./views/modulos/logoutScript.php"; 

	endif; ?>

	<!--===== Scripts -->
	
	<script>
		$.material.init();
	</script>
</body>

</html>