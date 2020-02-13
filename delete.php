<?php 
	session_start();	// Chạy session
	if (!isset($_SESSION['User']))
		header('location:login.php');
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Delete</title>
</head>

<body>
	<?php
		include("connection.php");
	?>
    
    <?php
		$uid = $_REQUEST['XOA'];
		if ($uid != "") {
			$sql = "DELETE FROM `datve` 
					WHERE `User` = '".$uid."'";
			if ($query = mysqli_query($conn, $sql)) {
				echo "<script>alert('Xóa thành công!')</script>";
			} else {
				echo "<script>alert('Xóa KHÔNG thành công!')</script>";	
			}
			header('location:register.php');
		}
	?>
</body>
</html>