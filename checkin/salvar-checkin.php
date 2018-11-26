<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . "/arquitetura/classes/cliente.php";
$cliente = new cliente();

include_once $_SERVER['DOCUMENT_ROOT'] . "/arquitetura/classes/quartos.php";

$qto = new quartos();

include_once $_SERVER['DOCUMENT_ROOT'] . "/arquitetura/classes/reservas.php";
$reserva = new reservas();




$cpf_cliente = $_POST['cpf'];
$data_entrada = $_POST['data_entrada'];
$data_saida = $_POST['data_saida'];
$quarto_escolhido = $_POST['quarto'];

$id_cliente = $cliente->buscaCPF($cpf_cliente);

if($id_cliente == false){

	echo "CPF Inválido";

} else{

	$endereco_cliente = $cliente->verificaEndereco($id_cliente);

	if($endereco_cliente == false){
		echo "Usuário não possui endereço";
	} else{

		$devedor = $cliente->verificaDevedor($id_cliente);

		if($devedor == NULL){
			
			$cliente->insereDevedor($id_cliente);

		} 


		if($devedor == 0){
			
		$date1=date_create($data_entrada);
		$date2=date_create($data_saida);

			if( ($date1 < $date2) == true ){
				
	
				$reserva->setDataentrada($data_entrada);
				$reserva->setQuarto($quarto_escolhido);
				$reserva->setCliente($id_cliente);
				$reserva->setDataPrevisaoSaida($data_saida);
	
				$reserva->insere();
				echo 1;
			} else{

				echo "A data que você está inserindo é menor do que a data de entrada";
			}

		
		} else if($devedor == 1){

			echo "Este cliente é caloteiro! E não pode alugar quartos!";

		}

	}

} // final if validação


?>