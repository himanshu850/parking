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
		// Prepare any popup message based on query params
		$popup = null;
		if (!empty($_GET['error'])) {
			switch ($_GET['error']) {
				case 'slot_taken': $popup = ['type'=>'danger','title'=>'Slot unavailable','body'=>'The selected slot has already been booked. Please choose another slot.']; break;
				case 'user_has_booking': $popup = ['type'=>'warning','title'=>'Existing booking','body'=>'You already have an active booking. Cancel it before booking a new slot.']; break;
				case 'invalid_input': $popup = ['type'=>'danger','title'=>'Invalid input','body'=>'Required form data was missing.']; break;
				case 'db_prepare': $popup = ['type'=>'danger','title'=>'Server error','body'=>'Database error (prepare failed). Please try again later.']; break;
				case 'booking_failed': $popup = ['type'=>'danger','title'=>'Booking failed','body'=>'Unable to complete booking. Please try again.']; break;
				default: $popup = ['type'=>'info','title'=>'Notice','body'=>htmlspecialchars($_GET['error'])];
			}
		} elseif (!empty($_GET['state']) && $_GET['state'] === 'success') {
			$popup = ['type'=>'success','title'=>'Booked','body'=>'You have successfully secured a parking slot.'];
		}
		?>
		<?php
		$conn = mysqli_connect("localhost", "root", "", "parking");
		$sql2 = "SELECT * FROM parking_slot WHERE Status='Free'";
		$results = $conn->query($sql2);



		 ?>
		<?php include('../includes/errors.php'); ?>
		<?php if ($popup): ?>
		  <!-- Modal markup -->
		  <div class="modal fade" id="bookingAlertModal" tabindex="-1" aria-hidden="true">
		    <div class="modal-dialog modal-dialog-centered">
		      <div class="modal-content">
		        <div class="modal-header bg-<?php echo $popup['type']; ?> text-white">
		          <h5 class="modal-title"><?php echo $popup['title']; ?></h5>
		          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		        </div>
		        <div class="modal-body">
		          <p><?php echo $popup['body']; ?></p>
		        </div>
		        <div class="modal-footer">
		          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		        </div>
		      </div>
		    </div>
		  </div>
		<script>
			document.addEventListener('DOMContentLoaded', function(){
				var modalEl = document.getElementById('bookingAlertModal');
				if (modalEl) {
					var modal = new bootstrap.Modal(modalEl);
					modal.show();
					// redirect to user.php when the modal is hidden (close button, backdrop, or escape)
					modalEl.addEventListener('hidden.bs.modal', function(){
						window.location.href = 'user.php';
					});
				}
			});
		</script>
		<?php endif; ?>

		<?php if (empty($popup)): ?>
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
