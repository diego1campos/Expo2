CREATE USER 'isadeli'@'localhost' IDENTIFIED BY '123456';
/*Otorgar privilegios ='DD*/
/*especifico ='D*/
GRANT ALL PRIVILEGES ON isadeli.* TO 'isadeli'@'localhost';

/*GRANT [permiso] ON [nombre de bases de datos].[nombre de tabla] TO ‘[nombre de usuario]’@'localhost';
/*Otorgar privilegios ='DD*/

/*Actualizar los privilegios ='DD*/
/*FLUSH PRIVILEGES;
/*remover un permiso*/
/*REVOKE [permiso] ON [nombre de base de datos].[nombre de tabla] FROM ‘[nombre de usuario]’@‘localhost’;

/*cerrar cesion del usuario en consola*/
/*mysql -u [nombre de usuario]-p