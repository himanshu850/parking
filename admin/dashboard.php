<?php  include('../config.php'); ?>
	<?php include(ROOT_PATH . '/admin/includes/admin_functions.php');
	
	if (!isLoggedIn()) {
		$_SESSION['msg'] = "You must log in first";
		header('location:../login.php');
	} ?>
	<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
	<title>Admin | Dashboard</title>
</head>
<body>
	<div class="header">
		<div class="logo">
			<a href="<?php echo BASE_URL .'admin/dashboard.php' ?>">
				<h1>Strath Parking Booking</h1>
			</a>
		</div>
		<?php if (isset($_SESSION['user'])): ?>
			<div class="user-info">
				<span><?php echo $_SESSION['user']['username'] ?></span> &nbsp; &nbsp; 
				<a href="<?php echo BASE_URL . '/logout.php'; ?>" class="logout-btn">logout</a>
			</div>
		<?php endif ?>
	</div>
	<div class="container dashboard">
		<h1>Welcome To Admin Module</h1>
		<div class="stats">
			<a href="slots.php" class="first">
				<span>					
					<?php 
					$sql3 = "SELECT * FROM parking_slot";
									$result3 = $conn->query($sql3);
									$cnt =0;
									if ($result3) {
										 while($rec = $result3->fetch_assoc()) {
					       			$cnt=$cnt+1;
					 
					    	 			}

					    	 		}
					    	 		else{
					    	 			echo $conn->error;
					    	 		}

					 ?>

					 <?php echo $cnt; ?>
				</span> <br>
				<span>Parking Slots</span>
			</a>
			<a href="users.php">
				<span>
					
					<?php 
					$sql3 = "SELECT * FROM users";
									$result3 = $conn->query($sql3);
									$cnt =0;
									if ($result3) {
										 while($rec = $result3->fetch_assoc()) {
					       			$cnt=$cnt+1;
					 
					    	 			}

					    	 		}
					    	 		else{
					    	 			echo $conn->error;
					    	 		}

					 ?>

					 <?php echo $cnt; ?>

				</span> <br>
				<span>Registered Users</span>
			</a>
			<a>
				<span>
						<?php 
						$sql3 = "SELECT * FROM sticker";
									$result3 = $conn->query($sql3);
									$cnt =0;
									if ($result3) {
										 while($rec = $result3->fetch_assoc()) {
					       			$cnt=$cnt+1;
					 
					    	 			}

					    	 		}
					    	 		else{
					    	 			echo $conn->error;
					    	 		}

					 ?>

					 <?php echo $cnt; ?> 


				</span> <br>
				<span>Total Booked Stickers</span>
			</a>
		</div>
		<br><br><br>
		<div class="buttons">
			<a href="users.php">Add Users</a>
			<a href="add_slots.php">Add slots</a>
			<a href="feedback.php">View Feedback</a>
		</div>
	</div>
</body>
</html>