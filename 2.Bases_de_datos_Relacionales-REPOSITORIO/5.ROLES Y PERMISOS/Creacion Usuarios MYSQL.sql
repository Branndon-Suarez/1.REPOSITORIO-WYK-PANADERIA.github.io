-- 1. Vamos a iniciar por crear un usuario nuevo desde la consola de MySQL:

CREATE USER 'nombre_usuario'@'localhost' IDENTIFIED BY 'tu_contrasena';

-- Ejemplo: 
CREATE USER 'leo'@'localhost' IDENTIFIED BY '12345';
CREATE USER 'admin'@'localhost' IDENTIFIED BY 'admin123';
CREATE USER 'dba'@'localhost'IDENTIFIED BY 'dba123';
-- 2. Proporcionar el acceso requerido al usuario con la información que requiere.

GRANT ALL PRIVILEGES ON * . * TO 'nombre_usuario'@'localhost'; 

-- Ejemplo: 
GRANT ALL PRIVILEGES ON * . * TO 'leo'@'localhost';
GRANT ALL PRIVILEGES ON * . * TO 'admin'@'localhost';
GRANT ALL PRIVILEGES ON * . * TO 'dba'@'localhost';

-- 3. Una vez otorgado los servicios, hay que asegurarse siempre de refrescar todos los privilegios.
FLUSH PRIVILEGES; 

-- 4. Como se vio en sesiones anteriores ingresamos al motor con el usuario nuevo por medio de la sentencia:
Ejemplo: 
mysql -h localhost -u leo -p
mysql -h localhost -u admin -p 
