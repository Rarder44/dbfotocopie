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
	
	
	
	else if(isset($_POST["LoadPrivilegiUtenti"]))
	{
		if(CheckSessionLogin())
		{
			if(isset($_SESSION["privilegio"])  && isset($_SESSION["user"])  )
			{
				$priv=$_SESSION["privilegio"];
				$user=$_SESSION["user"];
				
				
				//superadmin -> ottiene tutti gli utenti
				if($priv==1)
				{
					$q="SELECT * from privilegi";
					$arr=array();
					
					$r=$link->query($q);
					if (!$r) {
						$message  = 'Errore query: ' . $link->error . "<br>";
						$message .= 'Whole query: ' . $q;
						SendError($message );
					}
					else
					{
						while($row=$r->fetch_assoc())
						{
							$arr[]=$row;
						}
						SendDato($arr);
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
	
	
	else if(isset($_POST["LoadCorsiClassi"]))
	{
		if(CheckSessionLogin())
		{
			if(isset($_SESSION["privilegio"])  && isset($_SESSION["user"])  )
			{
				$priv=$_SESSION["privilegio"];
				$user=$_SESSION["user"];
				
				
				//superadmin -> ottiene tutti gli utenti
				if($priv==1)
				{
					$q="SELECT * from corsi";
					$arr=array();
					
					$r=$link->query($q);
					if (!$r) {
						$message  = 'Errore query: ' . $link->error . "<br>";
						$message .= 'Whole query: ' . $q;
						SendError($message );
					}
					else
					{
						while($row=$r->fetch_assoc())
						{
							$arr[]=$row;
						}
						SendDato($arr);
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
	
	
	else if(isset($_POST["LoadClassiAssociazioni"]))
	{
		if(CheckSessionLogin())
		{
			if(isset($_SESSION["privilegio"])  && isset($_SESSION["user"])  )
			{
				$priv=$_SESSION["privilegio"];
				$user=$_SESSION["user"];
				
				
				//superadmin -> ottiene tutti gli utenti
				if($priv==1)
				{
					$q="SELECT classi.ID,CONCAT(`Numero classe`,Sezione,\" \",corsi.nome) as nome from classi INNER JOIN corsi on ( corsi.ID=Corso)";
					$arr=array();
					
					$r=$link->query($q);
					if (!$r) {
						$message  = 'Errore query: ' . $link->error . "<br>";
						$message .= 'Whole query: ' . $q;
						SendError($message );
					}
					else
					{
						while($row=$r->fetch_assoc())
						{
							$arr[]=$row;
						}
						SendDato($arr);
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
	
	
	else if(isset($_POST["LoadListaUtenti"]))
	{
		if(CheckSessionLogin())
		{
			if(isset($_SESSION["privilegio"])  && isset($_SESSION["user"])  )
			{
				$priv=$_SESSION["privilegio"];
				$user=$_SESSION["user"];
				
				
				//superadmin -> ottiene tutti gli utenti
				if($priv==1)
				{
					$q="SELECT ID,Nome,Cognome FROM utenti";
					$arr=array();
					
					$r=$link->query($q);
					if (!$r) {
						$message  = 'Errore query: ' . $link->error . "<br>";
						$message .= 'Whole query: ' . $q;
						SendError($message );
					}
					else
					{
						while($row=$r->fetch_assoc())
						{
							$arr[]=$row;
						}
						SendDato($arr);
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
	
	else if(isset($_POST["LoadListaUtentiCerca"])  && isset($_POST["campo"])  && isset($_POST["pattern"]))
	{
		if(CheckSessionLogin())
		{
			if(isset($_SESSION["privilegio"])  && isset($_SESSION["user"])  )
			{
				$priv=$_SESSION["privilegio"];
				$user=$_SESSION["user"];
				
				
				//superadmin -> ottiene tutti gli utenti
				if($priv==1)
				{
					$q="SELECT ID,Nome,Cognome FROM utenti where ".$_POST["campo"]." LIKE '%".$_POST["pattern"]."%'";
					$arr=array();
					
					$r=$link->query($q);
					if (!$r) {
						$message  = 'Errore query: ' . $link->error . "<br>";
						$message .= 'Whole query: ' . $q;
						SendError($message );
					}
					else
					{
						while($row=$r->fetch_assoc())
						{
							$arr[]=$row;
						}
						SendDato($arr);
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
	
	
	
	else if(isset($_POST["LoadDatiUtente"]) && isset($_POST["ID"]))
	{
		if(CheckSessionLogin())
		{
			if(isset($_SESSION["privilegio"])  && isset($_SESSION["user"])  )
			{
				$priv=$_SESSION["privilegio"];
				$user=$_SESSION["user"];
				
				
				//superadmin -> ottiene tutti gli utenti
				if($priv==1)
				{
					$q="SELECT ID,Nome,Cognome,Username,`E-mail`,Privilegio from utenti WHERE ID=".$_POST["ID"];
					$arr=array();
					
					$r=$link->query($q);
					if (!$r) {
						$message  = 'Errore query: ' . $link->error . "<br>";
						$message .= 'Whole query: ' . $q;
						SendError($message );
					}
					else
					{
						while($row=$r->fetch_assoc())
						{
							$arr[]=$row;
						}
						SendDato($arr);
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
	
	else if(isset($_POST["RemoveUtente"]) && isset($_POST["ID"]))
	{
		if(CheckSessionLogin())
		{
			if(isset($_SESSION["privilegio"])  && isset($_SESSION["user"])  )
			{
				$priv=$_SESSION["privilegio"];
				$user=$_SESSION["user"];
				
				
				//superadmin -> ottiene tutti gli utenti
				if($priv==1)
				{
					$q="delete from utenti where ID=$_POST[ID];";
					$arr=array();
					
					$r=$link->query($q);
					if (!$r) {
						$message  = 'Errore query: ' . $link->error . "<br>";
						$message .= 'Whole query: ' . $q;
						SendError($message );
					}
					else
					{
						SendDato(null,"Utente eliminato correttamente");
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
	
	else if(isset($_POST["AddUtente"]) && isset($_POST["Nome"])&& isset($_POST["Cognome"])&& isset($_POST["Mail"])&& isset($_POST["Username"])&& isset($_POST["Password"])&& isset($_POST["Privilegio"]))
	{
		if(CheckSessionLogin())
		{
			if(isset($_SESSION["privilegio"])  && isset($_SESSION["user"])  )
			{
				$priv=$_SESSION["privilegio"];
				$user=$_SESSION["user"];
				
				
				//superadmin -> ottiene tutti gli utenti
				if($priv==1)
				{
					$q="SELECT count(ID) as c from utenti WHERE Username='".$_POST["Username"]."'";
					
					
					$r=$link->query($q);
					if (!$r) {
						$message  = 'Errore query: ' . $link->error . "<br>";
						$message .= 'Whole query: ' . $q;
						SendError($message );
					}
					else
					{
						
						if($row=$r->fetch_assoc())
						{
							if($row["c"]>0)
								SendError("Username già presente nel database");
							
							else
							{
								$q="insert INTO utenti(Nome,Cognome,`E-mail`,Username,`Password`,Privilegio) values('$_POST[Nome]','$_POST[Cognome]','$_POST[Mail]','$_POST[Username]',md5('$_POST[Password]'),$_POST[Privilegio])";
								$arr=array();
								
								$r=$link->query($q);
								if (!$r) {
									$message  = 'Errore query: ' . $link->error . "<br>";
									$message .= 'Whole query: ' . $q;
									SendError($message );
								}
								else
								{
									SendDato(null,"Utente aggiunto correttamente");
								}
							}
						}
						else
							SendError("Errore nel recupero degli Utenti");

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
	
	else if(isset($_POST["EditUtente"]) && isset($_POST["ID"])&& isset($_POST["Nome"])&& isset($_POST["Cognome"])&& isset($_POST["Mail"])&& isset($_POST["Username"])&& isset($_POST["Privilegio"]))
	{
		if(CheckSessionLogin())
		{
			if(isset($_SESSION["privilegio"])  && isset($_SESSION["user"])  )
			{
				$priv=$_SESSION["privilegio"];
				$user=$_SESSION["user"];
				
				
				//superadmin -> ottiene tutti gli utenti
				if($priv==1)
				{
					$q="";
					if( isset($_POST["Password"]))
					{
						$q="update utenti set Nome='$_POST[Nome]', Cognome='$_POST[Cognome]',`E-mail`='$_POST[Mail]',Username='$_POST[Username]',`Password`=md5('$_POST[Password]'),Privilegio=$_POST[Privilegio] where ID=$_POST[ID]";
					}
					else
					{
						$q="update utenti set Nome='$_POST[Nome]', Cognome='$_POST[Cognome]',`E-mail`='$_POST[Mail]',Username='$_POST[Username]',Privilegio=$_POST[Privilegio] where ID=$_POST[ID]";
					}
					
					$arr=array();
					
					$r=$link->query($q);
					if (!$r) {
						$message  = 'Errore query: ' . $link->error . "<br>";
						$message .= 'Whole query: ' . $q;
						SendError($message );
					}
					else
					{
						SendDato(null,"Utente eliminato correttamente");
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
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	else if(isset($_POST["LoadListaClassi"]))
	{
		if(CheckSessionLogin())
		{
			if(isset($_SESSION["privilegio"])  && isset($_SESSION["user"])  )
			{
				$priv=$_SESSION["privilegio"];
				$user=$_SESSION["user"];
				
				
				//superadmin -> ottiene tutti gli utenti
				if($priv==1)
				{
					$q="SELECT classi.ID,CONCAT(`Numero classe`,Sezione,\" \",corsi.nome) as Nome from classi INNER JOIN corsi on ( corsi.ID=Corso) ORDER BY Corso,Sezione,`Numero classe`";
					$arr=array();
					
					$r=$link->query($q);
					if (!$r) {
						$message  = 'Errore query: ' . $link->error . "<br>";
						$message .= 'Whole query: ' . $q;
						SendError($message );
					}
					else
					{
						while($row=$r->fetch_assoc())
						{
							$arr[]=$row;
						}
						SendDato($arr);
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
	
	
	
	else if(isset($_POST["LoadDatiClasse"]) && isset($_POST["ID"]))
	{
		if(CheckSessionLogin())
		{
			if(isset($_SESSION["privilegio"])  && isset($_SESSION["user"])  )
			{
				$priv=$_SESSION["privilegio"];
				$user=$_SESSION["user"];
				
				
				//superadmin -> ottiene tutti gli utenti
				if($priv==1)
				{
					$q="SELECT ID,`Numero classe`,`Sezione`,`Corso`,`Numero alunni`,`Fotocopie rimanenti` FROM `classi` WHERE ID=".$_POST["ID"];
					$arr=array();
					
					$r=$link->query($q);
					if (!$r) {
						$message  = 'Errore query: ' . $link->error . "<br>";
						$message .= 'Whole query: ' . $q;
						SendError($message );
					}
					else
					{
						while($row=$r->fetch_assoc())
						{
							$arr[]=$row;
						}
						SendDato($arr);
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

	else if(isset($_POST["AddClasse"]) && isset($_POST["Numero"])&& isset($_POST["Sezione"])&& isset($_POST["Corso"])&& isset($_POST["Numero_Alunni"])&& isset($_POST["Fotocopie"]))
	{
		if(CheckSessionLogin())
		{
			if(isset($_SESSION["privilegio"])  && isset($_SESSION["user"])  )
			{
				$priv=$_SESSION["privilegio"];
				$user=$_SESSION["user"];
				
				
				//superadmin -> ottiene tutti gli utenti
				if($priv==1)
				{
					$q="SELECT count(ID)as c from classi where `Numero classe`=$_POST[Numero] and Sezione='$_POST[Sezione]' and Corso=$_POST[Corso] ";
					
					
					$r=$link->query($q);
					if (!$r) {
						$message  = 'Errore query: ' . $link->error . "<br>";
						$message .= 'Whole query: ' . $q;
						SendError($message );
					}
					else
					{
						
						if($row=$r->fetch_assoc())
						{
							if($row["c"]>0)
								SendError("La classe è già presente nel database");
							
							else
							{
								$q="INSERT into classi (`Numero classe`,Sezione,Corso,`Numero alunni`,`Fotocopie rimanenti`) VALUES($_POST[Numero],'$_POST[Sezione]',$_POST[Corso],$_POST[Numero_Alunni],$_POST[Fotocopie])";
								$arr=array();
								
								$r=$link->query($q);
								if (!$r) {
									$message  = 'Errore query: ' . $link->error . "<br>";
									$message .= 'Whole query: ' . $q;
									SendError($message );
								}
								else
								{
									SendDato(null,"Classe aggiunta correttamente");
								}
							}
						}
						else
							SendError("Errore nel recupero degli Utenti");

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
	
	else if(isset($_POST["RemoveClasse"]) && isset($_POST["ID"]))
	{
		if(CheckSessionLogin())
		{
			if(isset($_SESSION["privilegio"])  && isset($_SESSION["user"])  )
			{
				$priv=$_SESSION["privilegio"];
				$user=$_SESSION["user"];
				
				
				//superadmin -> ottiene tutti gli utenti
				if($priv==1)
				{
					$q="delete from classi where ID=$_POST[ID];";
					$arr=array();
					
					$r=$link->query($q);
					if (!$r) {
						$message  = 'Errore query: ' . $link->error . "<br>";
						$message .= 'Whole query: ' . $q;
						SendError($message );
					}
					else
					{
						SendDato(null,"Classe eliminata correttamente");
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
		else if(isset($_POST["EditClasse"]) && isset($_POST["ID"])&& isset($_POST["Numero"])&& isset($_POST["Sezione"])&& isset($_POST["Corso"])&& isset($_POST["Numero_Alunni"])&& isset($_POST["Fotocopie"]))
	{
		if(CheckSessionLogin())
		{
			if(isset($_SESSION["privilegio"])  && isset($_SESSION["user"])  )
			{
				$priv=$_SESSION["privilegio"];
				$user=$_SESSION["user"];
				
				
				//superadmin -> ottiene tutti gli utenti
				if($priv==1)
				{
					$q="SELECT count(ID)as c from classi where `Numero classe`=$_POST[Numero] and Sezione='$_POST[Sezione]' and Corso=$_POST[Corso] and ID<>$_POST[ID]";
					
					
					$r=$link->query($q);
					if (!$r) {
						$message  = 'Errore query: ' . $link->error . "<br>";
						$message .= 'Whole query: ' . $q;
						SendError($message );
					}
					else
					{
						
						if($row=$r->fetch_assoc())
						{
							if($row["c"]>0)
								SendError("La classe è già presente nel database");
							else
							{
								$q="update classi set `Numero classe`=$_POST[Numero], Sezione='$_POST[Sezione]',Corso=$_POST[Corso],`Numero alunni`=$_POST[Numero_Alunni],`Fotocopie rimanenti`=$_POST[Fotocopie] where ID=$_POST[ID]";
								$arr=array();
								
								$r=$link->query($q);
								if (!$r) {
									$message  = 'Errore query: ' . $link->error . "<br>";
									$message .= 'Whole query: ' . $q;
									SendError($message );
								}
								else
								{
									SendDato(null,"classe aggiornata correttamente");
								}
							}							
						}
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
	else if(isset($_POST["LoadListaClassiCerca"])  && isset($_POST["corso"]))
	{
		if(CheckSessionLogin())
		{
			if(isset($_SESSION["privilegio"])  && isset($_SESSION["user"])  )
			{
				$priv=$_SESSION["privilegio"];
				$user=$_SESSION["user"];
				
				
				//superadmin -> ottiene tutti gli utenti
				if($priv==1)
				{
					$q="SELECT classi.ID,CONCAT(`Numero classe`,Sezione,\" \",corsi.nome) as Nome from classi INNER JOIN corsi on ( corsi.ID=Corso and Corso=$_POST[corso])";
					$arr=array();
					
					$r=$link->query($q);
					if (!$r) {
						$message  = 'Errore query: ' . $link->error . "<br>";
						$message .= 'Whole query: ' . $q;
						SendError($message );
					}
					else
					{
						while($row=$r->fetch_assoc())
						{
							$arr[]=$row;
						}
						SendDato($arr);
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
	
	else if(isset($_POST["LoadListaClassiAssociazioni"]) && isset($_POST["IDUtente"]))
	{
		if(CheckSessionLogin())
		{
			if(isset($_SESSION["privilegio"])  && isset($_SESSION["user"])  )
			{
				$priv=$_SESSION["privilegio"];
				$user=$_SESSION["user"];
				
				
				//superadmin -> ottiene tutti gli utenti
				if($priv==1)
				{
				
						
					$q="SELECT classi.ID,CONCAT(`Numero classe`,Sezione,' ',corsi.nome) as Nome from classi inner JOIN insegna on (insegna.ID_Classe=classi.ID) INNER JOIN utenti on (utenti.ID=insegna.ID_Utente) INNER JOIN corsi on ( corsi.ID=Corso) where ID_Utente =$_POST[IDUtente] ORDER BY Corso,Sezione,`Numero classe`";
					$arr=array();
					
					$r=$link->query($q);
					if (!$r) {
						$message  = 'Errore query: ' . $link->error . "<br>";
						$message .= 'Whole query: ' . $q;
						SendError($message );
					}
					else
					{
						while($row=$r->fetch_assoc())
						{
							$arr[]=$row;
						}
						SendDato($arr);
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
	

	
	else if(isset($_POST["RemoveAssociazione"]) && isset($_POST["IDUtente"]) && isset($_POST["IDClasse"]))
	{
		if(CheckSessionLogin())
		{
			if(isset($_SESSION["privilegio"])  && isset($_SESSION["user"])  )
			{
				$priv=$_SESSION["privilegio"];
				$user=$_SESSION["user"];
				
				
				//superadmin -> ottiene tutti gli utenti
				if($priv==1)
				{
					$q="delete from insegna where ID_Utente=$_POST[IDUtente] and ID_Classe=$_POST[IDClasse]";
					$arr=array();
					
					$r=$link->query($q);
					if (!$r) {
						$message  = 'Errore query: ' . $link->error . "<br>";
						$message .= 'Whole query: ' . $q;
						SendError($message );
					}
					else
					{
						SendDato(null,"Associazione eliminata correttamente");
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
	
		else if(isset($_POST["AddAssociazione"])&& isset($_POST["IDUtente"]) && isset($_POST["IDClasse"]))
	{
		if(CheckSessionLogin())
		{
			if(isset($_SESSION["privilegio"])  && isset($_SESSION["user"])  )
			{
				$priv=$_SESSION["privilegio"];
				$user=$_SESSION["user"];
				
				
				//superadmin -> ottiene tutti gli utenti
				if($priv==1)
				{
					$q="SELECT count(ID)as c from insegna where ID_Utente=$_POST[IDUtente] and ID_Classe='$_POST[IDClasse]'";
					
					
					$r=$link->query($q);
					if (!$r) {
						$message  = 'Errore query: ' . $link->error . "<br>";
						$message .= 'Whole query: ' . $q;
						SendError($message );
					}
					else
					{
						
						if($row=$r->fetch_assoc())
						{
							if($row["c"]>0)
								SendError("La coppia Utente-Classe è gia prensente nel database");
							
							else
							{
								$q="INSERT into insegna (ID_Utente,ID_Classe) VALUES($_POST[IDUtente],$_POST[IDClasse])";
								$arr=array();
								
								$r=$link->query($q);
								if (!$r) {
									$message  = 'Errore query: ' . $link->error . "<br>";
									$message .= 'Whole query: ' . $q;
									SendError($message );
								}
								else
								{
									SendDato(null,"Associazione aggiunta correttamente");
								}
							}
						}
						else
							SendError("Errore nel recupero degli Utenti");

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
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	else if(isset($_POST["ConfermaEsecuzione"])  && isset($_POST["id"]))
	{
		if(CheckSessionLogin())
		{
			if(isset($_SESSION["privilegio"])  && isset($_SESSION["user"])  )
			{
				$priv=$_SESSION["privilegio"];
				$user=$_SESSION["user"];
				
				
				//superadmin -> ottiene tutti gli utenti
				if($priv==1)
				{
					$q= "UPDATE prenotazioni SET Eseguito=1 ,  DataEsecuzione=NOW()  WHERE ID=$_POST[id]";
					
					$arr=array();
					
					$r=$link->query($q);
					if (!$r) {
						$message  = 'Errore query: ' . $link->error . "<br>";
						$message .= 'Whole query: ' . $q;
						SendError($message );
					}
					else
					{
						SendDato(null,"Esecuzione Confermata");
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
	
	
	
?>