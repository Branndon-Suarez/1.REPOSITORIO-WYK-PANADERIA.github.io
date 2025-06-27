<?php
    require_once "../../CONEXION/CONEXION_PROYECTO.PHP";
    $obj = new Conexion_Proyecto();
    $conexion = $obj->conexion();

    $contraseña_cliente = mysqli_real_escape_string($conexion, $_POST['password_cliente']);
    $contraseña_con_hash = password_hash($contraseña_cliente, PASSWORD_DEFAULT);
    $id_cliente_fk = mysqli_real_escape_string($conexion, $_POST['id_cliente_fk']);
    $estado = "HABILITADO";

    /*Crea un array vacio para almacenar los mensajes y los muestro un mensaje guardado especifico dependiendo de:
        1. Si existe o no el id del cliente en el sistema.
        2. si está en uso o no el id del cliente para ser usado en como fk en la tabla de usuario cliente.
        3. Si no está en uso y no se repite procede a mostrar mensaje que se regisro exitosamente.*/
    $mensajes = [];

    //1.Verificar si la cédula existe no en el sistema para poder usada en el registro
    $verificar_existencia_fk = "SELECT * FROM CLIENTE WHERE Id_Cliente = '$id_cliente_fk'";
    $resultado_existencia = mysqli_query($conexion, $verificar_existencia_fk);

    if (mysqli_num_rows($resultado_existencia) == 0) {
        $mensajes['estado_fk'] = 'error';
        $mensajes['mensaje'] = "Error: La cédula ingresada no está registrada en el sistema.";
    } else{
        //2.Verificar si la cédula ya está registrada en la tabla USUARIO_CLIENTE
        $verificar_uso_fk = "SELECT * FROM USUARIO_CLIENTE WHERE Id_Cliente_FK_Usuario_Cliente = '$id_cliente_fk'";
        $resultado_uso = mysqli_query($conexion, $verificar_uso_fk);

        if (mysqli_num_rows($resultado_uso) > 0) {
            $mensajes['estado_fk'] = 'error';
            $mensajes['mensaje'] = "Error: El cliente con esta cédula ya está registrado.";
        } else{
            /*3.INSERTA FINALMENTE SE VERIFICA LAS 2 CONDICIONES ANTERIORES*/
            $sql = "INSERT INTO USUARIO_CLIENTE (Contraseña_Usuario_Cliente, Id_Cliente_FK_Usuario_Cliente, Estado_Usuario_Cliente)
                    VALUES ('$contraseña_con_hash', '$id_cliente_fk', '$estado')";
        
            if (mysqli_query($conexion, $sql)) {
                $mensajes['estado_fk'] = 'Confirmado';
                $mensajes['mensaje'] = "Registrado exitosamente.";
            } else {
                $mensajes['estado_fk'] = 'Rechazado';
                $mensajes['mensaje'] = "Error: " . mysqli_error($conexion);
            }
        }
    }    
    mysqli_close($conexion);

    /*A continuación el array "$mensajes" se convierte en un objeto JSON mediante el "echo json_encode($mensajes);" 
    para enviarlo como respuesta al navegador mediante el fetch y así empesar la promesa en js para ser respondida
    en cadena por los 2 .then()*/
    echo json_encode($mensajes);
?>