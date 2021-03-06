<?php
if(!isset($_SESSION))
	session_start();

include("include/func.php");
include ("include/conn.php");

if(!CheckSessionLogin())
{
	echo "<html></head><script language='javascript'>top.location.href = 'login.php';</script></head><html>";
}
?>
<html>
	<head>
		<?php include("_head.php"); ?>	
	
	<script>
	
	function ConfermaEsecuzione(id)
	{
		
		if (confirm('Sicuro di voler procedere?') == true)
		{
			$.post("include/db_worker.php",{ConfermaEsecuzione:1,id:id},function(data){
				var arr=JSONfn.parse(data);
				if(arr["err"]==1)
				{
					alert(arr["mess"]);
				}
				else
				{
					location.reload();
				}
			});
		
		
		}
	}
	
	</script>
	</head>
	<body>
		<div class="box">
			<table style="width:1050px;">
				<tr>
					<td style="width:140px;">
						
					</td>
					<td style="width:750px;">
						<div class="header">		
							<?php include("_header.php"); ?>
						</div>
						
					</td>
					<td style="width:140px;">
						
					</td>
				</tr>
				
				<tr>
					<td style="vertical-align: top;">
						<div class="sidebar">
						<?php include("_sidebar.php"); ?>
						</div>
					</td>
					<td>
						<div class="container">
				
						<!--inserire qui il codice-->
						<strong>Prenotazioni effettuate</strong>
						<br><br>
						<?php 
							global $link;
							//Esecuzione Query
							
							$q= "SELECT prenotazioni.ID, CONCAT(utenti.Nome,' ', utenti.Cognome) AS Utente, CONCAT (classi.`Numero classe`, ' ', classi.Sezione, ' ', corsi.nome) 
							AS Classe,  prenotazioni.`Numero alunni` AS Alunni, prenotazioni.`Numero pagine` AS Pagine,prenotazioni.`Numero fotocopie` as 'Num. copie', (CASE WHEN prenotazioni.Formato = 1 THEN \"A4\" ELSE \"A3\" END) AS 'Form.', 
							(CASE WHEN prenotazioni.Fogli = 1 THEN \"singoli\" ELSE \"fronte/retro\" END) AS Fogli, prenotazioni.DataRichiesta AS 'Data Ritiro', 
							prenotazioni.Eseguito, prenotazioni.FileName as 'File'";
							$q.= " FROM utenti, classi, prenotazioni, corsi";
							$q.=" WHERE utenti.ID = prenotazioni.ID_Utente AND classi.ID = prenotazioni.ID_Classe AND corsi.ID = classi.Corso";
							$q.=" AND prenotazioni.Eseguito='0'";
							$q.=" ORDER BY prenotazioni.DataRichiesta DESC";
							
							$result =$link->query($q);
							if($link->errno)
								die('Invalid query: ' .$link->error); 				
														
							echo "<table border=\"3\" style='  width: 100%;'>";
								echo "<tr>";
								while ($finfo = $result->fetch_field()) 
									if($finfo->name!="ID")
									echo "<td>".$finfo->name."</td>";
								echo "</tr>";
							
								// Stampo a video i valori di ogni riga
								while($row=$result->fetch_assoc())
								{
									echo "<tr>";
									$timestamp = time();
									$data = date('Y-m-d', $timestamp);
									$today = strtotime($data);
									$dataRichiesta = strtotime($row["Data Ritiro"]);
									if ($dataRichiesta > $today)					
									{
										$ID=0;
										foreach($row as $k=>$valore)
										{
											
											if ($k == "ID") // mi salvo l'ID della prenotazione in modo
												$ID = $valore;
											else if ($k == "File" && $valore!=null)
												echo "<td style='  text-align: center;' ><a  href = 'file/$valore'>link</a> </td>";
											else if ($k == "File" && $valore == null)
												echo "<td style='  text-align: center;' ><font  color=\"green\"> - </font></td>";
											else if ($k == "Eseguito") // nel campo eseguito creo un bottone che permette di aggiornare il database
												echo "<td><input type=\"button\" value=\"Esegui\" onClick=\"ConfermaEsecuzione($ID)\"></td>";
											else if ($k == "Data Ritiro")
											{
												// cambio il formato della data
												$array = explode("-", $valore);
												$data = $array[2]."/".$array[1]."/".$array[0];
												echo "<td><font color=\"green\">$data</font></td>";
											}
											else if($k != "ID" && $k != "Data Ritiro")
												echo "<td><font color=\"green\">$valore</font></td>";
											
										}
									}
									else 
									{
										$ID=0;
										foreach($row as $k=>$valore)
										{
											if ($k == "ID")
											{
												$ID = $valore;

											}
											else if ($k == "File" && $valore!=null)
												echo "<td style='  text-align: center;' ><a href = 'file/$valore'>link</a></td>";
											else if ($k == "File" && $valore == null)
												echo "<td style='  text-align: center;' ><font color=\"red\"> - </font></td>";
											else if ($k == "Eseguito")
												echo "<td><input type=\"button\" value=\"Esegui\" onClick=\"ConfermaEsecuzione($ID)\"></td>";
											else if ($k == "Data Ritiro")
											{
												// cambio il formato della data
												$array = explode("-", $valore);
												$data = $array[2]."/".$array[1]."/".$array[0];
												echo "<td><font color=\"red\">$data</font></td>";
											}
											else if($k != "ID" && $k != "Data Ritiro")
												echo "<td><font color=\"red\">$valore</font></td>";
										}
									}
									echo "</tr>";
								}
							echo "</table>";
						?>
						
						</div>
					</td>
					<td>
					
					</td>
				</tr>
				
				<tr>
					<td>
						
					</td>
					<td>
						<div class="footer">
							<?php include("_footer.php"); ?>
						</div>
		
						
					</td>
					<td>
					
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>