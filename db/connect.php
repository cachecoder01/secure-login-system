<?php

	$conn=mysqli_connect("localhost", "root", "", "login_setup");

	if (!$conn) {
		die("connection failed" . mysqli_connect_error());
	}

?>