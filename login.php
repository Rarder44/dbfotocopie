<?php
if(!isset($_SESSION))
	session_start();

include_once("include/func.php");


if(isset($_POST["logOut"]) || isset($_GET["logOut"]))
{
	session_unset();
	PrintLoginPanel();
}
else if(isset($_POST["LogOutAjax"]))
{
	session_unset();
}
else if(isset($_POST["user"]) && isset($_POST["pass"]))
{
	if(isset($_POST["LoginAjax"]))
		if(login($_POST["user"],md5($_POST["pass"])))
		{
			$_SESSION["user"]=$_POST["user"];
			$_SESSION["pass"]=md5($_POST["pass"]);
		}
		else
			echo "Errore durante la login";
	else
		if(login($_POST["user"],md5($_POST["pass"])))
		{
			$_SESSION["user"]=$_POST["user"];
			$_SESSION["pass"]=md5($_POST["pass"]);
			
			
			//redirect index
			echo "<html></head><script language=\"javascript\">top.location.href = \"index.php\";</script></head><html>";
		}
		else
			PrintLoginPanel("Errore durante la login");
		
}
else if(CheckSessionLogin())
{

	echo "<html></head><script language=\"javascript\">top.location.href = \"index.php\";</script></head><html>";
}
else
{
	PrintLoginPanel();
}

function PrintLoginPanel($mess="")
{
	?>
	
	<html>
	<head>
		<?php include("_head.php"); ?>	
		
		<script>
			$(document).ready(function(){
				$("#loginButton").click(function(){
					 DoLogin();
				});	
				
				$("#user , #pass").keypress(function(e) {
					if(e.which == 13) {
						 DoLogin();
					}
				});
			});
			function DoLogin()
			{
				$.post("login.php",{user:$("#user").val(),pass:$("#pass").val(),LoginAjax:""},function(data){
						if($.trim(data)=="")
							top.location.href = "index.php";
						else
							alert(data);
					});
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
						</div>
					</td>
					<td>
						<div class="container">
							<h1>Login</h1>
							<br>
							<div id="mess" style="height:20px;color:red;">
								<?php echo $mess;?>
							</div>
							<table>
								<tr>
									<td>
										Username:
									</td>
									<td>
										<input id="user"> </input>
									</td>
								</tr>
								<tr>
									<td>
										Password:
									</td>
									<td>
										<input id="pass"> </input>
									</td>
								</tr>
								<tr>
									<td>
										
									</td>
									<td>
										<button id="loginButton">Login</button>
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
?>
	
