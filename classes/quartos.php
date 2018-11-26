<?php
require_once ("banco.php");
class quartos {

    private $numero;   
    private $tipo;      
    private $valor;
    private $banco;
    private $status;


    public function __construct(){

        $this->banco = new banco();
        
    }  

    public function getNumero() {
        return $this->numero;
    }

 
    public function setNumero($numero) {
        $this->numero = $numero;
    }


    public function getStatus() {
        return $this->status;
    }

 
    public function setStatus($status) {
        $this->status = $status;
    }

 
    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }


    public function getValor() {
        return $this->valor;
    }

    public function setValor($valor) {
        $this->valor = $valor;
    }


    public function listarQuarto(){

        $stmt = $this->banco->prepare("SELECT * from quartos where status = 1");
        $stmt->execute();

        $resultado = $stmt->fetchALL(PDO::FETCH_ASSOC);
        
        return $resultado;

    }

    public function buscar($id){
        $stmt = $this->banco->prepare("SELECT * from quartos where id = $id");

        $stmt->execute();

         $resultado = $stmt->fetchALL(PDO::FETCH_ASSOC);
        
        foreach ($resultado as $key => $value) {
            

            $this->setNumero($value['id']);
            $this->setTipo($value['tipo']);
            $this->setValor($value['valor']);
            $this->setStatus($value['status']);
        }
    }

} /* final da classe */
