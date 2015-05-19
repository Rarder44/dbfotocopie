<?php
if(!isset($_SESSION))
	session_start();

include("include/func.php");
include("include/conn.php");
include("include/JSON.php");

if(!CheckSessionLogin())
{
	echo "<html></head><script language='javascript'>top.location.href = 'login.php';</script></head><html>";
}


if(isset($_FILES["fileToUpload"]))
{
	$target_dir = "file/";

	$imageFileType = pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION);
	$target_file =  basename($_FILES["fileToUpload"]["name"],".$imageFileType");
	$pre="";
	$uploadOk = 1;

	while(file_exists($target_dir.$pre.$target_file.".$imageFileType"))
		$pre.="_";
	$target_file1=$target_dir.$pre.$target_file.".$imageFileType";




	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" && $imageFileType != "txt") {
		SendError( "Sorry, only JPG, JPEG, PNG & GIF txt files are allowed.");
		return;
		$uploadOk = 0;
	}
	
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		SendError( "Sorry, your file was not uploaded.");
	// if everything is ok, try to upload file
	} else 
	{
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file1)) {
			$arrTemp["filename"]=$pre.$target_file.".$imageFileType";
			SendDato($arrTemp);
			
			
		} else {
			SendError( "Sorry, there was an error uploading your file.");
		}
	}
	return;
}

