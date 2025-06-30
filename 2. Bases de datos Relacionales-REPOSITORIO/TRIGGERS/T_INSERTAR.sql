USE PROYECTO_WYK;

														/*TRIGGERS DE INSERTAR*/
    
                                                        /*👮‍TRIGGER INSERTAR CARGO👮‍*/ 
                                                        
CREATE TABLE INSERTAR_CARGO
(ID_INSERT_CARGO INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
ACCION_INSERT_CARGO VARCHAR (200) NOT NULL,
FECHA_EJECUTO_INSERT_CARGO DATETIME NOT NULL);

DELIMITER $
CREATE TRIGGER TRIGGER_INSERTAR_CARGO
AFTER INSERT ON CARGO
FOR EACH ROW
BEGIN
	INSERT INTO INSERTAR_CARGO (ACCION_INSERT_CARGO,FECHA_EJECUTO_INSERT_CARGO)
	VALUES ('SE INSERTO CORRECTAMENTE', NOW());
END $

INSERT INTO CARGO (Nom_Cargo,Estado_Cargo)
VALUES ('Administrador',1);

SELECT * FROM INSERTAR_CARGO;
SELECT * FROM CARGO;                                                        
                                                        

                                                        