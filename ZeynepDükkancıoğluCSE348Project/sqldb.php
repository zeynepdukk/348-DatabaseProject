<?php 

try {

	$sql_object=new PDO("mysql:host=localhost;dbname=twitter_clone;charset=utf8",'root','');
}

catch (PDOExpception $e) {

	echo $e->getMessage();
}


 ?>