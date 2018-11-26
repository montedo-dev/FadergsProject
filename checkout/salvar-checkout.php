<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/arquitetura/classes/cliente.php";
$cliente = new cliente();

include_once $_SERVER['DOCUMENT_ROOT'] . "/arquitetura/classes/quartos.php";

$qto = new quartos();

include_once $_SERVER['DOCUMENT_ROOT'] . "/arquitetura/classes/reservas.php";
$reserva = new reservas();

		
		$reserva->buscar($_POST['id']);
		$data_entrada = $reserva->getDataEntrada();
		$data_saida = $_POST['data_saida'];
		

		if( ($data_saida > $data_entrada) == true ){
		


		$qto->buscar($reserva->getQuarto());
		
		$valor = $qto->getValor();
		
		$reserva->setDataSaida($data_saida);
		
		
		$data_entrada = date('Y-m-d', strtotime($data_entrada));	
		$data_saida = date('Y-m-d', strtotime($data_saida));
			
		$d1 = explode("-", $data_entrada);
		
		$d2 = explode("-", $data_saida);    		
    	$data1 = strtotime("$d1[2]-$d1[1]-$d1[0]"); 
		$data2 = strtotime("$d2[2]-$d2[1]-$d2[0]");	
		
		$dataFinal = ($data2 - $data1) /86400;
		$valor_diaria = $valor * $dataFinal;

		$reserva->setValor($valor_diaria);
		$reserva->setId($_POST['id']);
		

		$reserva->check_out();
		echo 1;
		
		
		} else{
			echo "Escolha uma data maior que a data de entrada";
		}	
		
?>