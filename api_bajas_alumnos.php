<?php
    include('../sitio/scripts_php/conexion_bd.php');
    $con = new ConexionBD();
    $conexion = $con->getConexion();

    //var_dump($conexion);

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $cadena_JSON = file_get_contents('php://input'); //Prepara PHP para recibir informacion a traves de HTTP

        if($cadena_JSON == false){
            echo "No hay cadena JSON";
        } else {
            $datos = json_decode($cadena_JSON, true);
            $nc = $datos['nc'];

            $sql = "DELETE FROM alumnos WHERE num_control ='$nc'";
            $res = mysqli_query($conexion, $sql);
    
            $respuesta = array();
            if($res){
                //todo bien
                $respuesta['exito'] = true;
                $respuesta['mensaje'] = "Eliminacion correcta";
                $cad = json_encode($respuesta);
                var_dump($cad);
                //echo $cad;
            } else{
                //todo mal
                $respuesta['exito'] = false;
                $respuesta['mensaje'] = "Error en la eliminacion";
                $cad = json_encode($respuesta);
                var_dump($cad);
                //echo $cad;
            }
        }
    } else {
        echo "No hay peticion HTTP";
    }
?>
