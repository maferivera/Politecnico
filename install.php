<?php
require_once 'includes/connect.php';

$sql = "CREATE TABLE IF NOT EXISTS Estudiante(
			user_id  int(255) auto_increment not null,
			Document varchar(255),
			Names	 varchar(50),
			Second_Names  varchar(255),
			Direction	varchar(255),
			Responsible varchar(255),
			TelephoneA  varchar(255),
			Password   varchar(255),
			Rol	  varchar(20),
			Image	   varchar(255),
			CONSTRAINT pk_Estudiante PRIMARY KEY(user_id)
		);";

$create_usuarios_table = mysqli_query($db, $sql);
$sql = "INSERT INTO Estudiante VALUES(NULL, '1053616651', 'Fernanda', 'Rivera',  'calle 5', 'Margarita Niquepa', '31245678', '".sha1("Password")."', '1', NULL)";
$insert_user = mysqli_query($db, $sql);




if($create_usuarios_table){
	echo "The table Estudiante was been created correctly !!";
}
?>
