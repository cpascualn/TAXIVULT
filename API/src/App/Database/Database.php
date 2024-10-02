<?php
namespace App\Database;
use PDO;
use PDOException;
class Database
{
    private $pdo;
    public $filas = array();   //Array de filas con el resultado de la consulta de datos
    private $host;
    private $dbname;
    private $user;
    private $password;
    public function __construct(
        $host,
        $dbname,
        $user,
        $password
    ) {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->user = $user;
        $this->password = $password;
    }

    private function Conectar()
    {
        $dns = "mysql:host=$this->host;dbname=$this->dbname;charset=utf8mb4";
        try {
            $this->pdo = new PDO($dns, $this->user, $this->password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function ConsultaSimple($consulta, $param = array())
    {
      
        $this->Conectar();  //Nos conectamos con la base de datos

        $sta = $this->pdo->prepare($consulta);  //Preparamos la consulta y recibimos el objeto de tipo statement

        if (!$sta->execute($param))   //si al ejecutar la consulta devuelve falso
        {
            echo "Error en la consulta simple";
        }

        $this->Cerrar();   //Cerramos la conexión
    }

    public function ConsultaDatos($consulta, $param = array())
    {
        $this->Conectar();      //Nos conectamos con la base de datos

        $sta = $this->pdo->prepare($consulta);  //Preparamos la consulta y recibimos el objeto de tipo statement
     

        $resul = $sta->execute($param);

        if ($resul)                     //si al ejecutar la consulta devuelve filas
        {
            $this->filas = $sta->fetchAll(PDO::FETCH_ASSOC);
           
        } else {
            echo "Error en la consulta de datos";
        }

        $this->Cerrar();

        return $this->filas;  //Retornamos el array con los resultados de la consulta

    }



    private function Cerrar()    //Cerramos la conexión eliminando ese objeto PDO
    {
        $this->pdo = null;

    }

}


