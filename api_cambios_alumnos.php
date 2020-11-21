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
            $no = $datos['no'];
            $pa = $datos['pa'];
            $sa = $datos['sa'];
            $ed = $datos['ed'];
            $se = $datos['se'];
            $ca = $datos['ca'];
    
            $sql = "UPDATE alumnos SET nombre='$no', primer_ap='$pa', segundo_ap='$sa', edad=$ed, semestre=$se, carrera='$ca' WHERE num_control='$nc'";
            $res = mysqli_query($conexion, $sql);
    
            $respuesta = array();
            if($res){
                //todo bien
                $respuesta['exito'] = true;
                $respuesta['mensaje'] = "Cambios realizados correctamente";
                $cad = json_encode($respuesta);
                var_dump($cad);
                //echo $cad;
            } else{
                //todo mal
                $respuesta['exito'] = false;
                $respuesta['mensaje'] = "Error al realizar los cambios";
                $cad = json_encode($respuesta);
                var_dump($cad);
                //echo $cad;
            }
        }
    } else {
        echo "No hay peticion HTTP";
    }
?>