?>
<html>
	<head>
		<?php include("_head.php"); ?>		
		<script src="js/date.js"></script>
	
	
	<script type="text/javascript">
		$(document).ready(function(){
			//funzione che non fa inserire nella casella di testo tutto ciò che non sono numeri
			$("#n_pagine, #n_alunni, #giorno, #mese, #anno").keypress( function(e) { return (e.charCode<48 || e.charCode>57)?false:true;});
			
			//quando clicco sul pulsante upload
			$("#upload").click(function(){
			UploadFile();
			});
			
		
			function UploadFile() // funzione che permette di selezionare l'immagine da disco e metterla in una cartella temporanea per visualizzarla
			{
				var iframe=document.createElement('iframe'); //crea un iframe e lo mette nella variabile iframe
				$(iframe).css("display","none"); // imposta l'attributo display dell'iframe a "none", cioè non visibile
				var form=document.createElement('form'); //crea un form e lo mette nella variabile form
				$(form).attr("method","POST"); //imposta come metodo del form il POST
				$(form).attr("enctype","multipart/form-data"); //imposta come enctype del form multipart/form-data
				$(form).attr("action","InserisciPrenotazione.php"); // imposta come action del form il file "upload.php" contenente il codice php				
				var i=document.createElement('input'); // crea un input e lo mette nella variabile i
				$(i).attr("type","file"); //imposta come tipo di input di i "file"
				$(i).attr("name","fileToUpload"); //imposta come nome di i "fileToUpload"		
				$(form).append(i); //aggiunge al form l'input i (fileToUpload)
				$("#UploaderDiv").append(iframe); //aggiunge al div UploaderDiv l'iframe creato sopra
				$(iframe).contents().find('html').append(form);  //aggiunge all'iframe il form creato
				$(i).change( // al cambio del file selezionato da disco imposta la seguente funzione
				function() 
				{	
					$(form).submit(); // effettua il submit
					$(iframe).load(function() // quando l'iframe e il suo contenuto sono stati compleatamente caricati
					{	
						var v=$(iframe).contents().find('html').text();
						var arr=JSONfn.parse(v); // converto in array la stringa JSON che ho ricevuto
						if(arr["err"]==1) // se è presente un errore
						{
							alert(arr["mess"]);
						}
						else // se non è presente
						{
							$("#testotemp").text(arr["dato"]["filename"]); 
							$("#tempFileName").val(arr["dato"]["filename"]);
							
						}						
					});
				});
				$(i).click(); // clicca sul bottone, aprendo la finestra di dialogo per la selezione dell'immagine da disco									
			}
			
			
			$("#SelectClasse").change(function(){
				
				caricaAlunni($('option:selected', this).attr('num-al'));
				
			});
		});
		
		function caricaAlunni(Num)
		{
			$("#n_alunni").val(Num);
		}
		
		function Form_CHECK()
		{
			var num_alunni = document.prenotazione.n_alunni.value;
			var num_pagine = document.prenotazione.n_pagine.value;
			var giorno = document.prenotazione.giorno.value;
			var mese = document.prenotazione.mese.value;
			var anno = document.prenotazione.anno.value;
			var data = new Date();
			var annoCorrente = data.getFullYear();
			if (num_alunni == "")
			{
				alert("Attenzione, devi inserire il numero degli alunni");
				return false;
			}
			else if (num_pagine == "")
			{
				alert("Attenzione, devi inserire il numero delle pagine");
				return false;
			}
			else if (giorno == "")
			{
				alert("Attenzione, devi inserire il giorno");
				return false;
			}
			else if (mese == "")
			{
				alert("Attenzione, devi inserire il mese");
				return false;
			}
			else if (anno == "")
			{
				alert("Attenzione, devi inserire l'anno");
				return false;
			}
			else if (mese > 12)
			{
				alert("Attenzione, mese non corretto!");
				return false;
			}
			else if (anno != annoCorrente && anno != (annoCorrente+1))
			{
				alert("Attenzione, anno non corretto!!");
				return false;
			}
			else if (mese == 1 || mese == 3 || mese == 5 || mese == 7 || mese == 8 || mese == 10 || mese == 12) // 1-3-5-7-8-10-12
			{
				if (giorno > 31)
				{
					alert("Attenzione, giorno non valido");
					return false;
				}
			}
			else if (mese == 2) // mese di febbraio
			{
				if (anno % 4 == 0) // controllo se l'anno è bisestile
				{
					if (giorno > 29)
					{
						alert("Attenzione, giorno non valido!");
						return false;
					}
				}
				else
				{
					if (giorno > 28)
					{
						alert("Attenzione, giorno non valido!");
						return false;
					}
				}
				
			}
			
			var gg3= Date.today().add(3).days().set({millisecond: 0,   second: 0,    minute: 0});
			var d= Date.today().set({day:parseInt(giorno),month:parseInt(mese)-1,year:parseInt(anno),millisecond: 0,   second: 0,    minute: 0});
			if(d.compareTo(gg3) == -1)
			{
				alert("Attenzione, Inserire una data maggiore di 3 gg da Oggi");
				return false;
			}		
			
			document.prenotazione.action = "PrenotazioneInserita.php";
			document.prenotazione.submit();
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
						<strong>Inserimento Prenotazione Fotocopie</strong>
						<br><br>
						<form name="prenotazione" method="post">
						Seleziona classe: 
							<select name="classe" id="SelectClasse">
								<option num-al="" value=""></option>
								<?php
									global $link;
									// query che ricava le classi assegnate all'utente
									
									if($_SESSION["privilegio"]==1)
									{
										$q = "select classi.ID, CONCAT( classi.`Numero classe`,' ',classi.Sezione, ' ', corsi.Nome,' - ',classi.`Fotocopie rimanenti`) as classe,classi.`Numero alunni` as NumAl from classi, corsi";
										$q .= " where classi.Corso = corsi.ID"; 
										
										$result=$link->query($q);
										while($row=$result->fetch_assoc())
										{
											echo "<option num-al=$row[NumAl]  value='$row[ID]'>$row[classe]</option>";	
										}
									}
									else
									{
										$q = "select classi.ID, CONCAT( classi.`Numero classe`,' ',classi.Sezione, ' ',corsi.Nome,' - ',classi.`Fotocopie rimanenti`) as classe from utenti, classi, insegna, corsi where utenti.ID = insegna.ID_Utente and insegna.ID_Classe = classi.ID  and classi.Corso = corsi.ID and utenti.`Username` = 'docente_1'";
										
										$result=$link->query($q);
										while($row=$result->fetch_assoc())
										{
											echo "<option value='$row[ID]'>$row[classe]</option>";	
										}
									}
								?>	
							</select>
							
							
						<br><br>
						<label>N° pagine: <input type="text" name="n_pagine" id="n_pagine"></label>
						<br><br>
						<label>N° alunni: <input type="text" name="n_alunni" id="n_alunni"></label>
						<br><br>
						Formato:
						<input type="radio" name="formato" value="A3">A3</input>
						<input type="radio" name="formato" value="A4" checked="checked" >A4</input>
						<br><br>
						Fogli:
						<input type="radio" name="fogli" value="fronte_retro">fronte/retro</input>
						<input type="radio" name="fogli" value="singoli" checked="checked" >singoli</input>	
						<br><br>
						Seleziona la data per il ritiro delle fotocopie: 
						<br><br><label>Giorno: <input type="text" name="giorno" id="giorno" size="5"></label>
						<label>Mese: <input type="text" name="mese" id="mese" size="5"></label>
						<label>Anno: <input type="text" name="anno" id="anno" size="5"></label>
						<br><br>					
						<label>Carica il file da stampare: <input id="upload" type="button" value="Upload"></input></label>
							<div id="testotemp"></div>
						<input type="text" id="tempFileName" name="FileName" style="display:none;"></input>
						<br><br>
						<input type="button" value="Prenota" onClick="Form_CHECK()">
						&nbsp;&nbsp;
						<input name="cancella_form" type="reset" value="Cancella">
						</form>
						</div>
					<div id="UploaderDiv"></div>
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