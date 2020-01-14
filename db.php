<?php

class DataBase{
    private $dsn = "mysql:host=localhost;dbname=estoque";
    private $user = "root";
    private $pass = "";
    public $conn;

    public function __construct()
    {
        try{
            $this->conn = new PDO($this->dsn,$this->user,$this->pass);
            
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public function insert($fmodelo,$fcompra,$fvenda,$fquantidade){
        $sql = "INSERT INTO produto (modelo,compra,venda,quantidade)VALUES (:fmodelo,:fcompra,:fvenda,:fquantidade)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['fmodelo'=>$fmodelo,'fcompra'=>$fcompra,'fvenda'=>$fvenda,'fquantidade'=>$fquantidade]);
        
        return true;
    }

    public function read(){
        $data = array();

        $sql = "SELECT * FROM produto";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row){
            $data[] = $row;    
        }
        return $data;
    }
    public function getUserbyId($id){
        $sql = "SELECT * FROM produto WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function update($id,$fmodelo,$fcompra,$fvenda,$fquantidade){
        $sql = "UPDATE produto SET modelo = :fmodelo, compra = :fcompra, venda = :fvenda,quantidade = :fquantidade WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['fmodelo'=>$fmodelo,'fcompra'=>$fcompra,'fvenda'=>$fvenda,'fquantidade'=>$fquantidade,'id'=>$id]);
        return true;

    }
    public function delete($id){
        $sql = "DELETE FROM produto WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id]);
        return true;
    }

    public function totalRowCount(){
        $sql = "SELECT * FROM produto";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $t_rows = $stmt->rowCount();

        return $t_rows;
    }
}




?>