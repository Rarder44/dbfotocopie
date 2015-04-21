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
						<strong>Prenotazioni effettuate</strong>
						<br><br>
						<?php 
							global $link;
							//Esecuzione Query
							
							$q= "SELECT CONCAT(utenti.Nome,' ', utenti.Cognome) AS Utente, CONCAT (classi.`Numero classe`, ' ', classi.Sezione, ' ', corsi.nome) 
							AS Classe, prenotazioni.`Numero fotocopie`, prenotazioni.Formato, prenotazioni.Fogli, prenotazioni.`Data`, prenotazioni.DataRichiesta, 
							prenotazioni.Eseguito";
							$q.= " FROM utenti, classi, prenotazioni, corsi";
							$q.=" WHERE utenti.ID = prenotazioni.ID_Utente AND classi.ID = prenotazioni.ID_Classe AND corsi.ID = classi.Corso";
							$q.=" AND prenotazioni.Eseguito='0'";
							
							$result =$link->query($q);
							if($link->errno)
								die('Invalid query: ' .$link->error); 				
														
							echo "<table border=\"3\">";
								echo "<tr>";
								while ($finfo = $result->fetch_field()) 
									echo "<td>".$finfo->name."</td>";
								echo "</tr>";
							
								// Stampo a video i valori di ogni riga
								while($row=$result->fetch_assoc())
								{
									$todays_date = date("d-m-Y");
									$today = strtotime($todays_date);
									$dataRitiro = strtotime($row["DataRichiesta"]); 
									if ($dataRitiro > $today)
									{
										echo "<tr><font color=\"green\">";
											foreach($row as $valore)
												echo "<td>$valore</td>";
										echo "</font></tr>";
										
									} 
									else 
									{ 
										echo "<tr><font color=\"red\">";
											foreach($row as $valore)
												echo "<td>$valore</td>";
										echo "</font></tr>";
									}
									/*
									echo "<tr>";
										if($row["Eseguito"])
										{
											echo "<input type=\checkbox\" name=\"eseguito\" value='1'";
										}
										else
										{
											foreach($row as $valore)
												echo "<td>$valore</td>";
										}
									echo "</tr>";
									*/
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