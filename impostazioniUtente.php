<?php
if(!isset($_SESSION))
	session_start();

include("include/func.php");

if(!CheckSessionLogin())
{
	echo "<html></head><script language='javascript'>top.location.href = 'login.php';</script></head><html>";
	return;
}

if(isset($_GET["CambiaPassword"]))
{
	CambiaPassword();
}
else if(isset($_GET["CambiaMail"]))
{
	CambiaMail();
}
else
	PrintImpostazioni();





function PrintImpostazioni()
{
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
							<?php include("_sidebar.php"); ?>
						</div>
					</td>
					<td>
						<div class="container">
				
							<h1>Impostazioni</h1>
							<table style="margin: 40px 0px 0px 20px;">
								<tr>
									<td>
										<a href="<?php echo $_SERVER['PHP_SELF'];?>?CambiaPassword=">Cambia Password</a>
									</td>
								</tr>
								<tr>
									<td>
										<a href="<?php echo $_SERVER['PHP_SELF'];?>?CambiaMail=">Cambia Mail</a>
									</td>
								</tr>
							</table>
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

<?php

}


function CambiaPassword($mess="")
{
?>


<html>
	<head>
		<?php include("_head.php"); ?>	
		<script>
			$(document).ready(function(){
				
				$("#SendButton").click(function(){
					if($("#NewPass").val()!=$("#NewPass2").val())
					{
						alert("Le due password non coincidono!\r\n");
						return;
					}
					
					$.post('include/db_worker.php',{NewPass:$("#NewPass").val(),OldPass:$("#OldPass").val(),CambiaPassword:""},function(data){
						var arr=JSONfn.parse(data);
						
						$(".messaggioAjax").html(arr["mess"]);
						
					});
				});
	
			});

			
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
				
							<h1>Cambia Password</h1>
							
							
				
							<div style="margin: 40px 0px 0px 20px;">
							<div class="messaggioAjax">
							
							</div>
								
								
								<table style="margin-top:40px;">
								<tr>
									<td>
										Vecchia Password
									</td>
									<td>
										<input type="password" id="OldPass"></input>
									</td>
								</tr>
								<tr>
									<td>
										Nuova Password
									</td>
									<td>
										<input type="password" id="NewPass"></input>
									</td>
								</tr>
								<tr>
									<td>
										Re-inserisci la Password
									</td>
									<td>
										<input type="password" id="NewPass2"></input>
									</td>
								</tr>
								<tr>
									<td>
										
									</td>
									<td>
										<button id="SendButton">Cambia</button>
									</td>
								</tr>
									
							</table>
							</div>
							
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

<?php

}


function CambiaMail($mess="")
{
?>


<html>
	<head>
		<?php include("_head.php"); ?>	
		<script>
			$(document).ready(function(){
				
				$("#SendButton").click(function(){
					
					$.post('include/db_worker.php',{NewMail:$("#NewMail").val(),CambiaMail:""},function(data){
						var arr=JSONfn.parse(data);
						
						$(".messaggioAjax").html(arr["mess"]);
						
					});
				});
	
			});

			
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
				
							<h1>Cambia Mail</h1>
							
							
				
							<div style="margin: 40px 0px 0px 20px;">
							<div class="messaggioAjax">
							
							</div>
								
								
								<table style="margin-top:40px;">
								<tr>
									<td>
										Nuova Mail
									</td>
									<td>
										<input id="NewMail"></input>
									</td>
								</tr>
								<tr>
									<td>
										
									</td>
									<td>
										<button id="SendButton">Cambia</button>
									</td>
								</tr>
									
							</table>
							</div>
							
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

<?php

}

?>




