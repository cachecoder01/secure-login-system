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
		#header {
			margin: 0;
			top: 0;
			position: fixed;
			width: 100%;
			padding: 15px;
  			background-color: #15161D;
  			
  			color: white;
		}
		.brand_logo {
			padding: 5px;
			float: left;
		}
		.brand_name {
			float: left;
		}
		.profile {
			float: right;
			margin-right: 40px;
			display: flex;
			flex: wrap;
			padding: 3px;
			margin-top: 20px;
		}
		@media only screen and (max-width: 768px){
			.profile {
				margin-top: 3px;
			}
		}

		.dropdown {overflow: hidden; margin: 0;}
    	.dropbtn, .dropbtn:focus {padding: 3px; padding-left: 5px; margin-right: 40px; background-color: inherit; color: white; border: none; padding-top: 5px}
    	.dropdown-content {display: none; margin-top: 15px; position: absolute; background-color: red; box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.05); z-index: 9000000; border-radius: 2px; height: 30px; padding: 5px;}
    	.dropdown-content a {color: white; padding: 5px; text-decoration: none; display: block; z-index: 9000000;}
    	.show {display: block; z-index: 2000;}

    	#sub_header {
    		margin: 0;
    		width: 100%;
    		height: 5px;
    		background-color: red;
    		position: sticky;
    	}
	</style>
</head>
<body>

	<div id="header">
		
			<div class="brand_logo">
				<img src="./assets/images/brand_logo/<?= $b_img ?>" width="50">
			</div>
			<div class="brand_name">
				<h1 class="brand"><?= $b_name ?><div style="display: inline; color: red;">.</div></h1>
			</div>

			<div class="profile">
				<div style="padding: 3px; padding-right: 5px; border-right: thin solid red;">
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
                      				<a>LogOut <i class="fa fa-sign-out"></i></a>
                      			</div>
                      		</div>
                  		</span>
				</div>
				<div style="border: thin solid red; padding: 5px;">
					Contact us
				</div>
			</div>
		
	</div>
	<div id="sub_header">

	</div>

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