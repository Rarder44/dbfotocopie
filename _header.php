<img src="images/header.gif"><br>
<div class="topmenu" >

<?php
	if(!isset($_SESSION))
		session_start();
		
	$menuHeader=array();

	
	$priv=isset($_SESSION["privilegio"])?$_SESSION["privilegio"]:"";
	$user=isset($_SESSION["user"])?$_SESSION["user"]:"";
	

	global $menuHeader;
	$menuHeader["Loggato"]=array();
	
	
	
	
	
	//admin
	$menuHeader["Loggato"]["1"]="";
	$menuHeader["Loggato"]["1"].="<table>";
	$menuHeader["Loggato"]["1"].="	<tr>";
	$menuHeader["Loggato"]["1"].="		<td>";
	$menuHeader["Loggato"]["1"].="			<a href='index.php' class='bottone'>Home</a>";
	$menuHeader["Loggato"]["1"].="		</td>";
	$menuHeader["Loggato"]["1"].="		<td>";
	$menuHeader["Loggato"]["1"].="			<div style='width:141px;'></div>";
	$menuHeader["Loggato"]["1"].="		</td>";
	$menuHeader["Loggato"]["1"].="		<td>";
	$menuHeader["Loggato"]["1"].="			<div style='width:141px;'></div>";
	$menuHeader["Loggato"]["1"].="		</td>";
	$menuHeader["Loggato"]["1"].="		<td>";
	$menuHeader["Loggato"]["1"].="			<div style='width:150px;margin-left:20px;'>";
	$menuHeader["Loggato"]["1"].="				Ciao <span style='font-size: 17px;font-weight: bold;'>$user</span>,<br><a href='impostazioniUtente.php'>Impostazioni</a> | <a href='login.php?logOut=1'>LogOut</a>";
	$menuHeader["Loggato"]["1"].="			</div>";
	$menuHeader["Loggato"]["1"].="		</td>";
	$menuHeader["Loggato"]["1"].="	</tr>";
	$menuHeader["Loggato"]["1"].="</table>";

	//professori
	$menuHeader["Loggato"]["2"]="";
	$menuHeader["Loggato"]["2"].="<table>";
	$menuHeader["Loggato"]["2"].="	<tr>";
	$menuHeader["Loggato"]["2"].="		<td>";
	$menuHeader["Loggato"]["2"].="			<a href='index.php' class='bottone'>Home</a>";
	$menuHeader["Loggato"]["2"].="		</td>";
	$menuHeader["Loggato"]["2"].="		<td>";
	$menuHeader["Loggato"]["2"].="			<div style='width:141px;'></div>";
	$menuHeader["Loggato"]["2"].="		</td>";
	$menuHeader["Loggato"]["2"].="		<td>";
	$menuHeader["Loggato"]["2"].="			<div style='width:141px;'></div>";
	$menuHeader["Loggato"]["2"].="		</td>";
	$menuHeader["Loggato"]["2"].="		<td>";
	$menuHeader["Loggato"]["2"].="			<div style='width:150px;margin-left:20px;'>";
	$menuHeader["Loggato"]["2"].="				Ciao <span style='font-size: 17px;font-weight: bold;'>$user</span>,<br><a href='impostazioniUtente.php'>Impostazioni</a> | <a href='login.php?logOut=1'>LogOut</a>";
	$menuHeader["Loggato"]["2"].="			</div>";
	$menuHeader["Loggato"]["2"].="		</td>";
	$menuHeader["Loggato"]["2"].="	</tr>";
	$menuHeader["Loggato"]["2"].="</table>";
	
	
	//segreteria
	$menuHeader["Loggato"]["3"]="";
	$menuHeader["Loggato"]["3"].="<table>";
	$menuHeader["Loggato"]["3"].="	<tr>";
	$menuHeader["Loggato"]["3"].="		<td>";
	$menuHeader["Loggato"]["3"].="			<a href='index.php' class='bottone'>Home</a>";
	$menuHeader["Loggato"]["3"].="		</td>";
	$menuHeader["Loggato"]["3"].="		<td>";
	$menuHeader["Loggato"]["3"].="			<div style='width:141px;'></div>";
	$menuHeader["Loggato"]["3"].="		</td>";
	$menuHeader["Loggato"]["3"].="		<td>";
	$menuHeader["Loggato"]["3"].="			<div style='width:141px;'></div>";
	$menuHeader["Loggato"]["3"].="		</td>";
	$menuHeader["Loggato"]["3"].="		<td>";
	$menuHeader["Loggato"]["3"].="			<div style='width:150px;margin-left:20px;'>";
	$menuHeader["Loggato"]["3"].="				Ciao <span style='font-size: 17px;font-weight: bold;'>$user</span>,<br><a href='impostazioniUtente.php'>Impostazioni</a> | <a href='login.php?logOut=1'>LogOut</a>";
	$menuHeader["Loggato"]["3"].="			</div>";
	$menuHeader["Loggato"]["3"].="		</td>";
	$menuHeader["Loggato"]["3"].="	</tr>";
	$menuHeader["Loggato"]["3"].="</table>";
	
	
	
	
	

	
	$menuHeader["Loggato"]["4"]="";
	
	
	
	
	$menuHeader["NonLoggato"]="";
	$menuHeader["NonLoggato"].="<table>";
	$menuHeader["NonLoggato"].="	<tr>";
	$menuHeader["NonLoggato"].="		<td>";
	$menuHeader["NonLoggato"].="			<a href='index.php' class='bottone'>Home</a>";
	$menuHeader["NonLoggato"].="		</td>";
	$menuHeader["NonLoggato"].="		<td>";
	$menuHeader["NonLoggato"].="			<div style='width:141px;'></div>";
	$menuHeader["NonLoggato"].="		</td>";
	$menuHeader["NonLoggato"].="		<td>";
	$menuHeader["NonLoggato"].="			<div style='width:141px;'></div>";
	$menuHeader["NonLoggato"].="		</td>";
	$menuHeader["NonLoggato"].="		<td>";
	$menuHeader["NonLoggato"].="			<div style='width:150px;margin-left:20px;'>";
	$menuHeader["NonLoggato"].="				Non sei autenticato<br>Effettua la <a href='login.php'>Login</a>";
	$menuHeader["NonLoggato"].="			</div>";
	$menuHeader["NonLoggato"].="		</td>";
	$menuHeader["NonLoggato"].="	</tr>";
	$menuHeader["NonLoggato"].="</table>";
	




	include_once("include/func.php");

	if(CheckSessionLogin())
	{
		if(isset($_SESSION["privilegio"]) && isset($menuHeader["Loggato"][$_SESSION["privilegio"]]))
			echo $menuHeader["Loggato"][$_SESSION["privilegio"]];
		else
			echo "Errore privilegio, <a href='login.php?logOut=1'>LogOut</a>";
	}
	else
	{
		echo $menuHeader["NonLoggato"];
	}
	
?>
	
		
</div>