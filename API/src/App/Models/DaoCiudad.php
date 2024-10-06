<?php
namespace App\Models;
use App\Database\Database;
use App\Entities\Ciudad;


class DaoCiudad
{

    public $ciudades = array();
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }


    public function listar()
    {
        $consulta = 'SELECT * FROM Ciudad';

        $this->ciudades = array();  //Vaciamos el array de las situaciones entre consulta y consulta

        $this->db->ConsultaDatos($consulta);

        foreach ($this->db->filas as $fila) {
            $ciu = new Ciudad();
            $ciu->setId($fila['id']);
            $ciu->setNombre(nombre: $fila['nombre']);
            $ciu->setComunidad(comunidad: $fila['comunidad']);
            $ciu->setPais(pais: $fila['pais']);

            $this->ciudades[] = $ciu;   //Insertamos el objeto con los valores de esa fila en el array de objetos
        }

        return $this->ciudades;

    }

}