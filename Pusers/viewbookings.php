<?php  include('../config.php'); ?>
<?php include(ROOT_PATH . '/Pusers/includes/head_section.php'); 

?>
	<title>View Booking</title>
</head>
<body>
<!-- PUser navbar -->
	<?php include(ROOT_PATH . '/Pusers/includes/navbar.php') ?>

	<div class="container content">
		<!-- Left side menu -->
		<?php include(ROOT_PATH . '/Pusers/includes/menu.php') ?>

		<!-- Display records from DB-->
		<div class="table-div"  style="width: 80%;">
			<!-- Display notification message -->
			<?php include(ROOT_PATH . '/includes/messages.php') ?>
			<center><h1 class="page-title">View Bookings</h1></center>
			
	<table class="table">
						<thead>
						<th>SlotID</th>
						<th>Location</th>
						<th>Status</th>
						<th>From</th>
						<th>To</th>
						<th>Action</th>

		<tbody>
<?php
	$conn = mysqli_connect("localhost", "root", "", "parking");

	// Determine user id from session (support different column/key names)
	$idd = null;
	if (isset($_SESSION['user']['userID'])) {
		$idd = intval($_SESSION['user']['userID']);
	} elseif (isset($_SESSION['user']['id'])) {
		$idd = intval($_SESSION['user']['id']);
	} elseif (isset($_SESSION['user']['UserID'])) {
		$idd = intval($_SESSION['user']['UserID']);
	}

	if (empty($idd)) {
		echo "<tr><td colspan=6 class=\"text-center\">No bookings (not logged in or no user id)</td></tr>";
	} else {
		$sql3 = "SELECT * FROM sticker WHERE userNo='$idd'";
		$result = $conn->query($sql3);
		$sql4 = "SELECT * FROM bookings JOIN parking_slot Ps ON bookings.slot = Ps.SlotID WHERE useri=$idd";
		$result = $conn->query($sql4);
		if ($result) {
			 while($rec = $result->fetch_assoc() ) {

				$SlotID= $rec['slot'];
				 $Location=$rec['LocationID'];
				 $time=$rec['start'];
				 //$Status=$rec['Message'];
		echo "
				 <tr>
				 <td>$SlotID</td>
				 <td>$Location</td>
				 <td>Active</td>
				 <td>$time</td>
				 <td>2019-11-26 5:30:00pm</td>
				 <td><a class=\"btn btn-sm btn-danger\" href=\"unbook.php?slot_id=$SlotID\" onclick=\"return confirm('Are you sure you want to unbook this slot?');\">Unbook</a></td>
			 </tr>

				 ";
			}

		} else {
			echo $conn->error;
		}
	}

	?>
		
	</tbody>	
</table>

</body>
</html>