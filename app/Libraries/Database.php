<?php
class Database{
    private $host = 'localhost';
    private $usuario = 'root';
    private $senha = '';
    private $banco = 'blog';
    private $porta = '3306';
    private $dbh;
    private $stmt;


public function __construct(){
    $dsn = 'mysql:host' .$this->host. ';port=' .$this->porta .';dbname=' .$this->banco;
    $opcoes = [
        PDO:: ATTR_PERSISTENT => TRUE,
        PDO:: ATTR_ERRMODE => PDO:: ERRMODE_EXCEPTION
    ];
    try{
        $this->dbh = new PDO($dsn, $this->usuario, $this->senha, $opcoes);
        $dbh = null;
    } catch (PDOException $e){
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}//fim do método __construct

//Prepared Statements com query
public function query($sql){
    //prepara uma consulta sql
    $this->stmt = $this->dbh->prepare($sql);
}

//vincula um valor a um parâmetro
public function bind($parametro, $valor, $tipo = null){
    if(is_null($tipo)):
        switch (true):
            case is_int($valor):
                $tipo = PDO::PARAM_INT;
            break;
            case is_bool($valor):
                $tipo = PDO::PARAM_BOOL;
            break;
            case is_null($valor):
                $tipo = PDO::PARAM_NULL;
            break;
            default;
                $tipo = PDO::PARAM_STR;
            endswitch;
            endif;

            $this->stmt->bindValue($parametro, $valor, $tipo);
}

//executa prepared stament
public function executa(){
    return $this->stmt->execute();
}

//obtem um único registro
public function resultado(){
    $this->executa();
    return $this->stmt->fetch(PDO::FETCH_OBJ);
}

//obtem um conjunto registro
public function resultados(){
    $this->executa();
    return $this->stmt->fetchAll(PDO::FETCH_OBJ);
}

//retorna o número de linhas afetadas pela última instrução SQL
public function totalResultados(){
    return $this->stmt->rowCount();
}
//retorna o último ID inserido no banco de dados
public function ultimoIdInserido(){
    return $this->dbh->lastInsertId();
}
}//fim da classe
?>