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
		
		//caricamento select - option 
		LoadPrivilegiUtenti();
		LoadCorsiClassi();
		LoadClassiAssociazioni();
		
		//caricamento Utenti - Classi
		LoadListaUtenti();
		LoadListaClassi();
		LoadListaUtentiAssociazioni();
		
		//Eventi Bottoni Utenti
		$("#ButtonUtentiShowDivHidden").click(function(){
			$("#div_cerca_utenti_hidden").slideToggle(400);
		});
		$("#ButtonCanceldit").click(function(){
			CancelEditUtente();
		});
		$("#ButtonSaveEdit").click(function(){	
			if($("#dati_utenti_Password").attr("cambia-pass")=="si")
				EditUtente($(".cont_dati_utenti").attr("id-ut"),$("#dati_utenti_nome").val(),$("#dati_utenti_cognome").val(),$("#dati_utenti_mail").val(),$("#dati_utenti_user").val(),$("#dati_utenti_Privilegio").val(),$("#dati_utenti_Password").val());
			else
				EditUtente($(".cont_dati_utenti").attr("id-ut"),$("#dati_utenti_nome").val(),$("#dati_utenti_cognome").val(),$("#dati_utenti_mail").val(),$("#dati_utenti_user").val(),$("#dati_utenti_Privilegio").val());
		});
		$("#ButtonRemoveUtente").click(function(){			
			RemoveUtente($(".cont_dati_utenti").attr("id-ut"));
		});
		$("#ButtonAddUtente").click(function(){			
			AddUtente($("#dati_utenti_nome").val(),$("#dati_utenti_cognome").val(),$("#dati_utenti_mail").val(),$("#dati_utenti_user").val(),$("#dati_utenti_Password").val(),$("#dati_utenti_Privilegio").val());
		});
		$("#ButtonCercaUtenti").click(function(){			
			CancelEditUtente();
			LoadListaUtentiCerca($("#cerca_utenti_combo_campo").val(),$("#Cerca_utenti_textbox").val());
		});
		$("#ConfirmPassChange").click(function(){			
			if($("#dati_utenti_Password").attr("cambia-pass")=="si")
			{
				$("#dati_utenti_Password").removeAttr("cambia-pass");
				$("#dati_utenti_Password").removeClass("verde");
				$("#ConfirmPassChange").text("✓");
			}
			else
			{
				$("#dati_utenti_Password").attr("cambia-pass","si");
				$("#dati_utenti_Password").addClass("verde");
				$("#ConfirmPassChange").text("✗");
			}
		});
		
		
		
		//Eventi Bottoni Classi
		$("#ButtonClassiShowDivHidden").click(function(){
			$("#div_cerca_Classi_hidden").slideToggle(400);
		});
		$("#ButtonCancelEditClasse").click(function(){
			CancelEditClasse();
		});		
		$("#ButtonSaveEditClasse").click(function(){	
			EditClasse($(".cont_dati_classi").attr("id-ut"),$("#dati_classe_numero").val(),$("#dati_classe_sezione").val(),$("#dati_classe_corso").val(),$("#dati_classe_Nalunni").val(),$("#dati_classe_fotocopie").val());
		});
		$("#ButtonRemoveClasse").click(function(){			
			RemoveClasse($(".cont_dati_classi").attr("id-ut"));
		});
		$("#ButtonAddClasse").click(function(){			
			AddClasse($("#dati_classe_numero").val(),$("#dati_classe_sezione").val(),$("#dati_classe_corso").val(),$("#dati_classe_Nalunni").val(),$("#dati_classe_fotocopie").val());
		});
		$("#ButtonCercaClassi").click(function(){			
			CancelEditClasse();
			LoadListaClassiCerca($("#cerca_Classi_combo_corso").val());
		});
		
		$("#ButtonAddAssociazione").click(function(){		
			AddAssociazione($("div#cont_relazioni_classi").attr("id-ut"),$("#classi_associazioni").val());
		});
		
		$("#ButtonRemoveAssociazione").click(function(){	
				
			if($("#cont_relazioni_Classi table .selected").length==1)
				RemoveAssociazione($("div#cont_relazioni_classi").attr("id-ut"),$("#cont_relazioni_Classi table .selected").attr("id-cl"));
			else
				alert("selezionare una classe");
			
			
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
				var v1=document.createElement('OPTION');
				$(v1).append(" - ");
				$(v1).val(-1);
				$("#cerca_Classi_combo_corso").append(v1);
				
				$.each(arr["dato"], function( index, value ) {
					var v1=document.createElement('OPTION');
					$(v1).append(value["nome"]);
					$(v1).val(value["ID"]);
					$("#dati_classe_corso").append(v1);
					
					
					$("#cerca_Classi_combo_corso").append($(v1).clone());
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
		$.post("include/db_worker.php",{LoadListaUtenti:1},function(data){
			var arr=JSONfn.parse(data);
			if(arr["err"]==1)
			{
				alert(arr["mess"]);
			}
			else
			{
				$("#Lista_Utenti table").html("");
				$.each(arr["dato"], function( index, value ) {
					var v1=document.createElement('tr');
					$(v1).attr("id-ut",value["ID"]);
					var v2=document.createElement('td');
					$(v2).append(value["Cognome"]);
					var v3=document.createElement('td');
					$(v3).append(value["Nome"]);
					$(v1).append(v2);
					$(v1).append(v3);
					$(v1).click(function()
					{
						UnselectAllUtenti();
						$(this).addClass("selected");
						LoadDatiUtente($(this).attr("id-ut"));
					});
					
					$("#Lista_Utenti table").append(v1);
				});
				
			}
		});
	}
	function LoadListaUtentiCerca(campo,pattern)
	{
		$.post("include/db_worker.php",{LoadListaUtentiCerca:1,campo:campo,pattern:pattern},function(data){
			var arr=JSONfn.parse(data);
			if(arr["err"]==1)
			{
				alert(arr["mess"]);
			}
			else
			{
				$("#Lista_Utenti table").html("");
				$.each(arr["dato"], function( index, value ) {
					var v1=document.createElement('tr');
					$(v1).attr("id-ut",value["ID"]);
					var v2=document.createElement('td');
					$(v2).append(value["Cognome"]);
					var v3=document.createElement('td');
					$(v3).append(value["Nome"]);
					$(v1).append(v2);
					$(v1).append(v3);
					$(v1).click(function()
					{
						UnselectAllUtenti();
						$(this).addClass("selected");
						LoadDatiUtente($(this).attr("id-ut"));
					});
					
					$("#Lista_Utenti table").append(v1);
				});
				
			}
		});
	}
	function LoadDatiUtente(ID)
	{
		$.post("include/db_worker.php",{LoadDatiUtente:1,ID:ID},function(data){
			var arr=JSONfn.parse(data);
			if(arr["err"]==1)
			{
				alert(arr["mess"]);
			}
			else
			{
				
				$("#ButtonCanceldit").removeAttr("disabled");
				$("#ButtonSaveEdit").removeAttr("disabled");
				$("#ButtonRemoveUtente").removeAttr("disabled");
				$("#ConfirmPassChange").removeAttr('disabled');
				
				
				$("#dati_utenti_nome").val(arr["dato"][0]["Nome"]);
				$("#dati_utenti_cognome").val(arr["dato"][0]["Cognome"]);
				$("#dati_utenti_mail").val(arr["dato"][0]["E-mail"]);
				$("#dati_utenti_user").val(arr["dato"][0]["Username"]);
				$("#dati_utenti_Privilegio").val(arr["dato"][0]["Privilegio"]);
				$(".cont_dati_utenti").attr("id-ut",arr["dato"][0]["ID"]);
				$("#dati_utenti_Password").val("");
			}
		});
	}
	function AddUtente(Nome,Cognome,Mail,Username,Password,Privilegio)
	{
		if(Nome.trim()=="" || Cognome.trim()=="" || Mail.trim()=="" || Username.trim()=="" )
		{
			alert("Non sono ammessi campi vuoti");
			return;
		}
		
		$.post("include/db_worker.php",{AddUtente:1,Nome:Nome,Cognome:Cognome,Mail:Mail,Username:Username,Password:Password,Privilegio:Privilegio},function(data){
			var arr=JSONfn.parse(data);
			if(arr["err"]==1)
			{
				alert(arr["mess"]);
			}
			else
			{
				CancelEditUtente();
				LoadListaUtenti();
			}
		});
	}
	function RemoveUtente(ID)
	{
		$.post("include/db_worker.php",{RemoveUtente:1,ID:ID},function(data){
			var arr=JSONfn.parse(data);
			if(arr["err"]==1)
			{
				alert(arr["mess"]);
			}
			else
			{
				CancelEditUtente();
				LoadListaUtentiCerca($("#cerca_utenti_combo_campo").val(),$("#Cerca_utenti_textbox").val());
			}
		});
	}
	function EditUtente(ID,Nome,Cognome,Mail,Username,Privilegio,Password)
	{
		if(Nome.trim()=="" || Cognome.trim()=="" || Mail.trim()=="" || Username.trim()=="" )
		{
			alert("Non sono ammessi campi vuoti");
			return;
		}
		//Senza cambio pass
		if (typeof Password == 'undefined')
		{
				$.post("include/db_worker.php",{EditUtente:1,ID:ID,Nome:Nome,Cognome:Cognome,Mail:Mail,Username:Username,Privilegio:Privilegio},function(data){
				var arr=JSONfn.parse(data);
				if(arr["err"]==1)
				{
					alert(arr["mess"]);
				}
				else
				{
					CancelEditUtente();
					LoadListaUtentiCerca($("#cerca_utenti_combo_campo").val(),$("#Cerca_utenti_textbox").val());
				}
			});
		}
		//Con cambio pass
		else
		{	
			$.post("include/db_worker.php",{EditUtente:1,ID:ID,Nome:Nome,Cognome:Cognome,Mail:Mail,Username:Username,Password:Password,Privilegio:Privilegio},function(data){
				var arr=JSONfn.parse(data);
				if(arr["err"]==1)
				{
					alert(arr["mess"]);
				}
				else
				{
					CancelEditUtente();
					LoadListaUtentiCerca($("#cerca_utenti_combo_campo").val(),$("#Cerca_utenti_textbox").val());
				}
			});
		}
	}
	function CancelEditUtente()
	{
		$("#ButtonCanceldit").attr('disabled','disabled');
		$("#ButtonSaveEdit").attr('disabled','disabled');
		$("#ButtonRemoveUtente").attr('disabled','disabled');
		$("#ConfirmPassChange").attr('disabled','disabled');
		
		
		$("#dati_utenti_nome").val("");
		$("#dati_utenti_cognome").val("");
		$("#dati_utenti_mail").val("");
		$("#dati_utenti_user").val("");
		$("#dati_utenti_Password").val("");
		$("#dati_utenti_Privilegio").val(1);
		$(".cont_dati_utenti").removeAttr("id-ut");
		
		$("#dati_utenti_Password").removeAttr("cambia-pass");
		$("#dati_utenti_Password").removeClass("verde");
		$("#ConfirmPassChange").text("✓");
				
				
		UnselectAllUtenti();
	}
	function UnselectAllUtenti()
	{
		$("#Lista_Utenti table .selected").removeClass("selected");
	}
	
	
	
	//<button id="ButtonCancelEditClasse" disabled="disabled" style="float:right;">Annulla</button>
	//<button id="ButtonSaveEditClasse" disabled="disabled" style="float:right;">Salva</button>
	
	//Funzioni Classi
	function LoadListaClassi()
	{
		$.post("include/db_worker.php",{LoadListaClassi:1},function(data){
			var arr=JSONfn.parse(data);
			if(arr["err"]==1)
			{
				alert(arr["mess"]);
			}
			else
			{
				$("#Lista_Classi table").html("");
				$.each(arr["dato"], function( index, value ) {
					var v1=document.createElement('tr');
					$(v1).attr("id-cl",value["ID"]);
					var v2=document.createElement('td');
					$(v2).append(value["Nome"]);
					$(v1).append(v2);
					$(v1).click(function()
					{
						UnselectAllClassi();
						$(this).addClass("selected");
						LoadDatiClasse($(this).attr("id-cl"));
					});
					
					$("#Lista_Classi table").append(v1);
				});
				
			}
		});
	}
	function LoadListaClassiCerca(corso)
	{
		if(corso==-1)
			LoadListaClassi()
		else
		{
			$.post("include/db_worker.php",{LoadListaClassiCerca:1,corso:corso},function(data){
				var arr=JSONfn.parse(data);
				if(arr["err"]==1)
				{
					alert(arr["mess"]);
				}
				else
				{
					$("#Lista_Classi table").html("");
					$.each(arr["dato"], function( index, value ) {
						var v1=document.createElement('tr');
						$(v1).attr("id-cl",value["ID"]);
						var v2=document.createElement('td');
						$(v2).append(value["Nome"]);
						$(v1).append(v2);
						$(v1).click(function()
						{
							UnselectAllClassi();
							$(this).addClass("selected");
							LoadDatiClasse($(this).attr("id-cl"));
						});
						
						$("#Lista_Classi table").append(v1);
					});
				}
			});
		}
	}
	function LoadDatiClasse(ID)
	{
		$.post("include/db_worker.php",{LoadDatiClasse:1,ID:ID},function(data){
			var arr=JSONfn.parse(data);
			if(arr["err"]==1)
			{
				alert(arr["mess"]);
			}
			else
			{
				
				$("#ButtonCancelEditClasse").removeAttr("disabled");
				$("#ButtonSaveEditClasse").removeAttr("disabled");
				$("#ButtonRemoveClasse").removeAttr("disabled");
		
				
				
				$("#dati_classe_numero").val(arr["dato"][0]["Numero classe"]);
				$("#dati_classe_sezione").val(arr["dato"][0]["Sezione"]);
				$("#dati_classe_corso").val(arr["dato"][0]["Corso"]);
				$("#dati_classe_Nalunni").val(arr["dato"][0]["Numero alunni"]);
				$("#dati_classe_fotocopie").val(arr["dato"][0]["Fotocopie rimanenti"]);
				$(".cont_dati_classi").attr("id-ut",arr["dato"][0]["ID"]);

			}
		});
	}
	function AddClasse(Numero,Sezione,Corso,Numero_Alunni,Fotocopie)
	{
		if(Numero.trim()=="" || Sezione.trim()=="" || Numero_Alunni.trim()=="" || Fotocopie.trim()=="" )
		{
			alert("Non sono ammessi campi vuoti");
			return;
		}
		else if( isNaN(Numero) || isNaN(Numero_Alunni) || isNaN(Fotocopie))
		{
			alert("Ricontrollare i Campi");
			return;
		}
		var temp=parseInt(Numero);
		if(temp>5||temp<1)
		{
			alert("La classe deve essere compresa tra 1 e 5");
			return;
		}
		
		
		
		
		$.post("include/db_worker.php",{AddClasse:1,Numero:Numero,Sezione:Sezione,Corso:Corso,Numero_Alunni:Numero_Alunni,Fotocopie:Fotocopie},function(data){
			var arr=JSONfn.parse(data);
			if(arr["err"]==1)
			{
				alert(arr["mess"]);
			}
			else
			{
				CancelEditClasse();
				LoadListaClassi();
			}
		});
	}
	function RemoveClasse(ID)
	{
		$.post("include/db_worker.php",{RemoveClasse:1,ID:ID},function(data){
			var arr=JSONfn.parse(data);
			if(arr["err"]==1)
			{
				alert(arr["mess"]);
			}
			else
			{
				CancelEditClasse();
				LoadListaClassiCerca($("#cerca_Classi_combo_corso").val());
			}
		});
	}
	function EditClasse(ID,Numero,Sezione,Corso,Numero_Alunni,Fotocopie)
	{
		if(Numero.trim()=="" || Sezione.trim()=="" || Numero_Alunni.trim()=="" || Fotocopie.trim()=="" )
		{
			alert("Non sono ammessi campi vuoti");
			return;
		}
		else if( isNaN(Numero) || isNaN(Numero_Alunni) || isNaN(Fotocopie))
		{
			alert("Ricontrollare i Campi");
			return;
		}
		var temp=parseInt(Numero);
		if(temp>5||temp<1)
		{
			alert("La classe deve essere compresa tra 1 e 5");
			return;
		}
		
		$.post("include/db_worker.php",{EditClasse:1,ID:ID,Numero:Numero,Sezione:Sezione,Corso:Corso,Numero_Alunni:Numero_Alunni,Fotocopie:Fotocopie},function(data){
				var arr=JSONfn.parse(data);
				if(arr["err"]==1)
				{
					alert(arr["mess"]);
				}
				else
				{
					CancelEditClasse();
					LoadListaClassiCerca($("#cerca_Classi_combo_corso").val());
				}
		});
	}
	function CancelEditClasse()
	{
		$("#ButtonCancelEditClasse").attr('disabled','disabled');
		$("#ButtonSaveEditClasse").attr('disabled','disabled');
		$("#ButtonRemoveClasse").attr('disabled','disabled');
		
		
		$("#dati_classe_numero").val("");
		$("#dati_classe_sezione").val("");
		$("#dati_classe_corso").val("");
		$("#dati_classe_Nalunni").val("");
		$("#dati_classe_fotocopie").val("");
		$(".cont_dati_classi").removeAttr("id-ut");
		
				
		UnselectAllClassi();
	}
	function UnselectAllClassi()
	{
		$("#Lista_Classi table .selected").removeClass("selected");
	}
	
	
	
	//Funzioni Associazioni
	function LoadListaUtentiAssociazioni()
	{
		$.post("include/db_worker.php",{LoadListaUtenti:1},function(data){
			var arr=JSONfn.parse(data);
			if(arr["err"]==1)
			{
				alert(arr["mess"]);
			}
			else
			{
				$("#cont_relazioni_utenti table").html("");
				$.each(arr["dato"], function( index, value ) {
					var v1=document.createElement('tr');
					$(v1).attr("id-ut",value["ID"]);
					var v2=document.createElement('td');
					$(v2).append(value["Cognome"]);
					var v3=document.createElement('td');
					$(v3).append(value["Nome"]);
					$(v1).append(v2);
					$(v1).append(v3);
					$(v1).click(function()
					{
						CancelEditAssociazione();
						$("#ButtonAddAssociazione").removeAttr('disabled');
						UnselectAllUtentiAssociazioni();
						$(this).addClass("selected");
						LoadListaClassiAssociazioni($(this).attr("id-ut"));
					});
					
					$("#cont_relazioni_utenti table").append(v1);
				});
				
			}
		});
	}
	function CancelEditAssociazione()
	{
		$("#ButtonAddAssociazione").attr('disabled','disabled');
		$("#ButtonRemoveAssociazione").attr('disabled','disabled');
	}
	function UnselectAllUtentiAssociazioni()
	{
		$("#cont_relazioni_utenti table .selected").removeClass("selected");
	}
	function UnselectAllClassiAssociazioni()
	{
		$("#cont_relazioni_Classi table .selected").removeClass("selected");
	}

	
	function LoadListaClassiAssociazioni(IDUtente)
	{
		$.post("include/db_worker.php",{LoadListaClassiAssociazioni:1,IDUtente:IDUtente},function(data){
			var arr=JSONfn.parse(data);
			if(arr["err"]==1)
			{
				alert(arr["mess"]);
			}
			else
			{
				$("div#cont_relazioni_classi").attr("id-ut",IDUtente);
				$("#cont_relazioni_classi table").html("");
				$.each(arr["dato"], function( index, value ) {
					var v1=document.createElement('tr');
					$(v1).attr("id-cl",value["ID"]);
					var v2=document.createElement('td');
					$(v2).append(value["Nome"]);
					$(v1).append(v2);
					$(v1).click(function()
					{
						UnselectAllClassiAssociazioni();
						$("#ButtonRemoveAssociazione").removeAttr('disabled');
						$(this).addClass("selected");
					});
					
					$("#cont_relazioni_classi table").append(v1);
				});
				
			}
		});
	}
	function AddAssociazione(IDUtente,IDClasse)
	{
		//alert(IDUtente+" "+IDClasse);
		
		$.post("include/db_worker.php",{AddAssociazione:1,IDUtente:IDUtente,IDClasse:IDClasse},function(data){
			var arr=JSONfn.parse(data);
			if(arr["err"]==1)
			{
				alert(arr["mess"]);
			}
			else
			{
				LoadListaClassiAssociazioni($("div#cont_relazioni_classi").attr("id-ut"));
			}
		});
		
	}
	function RemoveAssociazione(IDUtente,IDClasse)
	{
		//alert(IDUtente+" "+IDClasse);
		
		$.post("include/db_worker.php",{RemoveAssociazione:1,IDUtente:IDUtente,IDClasse:IDClasse},function(data){
			var arr=JSONfn.parse(data);
			if(arr["err"]==1)
			{
				alert(arr["mess"]);
			}
			else
			{
				LoadListaClassiAssociazioni($("div#cont_relazioni_classi").attr("id-ut"));
			}
		});
		
		
		
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

#ContainerButtonUtentiShowDivHidden,#ContainerButtonClassiShowDivHidden{
	height: 9px;
}
#ButtonUtentiShowDivHidden,#ButtonClassiShowDivHidden{
	float:right;
	margin: 4px;
}

#div_cerca_utenti_hidden,#div_cerca_Classi_hidden
{
	border: 1px solid black;
	margin: 2px;padding: 4px;
	width: 280px;
	height: 80px;
}
#div_cerca_utenti_hidden table,#div_cerca_Classi_hidden table
{
	width:100%;
	height:80px;
}


#Lista_Utenti table tr,#Lista_Classi table tr,#cont_relazioni_utenti table tr,#cont_relazioni_Classi table tr
{
	cursor:pointer;
}
#Lista_Utenti table tr.selected,#Lista_Classi table tr.selected,#cont_relazioni_utenti table tr.selected,#cont_relazioni_Classi table tr.selected
{
	  background: rgb(255, 178, 178);
}
#Lista_Utenti table tr:hover,#Lista_Classi table tr:hover,#cont_relazioni_utenti table tr:hover,#cont_relazioni_Classi table tr:hover
{
	    background: rgb(255, 218, 218);
}



#dati_utenti_Password.verde
{
	  background: rgb(148, 253, 148);
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
																				<option value="Cognome">Cognome</option>
																				<option value="Nome">Nome</option>
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
																
															</table>
														</div>
														<div id="Menu_Utenti" >
															<button id="ButtonAddUtente">+</button>
															<button id="ButtonRemoveUtente" disabled="disabled">-</button>
															
															<button id="ButtonCanceldit" disabled="disabled" style="float:right;">Annulla</button>
															<button id="ButtonSaveEdit" disabled="disabled" style="float:right;">Salva</button>
															
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
																	<button id="ConfirmPassChange" disabled="disabled">&#10003;</button>
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
															
															
															
															<div id="ContainerButtonUtentiShowDivHidden">
															<!-- &#9650 su | &#9660 giu-->
																<button id="ButtonClassiShowDivHidden">Cerca &#9660</button>
															</div><br>
															<div id="div_cerca_Classi_hidden" style="display: none;">
																<table >
																	<tr>
																		<td>
																			Corso:
																		</td>
																		<td>
																			<select id="cerca_Classi_combo_corso">
																				
																			</select>
																		</td>
																	</tr>
																	<tr>
																		<td>
																			
																		</td>
																		<td>
																			<button id="ButtonCercaClassi">Cerca</button>
																		</td>
																		
																	</tr>
																</table>
															</div>
															
															
														</div>
														<div id="Lista_Classi" >
															<table style="width:100%;">
																
															</table>
														</div>
														<div id="Menu_Utenti" >
															<button id="ButtonAddClasse">+</button>
															<button id="ButtonRemoveClasse" disabled="disabled">-</button>
															<button id="ButtonCancelEditClasse" disabled="disabled" style="float:right;">Annulla</button>
															<button id="ButtonSaveEditClasse" disabled="disabled" style="float:right;">Salva</button>
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
															<table>
															
															</table>
														</div>
													</td>
													<td>
													
													</td>
													<td style="vertical-align: top;   width: 200px;">
														<div id="cont_relazioni_Classi">
															<table>
															
															</table>
														</div>
														<br>
														
														<div style="float:right;">
															<select id="classi_associazioni">
																
															</select>
															<button id="ButtonAddAssociazione" disabled="disabled">+</button>					
														</div>
														<button id="ButtonRemoveAssociazione" disabled="disabled">-</button>
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