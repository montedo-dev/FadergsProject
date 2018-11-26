<?php

require "header.php";

require_once "classes/reservas.php";

$reserva_view = new reservas();

?>





<div class="container" style="margin-top: 5%;">

 
  
  
    
	<div class="row">
		<div class="col-md-4">
			<center>
				<button type="button" class="btn btn-light" data-toggle="modal" data-target="#modal_check_in">Check In</button>
			</center>
			
		
			
		</div><!-- final col -->

  <div class="col-md-4">
      <center>
        <button onclick="window.location.href='sobre.php'" type="button" id="sobre" class="btn btn-light">Sobre</button>
      </center>
     
    </div>


		<div class="col-md-4">
			<center>
			<button type="button" id="btn_importar" class="btn btn-light">Importar dados</button>
			</center>
			
		</div><!-- final col -->
		
	</div><!-- final row -->
		
</div> <!--final container  -->





  <?php $table = $reserva_view->listar(); ?>

  <div class="row"> <!-- ROW TABLEA -->
    <div class="col-md-12 mt-4 responsive-table">

          <table id="table_carro" class="table table-dark">
             <thead>

              <tr>
                <th scope="col">ID</th>
                <th scope="col">Cliente</th>
                <th scope="col">Quarto</th>
                
                <th scope="col">Data Entrada</th>
                <th scope="col">Data Previsão saída</th>
                <th scope="col">Data saída</th>
                <th scope="col">Pagamento</th>
                <th scope="col">Valor total</th>
                <th scope="col">Status</th>            
                <th scope="col">Editar</th>
                <th scope="col">Check Out</th>

              </tr>
            </thead>

            <tbody>
              
              <?php 
                  $buffer = '';
              foreach ($table as $key => $value) {                
              
                  $buffer.= '<tr>';
                  $buffer.=' <td>'.$value['id_reserva'].' </td>';
                  $buffer.= '<td>'.$value['nome'].' </td>';
                  $buffer.= '<td>'.$value['quarto'].'</td>';	

                  $data_formatada_entrada = date('d/m/Y', strtotime($value['data_entrada']));
                  $buffer.= '<td>'.$data_formatada_entrada.'</td>';

                  $data_formatada_saida_p = date('d/m/Y', strtotime($value['data_previsao_saida']));
                  $buffer.= ' <td>'.$data_formatada_saida_p.'</td>';

                  if($value['data_saida'] == ""){
						$buffer.='<td></td>';
				} else{
					$data_formatada__saida = date('d/m/Y', strtotime($value['data_saida']));
                  $buffer.= '<td>'. $data_formatada__saida.'</td>';
				}


                  
                 

                  if($value['pago'] == 1 ){
                   $buffer.= ' <td style="color: green;"> Pago </td>';
                  } else if($value['pago'] == 0){
                    $buffer.= ' <td style="color: red;"> Não pago </td>';
                  }
                   $buffer.= '<td> R$ '.$value['valor'].'</td>';

                    if($value['finalizada'] == 1 ){
                    $buffer.= ' <td style="color: yellow;"> Finalizada</td>';
                    
                    $buffer.= '<td> <button disabled value="'.$value['id_reserva'].'" class="edt_reserva btn btn-success"> Editar </button> </td>';

                   if($value['pago'] == 1 )
                    $buffer.= '<td> <button disabled value="'.$value['id_reserva'].'" class="pagamento_class btn btn-primary"> Gerar Pagamento </button> </td>';
                    else
                        $buffer.= '<td> <button value="'.$value['id_reserva'].'" class="pagamento_class btn btn-primary"> Gerar Pagamento </button> </td>';

                  } else if($value['finalizada'] == 0){
                     $buffer.= ' <td style="color: green"> Ativa </td>';
                     $buffer.= '<td> <button value="'.$value['id_reserva'].'" class="edt_reserva btn btn-success"> Editar </button> </td>';
                     $buffer.= '<td> <button value="'.$value['id_reserva'].'" class="checkout btn btn-danger"> Check Out </button> </td>';
                  }
            
                  
                 
                  $buffer.= '</tr>';
                  
              }

              echo $buffer;

              ?>
            

             
            </tbody>

          </table>
    </div> <!-- FINAL DA COLUNA -->

  </div><!-- FINAL DA ROW -->
</div>





<!-- Modal -->
<div class="modal fade" id="modal_check_in" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Check in</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <?php require_once "checkin/checkin_modal.php" ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btn_check_in">Alugar</button>
      </div>
    </div>
  </div>
</div>





<!-- Modal -->
<div class="modal fade" id="modal_check_out" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Check out</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <?php require_once "checkout/checkout_modal.php" ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btn_check_out">Finalizar</button>
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="modal_pagamento" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Tela de pagamento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <?php require_once "pagamento/pagamento_modal.php" ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btn_pagamento">Finalizar</button>
      </div>
    </div>
  </div>
</div>





<script type="text/javascript">
	var valor = 0;

	$(document).ready(function(){
	
	$("#btn_check_in").click(function(){
		check_in();
	});

  $("#btn_check_out").click(function(){
    check_out();
  });


	   $(".checkout").click(function(){
     	 valor = $(this).val();    
          	$('#modal_check_out').modal('show');                    
                });
     
     $(".pagamento_class").click(function(){
       valor = $(this).val();    
            $('#modal_pagamento').modal('show');                    
                });
	   
   $("#gerar_pagamentoo").click(function(){
      window.open('pagamento/pagamento.php?id='+valor);
  });

    $("#btn_importar").click(function(){
      window.open('importar.php');
  });

   $("#btn_pagamento").click(function(){
      pagamento();
   });

   
function pagamento(){

  var SENDVALUE = {
        edt: 0,        
        status: $("#check_pagar").val()
      }

      $.ajax({
          type: "POST",
          url: "pagamento/salvar-pagamento.php?id="+valor,
          data: SENDVALUE,
          dataType: 'text',
          success: function(dados){
           
              if(dados == 1){                         
                alert("O pagamento foi contabilizado com sucesso!");           
                $('#modal_pagamento').modal('hide');
                $('#modal_pagamento').find("input,textarea,select").val('');
              location.reload(); 
            } else{
              alert(dados);
            }          
              
           }
            
        });

}

function check_in(){


var SENDVALUE = {
        edt: 0,        
        cpf: $("#cpf_cliente").val(),
        data_entrada: $("#data_entrada").val(),
        data_saida: $("#data_saida").val(),
        quarto: $("#quarto").val()
      }

      $.ajax({
          type: "POST",
          url: "checkin/salvar-checkin.php",
          data: SENDVALUE,
          dataType: 'text',
          success: function(dados){
           
            	if(dados == 1){                
             
                alert("check in feito com sucesso!");           
                $('#modal_check_out').modal('hide');
                $('#modal_check_out').find("input,textarea,select").val('');
              location.reload(); 
          	} else{
              alert(dados);
            }          
              
           }
            
        });
     }  //FINAL DA FUNLÇÃO



     function check_out(){


    var SENDVALUE = {
        edt: 0,        
        data_saida: $("#co_data_saida").val(),
        id: valor       
      }

      $.ajax({
          type: "POST",
          url: "checkout/salvar-checkout.php",
          data: SENDVALUE,
          dataType: 'text',
          success: function(dados){            
            if(dados == 1){  
               alert("check out feito com sucesso!");           
                $('#modal_check_in').modal('hide');
                $('#modal_check_in').find("input,textarea,select").val('');
              location.reload(); 
            } else{
              alert(dados);
            }          
              
           }
            
        });
     }  //FINAL DA FUNLÇÃO

	});

</script>










<?php
require "footer.php";

?>