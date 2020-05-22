<?php 
	include "conexion.php";
?>
<?php 
	error_reporting(E_ALL ^ E_NOTICE);

	if($_REQUEST){//Si hay un envío de variable
		if(strtolower($_REQUEST["pasar"])=="b-nombre"){//Si se buscó por nombre
			$busqueda = strtolower($_REQUEST['nombre']);
			$conseguido = mysqli_query($conexion, "SELECT * FROM `juegos` WHERE nombre LIKE '%$busqueda%'") or die("Algo salió mal");		
			$cantidad = mysqli_query($conexion, "SELECT COUNT(*) FROM `juegos` WHERE nombre LIKE '%$busqueda%'") or die("Algo salió mal");
		}
		if(strtolower($_REQUEST["pasar"])=="b-consola"){//Si se buscó por consola
			$busqueda = strtolower($_REQUEST['consola']);
			$conseguido = mysqli_query($conexion, "SELECT * FROM `juegos` WHERE consola LIKE '%$busqueda%'") or die("Algo salió mal");		
			$cantidad = mysqli_query($conexion, "SELECT COUNT(*) FROM `juegos` WHERE consola LIKE '%$busqueda%'") or die("Algo salió mal");
		}
		if(strtolower($_REQUEST["pasar"])=="b-genero"){//Si se buscó por género
			$busqueda = strtolower($_REQUEST['genero']);
			$conseguido = mysqli_query($conexion, "SELECT * FROM `juegos` WHERE genero LIKE '%$busqueda%'") or die("Algo salió mal");		
			$cantidad = mysqli_query($conexion, "SELECT COUNT(*) FROM `juegos` WHERE genero LIKE '%$busqueda%'") or die("Algo salió mal");
		}
		if(strtolower($_REQUEST["prestados"])=="prestados"){//Si se buscó por prestados
			$conseguido = mysqli_query($conexion, "SELECT * FROM `juegos` WHERE estado = 1") or die("Algo salió mal");		
			$cantidad = mysqli_query($conexion, "SELECT COUNT(*) FROM `juegos` WHERE estado = 1") or die("Algo salió mal");
		}
		if(strtolower($_REQUEST["pasar"]))//Estableciendo cantidad de juegos
			$cant = mysqli_fetch_array( $cantidad);	

		if(($_REQUEST["editar"])){//Si se va a editar
			$busqueda = strtolower($_REQUEST['editar']);
			$conseguido = mysqli_query($conexion, "SELECT * FROM `juegos` WHERE nombre LIKE '%$busqueda%'") or die("Algo salió mal");
		}
		if($_REQUEST["accion"]){
			$busqueda = ($_REQUEST['accion']);
			$aconseguido = mysqli_query($conexion, "SELECT * FROM `juegos` WHERE nombre LIKE '$busqueda'") or die("Algo salió mal");
		}
		
	}	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Buscador de juegos</title>
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
</head>

