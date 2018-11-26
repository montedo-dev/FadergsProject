<?php
require_once ("banco.php");

class reservas {

    private $id; 
    private $quarto;
    private $cliente;  
    private $data_entrada;
    private $data_saida;
    private $valor;  
    private $data_previsao_saida;
    private $pago;
    private $banco;


    public function __construct(){

        $this->banco = new banco();
        
    }  
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getQuarto() {
        return $this->quarto;
    }

 
    public function setQuarto($quarto) {
        $this->quarto = $quarto;
    }


    public function getCliente() {
        return $this->cliente;
    }


    public function setCliente($cliente) {
        $this->cliente = $cliente;
    }

    public function getDataEntrada() {
        return $this->data_entrada;
    }

    public function setDataEntrada($dataEntrada) {
        $this->data_entrada = $dataEntrada;
    }

    public function getDataSaida() {
        return $this->data_saida;
    }

 
    public function setDataSaida($dataSaida) {
        $this->data_saida = $dataSaida;
    }


    public function getValor() {
        return $this->valor;
    }


    public function setValor($valor) {
        $this->valor = $valor;
    }


    public function getDataPrevisaoSaida() {
        return $this->data_previsao_saida;
    }


    public function setDataPrevisaoSaida($dataPrevisaoSaida) {
        $this->data_previsao_saida = $dataPrevisaoSaida;
    }

    public function getPago() {
        return $this->pago;
    }

    public function setPago($pago) {
        $this->pago = $pago;
    }



    public function insere(){
        $cliente = $this->getCliente();
        $quarto = $this->getQuarto();
        $data_saida = $this->getDataPrevisaoSaida();
        $data_entrada = $this->getDataEntrada();

        $stmt = $this->banco->prepare("INSERT INTO reservas (quarto,cliente,data_entrada,data_previsao_saida,finalizada) VALUES (:QUARTO,:CLIENTE,:DATA_ENTRADA,:DATA_SAIDA,0)");

        $stmt->bindParam(":QUARTO", $quarto);
        $stmt->bindParam(":CLIENTE", $cliente);
        $stmt->bindParam(":DATA_ENTRADA", $data_entrada);
        $stmt->bindParam(":DATA_SAIDA", $data_saida);

        $stmt->execute();

        $stmt = $this->banco->prepare("UPDATE quartos set status = 0 where id = :QUARTO");

        $stmt->bindParam(":QUARTO", $quarto);

        $stmt->execute();

    }


    public function listar(){
        $stmt = $this->banco->prepare("SELECT r.id as id_reserva, r.valor, r.data_entrada,r.data_previsao_saida,r.data_saida, r.pago, c.nome,r.finalizada,r.quarto from reservas r
                inner join cliente c on c.id = r.cliente");

        $stmt->execute();

        $resultado = $stmt->fetchALL(PDO::FETCH_ASSOC);
        
        return $resultado;
    }


    public function buscar($id){

        $stmt = $this->banco->prepare("SELECT * FROM reservas where id = $id");
        $stmt->bindParam(":ID",$id);
        $stmt->execute();

        $resultado = $stmt->fetchALL(PDO::FETCH_ASSOC);

        foreach ($resultado as $key => $value) {
        
            $this->setId($value['id']);
            $this->setQuarto($value['quarto']);
            $this->setCliente($value['cliente']);
            $this->setDataEntrada($value['data_entrada']);
            $this->setDataSaida($value['data_saida']);
            $this->setValor($value['valor']);
            $this->setDataPrevisaoSaida($value['data_previsao_saida']);
            $this->setPago($value['pago']);
        }
  }

  public function check_out(){
       
        $stmt = $this->banco->prepare("UPDATE reservas set data_saida = :DATA_SAIDA, valor = :VALOR, finalizada = 1 where id = :ID");
        
        $id = $this->getId();
        $data_saida =  $this->getDataSaida();
        $valor = $this->getValor();
        $quarto = $this->getQuarto();
        $cliente = $this->getCliente();

        $stmt->bindParam(":ID",$id );
        $stmt->bindParam(":DATA_SAIDA",$data_saida );
        $stmt->bindParam(":VALOR",$valor );       

        $stmt->execute();

        $stmt = $this->banco->prepare("UPDATE quartos set status = 1 where id = :QUARTO");

        $stmt->bindParam(":QUARTO", $quarto);

        $stmt->execute();

        $stmt = $this->banco->prepare("UPDATE devedores set status = 1 where cliente = :CLIENTE");
        $stmt->bindParam(":CLIENTE", $cliente);
        $stmt->execute();
  }


  public function pagamento(){

        $id = $this->getId();
        $cliente = $this->getCliente();

        $stmt = $this->banco->prepare("UPDATE reservas set pago = 1 where id = $id");

        $stmt->execute();

        $stmt = $this->banco->prepare("UPDATE devedores set status = 0 where cliente = $cliente");
        $stmt->execute();
  }

}// final