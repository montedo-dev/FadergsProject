<?php
include_once ("classes/banco.php");

$banco = new banco();
$arquivo = "nome_arquivo.csv";

$arquivo_old ="old_nome_arquivo.csv";

$csv = array_map('str_getcsv', file($arquivo));

$dados_novos = array();
foreach ($csv as $row) {
	foreach ($row as $key => $value) {
		$dados_novos[] = explode(';', $value);
	}
	
	
}


if (file_exists('old_nome_arquivo.csv')){

//primeira inserção de arquivos no sistema
echo "Verificando Arquivos<br>";

$csv_old = array_map('str_getcsv', file($arquivo_old));	


 //SALVAR NOVOS DADOS

$diff = array_map('unserialize',
    array_diff(array_map('serialize', $dados_novos), array_map('serialize', $csv_old)));


foreach ($diff as $key_diff => $value_diff) {
	
	if(!$value_diff[0] == ""){

	$nome = $value_diff[1];
	$cpf = $value_diff[2];
	$endereco = $value_diff[3];
	$status = $value_diff[4];
	$id = $value_diff[0];	
	$stmt = $banco->prepare("UPDATE cliente set nome = :NOME, cpf = :CPF, endereco = :ENDERECO , status= :STATUS where id = :ID");

	$stmt->bindParam(":NOME", $nome);
	$stmt->bindParam(":CPF", $cpf);
	$stmt->bindParam(":ENDERECO", $endereco);
	$stmt->bindParam(":STATUS", $status);
	$stmt->bindParam(":ID", $id);


	$stmt->execute();

}


$fieldseparator = ";"; 
$lineseparator = "\n";

$affectedRows = $banco->exec("
    LOAD DATA LOCAL INFILE ".$banco->quote($arquivo)." INTO TABLE `cliente`
      FIELDS TERMINATED BY ".$banco->quote($fieldseparator)."
      LINES TERMINATED BY ".$banco->quote($lineseparator));

echo "Foram inserido $affectedRows cliente(s) ao banco e ao arquivo csv  .\n";


	//Arquivo já existe então da update nas diferenças e insert nos novos


$output = fopen("old_nome_arquivo.csv",'w') or die("Can't open php://output");

foreach($dados_novos as $product) {
	
	fputcsv($output, $product);
}

fclose ($output);




}

 

// FINAL ELE EXISTE
} else {


$fieldseparator = ";"; 
$lineseparator = "\n";

$affectedRows = $banco->exec("
    LOAD DATA LOCAL INFILE ".$banco->quote($arquivo)." INTO TABLE `cliente`
      FIELDS TERMINATED BY ".$banco->quote($fieldseparator)."
      LINES TERMINATED BY ".$banco->quote($lineseparator));

echo "Foram inserido $affectedRows cliente(s) ao banco e ao arquivo csv  .\n";


	//Arquivo já existe então da update nas diferenças e insert nos novos
	echo "ele não existe";

$output = fopen("old_nome_arquivo.csv",'w') or die("Can't open php://output");



foreach($dados_novos as $product) {
	
	fputcsv($output, $product);
}


fclose ($output);
}


function check_diff_multi($array1, $array2){
    $result = array();
    foreach($array1 as $key => $val) {
        if(isset($array2[$key])){
           if(is_array($val)  && is_array($array2[$key])){
                $result[$key] = check_diff_multi($val, $array2[$key]);
            }
        } else {
            $result[$key] = $val;
        }
    }

    return $result;
} 





?>

