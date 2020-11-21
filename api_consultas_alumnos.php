<?php
    include('../sitio/scripts_php/conexion_bd.php');
    $con = new ConexionBD();
    $conexion = $con->getConexion();

    //var_dump($conexion);

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $cadena_JSON = file_get_contents('php://input'); //Prepara PHP para recibir informacion a traves de HTTP

        if($cadena_JSON == false){
            $sql = "SELECT * FROM alumnos";
        } else {
            $datos = json_decode($cadena_JSON, true);
            $campo = $datos['campo'];
            $valor = $datos['valor'];
            
            $sql = "SELECT * FROM Alumnos WHERE $campo = '$valor'";
        }

        $res = mysqli_query($conexion, $sql);

        $datos['alumnos'] = array();
        if($res){
            //todo bien
            while($fila = mysqli_fetch_assoc($res)){
                $alumno = array();

                $alumno['nc'] = $fila['num_control'];
                $alumno['no'] = $fila['nombre'];
                $alumno['pa'] = $fila['primer_ap'];
                $alumno['sa'] = $fila['segundo_ap'];
                $alumno['ed'] = $fila['edad'];
                $alumno['se'] = $fila['semestre'];
                $alumno['ca'] = $fila['carrera'];

                array_push($datos['alumnos'], $alumno);
            }
            echo json_encode($datos);
        } else{
            //todo mal
            $respuesta['exito'] = false;
            $respuesta['mensaje'] = "Error en la consulta";
            $cad = json_encode($respuesta);
            var_dump($cad);
            //echo $cad;
        }
    } else {
        echo "No hay peticion HTTP";
    }
?>
