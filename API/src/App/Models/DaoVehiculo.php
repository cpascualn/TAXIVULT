<?php
namespace App\Models;
use App\Database\Database;
use App\Entities\Vehiculo;

class DaoVehiculo
{

    public $vehiculos = array();
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function listar()       //Lista el contenido de la tabla
    {
        $consulta = "SELECT v.*,u.email as conductor_mail FROM Vehiculo v left join Conductor c on c.coche = v.matricula left join Usuario u on c.id = u.id";
        $this->vehiculos = array();  //Vaciamos el array de las situaciones entre consulta y consulta

        $this->db->ConsultaDatos($consulta);

        foreach ($this->db->filas as $fila) {

            $vehiculo = new Vehiculo();
            $vehiculo->setId($fila['id']);
            $vehiculo->setMatricula($fila['matricula']);
            $vehiculo->setCapacidad($fila['capacidad']);
            $vehiculo->setFabricante($fila['fabricante']);
            $vehiculo->setModelo($fila['modelo']);
            $vehiculo->setTipo($fila['tipo']);
            $vehiculo->setImagen($fila['imagen']);
            $vehiculo->setConductor($fila['conductor_mail']);

            $this->vehiculos[] = $vehiculo;   //Insertamos el objeto con los valores de esa fila en el array de objetos
        }

        return $this->vehiculos;
    }
    public function listarLibres()       //Lista el contenido de la tabla
    {
        $consulta = "SELECT v.* FROM Vehiculo v left join Conductor c on c.coche = v.matricula where c.coche is null";
        $this->vehiculos = array();  //Vaciamos el array de las situaciones entre consulta y consulta

        $this->db->ConsultaDatos($consulta);

        foreach ($this->db->filas as $fila) {

            $vehiculo = new Vehiculo();
            $vehiculo->setId($fila['id']);
            $vehiculo->setMatricula($fila['matricula']);
            $vehiculo->setCapacidad($fila['capacidad']);
            $vehiculo->setFabricante($fila['fabricante']);
            $vehiculo->setModelo($fila['modelo']);
            $vehiculo->setTipo($fila['tipo']);
            $vehiculo->setImagen($fila['imagen']);

            $this->vehiculos[] = $vehiculo;   //Insertamos el objeto con los valores de esa fila en el array de objetos
        }

        return $this->vehiculos;
    }

    public function obtener($id)          //Obtenemos el elemento a partir de su Id
    {
        $consulta = "SELECT v.*,u.email as conductor FROM Vehiculo v left join Conductor c on c.coche = v.matricula join Usuario u on c.id = u.id where v.id = :ID";
        $this->vehiculos = array();  //Vaciamos el array de las situaciones entre consulta y consulta
        $param = array(":ID" => $id);
        $this->db->ConsultaDatos($consulta, $param);

        $vehiculo = null;
        if (count($this->db->filas) == 1) {
            $fila = $this->db->filas[0];
            $vehiculo = new Vehiculo();
            $vehiculo->setId($fila['id']);
            $vehiculo->setMatricula($fila['matricula']);
            $vehiculo->setCapacidad($fila['capacidad']);
            $vehiculo->setFabricante($fila['fabricante']);
            $vehiculo->setModelo($fila['modelo']);
            $vehiculo->setTipo($fila['tipo']);
            $vehiculo->setImagen($fila['imagen']);
            $vehiculo->setConductor($fila['conductor']);
        }


        return $vehiculo;
    }

    public function obtenerPorMatricula($matricula)          //Obtenemos el elemento a partir de su Id
    {
        $consulta = "SELECT v.*,u.email as conductor FROM Vehiculo v left join Conductor c on c.coche = v.matricula join Usuario u on c.id = u.id where v.matricula = :MATRICULA";
        $this->vehiculos = array();  //Vaciamos el array de las situaciones entre consulta y consulta
        $param = array(":MATRICULA" => $matricula);
        $this->db->ConsultaDatos($consulta, $param);

        $vehiculo = null;
        if (count($this->db->filas) == 1) {
            $fila = $this->db->filas[0];
            $vehiculo = new Vehiculo();
            $vehiculo->setId($fila['id']);
            $vehiculo->setMatricula($fila['matricula']);
            $vehiculo->setCapacidad($fila['capacidad']);
            $vehiculo->setFabricante($fila['fabricante']);
            $vehiculo->setModelo($fila['modelo']);
            $vehiculo->setTipo($fila['tipo']);
            $vehiculo->setImagen($fila['imagen']);
            $vehiculo->setConductor($fila['conductor']);
        }


        return $vehiculo;
    }

