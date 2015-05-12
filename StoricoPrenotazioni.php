<html>
	<head>
		<?php include("_head.php"); ?>	
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
						<strong>Storico Prenotazioni</strong>
						<br><br>
						<?php 
							global $link;
							//Esecuzione Query
							
							$q= "SELECT CONCAT(utenti.Nome,' ', utenti.Cognome) AS Utente, CONCAT (classi.`Numero classe`, ' ', classi.Sezione, ' ', corsi.nome) 
<<<<<<< HEAD
							AS Classe, prenotazioni.`Numero alunni` AS Alunni, prenotazioni.`Numero pagine` AS Pagine, prenotazioni.`Numero fotocopie` as 'Num. copie', 
							(CASE WHEN prenotazioni.Formato = 1 THEN \"A4\" ELSE \"A3\" END) AS 'Form.', 
							(CASE WHEN prenotazioni.Fogli = 1 THEN \"s\" ELSE \"f/r\" END) AS Fogli,prenotazioni.DataRichiesta AS 'Data Ritiro', 
=======
							AS Classe, prenotazioni.`Numero fotocopie` as 'Num. copie', (CASE WHEN prenotazioni.Formato = 1 THEN \"A4\" ELSE \"A3\" END) AS 'Form.', 
							(CASE WHEN prenotazioni.Fogli = 1 THEN \"singoli\" ELSE \"fronte/retro\" END) AS Fogli, prenotazioni.`Data`, prenotazioni.DataRichiesta, 
>>>>>>> origin/master
							(CASE WHEN prenotazioni.Eseguito = 0 THEN \"NO\" ELSE \"SI\" END) AS Eseguito, prenotazioni.FileName as 'File', prenotazioni.DataEsecuzione";
							$q.= " FROM utenti, classi, prenotazioni, corsi";
							$q.=" WHERE utenti.ID = prenotazioni.ID_Utente AND classi.ID = prenotazioni.ID_Classe AND corsi.ID = classi.Corso";
							
							$result =$link->query($q);
							if($link->errno)
								die('Invalid query: ' .$link->error); 				
														
							echo "<table style='width:100%;' border=\"3\">";
								echo "<tr>";
								while ($finfo = $result->fetch_field()) 
									echo "<td>".$finfo->name."</td>";
								echo "</tr>";
							
								// Stampo a video i valori di ogni riga
								while($row=$result->fetch_assoc())
								{
									echo "<tr>";
										foreach($row as $k=>$valore)
										{
											if ($k == "File" && $valore!=null)
												echo "<td style='  text-align: center;'> <a href = 'file/$valore'>link</a> </td>";
											else if ($k == "File" && $valore == null)
												echo "<td style='  text-align: center;'>-</td>";
											else
												echo "<td>$valore</td>";
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