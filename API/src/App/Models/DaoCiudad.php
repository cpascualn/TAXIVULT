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
            $ciu->setLat($fila['lat']);
            $ciu->setLong($fila['long']);
            $ciu->setLong_min($fila['long_min']);
            $ciu->setLong_max($fila['long_max']);
            $ciu->setLat_min($fila['lat_min']);
            $ciu->setLat_max($fila['lat_max']);

            $this->ciudades[] = $ciu;   //Insertamos el objeto con los valores de esa fila en el array de objetos
        }

        return $this->ciudades;
    }

    public function obtener($id)
    {
        $consulta = 'SELECT * FROM Ciudad where id = :ID';

        $this->ciudades = array();  //Vaciamos el array de las situaciones entre consulta y consulta
        $param = array(":ID" => $id);
        $this->db->ConsultaDatos($consulta, $param);

        $ciu = null;
        //Si la consulta devuelve un resultado, creamos un objeto Ciudad con los valores de esa fila y lo añadimos al array de objetos
        if (count($this->db->filas) == 1) {
            $fila = $this->db->filas[0];  //Recuperamos la fila devuelta
            $ciu = new Ciudad();
            $ciu->setId($fila['id']);
            $ciu->setNombre(nombre: $fila['nombre']);
            $ciu->setComunidad(comunidad: $fila['comunidad']);
            $ciu->setPais(pais: $fila['pais']);
            $ciu->setLat($fila['lat']);
            $ciu->setLong($fila['long']);
            $ciu->setLong_min($fila['long_min']);
            $ciu->setLong_max($fila['long_max']);
            $ciu->setLat_min($fila['lat_min']);
            $ciu->setLat_max($fila['lat_max']);
        }

        return $ciu;
    }

    public function obtenerPorNombre($nombreCiudad)
    {
        $consulta = 'SELECT * FROM Ciudad where nombre = :NOMBRE';

        $this->ciudades = array();  //Vaciamos el array de las situaciones entre consulta y consulta
        $param = array(":NOMBRE" => $nombreCiudad);
        $this->db->ConsultaDatos($consulta, $param);

        $ciu = null;
        //Si la consulta devuelve un resultado, creamos un objeto Ciudad con los valores de esa fila y lo añadimos al array de objetos
        if (count($this->db->filas) == 1) {
            $fila = $this->db->filas[0];  //Recuperamos la fila devuelta
            $ciu = new Ciudad();
            $ciu->setId($fila['id']);
            $ciu->setNombre(nombre: $fila['nombre']);
            $ciu->setComunidad(comunidad: $fila['comunidad']);
            $ciu->setPais(pais: $fila['pais']);
            $ciu->setLat($fila['lat']);
            $ciu->setLong($fila['long']);
            $ciu->setLong_min($fila['long_min']);
            $ciu->setLong_max($fila['long_max']);
            $ciu->setLat_min($fila['lat_min']);
            $ciu->setLat_max($fila['lat_max']);
        }

        return $ciu;
    }

}