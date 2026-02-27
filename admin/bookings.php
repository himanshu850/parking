<?php  include('../config.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/admin_functions.php'); 

	if (!isLoggedIn()) {
		$_SESSION['msg'] = "You must log in first";
		header('location:../login.php');
	}?>
<?php
	// Get all admin users from DB
	$admins = getAdminUsers();
	$roles = ['Admin','Guard', 'parkinguser'];

	

?>
<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
	<title>Admin | View Bookings</title>
	<style media="screen">
		.ed{
			width: 25px;
			float: left;
		}
		.fl{
			width: 95px;
		}
		.page-titleb{
			margin-top: 100px;
		}
	</style>
</head>
<body>
	<!-- admin navbar -->
	<?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>
	<div class="container content">
		<!-- Left side menu -->
		<?php include(ROOT_PATH . '/admin/includes/menu.php') ?>
		<!-- Middle form - to create and edit  -->
		
			<center><h1>USER BOOKINGS</h1></center>
		<!-- // Middle form - to create and edit -->

		<!-- Display records from DB-->
		<div class="table-div"  style="width: 80%;">
			<!-- Display notification message -->
			<?php include(ROOT_PATH . '/includes/messages.php') ?>

			<?php if (empty($admins)): ?>
				<h1>No Bookings in the database.</h1>
			<?php else: ?>
				<table class="table">
					<thead>
						<th>Booking ID</th>
						<th>Slot</th>
						<th>User ID</th>
							<th>User</th>

					</thead>
					<tbody>
					<?php
					$sql3 = "SELECT * FROM bookings ";
					$result3 = $conn->query($sql3);

				while($rec = $result3->fetch_assoc()): ?>
						<tr>
							<td><?php echo $rec['ID']; ?></td>
							<td>
								<?php echo $rec['slot']; ?>
							</td>
							<td><?php echo $rec['useri']; ?></td>
							<td><?php echo $rec['usern']; ?></td>

						</tr>
					<?php endwhile ?>
					</tbody>
				</table>
			<?php endif ?>
		</div>
		<!-- // Display records from DB -->
	</div>
</body>
</html>
