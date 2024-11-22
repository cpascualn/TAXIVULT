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
        $consulta = 'SELECT c.*,(SELECT count(*) from Usuario where ciudad = c.id) as usuarios,(SELECT count(*)  FROM Viaje where ciudad = c.id) as viajes from Ciudad c';

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
            $ciu->setUsuarios($fila['usuarios']);
            $ciu->setViajes($fila['viajes']);

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

    public function obtenerUsuariosPorCiudad()
    {
        $consulta = "SELECT c.nombre AS ciudad, COUNT(CASE WHEN u.rol = 2 THEN 1 END) AS conductores,COUNT(CASE WHEN u.rol = 3 THEN 1 END) AS pasajeros
                    FROM Ciudad c JOIN Usuario u ON c.id = u.ciudad GROUP BY c.nombre";


        $this->db->ConsultaDatos($consulta);
        $data = [];
        $ciudad = "";
        $conductores = "";
        $pasajeros = "";

        foreach ($this->db->filas as $fila) {
            $ciudad = $fila['ciudad'];
            $conductores = $fila['conductores'];
            $pasajeros = $fila['pasajeros'];

            $data[] = array('ciudad' => $ciudad, 'conductores' => $conductores, 'pasajeros' => $pasajeros);
        }

        return $data;
    }

    public function insertar($ciudad)
    {
        $consulta = 'INSERT INTO Ciudad (`nombre`, `comunidad`, `pais`, `lat_min`, `lat_max`, `long_min`, `long_max`, `lat`, `long`)
                     VALUES(:NOMBRE, :COMUNIDAD, :PAIS, :LAT_MIN, :LAT_MAX, :LONG_MIN, :LONG_MAX, :LAT, :LONG)';
        $param = array(
            ":NOMBRE" => $ciudad->getNombre(),
            ":COMUNIDAD" => $ciudad->getComunidad(),
            ":PAIS" => $ciudad->getPais(),
            ":LAT_MIN" => $ciudad->getLat_min(),
            ":LAT_MAX" => $ciudad->getLat_max(),
            ":LONG_MIN" => $ciudad->getLong_min(),
            ":LONG_MAX" => $ciudad->getLong_max(),
            ":LAT" => $ciudad->getLat(),
            ":LONG" => $ciudad->getLong(),
        );

        $this->db->ConsultaSimple($consulta, $param);
    }

    public function eliminar($id)
    {
        $consulta = 'DELETE FROM Ciudad WHERE id=:ID';
        $param = array(
            ":ID" => $id
        );


        $this->db->ConsultaSimple($consulta, $param);
    }
}