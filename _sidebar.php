

<?php
	if(!isset($_SESSION))
		session_start();
		
	$menuSide=array();

	
	$priv=isset($_SESSION["privilegio"])?$_SESSION["privilegio"]:"";
	$user=isset($_SESSION["user"])?$_SESSION["user"]:"";
	

	global $menuSide;
	$menuSide["Loggato"]=array();
	
	
	//Amministratore
	$menuSide["Loggato"]["1"]="";
	$menuSide["Loggato"]["1"].="<a href='InserisciPrenotazione.php' class='bottoneSidebar'>Inserisci Prenotazione</a>";
	$menuSide["Loggato"]["1"].="<a href='ModificaUtenti.php' class='bottoneSidebar'>Utenti</a>";	
	

	//Utenti
	$menuSide["Loggato"]["2"]="";
	$menuSide["Loggato"]["2"].="<a href='InserisciPrenotazione.php' class='bottoneSidebar'>Inserisci Prenotazione</a>";
	
	
	
	//Segreteria
	$menuSide["Loggato"]["3"]="";	
	$menuSide["Loggato"]["3"].="<a href='VisualizzaPrenotazioni.php' class='bottoneSidebar'>Visualizza Prenotazioni</a>";
	
	
	/*
	$menuSide["Loggato"]["3"]="";
	
	$menuSide["Loggato"]["4"]="";
	*/
	
	
	
	$menuSide["NonLoggato"]="";
	


	include_once("include/func.php");

	if(CheckSessionLogin())
	{
		if(isset($_SESSION["privilegio"]) && isset($menuSide["Loggato"][$_SESSION["privilegio"]]))
			echo $menuSide["Loggato"][$_SESSION["privilegio"]];
		else
			echo "Errore privilegio, <a href='Login.php?logOut=1'>LogOut</a>";
	}
	else
	{
		echo $menuSide["NonLoggato"];
	}
	
	
?>
