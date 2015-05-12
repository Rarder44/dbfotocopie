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
						</div>
					</td>
					<td>
						<div class="container">
				
						<?php 
						
							$ID_Classe = $_POST["classe"];
							$pagine = $_POST["n_pagine"];
							$alunni = $_POST["n_alunni"];
							$formato = $_POST["formato"];
							$fogli = $_POST["fogli"];
							$giorno = $_POST["giorno"];
							$mese = $_POST["mese"];
							$anno = $_POST["anno"];
							$FileName = $_POST["FileName"];
							
							$fotocopieTotali = "";
							if ($formato == 'A3')
								$form = 2;
							else if ($formato == 'A4')
								$form = 1;
							if ($fogli == 0)
							{
								$resto = $pagine%2;
								if ($resto == 1)
								{
									$pagine = $pagine/2;
									$paginePerAlunno = floor($pagine) + 1;
									$fotocopieTotali = $alunni*$paginePerAlunno;
								}
								else
									$fotocopieTotali = ($pagine*$alunni)/2;
									
								$fogli = 0;
							}
							else if ($fogli == 1)
							{
								$fogli = 1;
								$fotocopieTotali = $pagine*$alunni;
							}
							//se il giorno ha una sola cifra aggiungo uno 0 prima
							if ($giorno < 10 && $giorno > 1)
								$giorno = '0'.$giorno;
							// se il mese ha una sola cifra aggiungo uno 0 prima
							if ($mese < 10 && $mese > 1)
								$mese = '0'.$mese;

							$insert = "insert into prenotazioni (ID_Utente, ID_Classe, `Numero alunni`, `Numero pagine`, `Numero fotocopie`, Formato, Fogli, `Data`, Ora, DataRichiesta,FileName)";
							$insert .=" values ($_SESSION[ID], $ID_Classe, $alunni, $pagine, $fotocopieTotali, $form, $fogli, NOW(), NOW(), '$anno-$mese-$giorno','$FileName')";

							global $link;
							
							if (!$link->query($insert))
							{
								$message = 'Errore query: ' .$link->errno ." - ". $link->error. "\r\n";
								$message .= 'Whole query: ' .$q;
								echo $message;
							}
							else
							{
								echo "Prenotazione inserita con successo!";
								echo "<br><br><br><br>";
								$update ="update classi set `Fotocopie rimanenti`= `Fotocopie rimanenti`-$fotocopieTotali";
								$update .= " where ID = $ID_Classe";
								
								if (!$link->query($update))
								{
									$message = 'Errore query: ' .$link->errno ." - ". $link->error. "\r\n";
									$message .= 'Whole query: ' .$q;
									echo $message;
								}
							?>	
								<input type="button" onClick="location.href='index.php'" value="Home">
							<?php 
							
							}
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