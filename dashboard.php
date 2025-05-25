<?php
session_start();
$em=$_SESSION['email'];
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
	header('location: login.html');
	exit();
}
?>

<?php
	include 'db/connect.php';
	$em=$_SESSION['email'];
	$stmt = $conn->prepare("SELECT * FROM reginfo WHERE email = ?");
    $stmt->bind_param("s", $em);
    $stmt->execute();

    $result=$stmt->get_result();
    if ($result->num_rows > 0) {
    	while ($row = $result->fetch_assoc()) {
    		$b_name=$row["brand_name"];
    		$b_img=$row["brand_img"];
    		$name=$row["name"];
    	}
    }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Your Dashboard</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
	<link rel="shortcut icon" type="Image/icon" href="./assets/images/brand_logo/<?= $b_img ?>">
	<link rel="stylesheet" type="text/css" href="./assets/css/style.css">

	<style type="text/css">
		body {
			padding: 0;
			margin: 0;
		}

		
	</style>
</head>
<body>

	<div id="header">
		
			<div class="brand_logo">
				<img src="./assets/images/brand_logo/<?= $b_img ?>" width="50">
			</div>
			<div class="brand_name">
				<h1 class="brand"><?= $b_name ?><div style="display: inline; color: purple;">.</div></h1>
			</div>

			<div class="profile">
				<div style="padding: 3px; padding-right: 5px; border-right: thin solid purple;">
					<i class="fas fa-user"></i>
				</div>
				<div style="padding: 5px;">
					<?= $name ?>
				</div>
				<div style="">
					<button onclick="myfunction()" class="dropbtn"><i class="fa fa-caret-down"></i></button>
                  		<span>
                  			<div id="myDropdown" class="dropdown-content">
                    			<div>
                      				<a href="logout.php">LogOut <i class="fa fa-sign-out"></i></a>
                      			</div>
                      		</div>
                  		</span>
				</div>
				<div style="border: thin solid purple; padding: 5px;">
					<a href="contact_form">Contact us</a>
				</div>
			</div>
		
	</div>
	<div id="sub_header">
	</div>

	<table align="center" style="margin-top: 200px; text-align: center; box-shadow: none; background: none;">
		<tr>
			<td style="padding: 20px;">
				<img src="./assets/images/brand_logo/<?= $b_img ?>" width="200">
			</td>
		</tr>
		<tr>
			<td>Name: <em><?= $name ?></em><br>
				Email: <em><?= $em ?></em></td>
		</tr>
	</table>
	<script>
    	function myfunction() {
    	  document.getElementById("myDropdown").classList.toggle("show");
    	}
    	window.onclick=function (event) {
    	  if (!event.target.matches('.dropbtn')) {var dropdowns = document.getElementByClassName("dropdown-content");
    	    var i;
    	    for (i = 0; i < dropdowns.length; i++) {
    	      var openDropdown = dropdowns[i];
    	      if (openDropdown.classList.contains('show')) {openDropdown.classlist.remove('show');}
    	      }
    	    }   
    	  }
  	</script>

</body>
</html>