<body>		
	<div class="padre">
		<header class="header">
			<div class="menu">
				<div class="logo"><a href="index.php">xxxHaythamxxx</a></div>
			</div>
		</header>

		<section class="section">
			<div class="articulos">
				<?php if(($_REQUEST["pasar"]) || ($_REQUEST["prestados"])){//Si se envió una búsqueda
					while($columna = mysqli_fetch_array( $conseguido)){

						if($columna["consola"]=="PSX")
							$tam=120;
						if($columna["consola"]=="PS2")
							$tam=174;
						if($columna["consola"]=="PS3")
							$tam=140;
						if($columna["consola"]=="Gamecube")
							$tam=174;
						if($columna["consola"]=="DS")
							$tam=120;
						if($columna["consola"]=="3DS")
							$tam=120;	
						if($columna["consola"]=="GBA")
							$tam=120;
						if(strtolower($columna["estado"])==0)
							$estado="Libre";
						else
							$estado="Prestado";
						if(strtolower($columna["estado"])==0)
							$accion="Prestar";
						else
							$accion="Regresar";

				?>
				<article class="articulo">
					<div style="background-image: url(iconos/<?php echo $columna["portada"] ?>.jpg);height: <?php echo $tam ?>px" class="imagen"></div>
					<div class="contenedor">
						<label class="titulo"><?php echo $columna["nombre"] ?></label>
						<label class="desc"><?php echo $columna["descripcion"] ?></label>
						<div class="d-prest">
							<label class="d-estado">Estado: </label><label class="estado"><?php echo $estado ?></label>
							<?php if($columna["estado"]==1){ ?>
							<label class="d-persona">Persona: </label><label class="persona"><?php echo $columna["persona"] ?></label>
							<?php } ?>
						</div>
						<div class="crud">
							<form class="f-accion" method="POST" action=""><!-- Prestar/Regresar -->								
								<input type="hidden" name="accion" value="<?php echo $columna["nombre"] ?>">
								<input type="submit" name="a-accion" value="<?php echo $accion ?>">
							</form>
							<form class="f-editar" method="POST"><!-- Editar -->
								<input type="hidden" name="editar" 
								value="<?php echo $columna["nombre"] ?>">							
								<input type="submit" name="" value="Editar">
							</form>
							<form class="f-eliminar" method="POST" action="eliminar.php"><!--Eliminar-->
								<input type="hidden" name="nombre" value="<?php echo $columna["nombre"] ?>">
								<input type="submit" name="eliminar" value="Eliminar">
							</form>
						</div>
					</div>
				</article>
				<?php }} ?>
				<?php if($_REQUEST["nuevo"]){ //Si es un juego nuevo?>

					<article class="articulo">
						<form class="agregar" method="POST" action="nuevo.php">
							<label class="o-color">Ingrese nombre: </label><input class="" type="text" name="nombre">
							<label class="o-color">Seleccione consola: </label>
							<select name="consola">
								<option></option>
								<?php while($columna = mysqli_fetch_array($cons)){ ?>
								<option><?php echo $columna["consola"]; ?></option>
								<?php } ?>
							</select>
							<label class="o-color">Seleccione género: </label>
							<select name="genero">
								<option></option>
								<?php while($columna = mysqli_fetch_array($gen)){ ?>
								<option><?php echo $columna["genero"]; ?></option>
								<?php } ?>
							</select>
							<label class="o-color">Ingrese descripción: </label><textarea type="text" name="descripcion"></textarea>
							<label class="o-color">Ingrese nombre de portada: </label><input class="" type="text" name="portada">
							<input type="submit" name="Procesar" value="Procesar">
						</form>
					</article>

				<?php } ?>
				<?php if($_REQUEST["editar"]){ //Si es un juego a editar
					//echo "Nombre: ". $columna["nombre"];
					$columna = mysqli_fetch_array( $conseguido);
					?>

					<article class="articulo">
						<form class="agregar" method="POST" action="editar.php">
							<input type="hidden" name="nombreoriginal" value="<?php echo $columna["nombre"] ?>">
							<label class="o-color">Ingrese nombre: </label>
							<input type="text" name="nombre" value="<?php echo $columna["nombre"] ?>">
							<label class="o-color">Ingrese consola: </label>
							<input type="text" name="consola" value="<?php echo $columna["consola"] ?>">
							<label class="o-color">Ingrese género: </label>
							<input type="text" name="genero" value="<?php echo $columna["genero"] ?>">
							<input type="hidden" name="estado" value="<?php echo $columna["estado"] ?>">
							<input type="hidden" name="persona" value="<?php echo $columna["persona"] ?>">
							<label class="o-color">Ingrese descripción: </label><textarea type="text" name="descripcion"><?php echo $columna["descripcion"] ?></textarea>
							<label class="o-color">Ingrese nombre de portada: </label><input class="" type="text" name="portada" value="<?php echo $columna["portada"] ?>">
							<input type="submit" name="Procesar" value="Editar">
						</form>
					</article>

				<?php } ?>
				<?php if($_REQUEST["accion"]){//Si se va a prestar o regresar 
					$columna = mysqli_fetch_array( $aconseguido);?>
					 
				
						<article class="articulo">
							<form class="agregar" method="POST" action="editar.php">
								<input type="hidden" name="nombreoriginal" value="<?php echo $columna["nombre"] ?>">
								<input type="hidden" name="nombre" value="<?php echo $columna["nombre"] ?>">
								<label class="titulo"><?php echo $columna["nombre"] ?></label>
								<input type="hidden" name="consola" value="<?php echo $columna["consola"] ?>">
								<input type="hidden" name="genero" value="<?php echo $columna["genero"] ?>">
								
								<?php if($columna["estado"]==0){ ?>
									<input type="hidden" name="estado" value=1>
									<label class="o-color">Ingrese nombre de la persona: </label>
									<input type="text" name="persona" value="<?php echo $columna["persona"] ?>" placeholder="Ingrese 	nombre">
								<?php }else{ ?>
									<label class="o-color">Está a punto de retornar el juego</label>
									<input type="hidden" name="estado" value=0>
									<input type="hidden" name="persona" value="<?php echo $columna["persona"] ?>">
								<?php } ?>
								<input type="hidden" name="descripcion" value="<?php echo $columna["descripcion"] ?>">
								<input type="hidden" name="portada" value="<?php echo $columna["portada"] ?>">
								<input type="submit" name="Prestar" value="Procesar">
							</form>
						</article>		

				
				


				<?php } ?>
			</div>

			<aside class="aside">
				<label class="titulo2">Búsqueda</label> <!-- Busqueda por nombre -->
				<form class="buscar" method="POST">
					<input type="text" name="nombre" placeholder="Ingrese titulo">
					<input type="hidden" name="pasar" value="b-nombre">
					<input type="submit" name="" value="Buscar">
				</form>
				<hr>
				<form class="buscar2" method="POST"> <!-- Busqueda por consola -->
					<select name="consola">
						<option></option>
						<?php while($columna = mysqli_fetch_array($consolas)){ ?>
						<option><?php echo $columna["consola"]; ?></option>
						<?php } ?>
					</select>
					<input type="hidden" name="pasar" value="b-consola">
					<input type="submit" name="" value="Buscar">
				</form>
				<hr>
				<form class="buscar3" method="POST"> <!-- Busqueda por genero -->
					<select name="genero">
						<option></option>
						<?php while($columna = mysqli_fetch_array($generos)){ ?>
						<option><?php echo $columna["genero"]; ?></option>
						<?php } ?>
					</select>
					<input type="hidden" name="pasar" value="b-genero">
					<input type="submit" name="" value="Buscar">
				</form>
				<hr>
				<div class="buscar4"> <!-- Crear nuevo juego -->
					<form method="POST" action="">					
						<input type="hidden" name="nuevo" value="nuevo">
						<input type="submit" name="" value="Nuevo">
					</form>					
					<form method="POST"> <!-- Busqueda por prestados -->
						<input type="hidden" name="prestados" value="prestados">
						<input type="submit" name="" value="Prestados">
					</form>					
				</div>
				<hr>
				<div class="cantidad">
					<?php if(($_REQUEST["pasar"])){ ?>
					<label class="l-cant">Cantidad: </label><label class="cant"><?php echo $cant[0] ?></label>
					<?php } ?>
				</div>
			</aside>
		</section>

		<footer class="footer">
			<nav class="pie"></nav>
		</footer>
	</div>

</body>

<?php mysqli_close($conexion); ?>
</html>