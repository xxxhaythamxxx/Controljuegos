<?php  
include "conexion.php";

$nombre = $_REQUEST["nombre"];
$consola = $_REQUEST["consola"];
$genero = $_REQUEST["genero"];
$estado = 0;
$persona = "";
$descripcion = $_REQUEST["descripcion"];
$portada = $_REQUEST["portada"];

echo $nombre;
echo $consola;
echo $genero;
echo $estado;
echo $persona;
echo $descripcion;
echo $portada;

$conseguido = mysqli_query($conexion, "INSERT INTO juegos 
			(nombre,consola,genero,estado,persona,descripcion,portada) VALUES 
			('$nombre','$consola','$genero',$estado,'$persona','$descripcion','$portada')") or die("Algo salió mal");

header("Location: index.php");

mysqli_close($conexion);
?>