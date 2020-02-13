<?php
	session_start();
	include("connection.php");
	
	$loginInfo = "";
	if (isset($_SESSION['User']) && $_SESSION['User'] != "") {
		$sql = "SELECT * FROM datve";
		$q = mysqli_query($conn, $sql);
		
		$loginInfo = mysqli_fetch_array($q);
		$arrNgayDi = explode("/", $loginInfo["NgayDi"]);
		$arrNgayVe = explode("/", $loginInfo["NgayVe"]);
	}
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Đặt vé máy bay</title>
</head>

<body>
	<h1>Đặt mua vé máy bay</h1>
    <hr>
    
    <form method="post">
    	<table>
        	<tr>
            	<td>Điểm đi<br>
                	<select name="cbbDiemDi">
                    	<?php 
							$sql = "SELECT DiemDi FROM diemdi";
							$q = mysqli_query($conn, $sql);
							
							while ($row = mysqli_fetch_array($q)) {
						?>
                    		<option value="<?php echo $row["DiemDi"];?>"
                                            <?php if ($loginInfo != "" && $row["DiemDi"] == $loginInfo["DiemDi"]) echo 'selected';?>>
												
											<?php echo $row["DiemDi"];?>
                            </option>
                        <?php
							}
						?>
                    </select>
                </td>
                <td>Điểm đến<br>
                	<select name="cbbDiemDen">
                    	<?php 
							$sql = "SELECT DiemDen FROM diemden";
							$q = mysqli_query($conn, $sql);
							
							while ($row = mysqli_fetch_array($q)) {
						?>
                    		<option value="<?php echo $row["DiemDen"];?>"
                                            <?php if ($loginInfo != "" && $row["DiemDen"] == $loginInfo["DiemDen"]) echo 'selected';?>>
												
											<?php echo $row["DiemDen"];?>
                            </option>
                        <?php
							}
						?>
                    </select>
                </td>
            </tr>
            
            <tr>
            	<td>Ngày đi<br>
                	<select name="cbbNgayDi">
                    	<?php
							$i = 1;
							while ($i <= 31) {
                        ?>
                    	<option value="<?php echo $i;?>"
                                        <?php if ($loginInfo != "" && $i == $arrNgayDi[0]) echo 'selected';?>>
										<?php echo $i;?></option>
                        <?php
								$i++;
							}
						?>
                    </select>
                    <input type="month" name="cbbThangDi" value="<?php 
										if ($loginInfo != "")
											echo $arrNgayDi[1];?>">
                </td>
                <td>Ngày về<br>
                	<select name="cbbNgayVe">
	                    <?php
							$i = 1;
							while ($i <= 31) {
                        ?>
                    	<option value="<?php echo $i;?>"
                        				<?php if ($loginInfo != "" && $i == $arrNgayVe[0]) echo 'selected';?>>
										<?php echo $i;?></option>
                        <?php
								$i++;
							}
						?>
                    </select>
                    <input type="month" name="cbbThangVe" value="<?php 
										if ($loginInfo != "")
											echo $arrNgayVe[1];?>">
                </td>
            </tr>
        </table>
        
        <hr>
        
        <table>
        	<tr><td>Người lớn </td>
            	<td><select name="cbbNL">
                	<?php
						$i = 1;
						while ($i <= 10) {
                       ?>
                   	<option value="<?php echo $i;?>"
                    				<?php if ($loginInfo != "" && $i == $loginInfo["NguoiLon"]) echo 'selected';?>>
										<?php echo $i;?></option>
                       <?php
							$i++;
						}
					?>
                </select></td> 
                <td>Từ 12 tuổi trở lên)</td></tr>
            <tr><td>Trẻ em </td>
            	<td><select name="cbbTE">
					<?php
						$i = 1;
						while ($i <= 10) {
                       ?>
						<option value="<?php echo $i;?>"
                    				<?php if ($loginInfo != "" && $i == $loginInfo["TreEm"]) echo 'selected';?>>
										<?php echo $i;?></option>
                       <?php
							$i++;
						}
					?>
                </select></td> 
                <td>(Từ 2 đến dưới 12 tuổi)</td></tr>
            <tr><td>Em bé</td>
            	<td><select name="cbbEB">
					<?php
						$i = 1;
						while ($i <= 10) {
                       ?>
                   	<option value="<?php echo $i;?>"
                    				<?php if ($loginInfo != "" && $i == $loginInfo["EmBe"]) echo 'selected';?>>
										<?php echo $i;?></option>
                       <?php
							$i++;
						}
					?>
                </select></td>
                <td>(Dưới 2 tuổi)</td></tr>
        </table>
        
        <hr>
        
        <font size="+2">Xem video hướng dẫn</font>
        <input type="submit" name="btOK" value="<?php if ($loginInfo == "") echo "Mua ngay";
													  else echo "Sửa thông tin";?>">
        <?php
        	if ($loginInfo != "") {
		?>                      
        <br>                        
		<a href="delete.php?XOA=<?php echo $loginInfo['User']?>" onClick="if(confirm('Muốn xóa không?')) 
										return true;
								    return false;">Xóa</a>
		<?php
			}
		?>
    </form>
    
    <?php
		if (isset($_POST['btOK'])) {
			$ngayDi = $_POST['cbbNgayDi']."/".$_POST['cbbThangDi'];
			$ngayVe = $_POST['cbbNgayVe']."/".$_POST['cbbThangVe'];
			
			$tienNL = $_POST['cbbNL'] * 2000000;
			$tienTE = $_POST['cbbTE'] * 1500000;
			$tienEB = $_POST['cbbEB'] * 400000;
			
			$tongTien = $tienNL + $tienTE + $tienEB;
			
			// INSERT
			if ($loginInfo == "") {
				$sql = "INSERT INTO `datve` (`User`, `Pass`, `DiemDi`, `DiemDen`, `NgayDi`, `NgayVe`, `NguoiLon`, `TreEm`, `EmBe`, `TongTien`) 
					VALUES ('A', 'A', '".$_POST['cbbDiemDi']."', '".$_POST['cbbDiemDen']."', '".$ngayDi."', '".$ngayVe."', '".$_POST['cbbNL']."', '".$_POST['cbbTE']."', '".$_POST['cbbEB']."', '".$tongTien."')";
			} else { // UPDATE
				$sql = "UPDATE `datve` 
						SET `DiemDi` = '".$_POST['cbbDiemDi']."', `DiemDen` = '".$_POST['cbbDiemDen']."', `NgayDi` = '".$ngayDi."', `NgayVe` = '".$ngayVe."', `NguoiLon` = '".$_POST['cbbNL']."', `TreEm` = '".$_POST['cbbTE']."', `EmBe` = '".$_POST['cbbEB']."' 
						WHERE `datve`.`User` = 'A'";
			}
			//echo $sql;
			$q = mysqli_query($conn, $sql);
			if ($q)
				echo "<script>alert('Đặt vé thành công!')</script>";
			else
				echo "<script>alert('Đặt vé thất bại!')</script>";
		}
	?>
</body>
</html>