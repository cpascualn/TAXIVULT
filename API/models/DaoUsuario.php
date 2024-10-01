<?php

require_once APP_ROOT . '/entities/Usuario.php';
require_once APP_ROOT . '/database/LibreriaPDO.php';


class DaoUsuario extends DB
{
    public $usuarios = array();

    public function listar()       //Lista el contenido de la tabla
    {
        $consulta = 'SELECT * FROM usuario';

        $this->usuarios = array();  //Vaciamos el array de las situaciones entre consulta y consulta

        $this->ConsultaDatos($consulta);

        foreach ($this->filas as $fila) {
            $usu = new Usuario();
            $usu->__set("id", $fila['id']);
            $usu->__set("email", $fila['email']);
            $usu->__set("telefono", $fila['telefono']);
            $usu->__set("nombre", $fila['nombre']);
            $usu->__set("apellidos", $fila['apellidos']);
            $usu->__set("contrasena", $fila['contrasena']);
            $usu->__set("ciudad", $fila['ciudad']);
            $usu->__set("fecha_creacion", $fila['fecha_creacion']);
            $usu->__set("rol", $fila['rol']);

            $this->usuarios[] = $usu;   //Insertamos el objeto con los valores de esa fila en el array de objetos
        }
        return $this->usuarios;
    }

    public function obtener($id)          //Obtenemos el elemento a partir de su Id
    {
        $consulta = "SELECT * FROM usuario WHERE id=:ID";
        $param = array(":ID" => $id);

        $this->usuarios = array();  //Vaciamos el array de las situaciones entre consulta y consulta

        $this->ConsultaDatos($consulta, $param);

        $usu = null; //Inicializamos a nulo la variable que almacenarça el objeto de retorno

        if (count($this->filas) == 1) {
            $fila = $this->filas[0];  //Recuperamos la fila devuelta

            $usu = new Usuario();
            $usu->__set("id", $fila['id']);
            $usu->__set("email", $fila['email']);
            $usu->__set("telefono", $fila['telefono']);
            $usu->__set("nombre", $fila['nombre']);
            $usu->__set("apellidos", $fila['apellidos']);
            $usu->__set("contrasena", $fila['contrasena']);
            $usu->__set("ciudad", $fila['ciudad']);
            $usu->__set("fecha_creacion", $fila['fecha_creacion']);
            $usu->__set("rol", $fila['rol']);

        }

        return $usu;  //Retornamos el objeto con los datos del usuario
    }

    public function obtenerPorEmail($email)          //Obtenemos el elemento a partir de su Id
    {
        $consulta = "SELECT * FROM usuario WHERE email=:EMAIL";
        $param = array(":EMAIL" => $email);

        $this->usuarios = array();  //Vaciamos el array de las situaciones entre consulta y consulta

        $this->ConsultaDatos($consulta, $param);

        $usu = null; //Inicializamos a nulo la variable que almacenarça el objeto de retorno

        if (count($this->filas) == 1) {
            $fila = $this->filas[0];  //Recuperamos la fila devuelta

            $usu = new Usuario();
            $usu->__set("id", $fila['id']);
            $usu->__set("email", $fila['email']);
            $usu->__set("telefono", $fila['telefono']);
            $usu->__set("nombre", $fila['nombre']);
            $usu->__set("apellidos", $fila['apellidos']);
            $usu->__set("contrasena", $fila['contrasena']);
            $usu->__set("ciudad", $fila['ciudad']);
            $usu->__set("fecha_creacion", $fila['fecha_creacion']);
            $usu->__set("rol", $fila['rol']);

        }

        return $usu;  //Retornamos el objeto con los datos del usuario
    }

    public function buscar($valores){
        $consulta = "SELECT * FROM usuario WHERE 1=1";

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

        $this->ConsultaDatos($consulta, $param);

        $usu = null; //Inicializamos a nulo la variable que almacenara el objeto de retorno

        foreach ($this->filas as $fila) {
            $usu = new Usuario();
            $usu->__set("id", $fila['id']);
            $usu->__set("email", $fila['email']);
            $usu->__set("telefono", $fila['telefono']);
            $usu->__set("nombre", $fila['nombre']);
            $usu->__set("apellidos", $fila['apellidos']);
            $usu->__set("contrasena", $fila['contrasena']);
            $usu->__set("ciudad", $fila['ciudad']);
            $usu->__set("fecha_creacion", $fila['fecha_creacion']);
            $usu->__set("rol", $fila['rol']);

            $this->usuarios[] = $usu;   //Insertamos el objeto con los valores de esa fila en el array de objetos
        }
        return $this->usuarios;
    }

    public function insertar($usuario)      //Recibe como parámetro un objeto con los datos del usuario
    {
        $consulta = "INSERT INTO `usuario`(`email`, `telefono`, `nombre`, `apellidos`, `contrasena`, `ciudad`, `fecha_creacion`, `rol`) VALUES (:EMAIL,:TELEFONO,:NOMBRE,:APELLIDOS,:CONTRASENA,:CIUDAD,:FECHA_CREACION,:ROL)";
        $param = array();

        $param[":EMAIL"] = $usuario->__get("email");
        $param[":TELEFONO"] = $usuario->__get("telefono");
        $param[":NOMBRE"] = $usuario->__get("nombre");
        $param[":APELLIDOS"] = $usuario->__get("apellidos");
        $param[":CONTRASENA"] = $usuario->__get("contrasena");
        $param[":CIUDAD"] = $usuario->__get("ciudad");
        $param[":FECHA_CREACION"] = $usuario->__get("fecha_creacion");
        $param[":ROL"] = $usuario->__get("rol");


        $this->ConsultaSimple($consulta, $param);

    }

    public function actualizar($id, $usuario, $nuevo)          //Obtenemos el elemento a partir de su Id
    {
        $consulta = "UPDATE `usuario` SET `email`=:EMAIL,`telefono`=:TELEFONO,`nombre`=:NOMBRE,`apellidos`=:APELLIDOS,`contrasena`=:CONTRASENA,`ciudad`=:CIUDAD,
        `rol`=:ROL WHERE id = :ID";

        $param = array();

        $param[":ID"] = $id;
        $param[":EMAIL"] = $nuevo->__get("email") ?? $usuario->__get("email");
        $param[":TELEFONO"] = $nuevo->__get("telefono") ?? $usuario->__get("telefono");
        $param[":NOMBRE"] = $nuevo->__get("nombre") ?? $usuario->__get("nombre");
        $param[":APELLIDOS"] = $nuevo->__get("apellidos") ?? $usuario->__get("apellidos");
        $param[":CONTRASENA"] = $nuevo->__get("contrasena") ?? $usuario->__get("contrasena");
        $param[":CIUDAD"] = $nuevo->__get("ciudad") ?? $usuario->__get("ciudad");
        $param[":ROL"] = $nuevo->__get("rol") ?? $usuario->__get("rol");


        $this->ConsultaSimple($consulta, $param);

    }
    public function eliminar($id)          //Obtenemos el elemento a partir de su Id
    {
        $consulta = "DELETE FROM usuario WHERE id=:ID";
        $param = array(":ID" => $id);
        $this->ConsultaSimple($consulta, $param);
    }


}
