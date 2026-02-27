<?php
	include('../function.php');
	
	if (!isLoggedIn()) {
		$_SESSION['msg'] = "You must log in first";
		header('location:../login.php');
	}
 ?>

<?php include('includes/head_section.php'); ?>
	<title>Parking Bookings</title>
</head>
<body>
<!-- User navbar -->
<?php error_reporting( error_reporting() & ~E_NOTICE ); ?>
	<?php include( 'includes/navbar.php') ?>
	<div class="container content">
		<!-- Left side menu -->
		<?php include('includes/menu.php') ?>
		<?php
		$conn = mysqli_connect("localhost", "root", "", "parking");
		$sql2 = "SELECT * FROM parking_slot WHERE Status='Free'";
		$results = $conn->query($sql2);



		 ?>
		<?php include('../includes/errors.php'); ?>
		<?php	if (!empty($_GET['state'])): ?>
		<?php include('../includes/messages.php') ?>
		 <h1 style="text-align: center; margin-top: 20px; color:green;">You have Successfully Secured a Parking Slot</h1>
	 <?php else: ?>
		 <form method="post" action="book.php" >
		 <center><h2>Parking Slot Booking</h2>
		<input type="text" name="id" value="<?php if(!empty($_SESSION['user'])){echo $_SESSION['user']['userID'];} ?>" placeholder="UserID">
		<input type="text" name="unm" value="<?php if(!empty($_SESSION['user'])){echo $_SESSION['user']['username'];} ?>" placeholder="Username">
		
		
		<select name="slot">
			<option value="" selected disabled>Pick Slot</option>
			<?php
			if ($results) {
				 while($row = $results->fetch_assoc()) {
							$id= $row['SlotID'];
							echo "<option value=". $id.">$id</option>";
					}
			}
			 ?>

		</select>
		<button type="submit" class="btn" name="login_btn">BOOK</button>

	</form>
	<?php endif  ?>
	</div>
</body>
</html>
