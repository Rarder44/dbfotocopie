<?php
	//Collegamento al Database
	$link =new mysqli("localhost", "root", "","dbfotocopie");		// IP - username - password - DBname
	if ($link->connect_errno) 
		die('Could not connect: ' . $link->connect_error);
	
?>