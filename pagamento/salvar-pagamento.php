<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/arquitetura/classes/reservas.php";
$reserva = new reservas();

include_once $_SERVER['DOCUMENT_ROOT'] . "/arquitetura/classes/cliente.php";
$cliente = new cliente();



$status = $_POST['status'];
$id = $_GET['id'];



$reserva->buscar($id);


if($status == 1){
	$reserva->pagamento();
	echo 1;
}

?>