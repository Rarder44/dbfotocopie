

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
	$menuSide["Loggato"]["1"].="<a href='StoricoPrenotazioni.php' class='bottoneSidebar'>Visualizza Storico Prenotazioni</a>";
	$menuSide["Loggato"]["1"].="<a href='PrenotazioniCorrenti.php' class='bottoneSidebar'>Visualizza Prenotazioni Correnti</a>";
	
	//Utenti
	$menuSide["Loggato"]["2"]="";
	$menuSide["Loggato"]["2"].="<a href='InserisciPrenotazione.php' class='bottoneSidebar'>Inserisci Prenotazione</a>";
	
	
	
	//Segreteria
	$menuSide["Loggato"]["3"]="";	
	$menuSide["Loggato"]["3"].="<a href='StoricoPrenotazioni.php' class='bottoneSidebar'>Visualizza Storico Prenotazioni</a>";
	$menuSide["Loggato"]["3"].="<a href='PrenotazioniCorrenti.php' class='bottoneSidebar'>Visualizza Prenotazioni Correnti</a>";
	
	
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
