<?php
namespace App\models;


use App\Database\Database;
use App\Entities\Usuario;



class DaoUsuario
{

    public $usuarios = array();
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function listar()       //Lista el contenido de la tabla
    {
        $consulta = 'SELECT u.*,c.nombre as ciudad_nombre,r.nombre as rol_nombre FROM Usuario u left join Ciudad c on u.ciudad = c.id join Rol r on r.id =u.rol';

        $this->usuarios = array();  //Vaciamos el array de las situaciones entre consulta y consulta

        $this->db->ConsultaDatos($consulta);

        foreach ($this->db->filas as $fila) {

            $usu = new Usuario();
            $usu->setId($fila['id']);
            $usu->setEmail($fila['email']);
            $usu->setTelefono($fila['telefono']);
            $usu->setNombre($fila['nombre']);
            $usu->setApellidos($fila['apellidos']);
            $usu->setContrasena($fila['contrasena']);
            $usu->setCiudad($fila['ciudad_nombre']);
            $usu->setFechaCreacion($fila['fecha_creacion']);
            $usu->setRol($fila['rol_nombre']);

            $this->usuarios[] = $usu;   //Insertamos el objeto con los valores de esa fila en el array de objetos
        }

        return $this->usuarios;
    }

    public function obtener($id)          //Obtenemos el elemento a partir de su Id
    {
        $consulta = "SELECT * FROM Usuario WHERE id=:ID";
        $param = array(":ID" => $id);

        $this->usuarios = array();  //Vaciamos el array de las situaciones entre consulta y consulta

        $this->db->ConsultaDatos($consulta, $param);

        $usu = null; //Inicializamos a nulo la variable que almacenarça el objeto de retorno

        if (count($this->db->filas) == 1) {
            $fila = $this->db->filas[0];  //Recuperamos la fila devuelta

            $usu = new Usuario();
            $usu->setId($fila['id']);
            $usu->setEmail($fila['email']);
            $usu->setTelefono($fila['telefono']);
            $usu->setNombre($fila['nombre']);
            $usu->setApellidos($fila['apellidos']);
            $usu->setContrasena($fila['contrasena']);
            $usu->setCiudad($fila['ciudad']);
            $usu->setFechaCreacion($fila['fecha_creacion']);
            $usu->setRol($fila['rol']);

        }

        return $usu;  //Retornamos el objeto con los datos del usuario
    }

    public function obtenerPorEmail($email)          //Obtenemos el elemento a partir de su Id
    {
        $consulta = "SELECT * FROM Usuario WHERE email=:EMAIL";
        $param = array(":EMAIL" => $email);

        $this->usuarios = array();  //Vaciamos el array de las situaciones entre consulta y consulta

        $this->db->ConsultaDatos($consulta, $param);

        $usu = null; //Inicializamos a nulo la variable que almacenarça el objeto de retorno

        if (count($this->db->filas) == 1) {
            $fila = $this->db->filas[0];  //Recuperamos la fila devuelta

            $usu = new Usuario();
            $usu->setId($fila['id']);
            $usu->setEmail($fila['email']);
            $usu->setTelefono($fila['telefono']);
            $usu->setNombre($fila['nombre']);
            $usu->setApellidos($fila['apellidos']);
            $usu->setContrasena($fila['contrasena']);
            $usu->setCiudad($fila['ciudad']);
            $usu->setFechaCreacion($fila['fecha_creacion']);
            $usu->setRol($fila['rol']);

        }

        return $usu;  //Retornamos el objeto con los datos del usuario
    }

