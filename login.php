<!DOCTYPE html>
<html lang="eng">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initail-scale=1.0">
	<link rel="stylesheet" href="./assets/css/style.css">
	<style type="text/css">
		body {
			background-color: #eee;
		}
		table {
			margin-top: 200px;
		}
	</style>
</head>
<body>

<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	include 'db/connect.php';

	$email = trim($_POST['email']);
	$email = filter_var($email, FILTER_VALIDATE_EMAIL);

	$pass = trim($_POST['pass']);
	$pass = htmlentities(strip_tags($pass), ENT_QUOTES, 'UTF-8');

	$stmt=$conn->prepare("SELECT password FROM reginfo WHERE email=?");
	$stmt->bind_param("s", $email);
	$stmt->execute();

	$result=$stmt->get_result();
	if ($result->num_rows>0) {

		while ($row = $result->fetch_assoc()) {
			$s_pass=$row['password'];

			if (password_verify($pass, $s_pass)) {
				$_SESSION['user_logged_in'] = true;
				$_SESSION['email'] = $email;
				header('location: dashboard.php');
				exit();
			}else {
				echo '<table align="center">
						<tr>
							<td style="padding: 20px;">Invalid login details</td>
						</tr>
						<tr>
							<td style="padding: 20px; padding-top: 0; text-align: right;"><a href="login.html">Try again</a></td>
						</tr>
					</table>';
			}
		}

	}else {
	  	echo '
	  	<table align="center">
			<tr>
				<td style="padding: 20px;">Account does not exits</td>
			</tr>
			<tr>
				<td style="padding: 20px; padding-top: 0; display: flex; flex: wrap;">
					<div style="text-align: left; margin-right: 18px;"><a href="login.html">Try again</a></div>
					<div style="text-align: right; margin-left: 18px;"><a href="reg.html">Register</a></div>
				</td>
			</tr>
		</table>';
	}

}else {
	echo "Invalid Request";
}
?>

</body>
</html>