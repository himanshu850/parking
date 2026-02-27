<?php
$conn = mysqli_connect("localhost", "root", "", "parking");
$uid = $_POST['id'];
$unm = $_POST['unm'];
$slot = $_POST['slot'];
echo $uid." ".$slot;

	$sql = "INSERT INTO bookings (useri,usern,slot,start) VALUES('$uid','$unm','$slot',now())";
  if ($conn->query($sql)) {
    header("Location:booking.php?state='Success'");
  }
	else{
		echo "The slot is already booked";
		header("location:booking.php");
	}



if (!empty($slot)) {
$sql3 = "UPDATE `parking_slot` SET `Status`='Booked' WHERE SlotID ='$slot' ";

$conn->query($sql3);
}

 ?>
