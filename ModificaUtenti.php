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

		$("#n_pagine, #n_alunni, #giorno, #mese, #anno").keypress( function(e) { return (e.charCode<48 || e.charCode>57)?false:true;});
		
		
		

</script>

<style>
.cont_utenti,.cont_classi,.cont_relazioni,.cont_dati_utenti,.cont_dati_classi,#cont_relazioni_utenti,#cont_relazioni_classi{
	border: 1px solid black;
}
#Lista_Utenti{
height:300px;
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
															<input type="text" id="Cerca_utenti_textbox" ></input>
															<button>Cerca</button>
														</div>
														<div id="Lista_Utenti" >
															
														</div>
														<div id="Menu_Utenti" >
															<button>+</button>
															<button>-</button>
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
																	 <select>
																	<option value="0">admin</option>
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
														<div id="Lista_Utenti" >
															
														</div>
														<div id="Menu_Utenti" >
															<button>+</button>
															<button>-</button>
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
																	<input id="dati_utenti_nome"></input>
																</td>
															</tr>
															<tr>
																<td>
																	Sezione: 
																</td>
																<td>
																	<input id="dati_utenti_cognome"></input>
																</td>
															</tr>
															
															
															
															<tr>
																<td>
																	Corso: 
																</td>
																<td>
																	 <select>
																	<option value="0">informatica</option>
																</select>
																</td>
																
															</tr>
															<tr>
																<td>
																	Numero Alunni: 
																</td>
																<td>
																	<input id="dati_utenti_mail"></input>
																</td>
															</tr>
															<tr>
																<td>
																	Fotocopie: 
																</td>
																<td>
																	<input id="dati_utenti_user"></input>
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
															<select>
																<option value="1">5b info</option>
																
																
															</select>
															<button>+</button>
														</div>
														<button>-</button>
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