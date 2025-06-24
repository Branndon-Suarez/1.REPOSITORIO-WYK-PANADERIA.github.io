<?php

    session_start();

    require_once "../../CONEXION/CONEXION_PROYECTO.PHP";
    $obj= new Conexion_Proyecto();
    $conexion=$obj->conexion();
    
    if (isset($_POST['boton_login'])) {
        $Cedula_Cliente_fk=mysqli_real_escape_string($conexion,$_POST['Cedula_Cliente_fk']);
        $contrasena_cliente=mysqli_real_escape_string($conexion,$_POST['contrasena_cliente']);
        /*
            NOTA: La función "mysqli_real_escape_string" hace que cualquier carácter especial ingresados por el usuario en
            las variables "$Cedula_Cliente_fk" y "$contrasena_cliente" que guardan datos  cualquier carácter especial en la entrada 
            se trate como texto literal y no como parte de la consulta SQL.
        .*/

        $consulta_BD="SELECT * FROM USUARIO_CLIENTE WHERE Id_Cliente_FK_Usuario_Cliente='$Cedula_Cliente_fk'";
        $resultado=mysqli_query($conexion,$consulta_BD);

        if (mysqli_num_rows($resultado)==1) {/**"mysqli_num_rows" obtiene el número de filas en el resultado de una consulta SQL */
            $fila=mysqli_fetch_assoc($resultado); /**"mysqli_fetch_assoc" obtiene una fila de resultados de una consulta SQL */

            /*Aquí se compara la contraseña ingresada por el usuario ($contrasena_cliente) con el hash almacenado 
            en la BD ($fila['Contraseña_Usuario_Cliente'])*/
            if(password_verify($contrasena_cliente,$fila['Contraseña_Usuario_Cliente'])){
                /*si la contraseña es igual a la de BD se ALMAENA e IGUALA en la variavle "$_SESSION['Cedula_Cliente_fk']" la cédula ingresada por el usuario*/
                $_SESSION['Cedula_Cliente_fk']=$Cedula_Cliente_fk;
                header("Location: ../../4.1.PRODUCTO/Index_4.1.PROD-CLIENTE.PHP");
                exit();
            }else{
                header("Location: Index-LOGIN_CLIENTE.php?errorusuario_empleado=existe_error");
                exit();
            }
        }else{
            header("Location: Index-LOGIN_CLIENTE.php?errorusuario_empleado=existe_error");
            exit();
        }
    }

?>