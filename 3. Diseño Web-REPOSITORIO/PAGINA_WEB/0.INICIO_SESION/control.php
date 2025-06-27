<?php

    session_start();

    require_once "../CONEXION/CONEXION_PROYECTO.PHP";
    $obj= new Conexion_Proyecto();
    $conexion=$obj->conexion();
    
    if (isset($_POST['boton_login'])) {
        $Cedula_fk=mysqli_real_escape_string($conexion,$_POST['Cedula_fk']);
        $contrasena=mysqli_real_escape_string($conexion,$_POST['contrasena']);
        /*
            NOTA: La función "mysqli_real_escape_string" hace que cualquier carácter especial ingresados por el usuario en
            las variables "$Cedula_fk" y "$contrasena" que guardan datos  cualquier carácter especial en la entrada 
            se trate como texto literal y no como parte de la consulta SQL.
        .*/

        $consulta_BD="SELECT * FROM USUARIO_EMPLEADO WHERE Id_Emple_FK_Usuario_Empleado='$Cedula_fk'";
        $resultado=mysqli_query($conexion,$consulta_BD);

        if (mysqli_num_rows($resultado)==1) {/**"mysqli_num_rows" obtiene el número de filas en el resultado de una consulta SQL */
            $fila=mysqli_fetch_assoc($resultado); /**"mysqli_fetch_assoc" obtiene una fila de resultados de una consulta SQL */

            /*Aquí se compara la contraseña ingresada por el usuario ($contrasena) con el hash almacenado 
            en la BD ($fila['Contraseña_Usuario_Empleado'])*/
            if(password_verify($contrasena,$fila['Contraseña_Usuario_Empleado'])){
                /*si la contraseña es igual a la de BD se ALMAENA e IGUALA en la variavle "$_SESSION['Cedula_fk']" la cédula ingresada por el usuario correspondiente a us contraseña*/
                $_SESSION['Cedula_fk']=$Cedula_fk;
                header("Location: ../1.1.EMPLEADO/Index_1.1.EMPLEADO.PHP");
                exit();
            }else{
                header("Location: index.php?errorusuario_empleado=existe_error");
                exit();
            }
        }else{
            header("Location: index.php?errorusuario_empleado=existe_error");
            exit();
        }
    }

?>