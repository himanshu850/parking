<?php
	include('../function.php');

	if (!isLoggedIn()) {
		$_SESSION['msg'] = "You must log in first";
		header('location:../login.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Confirmation|Guard</title>
	<link rel="stylesheet" href="../static/css/public_styling.css">
</head>
<body>
	<div class="header" style="background-color: black;padding:2%">
		<center><h2 style="color: white">GUARD| Strath Parking Detail Confirmation</h2></center>
	</div>
	<?php include('../includes/messages.php') ?>
	<div class="container" style="width: 90%">
		<!-- notification message -->
		<?php if (isset($_SESSION['success'])) : ?>
			<div class="error success" >
				<center><h3>
					<?php
						echo $_SESSION['success'];
						unset($_SESSION['success']);
					?>
				</h3></center>
			</div>
		<?php endif ?>
		<!-- logged in user information -->
				<?php  if (isset($_SESSION['user'])) : ?>
					<strong style="font-size:20px"><?php echo $_SESSION['user']['username']; ?></strong>

					<small>
						<i  style="color: #888;">(<?php echo ucfirst($_SESSION['user']['role']); ?>)</i>
						<br>
						<a href="index.php?logout='1'" style="color: red;float: right;font-size:20px;text-decoration:underline;">logout</a>
					</small>

				<?php endif ?>
				<div style="width: 70%; margin: 30px auto;">
					<form method="post" >
						<input type="text" name="regno" value="" placeholder="Car Registration Number">
						<button type="submit" class="btn" name="search">Search</button>
					</form>
				</div>

			<div class="table-div"  style="width: 80%;">
			<!-- Display notification message -->
			<?php include('../includes/messages.php') ?>
			<center><h1 class="page-title"style="font-size:20px">User Details</h1></center>

	<table class="table" style=" border-collapse: collapse; width: 90%; margin: 20px auto; ">
		<thead>
		<th>Full Name</th>
		<th>Vehicle Model</th>
		<th>Study Mode</th>
		<th>Department</th>
		<th>Parking From</th>
		<th>Unbook</th>
	</thead>

		<?php
		$from= date("Y-m-d h:i:sa");
		$conn = mysqli_connect('localhost', 'root', '', 'parking');

		// Only run search when form is submitted
		if (isset($_POST['search'])) {
			$regno = trim($_POST['regno'] ?? '');
			$regno_esc = mysqli_real_escape_string($conn, $regno);

			$sql1 = "SELECT * FROM sticker s JOIN bookings b ON s.userNo = b.useri JOIN parking_slot ps ON b.slot = ps.SlotID WHERE vehicleNo='".$regno_esc."'";
			$result1 = $conn->query($sql1);

			if ($result1 && $result1->num_rows > 0) {
				while($rec1 = $result1->fetch_assoc()) {
					 $name= $rec1['name'];
					 $model=$rec1['vehicleModel'];
					 $mode=$rec1['sMode'];
					 $dept=$rec1['Department'];
					 $slot_id = $rec1['SlotID'];
					 echo "
					 <tr>
						<td>$name</td>
						<td>$model</td>
						<td>$mode</td>
						<td>$dept</td>
						<td>$from</td>
						<td><a href='unbook.php?slot_id=".$slot_id."'><button>Unbook</button></a></td>
					</tr>

					 ";
				}
			} else {
				 $_SESSION['message'] = "User Not registered in the system";
			}
		}

		?>
</table>
</div>
		</div>
</body>
</html>
