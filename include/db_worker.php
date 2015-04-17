<?php
	if(!isset($_SESSION))
		session_start();
	
	include ("JSON.php");
	include ("func.php");
	include ("conn.php");
	
	//funzione che cambia l'email
	if(isset($_POST["CambiaMail"]) && isset($_POST["NewMail"]))
	{
		$q="update utenti set utenti.`E-mail`='$_POST[NewMail]' where utenti.Username = '$_SESSION[user]' ";
		
		$r=$link->query($q);
		if (!$r) {
			$message  = 'Errore query: ' . $link->error . "<br>";
			$message .= 'Whole query: ' . $q;
			SendError($message );
		}
		else
		{
			SendDato(null,"<span style='color: rgb(38, 187, 63);font-size: 19px;'>Mail cambiata con successo!</span>");
		}

	}
	
	else if(isset($_POST["CambiaPassword"]) && isset($_POST["NewPass"]) && isset($_POST["OldPass"]))
	{
		$q="select ID from utenti where `password`='".md5($_POST["OldPass"])."' and username='$_SESSION[user]'";
		$arr=array();
		$r=$link->query($q);
		if($row=$r->fetch_assoc())
		{
			$q="update utenti  set `password`='".md5($_POST["NewPass"])."' where username='$_SESSION[user]'";
			
			$r=$link->query($q);
			if (!$r) {
				$message  = 'Errore query: ' . $link->error . "<br>";
				$message .= 'Whole query: ' . $q;
				SendError($message );
			}
			else
			{
				SendDato(null,"<span style='color: rgb(38, 187, 63);font-size: 19px;'>Password cambiata con successo!</span>");
			}
		}
		else
		{
			SendError("<span style='color:red;font-size: 19px;'>La password vecchia non è corretta</span>");
		}
	}
	
	
	
	else if(isset($_POST["CambiaPassword"]) && isset($_POST["IDUtente"]) && isset($_POST["NewPass"]) )
	{
		if(CheckSessionLogin())
		{
			if(isset($_SESSION["privilegio"])  && isset($_SESSION["user"])  )
			{
				$priv=$_SESSION["privilegio"];
				$user=$_SESSION["user"];
				
				
				//superadmin 
				if($priv==0)
				{
					$q="update utenti  set `password`='".md5($_POST["NewPass"])."' where ID='$_POST[IDUtente]'";
			
					$r=$link->query($q);
					if (!$r) {
						$message  = 'Errore query: ' . $link->error . "<br>";
						$message .= 'Whole query: ' . $q;
						SendError($message);
					}
					else
					{
						SendDato(null,"<span style='color: rgb(38, 187, 63);font-size: 19px;'>Password cambiata!</span>");
					}
				}
				
				//Preside -> ottiene tutti gli utenti legati alle strutture
				else if($priv==1)
				{
					
					$q="update utenti set `password`='".md5($_POST["NewPass"])."' where ID=$_POST[IDUtente] and ID in ";
					$q.="( select distinct t1.ID from (SELECT * FROM utenti) as t1 inner join `utenti-strutture` on ( `utenti-strutture`.IDUtente=t1.ID) where IDStruttura in ";
					$q.="( SELECT strutture.ID FROM strutture where ID_istituto in ( SELECT distinct Strutture.id_istituto FROM (SELECT * FROM utenti) as t2 inner join privilegi on ";
					$q.="( t2.privilegio = privilegi.ID) inner join `utenti-strutture` on ( `utenti-strutture`.IDUtente=t2 .ID) inner join strutture on ( strutture.ID = `utenti-strutture`.IDStruttura) ";
					$q.="where t2.username='$user' ) ) and username<>'$user')";
					
					
					$r=$link->query($q);
					if (!$r) {
						$message  = 'Errore query: ' . $link->error . "<br>";
						$message .= 'Whole query: ' . $q;
						SendError($message);
					}
					else
					{
						SendDato(null,"<span style='color: rgb(38, 187, 63);font-size: 19px;'>Password cambiata!</span>");
					}
				}
				else
					SendError("Autorizzazioni insufficenti");
			}
			else
				SendError("Errore nel recupero del privilegio/user");
		}
		else
			SendError("Autorizzazioni insufficenti");
	}
	
	
	function objectToArray($d)
	{
		if (is_object($d)) 
		{
			$d = get_object_vars($d);
		}
		if (is_array($d)) 
		{
			return array_map(__FUNCTION__, $d);
		}
		else 
		{
			return $d;
		}
	}
	
	
	function SendError($mess)
	{
		$arr=array();
		
		$arr["err"]=1;
		$arr["mess"]=$mess;
		$arr["dato"]="";
		$json = new Services_JSON();
		echo $json->encode($arr);
	}
	function SendDato($dato,$mess="")
	{
		$arr=array();
		
		$arr["err"]=0;
		$arr["mess"]=$mess;
		$arr["dato"]=$dato;
		$json = new Services_JSON();
		echo $json->encode($arr);
	}
?>