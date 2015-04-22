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


?>
<html>
	<head>
		<?php include("_head.php"); ?>		
		<script src="js/date.js"></script>
</head>
<script type="text/javascript">
	$(document).ready(function(){

		$("#dati_classe_Nalunni, #dati_classe_fotocopie, #dati_classe_numero").keypress( function(e) { return (e.charCode<48 || e.charCode>57)?false:true;});
		
		LoadPrivilegiUtenti();
		LoadCorsiClassi();
		LoadClassiAssociazioni();
		
		//TEST
		$("#ButtonAddUtente").click(function(){
			
		
		});
		
		$("#ButtonUtentiShowDivHidden").click(function(){
			$("#div_cerca_utenti_hidden").slideToggle(400);
		});
		
	});
	
	function LoadPrivilegiUtenti()
	{
		$.post("include/db_worker.php",{LoadPrivilegiUtenti:1},function(data){
			var arr=JSONfn.parse(data);
			if(arr["err"]==1)
			{
				alert(arr["mess"]);
			}
			else
			{
				$.each(arr["dato"], function( index, value ) {
					var v1=document.createElement('OPTION');
					$(v1).append(value["Privilegio"]);
					$(v1).val(value["ID"]);
					$("#dati_utenti_Privilegio").append(v1);
				});
				
			}
		});
	}
	
	function LoadCorsiClassi()
	{
		$.post("include/db_worker.php",{LoadCorsiClassi:1},function(data){
			var arr=JSONfn.parse(data);
			if(arr["err"]==1)
			{
				alert(arr["mess"]);
			}
			else
			{
				$.each(arr["dato"], function( index, value ) {
					var v1=document.createElement('OPTION');
					$(v1).append(value["nome"]);
					$(v1).val(value["ID"]);
					$("#dati_classe_corso").append(v1);
				});
				
			}
		});
	}
	
	function LoadClassiAssociazioni()
	{
		$.post("include/db_worker.php",{LoadClassiAssociazioni:1},function(data){
			var arr=JSONfn.parse(data);
			if(arr["err"]==1)
			{
				alert(arr["mess"]);
			}
			else
			{
				$.each(arr["dato"], function( index, value ) {
					var v1=document.createElement('OPTION');
					$(v1).append(value["nome"]);
					$(v1).val(value["ID"]);
					$("#classi_associazioni").append(v1);
				});
				
			}
		});
	}
	

	
	function ResetFormNome()
	{
		$("#dati_utenti_nome,#dati_utenti_cognome,#dati_utenti_mail,#dati_utenti_user,#dati_utenti_Password").val("");
		$("#dati_utenti_Privilegio").val(0);
	}
	
	function ResetFormClassi()
	{
		$("#dati_classe_numero,#dati_classe_sezione,#dati_classe_Nalunni,#dati_classe_fotocopie").val("");
		$("#dati_classe_corso").val(0);
	}
	
	function ResetFormAssociazioni()
	{
		$("#classi_associazioni").val(0);
	}
	
	
	//Funzioni dell'utente
	function LoadListaUtenti()
	{
		
	}
	function LoadListaUtentiCerca(Key)
	{
		
	}
	function LoadDatiUtente(ID)
	{
		
	}
	function AddUtente(Nome,Cognome,Mail,Username,Password,Privilegio)
	{
		
	}
	function RemoveUtente(ID)
	{
		
	}
	function EditUtente(ID,Nome,Cognome,Mail,Username,Password,Privilegio)
	{
		
	}
	
	
	
	
	//Funzioni Classi
	function LoadListaClassi()
	{
		
	}
	function LoadListaClassiCerca(Key)
	{
		
	}
	function LoadDatiClasse(ID)
	{
		
	}
	function AddClasse(Numero,Sezione,Corso,Numero_Alunni,Fotocopie)
	{
		
	}
	function RemoveClasse(ID)
	{
		
	}
	function EditClasse(ID,Numero,Sezione,Corso,Numero_Alunni,Fotocopie)
	{
		
	}
	
	
	
	//Funzioni Associazioni
	function LoadListaUtentiAssociazioni()
	{
		
	}
	function LoadListaClassiAssociazioni(IDUtente)
	{
		
	}
	function AddAssociazione(IDUtente,IDClasse)
	{
		
	}
	function RemoveAssociazione(IDUtente,IDClasse)
	{
		
	}
	
</script>

<style>
.cont_utenti,.cont_classi,.cont_relazioni,.cont_dati_utenti,.cont_dati_classi,#cont_relazioni_utenti,#cont_relazioni_classi{
	border: 1px solid black;
}
#Lista_Utenti{
	height:300px;
	overflow-y: scroll;
	overflow-x: hidden;
	width: 100%;
}
#Lista_Classi{
	height:300px;
	overflow-y: scroll;
	overflow-x: hidden;
	width: 100%;
}
#cont_relazioni_utenti{
	height:300px;
	width:200px;	
	overflow-y: scroll;
	overflow-x: hidden;
}

#cont_relazioni_classi{
	height:300px;
	width:200px;
	overflow-y: scroll;
  overflow-x: hidden;	
	
}

