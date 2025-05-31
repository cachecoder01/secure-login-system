<!DOCTYPE html>
<html lang="eng">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">

	<title>Password Reset</title>

		<link rel="stylesheet" type="text/css" href="./assets/css/style.css">
  	<link rel="shortcut icon" type="image/icon" href="./assets/images/logo/brand-logo.png">

  	<!--font aweasome -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

	<style type="text/css">
		body {
			background-color: #eee;
		}
		table {
			margin-top: 150px;
		}
		footer {
      bottom: 5px;
      position: fixed;
      justify-content: center;
      text-align: center;
    }
    input {
	background-color: #eee;
	border: thin solid #ddd;
	border-radius: 2px;
	outline: none;
	width: 250px;
	padding: 8px;
}
input:focus {
	border: thin solid purple;
	box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
}
button {
    font-weight: bold;
    padding: 10px;
    text-align: center;
    text-decoration: none;
    border-radius: 4px;
    border: none;
    margin: 5px 10px 0 0;
    color: white;
}
	</style>
	
</head>
<body>

	<?php
	session_start();
	include 'db/connect.php';
	$em="";
	if (!isset($_SESSION["user_logged_in"]) || $_SESSION["user_logged_in"] !== true) {
		$em=trim($_POST['email']);
		$em=filter_var($em, FILTER_SANITIZE_STRING);
	}else{
		$em=$_SESSION['email'];
	}

	$email=trim($_POST['email']);
	$email=filter_var($email, FILTER_SANITIZE_STRING);

		$stmt=$conn->prepare("SELECT * FROM reginfo WHERE email=?");
		$stmt->bind_param("s", $em);
		$stmt->execute();

		$result=$stmt->get_result();
		if ($result->num_rows>0 AND $em==$email) {
			while ($row=$result->fetch_assoc()) {
				$sec_quest=$row['sec_question'];
				$email=$row['email'];
				echo '
					<table align="center">
						<tr>
      				<td>
      				  <a href="dashboard.php">
      				  	<i class="fa fa-angle-left"></i> Back
      				  </a>
      				</td>
    				</tr>
						<tr>
							<td>
					  		<p style="font-size: small; width: 250px"> ' .$sec_quest. '</p>
					  			<form method="POST" action="new_pass.php">
					  				<input type="hidden" name="email" value="' .$em. '">
					  				<input type="text" name="sec_ans" placeholder="Answer" required=""><br><br>
					  				<input type="password" name="pass" placeholder="New password" required=""><br><br>
										<input type="password" name="conpass" placeholder="Confirm password" required="">
							</td>
						</tr>
						<tr>
							<td style="padding-bottom: 20px">
								  	<button style="background-color: purple; width: 250px;">Submit</button>
									</form>
							</td>
						</tr>
					</table>';
				}
			}else
			echo '
				<table align="center">
					<tr>
						<td>Invalid details<br></td>
					</tr>
					<tr>
						<td style="padding-bottom: 20px; text-align: right;"><a href="pass_reset.html">Try again</a></td>
					</tr>
				</table>';

	$stmt->close();
	$conn->close();
	?>

</body>
</html>