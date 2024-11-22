<?php
namespace App\Models;
use App\Database\Database;
use App\Entities\Viaje;




class DaoViaje
{

    public $viajes = array();
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }


    public function listar()
    {
        $consulta = 'SELECT v.*, (select u.email from Usuario u where u.id = v.id_conductor) as conductor_mail,(select u.email from Usuario u where u.id = v.id_pasajero) as pasajero_mail, (select c.nombre from Ciudad c  where c.id = v.ciudad) as ciudad_nombre FROM Viaje v';

        $this->viajes = array();  //Vaciamos el array de las situaciones entre consulta y consulta

        $this->db->ConsultaDatos($consulta);

        foreach ($this->db->filas as $fila) {
            $viaje = new Viaje();
            $viaje->setId($fila['id']);
            $viaje->setIdConductor($fila['conductor_mail']);
            $viaje->setIdPasajero($fila['pasajero_mail']);
            $viaje->setLatiIni($fila['lati_ini']);
            $viaje->setLongiIni($fila['longi_ini']);
            $viaje->setLatiFin($fila['lati_fin']);
            $viaje->setLongiFin($fila['longi_fin']);
            $viaje->setFechaIni(date('H:i:s d/m/Y ', $fila['fecha_ini']));
            $viaje->setFechaFin(date('H:i:s d/m/Y', $fila['fecha_fin']));
            $viaje->setMetodoPago($fila['metodo_pago']);
            $viaje->setDistancia($fila['distancia']);
            $viaje->setDuracionMin($fila['duracion_min']);
            $viaje->setPrecioTotal($fila['precio_total']);
            $viaje->setCiudad($fila['ciudad_nombre']);
            $viaje->setLugarSalida($fila['lugar_salida']);
            $viaje->setLugarLlegada($fila['lugar_llegada']);

            $this->viajes[] = $viaje;   //Insertamos el objeto con los valores de esa fila en el array de objetos
        }

        return $this->viajes;
    }

    public function obtenerViajesActivosUsuario($id)
    {
        $consulta = 'SELECT count(*) as cantidad FROM Viaje where id_pasajero = :ID and fecha_fin > UNIX_TIMESTAMP()';
        $param = array(":ID" => $id);
        $this->viajes = array();  //Vaciamos el array de las situaciones entre consulta y consulta

        $this->db->ConsultaDatos($consulta, $param);
        $cantidad = 0;
        foreach ($this->db->filas as $fila) {
            $cantidad = $fila['cantidad'];
        }

        return $cantidad;
    }

    public function obtenerViajesUsuario($id)
    {
        $consulta = 'SELECT * FROM Viaje where id_pasajero = :ID';
        $param = array(":ID" => $id);
        $this->viajes = array();  //Vaciamos el array de las situaciones entre consulta y consulta

        $this->db->ConsultaDatos($consulta, $param);

        foreach ($this->db->filas as $fila) {
            $viaje = new Viaje();
            $viaje->setId($fila['id']);
            $viaje->setIdConductor($fila['id_conductor']);
            $viaje->setIdPasajero($fila['id_pasajero']);
            $viaje->setLatiIni($fila['lati_ini']);
            $viaje->setLongiIni($fila['longi_ini']);
            $viaje->setLatiFin($fila['lati_fin']);
            $viaje->setLongiFin($fila['longi_fin']);
            $viaje->setFechaIni($fila['fecha_ini']);
            $viaje->setFechaFin($fila['fecha_fin']);
            $viaje->setMetodoPago($fila['metodo_pago']);
            $viaje->setDistancia($fila['distancia']);
            $viaje->setDuracionMin($fila['duracion_min']);
            $viaje->setPrecioTotal($fila['precio_total']);
            $viaje->setCiudad($fila['ciudad']);
            $viaje->setLugarSalida($fila['lugar_salida']);
            $viaje->setLugarLlegada($fila['lugar_llegada']);


            $this->viajes[] = $viaje;   //Insertamos el objeto con los valores de esa fila en el array de objetos
        }

        return $this->viajes;
    }

    public function obtenerViajesConductor($id)
    {
        $consulta = 'SELECT * FROM Viaje where ';

        $this->viajes = array();  //Vaciamos el array de las situaciones entre consulta y consulta

        $this->db->ConsultaDatos($consulta);

        foreach ($this->db->filas as $fila) {
            $viaje = new Viaje();
            $viaje->setId($fila['id']);
            $viaje->setIdConductor($fila['id_conductor']);
            $viaje->setIdPasajero($fila['id_pasajero']);
            $viaje->setLatiIni($fila['lati_ini']);
            $viaje->setLongiIni($fila['longi_ini']);
            $viaje->setLatiFin($fila['lati_fin']);
            $viaje->setLongiFin($fila['longi_fin']);
            $viaje->setFechaIni($fila['fecha_ini']);
            $viaje->setFechaFin($fila['fecha_fin']);
            $viaje->setMetodoPago($fila['metodo_pago']);
            $viaje->setDistancia($fila['distancia']);
            $viaje->setDuracionMin($fila['duracion_min']);
            $viaje->setPrecioTotal($fila['precio_total']);
            $viaje->setCiudad($fila['ciudad']);
            $viaje->setLugarSalida($fila['lugar_salida']);
            $viaje->setLugarLlegada($fila['lugar_llegada']);


            $this->viajes[] = $viaje;   //Insertamos el objeto con los valores de esa fila en el array de objetos
        }

        return $this->viajes;
    }



    public function insertar($viaje)
    {
        $consulta = "INSERT INTO Viaje (id_conductor, id_pasajero, lati_ini, longi_ini, lati_fin, longi_fin, fecha_ini, fecha_fin, metodo_pago, distancia, duracion_min, precio_total, lugar_salida, lugar_llegada, ciudad) 
        VALUES(:ID_CONDUCTOR, :ID_PASAJERO, :LATI_INI, :LONGI_INI, :LATI_FIN, :LONGI_FIN, :FECHA_INI, :FECHA_FIN, :METODO_PAGO, :DISTANCIA, :DURACION_MIN, :PRECIO_TOTAL, :LUGAR_SALIDA, :LUGAR_LLEGADA, :CIUDAD)";
        $param = array(
            ':ID_CONDUCTOR' => $viaje->getIdConductor(),
            ':ID_PASAJERO' => $viaje->getIdPasajero(),
            ':LATI_INI' => $viaje->getLatiIni(),
            ':LONGI_INI' => $viaje->getLongiIni(),
            ':LATI_FIN' => $viaje->getLatiFin(),
            ':LONGI_FIN' => $viaje->getLongiFin(),
            ':FECHA_INI' => $viaje->getFechaIni(),
            ':FECHA_FIN' => $viaje->getFechaFin(),
            ':METODO_PAGO' => $viaje->getMetodoPago(),
            ':DISTANCIA' => $viaje->getDistancia(),
            ':DURACION_MIN' => $viaje->getDuracionMin(),
            ':PRECIO_TOTAL' => $viaje->getPrecioTotal(),
            ':LUGAR_SALIDA' => $viaje->getLugarSalida(),
            ':LUGAR_LLEGADA' => $viaje->getLugarLlegada(),
            ':CIUDAD' => $viaje->getCiudad()
        );

        $this->db->ConsultaSimple($consulta, $param);
    }


    public function verTotales()
    {
        $consulta = "SELECT SUM(precio_total) as dinero,count(*) as viajes FROM Viaje";


        $this->db->ConsultaDatos($consulta);

        $viajes = 0;
        $dinero = 0;
        if (count($this->db->filas) == 1) {
            $fila = $this->db->filas[0];
            $viajes = $fila['viajes'];
            $dinero = $fila['dinero'];
        }

        return array($viajes, $dinero);
    }

    public function verTotalesCiudad()
    {
        $consulta = "SELECT c.nombre as ciudad,SUM(precio_total) as dinero,count(v.id) as viajes,(select count(*) from Usuario u where u.ciudad = c.id ) as usuarios  
        FROM Ciudad c left join Viaje v  on v.ciudad = c.id group by c.id,c.nombre";

        $this->db->ConsultaDatos($consulta);
        $data = [];

        foreach ($this->db->filas as $fila) {
            $data[] = array('ciudad' => $fila['ciudad'], 'dinero' => $fila['dinero'], 'viajes' => $fila['viajes'], 'usuarios' => $fila['usuarios']);
        }


        return $data;
    }

    public function verTotalesCiudadPorMes()
    {
        $consulta = "SELECT c.nombre AS ciudad, DATE_FORMAT(FROM_UNIXTIME(v.fecha_ini), '%Y-%m') AS mes, SUM(v.precio_total) AS dinero
                    FROM Ciudad c JOIN  Viaje v ON  c.id = v.ciudad
                    WHERE YEAR(FROM_UNIXTIME(v.fecha_ini)) = YEAR(CURDATE())
                    GROUP BY c.nombre,DATE_FORMAT(FROM_UNIXTIME(v.fecha_ini), '%Y-%m')
                    ORDER BY  mes ASC";

        $this->db->ConsultaDatos($consulta);
        $data = [];

        foreach ($this->db->filas as $fila) {
            $data[] = array('ciudad' => $fila['ciudad'], 'mes' => $fila['mes'], 'dinero' => $fila['dinero']);
        }


        return $data;
    }


}