#ContainerButtonUtentiShowDivHidden{
	height: 9px;
}
#ButtonUtentiShowDivHidden{
	float:right;
	margin: 4px;
}
#div_cerca_utenti_hidden
{
	border: 1px solid black;
	margin: 2px;padding: 4px;
	width: 280px;
	height: 80px;
}
#div_cerca_utenti_hidden table
{
	width:100%;
	height:80px;
}
</style>
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
							<table>
								<tr>
									<td>
										<table style="width:100%;">
											<tr>
												<td style="width:50%;vertical-align: top;">
													<h2>Utenti</h2>
													<div class="cont_utenti">
														<div id="Cerca_utenti">
															<div id="ContainerButtonUtentiShowDivHidden">
															<!-- &#9650 su | &#9660 giu-->
																<button id="ButtonUtentiShowDivHidden">Cerca &#9660</button>
															</div><br>
															<div id="div_cerca_utenti_hidden" style="display: none;">
																<table >
																	<tr>
																		<td>
																			Pattern:
																		</td>
																		<td>
																			<input type="text" id="Cerca_utenti_textbox" ></input><br>
																		</td>
																	</tr>
																	<tr>
																		<td>
																			Campo:
																		</td>
																		<td>
																			<select id="cerca_utenti_combo_campo">
																				<option value=0>Cognome</option>
																				<option value=1>Nome</option>
																			</select>
																		</td>
																		
																	</tr>
																	<tr>
																		<td>
																			
																		</td>
																		<td>
																			<button id="ButtonCercaUtenti">Cerca</button>
																		</td>
																		
																	</tr>
																</table>
																
																
																
															</div>
														</div>
														<div id="Lista_Utenti" >
															<table style="width:100%;">
																<tr>
																	<td>
																		Cognome
																	</td>
																	<td>
																		Nome
																	</td>
																	
																</tr>
															</table>
														</div>
														<div id="Menu_Utenti" >
															<button id="ButtonAddUtente">+</button>
															<button id="ButtonRemoveUtente">-</button>
														</div>
													</div>
													<br>
													<div class="cont_dati_utenti">
														
														<table style="  width: auto;">
															<tr>
																<td>
																	Nome: 
																</td>
																<td>
																	<input id="dati_utenti_nome"></input>
																</td>
															</tr>
															<tr>
																<td>
																	Cognome: 
																</td>
																<td>
																	<input id="dati_utenti_cognome"></input>
																</td>
															</tr>
															<tr>
																<td>
																	Mail: 
																</td>
																<td>
																	<input id="dati_utenti_mail"></input>
																</td>
															</tr>
															<tr>
																<td>
																	Username: 
																</td>
																<td>
																	<input id="dati_utenti_user"></input>
																</td>
															</tr>
															<tr>
																<td>
																	Password: 
																</td>
																<td>
																	<input id="dati_utenti_Password"></input>
																</td>
																
															</tr>
															<tr>
																<td>
																	Privilegio: 
																</td>
																<td>
																<select id="dati_utenti_Privilegio">
																
																</select>
																</td>
																
															</tr>
														</table>													
													</div>
												</td>
												<td style="width:50%;vertical-align: top;">
													<h2>Classi</h2>
													<div class="cont_classi">
														<div id="Cerca_utenti">
															<input type="text" id="Cerca_utenti_textbox" ></input>
															<button>Cerca</button>
														</div>
														<div id="Lista_Classi" >
															
														</div>
														<div id="Menu_Utenti" >
															<button id="ButtonAddClasse">+</button>
															<button id="ButtonRemoveClasse">-</button>
														</div>
													</div>
													
													<br>
													<div class="cont_dati_classi">
														
														<table style="  width: auto;">
															<tr>
																<td>
																	Numero: 
																</td>
																<td>
																	<input id="dati_classe_numero"></input>
																</td>
															</tr>
															<tr>
																<td>
																	Sezione: 
																</td>
																<td>
																	<input id="dati_classe_sezione"></input>
																</td>
															</tr>
															
															
															
															<tr>
																<td>
																	Corso: 
																</td>
																<td>
																	<select id="dati_classe_corso">
																		
																	</select>
																</td>
																
															</tr>
															<tr>
																<td>
																	Numero Alunni: 
																</td>
																<td>
																	<input id="dati_classe_Nalunni"></input>
																</td>
															</tr>
															<tr>
																<td>
																	Fotocopie: 
																</td>
																<td>
																	<input id="dati_classe_fotocopie"></input>
																</td>
															</tr>
														</table>													
													</div>
													
													
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td>
										<div class="cont_relazioni">
											<table>
												<tr>
													<td>
														Utenti
													</td>
													<td>
													
													</td>
													<td>
														Classi
													</td>
												</tr>
												<tr>
													<td style="vertical-align: top;  width: 200px;">
														<div id="cont_relazioni_utenti">
															
														</div>
													</td>
													<td>
													
													</td>
													<td style="vertical-align: top;   width: 200px;">
														<div id="cont_relazioni_Classi">
													
														</div>
														<br>
														
														<div style="float:right;">
															<select id="classi_associazioni">
																
															</select>
															<button id="ButtonAddAssociazione">+</button>					
														</div>
														<button id="ButtonRemoveAssociazione">-</button>
													</td>
												</tr>
											
											</table>
												
												
										</div>
									</td>
								</tr>
							</table>
							
						</div>
					
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