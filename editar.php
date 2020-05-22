<?php  
include "conexion.php";

$nombreoriginal = $_REQUEST["nombreoriginal"];
$nombre = $_REQUEST["nombre"];
$consola = $_REQUEST["consola"];
$genero = $_REQUEST["genero"];
$estado = $_REQUEST["estado"];
$persona = $_REQUEST["persona"];
$descripcion = $_REQUEST["descripcion"];
$portada = $_REQUEST["portada"];

/*echo "nombreoriginal: ".$_REQUEST["nombreoriginal"];
echo "nombre: ".$_REQUEST["nombre"];
echo "consola: ".$_REQUEST["consola"];
echo "genero: ".$_REQUEST["genero"];
echo "estado: ".$_REQUEST["estado"];
echo "persona: ".$_REQUEST["persona"];
echo "descripcion: ".$_REQUEST["descripcion"];
echo "portada: ".$_REQUEST["portada"];*/

$conseguido = mysqli_query($conexion, "UPDATE juegos SET 
			nombre='$nombre',
			consola='$consola',
			genero='$genero',
			estado=$estado,
			persona='$persona',
			descripcion='$descripcion',
			portada='$portada' 
			WHERE nombre LIKE '$nombreoriginal'") or die("Algo salió mal");

header("Location: index.php");

mysqli_close($conexion);
?>