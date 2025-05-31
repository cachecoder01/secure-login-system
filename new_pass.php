<?php
include 'db/connect.php';

$em=trim($_POST['email']);
$em=filter_var($em, FILTER_VALIDATE_EMAIL);

$sa=trim($_POST['sec_ans']);
$sa=htmlspecialchars(strip_tags($sa), ENT_QUOTES, 'UTF-8');

$newpass=trim($_POST['pass']);
$newpass=htmlspecialchars(strip_tags($newpass), ENT_QUOTES, 'UTF-8');

$cpass=trim($_POST['conpass']);
$cpass=htmlspecialchars(strip_tags($cpass), ENT_QUOTES, 'UTF-8');


$stmt=$conn->prepare("SELECT sec_answer FROM reginfo WHERE email=?");
$stmt->bind_param("s", $em);
$stmt->execute();
$output=$stmt->get_result();

if ($output->num_rows>0) {
	while ($row = $output->fetch_assoc()) {
		$sec_ans=$row['sec_answer'];

		$sa=password_hash($sa, PASSWORD_DEFAULT);
		$newpass=password_hash($newpass, PASSWORD_DEFAULT);
		
		if ($newpass==$cpass) {
			$stmt=$conn->prepare("UPDATE reginfo SET password='$newpass' WHERE email=?");
			$stmt->bind_param("s", $em);
			$stmt->execute();
	
			if ($stmt->execute()) {
				echo '
				<table align="center">
					<tr>
						<td>password changed successfully</td>
					</tr>
					<tr>
						<td style="padding: 0 20px;"><a href="dashboard.php"> OK </td>
					</tr>
				</table>';
			}else {
				echo "unable to update pass";
			}
		}
	}
}else {
		echo '
		<table align="center">
			<tr>
				<td style="padding: 20px 100px 0 100px;">Invalid details<br></td>
			</tr>
			<tr>
				<td><a href="pass_reset.html">Try again</a></td>
			</tr>
		</table>';
}

$stmt->close();
$conn->close();
?>