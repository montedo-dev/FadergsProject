<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/arquitetura/classes/quartos.php";

$quarto = new quartos();

$quarto->listarQuarto();
?>

<form>
 
  <div class="form-group">
    <label for="cpf_cliente">CPF cliente</label>

    <input type="text" class="form-control" id="cpf_cliente" placeholder="Informe o CPF do cliente">
    
  </div>
  
  <div class="form-group">

    <label for="data_entrada">Data de entrada</label>
    <input type="date" class="form-control" id="data_entrada" placeholder="data_entrada">

  </div>
  
  
  <div class="form-group">

    <label for="data_saida">Data de saida</label>
    <input type="date" class="form-control" id="data_saida" placeholder="data_entrada" >

  </div>


  <div class="form-group">
  
    <label>Quartos livres: </label>

    <select class="form-control" id="quarto">
        <option selected disabled=""> Selecione o quarto </option>
         <?php
          $quartos = $quarto->listarQuarto();
           foreach ($quartos as $key => $value) {
             echo '<option value="'.$value['id'].'">'.$value['id'].'</option>';
           }
            ?>

    </select>   
  
  </div>
 
  

</form>