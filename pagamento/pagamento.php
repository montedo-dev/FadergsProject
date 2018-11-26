    <!-- Declaração do formulário -->  
    
    <?php 
        include_once $_SERVER['DOCUMENT_ROOT'] . "/arquitetura/classes/cliente.php";
        $cliente = new cliente();
        
        include_once $_SERVER['DOCUMENT_ROOT'] . "/arquitetura/classes/quartos.php";
        
        $qto = new quartos();
        
        include_once $_SERVER['DOCUMENT_ROOT'] . "/arquitetura/classes/reservas.php";
        $reserva = new reservas();
                $id = $_GET['id'];

        $reserva->buscar($id);

        $nome = $cliente->buscaNome($reserva->getCliente());

        $valor = $reserva->getValor();

        $endereco = $cliente->verificaEndereco($reserva->getCliente());
     ?>


    <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_cart">
    <input type="hidden" name="upload" value="1">
    <INPUT TYPE="hidden" name="charset" value="utf-8">
    <input type="hidden" name="business" value="rafaelirumemontedo@hotmail.com">
    
    <input type="hidden" name="first_name" value="<?php echo $nome ?>">
    
    <input type="hidden" name="address1" value="<?php echo $endereco ?>">
    
    <input type="hidden" name="item_name_1" value="Diária Hotel">
    <input type="hidden" name="item_number_1" value="1">
    <input type="hidden" name="amount_1" value="<?php echo $valor ?>">
    <input type="hidden" name="quantity_1" value="1">
    

    <input type="hidden" name="currency_code" value="BRL">  


    <input type="image" name="submit"
      src="https://www.paypalobjects.com/pt_BR/i/btn/btn_buynow_LG.gif"
      alt="PayPal - The safer, easier way to pay online">

</form>

<script>
document.forms[0].submit();
</script>