    public function buscar($valores)
    {
        $consulta = "SELECT * FROM Usuario WHERE 1=1";

        $param = [];
        $valores = array_change_key_case($valores, CASE_UPPER);

        // Agregar filtros dinámicamente en función de los parámetros recibidos
        if (!empty($valores['ID'])) {
            $consulta .= " AND ID = :ID";
            $param[':ID'] = $valores['ID'];
        }
        if (!empty($valores['EMAIL'])) {
            $consulta .= " AND EMAIL = :EMAIL";
            $param[':EMAIL'] = $valores['EMAIL'];
        }
        if (!empty($valores['TELEFONO'])) {
            $consulta .= " AND TELEFONO = :TELEFONO";
            $param[':TELEFONO'] = $valores['TELEFONO'];
        }
        if (!empty($valores['NOMBRE'])) {
            $consulta .= " AND NOMBRE LIKE :NOMBRE";
            $param[':NOMBRE'] = "%" . $valores['NOMBRE'] . "%"; // Búsqueda parcial
        }
        if (!empty($valores['APELLIDOS'])) {
            $consulta .= " AND APELLIDOS LIKE :APELLIDOS";
            $param[':APELLIDOS'] = "%" . $valores['APELLIDOS'] . "%";
        }
        if (!empty($valores['CIUDAD'])) {
            $consulta .= " AND CIUDAD = :CIUDAD";
            $param[':CIUDAD'] = $valores['CIUDAD'];
        }
        if (!empty($valores['FECHA_CREACION'])) {
            $consulta .= " AND FECHA_CREACION = :FECHA_CREACION";
            $param[':FECHA_CREACION'] = $valores['FECHA_CREACION'];
        }
        if (!empty($valores['ROL'])) {
            $consulta .= " AND ROL = :ROL";
            $param[':ROL'] = $valores['ROL'];
        }

        $this->usuarios = array();  //Vaciamos el array de las situaciones entre consulta y consulta

        $this->db->ConsultaDatos($consulta, $param);

        $usu = null; //Inicializamos a nulo la variable que almacenara el objeto de retorno

        foreach ($this->db->filas as $fila) {
            $usu = new Usuario();
            $usu->setId($fila['id']);
            $usu->setEmail($fila['email']);
            $usu->setTelefono($fila['telefono']);
            $usu->setNombre($fila['nombre']);
            $usu->setApellidos($fila['apellidos']);
            $usu->setContrasena($fila['contrasena']);
            $usu->setCiudad($fila['ciudad']);
            $usu->setFechaCreacion($fila['fecha_creacion']);
            $usu->setRol($fila['rol']);

            $this->usuarios[] = $usu;   //Insertamos el objeto con los valores de esa fila en el array de objetos
        }
        return $this->usuarios;
    }

    public function insertar($usuario)      //Recibe como parámetro un objeto con los datos del usuario
    {
        $consulta = "INSERT INTO `Usuario`(`email`, `telefono`, `nombre`, `apellidos`, `contrasena`, `ciudad`, `fecha_creacion`, `rol`) VALUES (:EMAIL,:TELEFONO,:NOMBRE,:APELLIDOS,:CONTRASENA,:CIUDAD,:FECHA_CREACION,:ROL)";
        $param = array();

        $param[":EMAIL"] = $usuario->getEmail();
        $param[":TELEFONO"] = $usuario->getTelefono();
        $param[":NOMBRE"] = $usuario->getNombre();
        $param[":APELLIDOS"] = $usuario->getApellidos();
        $param[":CONTRASENA"] = $usuario->getContrasena();
        $param[":CIUDAD"] = $usuario->getCiudad();
        $param[":FECHA_CREACION"] = $usuario->getFechaCreacion();
        $param[":ROL"] = $usuario->getRol();


        $this->db->ConsultaSimple($consulta, $param);

    }

    public function actualizar($id, $usuario, $nuevo)          //Obtenemos el elemento a partir de su Id
    {
        $consulta = "UPDATE `Usuario` SET `email`=:EMAIL,`telefono`=:TELEFONO,`nombre`=:NOMBRE,`apellidos`=:APELLIDOS,`contrasena`=:CONTRASENA,`ciudad`=:CIUDAD WHERE id = :ID";

        $param = array();

        $param[":ID"] = $id;
        $param[":EMAIL"] = $nuevo->getEmail() ?? $usuario->getEmail();
        $param[":TELEFONO"] = $nuevo->getTelefono() ?? $usuario->getTelefono();
        $param[":NOMBRE"] = $nuevo->getNombre() ?? $usuario->getNombre();
        $param[":APELLIDOS"] = $nuevo->getApellidos() ?? $usuario->getApellidos();
        $param[":CONTRASENA"] = $nuevo->getContrasena() ?? $usuario->getContrasena();
        $param[":CIUDAD"] = $nuevo->getCiudad() ?? $usuario->getCiudad();


        $this->db->ConsultaSimple($consulta, $param);

    }
    public function eliminar($id)          //Obtenemos el elemento a partir de su Id
    {
        $consulta = "DELETE FROM Usuario WHERE id=:ID";
        $param = array(":ID" => $id);
        $this->db->ConsultaSimple($consulta, $param);
    }


}
