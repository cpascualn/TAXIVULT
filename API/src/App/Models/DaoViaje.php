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
        $consulta = 'SELECT * FROM Viaje';

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


}