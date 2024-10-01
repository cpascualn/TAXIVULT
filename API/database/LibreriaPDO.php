<?php

class DB
{
    private $usuario = "root";
    private $clave = "";
    private $host = "localhost";

    private $pdo;

    protected $dbname = "";

    private $databaseProd;
    private $hostProd;
    private $passwordProd;
    private $userProd;

    public $filas = array();   //Array de filas con el resultado de la consulta de datos

    public function __construct($base)  //El constructor recibe como parámetro la base de datos a conectar
    {
        $this->dbname = $base;

        $this->databaseProd = getenv('MYSQLDATABASE');
        $this->hostProd = getenv('MYSQLHOST');
        $this->userProd = getenv('MYSQLUSER');
        $this->passwordProd = getenv('MYSQLPASSWORD');

    }

    private function Conectar()
    {
        //  DESARROLLO
        //   $dns="mysql:host=$this->host;dbname=$this->dbname;charset=utf8mb4";
        // PRODUCCION
        $dns = "mysql:host=$this->hostProd;dbname=$this->databaseProd";

        try {
            //  DESARROLLO
            //   $this->pdo = new PDO($dns, $this->usuario, $this->clave,[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            // PRODUCCION
            $this->pdo = new PDO($dns, $this->userProd, $this->passwordProd, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
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


