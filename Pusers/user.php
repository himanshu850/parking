<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	include('../function.php');
	
	if (!isLoggedIn()) {
		$_SESSION['msg'] = "You must log in first";
		header('location:../login.php');
		exit();
	}
 ?>
<?php include( 'includes/head_section.php'); ?>

	<title>Parking User Account</title>
</head>
<body>
	<!-- PUser navbar -->
	<?php include( 'includes/navbar.php') ?>
	<div class="container content" style="width: 100%;padding: 40px">
		<!-- Left side menu -->
		<?php include( 'includes/menu.php') ?>
		<!-- Account  -->
		<div class="action">
			<h1 class="page-title">Parking Sticker</h1>
		<?php
		$conn = mysqli_connect("localhost", "root", "", "parking");
		$idd = $_SESSION['user']['userID'];
		$sql3 = "SELECT * FROM sticker WHERE userNo='$idd'";
		$result3 = $conn->query($sql3);
		if ($result3->num_rows == 0): ?>
			<form method="post" action="sticker.php" >

				<select class="role"  name="sMode">
			          <option value="" selected disabled>Mode Of Study</option>
			        <option value="fullTime">Full Time</option>
			         <option value="Evening">Evening</option>
	          </select>
				<input type="number"   style="width: 95%;padding: 12px;border-radius: 2px;"name="userNo" value="<?php if(!empty($_SESSION['user'])){echo $_SESSION['user']['userID'];} ?>" placeholder="Student ID or Lecturer ID">
				<input type="text" name="name"  placeholder="Full Name" value="<?php if(!empty($_SESSION['user'])){echo $_SESSION['user']['username'];} ?>" >
				<input type="Address"  style="width: 95%;padding: 12px;border-radius: 2px;" name="Address" value="" placeholder="Telephone No">
                <input type="text" name="vehicleNo" value="" placeholder="Vehicle Registration No">
                <input type="text" name="vehicleColor" value="" placeholder="Vehicle Color">
				<input type="text" name="vehicleModel" placeholder="Vehicle Model">
     			<input type="date"  style="width: 95%;padding: 12px;border-radius: 2px;" name="Validity" placeholder="Sticker Validity">
	     	   <select class="role"  name="Department">
			          <option value="" selected disabled>Department</option>
			        <option value="Lecturer">lecturer</option>
			         <option value="Student">Student</option>
			          <option value="Staff">Staff</option>
	          </select>
						<select class="role"  name="Disabled">
								<option value="" selected disabled>Disabled</option>
							<option value="Yes">Yes</option>
							 <option value="No">No</option>
						</select>

					<button type="submit" class="btn" name="create_btn">SUBMIT</button>

			</form>
			<?php else: ?>
				<h1>YOUR STICKER HAS BEEN RESERVED VALID FOR ONE YEAR</h1>
					<?php endif ?>
		</div>
</div>
</body>
</html>
