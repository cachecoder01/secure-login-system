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
	<?php
	if (!empty($b_img)) {
		echo '<link rel="shortcut icon" type="Image/icon" href="./assets/images/brand_logo/' .$b_img. '">';
	}else {
		echo '<link rel="shortcut icon" type="Image/icon" href="./assets/images/logo/brand-logo.png">';
	}
	?>
	
	<link rel="stylesheet" type="text/css" href="./assets/css/style.css">

	<style type="text/css">
		body {
			padding: 0;
			margin: 0;
		}
		a {color: white;}
		a:visited {
			color: white;
		}
		footer {
      bottom: 5px;
      position: fixed;
      justify-content: center;
      text-align: center;
      margin: 5px;
    }
    .dropdown {
	overflow: hidden;
	margin: 0;
}
.dropbtn, .dropbtn:focus { 
	padding: 3px;
	padding-left: 5px;
	margin-right: 40px;
	background-color: inherit;
	color: white;
	border: none;
}
.dropdown-content {
	display: none;
	margin-top: 15px;
	position: absolute;
	background-color: purple;
	box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.05);
	z-index: 9000000;
	border-radius: 2px;
	height: 70px;
	padding: 5px;}
.dropdown-content a {
	color: white;
	padding: 5px;
	text-decoration: none;
	display: block;
	z-index: 9000000;}
.show {
	display: block;
	z-index: 2;
}
	</style>
</head>
<body>

	<div id="header">
		<?php
		if (!empty($b_img)) {
		echo '<div class="brand_logo">
				<img src="./assets/images/brand_logo/' .$b_img. '" width="50">
			</div>
			<div class="brand_name">
				<h1 class="brand">' .$b_name. '<div style="display: inline; color: purple;">.</div></h1>
			</div>';
		}else {
		echo '<div class="brand_name">
				<h1 class="brand">' .$b_name. '<div style="display: inline; color: purple;">.</div></h1>
			</div>';
		}
		?>
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
                      				<a onclick="return confirm('Are you sure you want to LogOut?')" href="logout.php">LogOut <i class="fa fa-sign-out"></i></a>
                      				<a href="pass_reset.html">Change Password <i class="fa fa-lock"></i></a>
                      			</div>
                      		</div>
                  		</span>
				</div>
				<div style="border: thin solid purple; padding: 5px; color: white;">
					<a href="https://cachecoder.site" target="_blank">Contact us</a>
				</div>
			</div>
		
	</div>
	<div id="sub_header">
	</div>

	<table align="center" style="margin-top: 200px; text-align: center; box-shadow: none; background: none;">
		<tr>
			<td style="padding: 20px;">
				<?php
				if (!empty($b_img)) {
				echo '<img src="./assets/images/brand_logo/' .$b_img. '" width="200">';
				}else {
					echo '<img src="./assets/images/logo/me.jpg" width="200">';
				}
				?>
			</td>
		</tr>
		<tr>
			<td>Name: <em><?= $name ?></em><br>
				Email: <em><?= $em ?></em></td>
		</tr>
	</table>

	<section>
      <footer align="center">
          <p style="font-size: small; color: #888ea5;">
            &copy; All Rights Reserved. Design and Developed by
            <a href="https://cachecoder.site" target="_blank" style="color: #444;">CacheCoder</a>
          </p>
      </footer>
    </section>

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