    public function insertar($vehiculo)
    {
        $consulta = "INSERT INTO `Vehiculo` (matricula, capacidad, fabricante, modelo, tipo, imagen) VALUES( :MATRICULA, :CAPACIDAD, :FABRICANTE, :MODELO, :TIPO, :IMAGEN);";
        $param = array();

        $param[":MATRICULA"] = $vehiculo->getMatricula();
        $param[":CAPACIDAD"] = $vehiculo->getCapacidad();
        $param[":FABRICANTE"] = $vehiculo->getFabricante();
        $param[":MODELO"] = $vehiculo->getModelo();
        $param[":TIPO"] = $vehiculo->getTipo();
        $param[":IMAGEN"] = $vehiculo->getImagen();


        $this->db->ConsultaSimple($consulta, $param);
    }

    public function actualizar($id, $vehiculo, $nuevo)          //Obtenemos el elemento a partir de su Id
    {
        $consulta = "UPDATE `Vehiculo` SET `matricula`=:MATRICULA,`capacidad`=:CAPACIDAD,`fabricante`=:FABRICANTE,`modelo`=:MODELO,`tipo`=:TIPO,`imagen`=:IMAGEN WHERE id = :ID";

        $param = array();

        $param[":ID"] = $id;
        $param[":MATRICULA"] = $nuevo->getMatricula() ?? $vehiculo->getMatricula();
        $param[":CAPACIDAD"] = $nuevo->getCapacidad() ?? $vehiculo->getCapacidad();
        $param[":FABRICANTE"] = $nuevo->getFabricante() ?? $vehiculo->getFabricante();
        $param[":MODELO"] = $nuevo->getModelo() ?? $vehiculo->getModelo();
        $param[":TIPO"] = $nuevo->getTipo() ?? $vehiculo->getTipo();
        $param[":IMAGEN"] = $nuevo->getImagen() ?? $vehiculo->getImagen();


        $this->db->ConsultaSimple($consulta, $param);

    }

    public function eliminar($id, $matricula = null)          //Obtenemos el elemento a partir de su Id
    {
        $consulta = "DELETE FROM Vehiculo WHERE id=:ID or matricula =:MATRICULA";
        $param = array();
        $param[":ID"] = $id ?? null;
        $param[":MATRICULA"] = $matricula;
        $this->db->ConsultaSimple($consulta, $param);
    }


    public function verTotales()
    {
        $consulta = "SELECT COUNT(*) as total FROM Vehiculo";
        $this->db->ConsultaDatos($consulta);

        $total = 0;
        if (count($this->db->filas) == 1) {
            $fila = $this->db->filas[0];
            $total = $fila['total'];
        }

        return $total;
    }

    public function obtenerPorUsuario($id)
    {
        $consulta = "SELECT v.*  FROM Vehiculo v join Conductor c on c.coche = v.matricula where c.id = :ID";
        $param = array(":ID" => $id);
        $this->db->ConsultaDatos($consulta, $param);

        $vehiculo = null;
        if (count($this->db->filas) == 1) {
            $fila = $this->db->filas[0];
            $vehiculo = new Vehiculo();
            $vehiculo->setId($fila['id']);
            $vehiculo->setMatricula($fila['matricula']);
            $vehiculo->setCapacidad($fila['capacidad']);
            $vehiculo->setFabricante($fila['fabricante']);
            $vehiculo->setModelo($fila['modelo']);
            $vehiculo->setTipo($fila['tipo']);
            $vehiculo->setImagen($fila['imagen']);
        }


        return $vehiculo;
    }

}