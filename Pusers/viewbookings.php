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

		<tbody>
<?php
	$conn = mysqli_connect("localhost", "root", "", "parking");
		$idd = $_SESSION['user']['UserID'];
		$sql3 = "SELECT * FROM sticker WHERE userNo='$idd'";
		$result = $conn->query($sql3);
	$sql4 = "SELECT * FROM bookings JOIN parking_slot  Ps ON bookings.slot= Ps.SlotID WHERE useri=$idd";
	//$sql3 = "SELECT * FROM bookings";
	//$result3 = $conn->query($sql3);
	$result = $conn->query($sql4);
	if ( $result) {
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
			 </tr>

				 ";
			}

		}
		else{
			echo $conn->error;
		}

		?>
		
	</tbody>	
</table>

</body>
</html>