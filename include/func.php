<?php 
include_once("conn.php");
/*
function ConfermaEsecuzione(&$ID)
{
?>
<script>
	conferma = confirm('Sei sicuro di voler procedere con l\'esecuzione della stampa?');
	
	if (conferma == true)
	{
	<?php
		global $link;
		$update ="update prenotazioni set `DataEsecuzione`= `NOW()";
		$update .= " where ID = $ID";
						
			if (!$link->query($update))
			{
				$message = 'Errore query: ' .$link->errno ." - ". $link->error. "\r\n";
				$message .= 'Whole query: ' .$q;
				echo $message;
			}
	?>
	}
</script>
<?php
}
*/
function login($user,$md5pass)
{
	//query che controlla la login
	
	global $link;
	
	$q="select ID, privilegio from utenti where `Username`='".$link->real_escape_string($user)."' and `Password`='".$link->real_escape_string($md5pass)."'";
	
	$r=$link->query($q);
	// print_r ($r);
	if($row=$r->fetch_assoc())
	{
		if(!isset($_SESSION))
			session_start();
		$_SESSION["privilegio"]=$row["privilegio"];
		$_SESSION["ID"]=$row["ID"];
		return true;

	}	
	return false;
}

function CheckSessionLogin()
{
	if(!isset($_SESSION))
		session_start();
	
	if(isset($_SESSION["user"]) && isset($_SESSION["pass"]))
	{
		if(login($_SESSION["user"],$_SESSION["pass"]))
		{
			return true;
		}
	}
	return false;	
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