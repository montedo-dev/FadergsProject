
<?php
require_once ("banco.php");

class cliente {

    private $id;
    private $nome;
    private $cpf; 
    private $status;
    private $endreco;
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


    public function getNome() {
        return $this->nome;
    }


    public function setNome($nome) {
        $this->nome = $nome;
    }


    public function getCpf() {
        return $this->cpf;
    }

    public function setCpf($cpf) {
        $this->cpf = $cpf;
    }


    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }


    public function getEndreco() {
        return $this->endreco;
    }

    public function setEndreco($endreco) {
        $this->endreco = $endreco;
    }



    public function buscaCPF($cpf){
        $stmt = $this->banco->prepare("SELECT id from cliente where cpf = :CPF");
        $stmt->bindParam(":CPF", $cpf);
        $resultado = $stmt->execute();

        if($resultado == true){
           $result = $stmt->fetchColumn();

           return $result;
        } else {
            return false;
        }

        
    }


    public function verificaEndereco($id){
        $stmt = $this->banco->prepare("SELECT endereco from cliente where id = :ID");

        $stmt->bindParam(":ID", $id);
        $resultado = $stmt->execute();

        if($resultado == true){
           $result = $stmt->fetchColumn();
           return $result;
        } else {
            return false;
        }
    }

    public function verificaDevedor($id){
        $stmt = $this->banco->prepare("SELECT status from devedores where cliente = :ID");

        $stmt->bindParam(":ID", $id);
        $resultado = $stmt->execute();

        if($resultado == true){
           $result = $stmt->fetchColumn();
           return $result;
        } else {
            return false;
        }
    }


    public function insereDevedor($id){
        $stmt = $this->banco->prepare("INSERT INTO devedores (cliente,status) VALUES ($id,0)");
        $stmt->execute();
    }


    public function setarDevedor($id){
        $stmt = $this->banco->prepare("UPDATE devedores set status = 1 where cliente = $id");
        $stmt->execute();
    }


    public function buscaNome($id){

        $stmt = $this->banco->prepare("SELECT id from cliente where id = :ID");
        $stmt->bindParam(":ID", $id);
        $resultado = $stmt->execute();

        if($resultado == true){
           $result = $stmt->fetchColumn();

           return $result;
        } else {
            return false;
        }
} 

}// final da classe
