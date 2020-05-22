<?php  
include "conexion.php";

$busqueda = $_REQUEST["nombre"];

$conseguido = mysqli_query($conexion, "DELETE from juegos where	nombre='$busqueda'") or die("Algo salió mal");

header("Location: index.php");

mysqli_close($conexion);
?>