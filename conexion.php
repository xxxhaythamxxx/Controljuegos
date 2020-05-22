<?php
	$usuario = "root";
	$contraseña = "";
	$servidor = "localhost";
	$basededatos = "Juegos";

	$conexion = mysqli_connect($servidor, $usuario, "") or die("No se ha podido conectar al servidor");

	$db = mysqli_select_db($conexion, $basededatos) or die("No se ha podido conectar a la base de datos");


	$consolas = mysqli_query($conexion, "SELECT DISTINCT consola FROM juegos") or die("Algo salió mal");
	$generos = mysqli_query($conexion, "SELECT DISTINCT genero FROM juegos") or die("Algo salió mal");

	$cons = mysqli_query($conexion, "SELECT DISTINCT consola FROM juegos") or die("Algo salió mal");
	$gen = mysqli_query($conexion, "SELECT DISTINCT genero FROM juegos") or die("Algo salió mal");


	/*mysqli_close($conexion);*/
?>