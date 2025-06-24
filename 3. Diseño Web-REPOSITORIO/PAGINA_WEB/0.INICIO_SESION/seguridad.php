<?php
    session_start();

    require_once "../CONEXION/CONEXION_PROYECTO.PHP";
    $obj = new Conexion_Proyecto();
    $conexion = $obj->conexion();


    /*--- 🚀 VERIFICAR INICIO SESION ---*/
    //Aqui lo que se hace es si el usuario intenta entrar modificando la URL a un formulario SIN INICIAR SESIÓN
    //lo redirija inmediatamente al archivo de iniciar sesion y no directamente a los formularios.
    if (!isset($_SESSION['Cedula_fk']) && !isset($_SESSION['Cedula_Cliente_fk'])) {
        header("Location: ../0.INICIO_SESION/index.php");
        exit();
    }
    /*--- 🏁 VERIFICAR INICIO SESION ---*/


    /*--- 🚀 DETECTAR TIPO DE USUARIO ---*/
    if (isset($_SESSION['Cedula_fk'])) {
        /*Esta parte es importante porque ya cuando se verifico que se inició sesión COMO ADMIN/EMPLEADO, la cédula que ingresó el usuario
        para a igualarse a una variable, la "$id_usuario". Esto es importante ya que dicha variable se utilizará en los INNER JOIN
        para obtener datos específicos, entre ellos el rol SOLAMENTE DEL ADMIN Y EMPLEADO y por ende una parte del sistema de roles funcione.*/
        $id_usuario = $_SESSION['Cedula_fk'];

        /*--- 🚀 CONSULTA ROL (ADMIN/EMPLEADO) ---*/
        $consulta_rol = "
        SELECT cargo.Nom_Cargo 
        FROM USUARIO_EMPLEADO user
        JOIN EMPLEADO emple ON user.Id_Emple_FK_Usuario_Empleado = emple.Id_Emple
        JOIN CARGO cargo ON emple.Id_Cargo_FK_Emple = cargo.Id_Cargo
        WHERE user.Id_Emple_FK_Usuario_Empleado = '$id_usuario'";
        $resultado_rol = mysqli_query($conexion, $consulta_rol);
        /*--- 🏁 CONSULTA ROL (ADMIN/EMPLEADO) ---*/

        /*--- 🚀 OBTENER ROL (ADMIN/EMPLEADO) ---*/
        if ($resultado_rol && mysqli_num_rows($resultado_rol) == 1) {/*"mysqli_num_rows" obtiene el número de filas que resultaron de la consulta SQL ejecutada con mysqli_query
                                                                        anteriormente. Si "mysqli_num_rows" es 1, significa que la consulta encontró exactamente un cliente 
                                                                        que cumple la condición especificada en la consulta SQL.*/
            $fila_rol = mysqli_fetch_assoc($resultado_rol);
            /*⚠️ aqui CREE LA VARIABLE ROL mediante la tabla de cargo para mirar las dos opciones, si es admin y empleado*/
            $_SESSION['rol_usuario'] = $fila_rol['Nom_Cargo'];
        } else {
            //Maneja el error si no se encuentra el rol
            $_SESSION['rol_usuario'] = 'Rol no disponible';
        }
        /*--- 🏁 OBTENER ROL (ADMIN/EMPLEADO) ---*/

        /*--- 🚀 CONSULTA NOMBRE (ADMIN/EMPLEADO) ---*/
        $consulta_nombre = "
            SELECT emple.Nom_Emple
            FROM USUARIO_EMPLEADO user
            JOIN EMPLEADO emple ON user.Id_Emple_FK_Usuario_Empleado = emple.Id_Emple
            WHERE user.Id_Emple_FK_Usuario_Empleado = '$id_usuario'";
        $resultado = mysqli_query($conexion, $consulta_nombre);
        /*--- 🏁 CONSULTA NOMBRE (ADMIN/EMPLEADO) ---*/

        /*--- 🚀 OBTENER NOMBRE (ADMIN/EMPLEADO) ---*/
        if ($resultado && mysqli_num_rows($resultado) == 1) {
            $fila = mysqli_fetch_assoc($resultado);
            $_SESSION['nombre_usuario'] = $fila['Nom_Emple'];
        } else {
            //Maneja el error si no se encuentra el nombre
            $_SESSION['nombre_usuario'] = 'Nombre no disponible';
        }
        /*--- 🏁 OBTENER NOMBRE (ADMIN/EMPLEADO) ---*/

        /*--- 🚀 CONSULTA GMAIL (ADMIN/EMPLEADO) ---*/
        $consulta_email="
        SELECT gme.Email_Emple
        FROM USUARIO_EMPLEADO user
        JOIN EMAIL_EMPLEADO gme ON user.Id_Emple_FK_Usuario_Empleado = gme.Id_Emple_FK_Email_Emple
        WHERE user.Id_Emple_FK_Usuario_Empleado = '$id_usuario'";
        $resultado_email_emple = mysqli_query($conexion, $consulta_email);
        /*--- 🏁 CONSULTA GMAIL (ADMIN/EMPLEADO) ---*/

        /*--- 🚀 OBTENER GMAIL (ADMIN/EMPLEADO) ---*/
        if ($resultado_email_emple && mysqli_num_rows($resultado_email_emple) == 1) {
            $fila_email_emple = mysqli_fetch_assoc($resultado_email_emple);
            $_SESSION['email_usuario'] = $fila_email_emple['Email_Emple'];
        } else {
            //Maneja el error si no se encuentra el email
            $_SESSION['email_usuario'] = 'Email no disponible';
        }
        /*--- 🏁 OBTENER GMAIL (ADMIN/EMPLEADO) ---*/

    } elseif (isset($_SESSION['Cedula_Cliente_fk'])) {
        /*⚠️ aqui CREE LA VARIABLE ROL igualandola a CLIENTE ya que esta parte del código forma parte de lo que NO SE INICION COMO ADAMIN/EMPLEADO y por ende es CLIENTE*/
        $_SESSION['rol_usuario'] = 'CLIENTE';

        /*Esta parte es importante porque ya cuando se verifico que se inició sesión COMO CLIENTE, la cédula que ingresó el usuario
        para a igualarse a una variable, la "$id_usuario_cliente". Esto es importante ya que dicha variable se utilizará en los INNER JOIN
        para obtener especificamente el rol CLIENTE y terminando el sistema de roles.*/
        $id_usuario_cliente = $_SESSION['Cedula_Cliente_fk'];

        /*--- 🚀 CONSULTA NOMBRE (CLIENTE) ---*/
        $consulta_cliente = "
            SELECT c.Nom_Cliente
            FROM USUARIO_CLIENTE uc
            JOIN CLIENTE c ON uc.Id_Cliente_FK_Usuario_Cliente = c.Id_Cliente
            WHERE uc.Id_Cliente_FK_Usuario_Cliente = '$id_usuario_cliente'";
        $resultado_nombre_cliente = mysqli_query($conexion, $consulta_cliente);
        /*--- 🏁 CONSULTA NOMBRE (CLIENTE) ---*/

        /*--- 🚀 OBTENER NOMBRE (CLIENTE) ---*/
        if ($resultado_nombre_cliente && mysqli_num_rows($resultado_nombre_cliente) == 1) {
            $fila = mysqli_fetch_assoc($resultado_nombre_cliente);
            $_SESSION['nombre_usuario_cliente'] = $fila['Nom_Cliente'];
        } else {
            //Maneja el error si no se encuentra el nombre
            $_SESSION['nombre_usuario_cliente'] = 'Nombre no disponible';
        }
        /*--- 🏁 OBTENER NOMBRE (CLIENTE) ---*/

        /*--- 🚀 CONSULTA NOMBRE (CLIENTE) ---*/
        $consultar_email_cliente ="
            SELECT ec.Email_Cliente
            FROM EMAIL_CLIENTE ec
            JOIN CLIENTE c ON ec.Id_Cliente_FK_Email_Cliente = c.Id_Cliente
            WHERE ec.Id_Cliente_FK_Email_Cliente = '$id_usuario_cliente'";
        $resultado_email_cliente=mysqli_query($conexion,$consultar_email_cliente);
        /*--- 🏁 CONSULTA NOMBRE (CLIENTE) ---*/

        /*--- 🚀 OBTENER EMIAL (CLIENTE) ---*/
        if ($resultado_email_cliente && mysqli_num_rows($resultado_email_cliente) == 1) {
            $fila= mysqli_fetch_assoc($resultado_email_cliente);
            $_SESSION['email_usuario_cliente'] = $fila['Email_Cliente'];
        } else {
            //Maneja el error si no se encuentra el nombre
            $_SESSION['email_usuario_cliente'] = 'Email no disponible';
        }
        /*--- 🚀 OBTENER EMIAL (CLIENTE) ---*/
    }
?>

