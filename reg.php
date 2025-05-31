<!DOCTYPE html>
<html lang="eng">
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link rel="stylesheet" type="text/css" href="./assets/css/style.css">
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
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	include 'db/connect.php';

	$b_name=trim($_POST['b_name']);
	$b_name=htmlspecialchars(strip_tags($b_name), ENT_QUOTES, 'UTF-8');

	$name=trim($_POST['name']);
	$name=htmlspecialchars(strip_tags($name), ENT_QUOTES, 'UTF-8');

	$email=trim($_POST['email']);
	$email=filter_var($email, FILTER_VALIDATE_EMAIL);

	$sec_q=trim($_POST['question']);
	$sec_q=htmlspecialchars(strip_tags($sec_q), ENT_QUOTES, 'UTF-8');

	$sec_a=trim($_POST['answer']);
	$sec_a=htmlspecialchars(strip_tags($sec_a), ENT_QUOTES, 'UTF-8');

	$pass=trim($_POST['pass']);
	$pass=htmlspecialchars(strip_tags($pass), ENT_QUOTES, 'UTF-8');

	$cpass=trim($_POST['cpass']);
	$cpass=htmlspecialchars(strip_tags($cpass), ENT_QUOTES, 'UTF-8');

	$img="";
	if (isset($_FILES["img"]) && $_FILES["img"]["error"] === 0) {
		$img=$_FILES["img"]["name"];
	}

	if (isset($_FILES["img"]) && $_FILES["img"]["error"] === 0) {

		$target_Dir = "./assets/images/brand_logo/";
		if (!is_dir($target_Dir)) {
			mkdir($target_Dir, 0777, true);
		}

		$imageName = time() ."_". basename((string)$_FILES['img']['name']);

		$targetFile = $target_Dir . $imageName;

		$check = getimagesize($_FILES['img']['tmp_name']);
		if ($check !== false) {
			if (move_uploaded_file($_FILES['img']['tmp_name'], $targetFile)) {
				$imgPath = (string)$targetFile;
				$img = $imageName;
			}
		}else{
			echo 'upload error:' .$_FILES['img']['error'];
			exit();
		}

		$allowed_types = ['image/jpeg', 'image/png', 'image/webp'];
		if (!in_array($check['mime'], $allowed_types)) {
			die('Only PNG, JPEG, AND WebP are allowed');
		}
	}elseif ($_FILES['img']['error'] !== 4) {
		echo "upload error: " .$_FILES['img']['error'];
		exit();
	}

	$stmt = $conn->prepare("SELECT id FROM reginfo WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<table align='center'>
        		<tr>
        			<td style='padding: 20px;'>Email already registered!</td>
        		</tr>
        		<tr>
        			<td style='padding: 20px; padding-top: 0; text-align: right;'><a href='login.html'>Login</a></td>
        		</tr>
        	</table>";
        exit;
    }
    $stmt->close();
	$result="";
	if ($pass !== $cpass or strlen($pass)>20) {
		echo "<table align='center'>
				<tr>
					<td style='padding: 20px;'>Password do not match</td>
				</tr>
				<tr>
					<td style='padding: 20px; padding-top: 0; text-align: right;'><a href='reg.html'>Try again</a></td>
				</tr>
			</table>";
	}else {

	$pass = password_hash($pass, PASSWORD_DEFAULT);
	$sec_a= password_hash($sec_a, PASSWORD_DEFAULT);
	
		$stmt=$conn->prepare("INSERT INTO reginfo(brand_name, brand_img, name, email, password, sec_question, sec_answer)VALUE(?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("sssssss", $b_name, $img, $name, $email, $pass, $sec_q, $sec_a);
		$result=$stmt->execute();
	}
	if ($result) {
		echo include 'login.html';
		}
}else{
	echo 'Invalid Request';
}
?>

</body>
</html>