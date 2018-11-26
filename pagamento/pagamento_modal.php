<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/arquitetura/classes/cliente.php";
$cliente = new cliente();

include_once $_SERVER['DOCUMENT_ROOT'] . "/arquitetura/classes/quartos.php";

$qto = new quartos();

include_once $_SERVER['DOCUMENT_ROOT'] . "/arquitetura/classes/reservas.php";
$reserva = new reservas();




?>

<form>

 <div class="form-group">


    <button class="btn btn-primary" id="gerar_pagamentoo"> Gerar pagamento </button>

  </div>


  <div class="form-check">
    <input type="checkbox" value="1" class="form-check-input" id="check_pagar">
    <label class="form-check-label" for="check_pagar">Valor pago</label>
  </div>

</form>